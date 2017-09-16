<?php
/*
 *  支付控制器，从购物车到支付成功
 */
namespace Home\Controller;
use Home\Controller\CommonController;
class PayController extends CommonController
{

    /* 支付 第一步  查看购物车 */
    public function showPayCar(){

        if(isset($_COOKIE['car'])){

            $car = unserialize($_COOKIE['car']);
            $cars = array();
            $model = D('goods');
            foreach ($car as $k => $v){

                $arr  = explode('-',$k);
                // 获取商品以及店铺信息
                $data = $model->get_goods_store_info($arr[0]);
                // 是否收藏
                $data['is_follow'] = M('follow')->where("value_id = '{$data['id']}' and user_id = '{$_SESSION['eater_uid']}'")->count();
                // 购买数量
                $data['number']    = $v['number'];

                /* 判断有无属性 */
                if($arr[1]){
                    // 获取属性的 加价
                    $goods_attr_id      = str_replace('&',',',$arr[1]);
                    // 获取商品属性
                    $goods_attr         = $model->get_goods_attr($goods_attr_id);
                    // 属性总加价
                    $add_price          = array_sum(array_column($goods_attr,'attr_price'));
                    // 本店价 + 加价
                    $data['price']      = $data['price'] + $add_price;
                    $data['goods_attr'] = $goods_attr;
                }

                $data['only'] = $k;  // 该商品的唯一标识

                $cars[$data['sid']][] = $data;

            }

        }else{
            $cars = "";
        }

        $this->assign('cars',$cars);

        layout('Layout/layout');
        $this->display();
    }

    /* 清空购物车 */
    public function delAllCar(){
        if(IS_AJAX){
            setcookie('car','',time()-3600,'/');
            $this->ajaxReturn(array('status'=>true));
        }
    }

    /* ajax 获取商品内存 */
    public function ajaxGetStock(){
        
        if(IS_AJAX){

            $goods_attr_id = $_POST['goods_attr_id'];
            $goods_id      = $_POST['goods_id'];

            $model = M('stock');

            // 如果此商品有属性
            if($goods_attr_id)
            {
                $data = $model->where("goods_attr_id = '{$goods_attr_id}'")->getField('goods_number');
                echo $data;exit;
            }
            else
            {
                $data = $model->where("goods_id = '{$goods_id}'")->getField('goods_number');
                echo $data;exit;
            }
        }
    }

    /* 支付第二步，确认订单 */
    public function confirmOrder(){

        if(IS_POST){

            /* 判断用户是否登录 */
            $eater_id = $_SESSION['eater_uid'];
            if(!$eater_id){
                $this->redirect('Login/login');exit;
            }

            /*********** 如果传递过来的是订单号，说明是在订单页面，再次购买点进来的 *************/
            if(isset($_POST['ordersn']) && $_POST['ordersn']){
                $orderModel = M('orders');
                $orderData  = $orderModel->field('goods_id,goods_attr,number')->where("ordersn = '{$_POST['ordersn']}'")->select();
                $order = array();
                $order_goods_number = array();
                foreach($orderData as $k => $v){
                    $order[] = $v['goods_id'].'-'.$v['goods_attr'];
                    $order_goods_number[] = $v['number'];
                }
            }else{
                $order = $_POST['order'];
            }


            if($order){

                $cars = array();
                $goodsModel = D('goods');

                $car = unserialize($_COOKIE['car']);    // 取出购物车内容
                $total_price = 0;
                $goodsList   = "";
                foreach($order as $k => $v){

                    $arr = explode('-',$v);

                    // 获取商品信息以及店铺信息
                    $data = $goodsModel->get_goods_store_info($arr[0]);
                    // 购买数量
                    $data['number'] =  $car[$v]['number'] ? $car[$v]['number'] : $order_goods_number[$k];      // 取出购物车中的购买数量
                    // 拼接字符串，包含id 购买数量等信息
                    $goodsList .= $v.'-'.$data['number'].',';

                    // 如果商品有属性
                    if($arr[1]){

                        // 获取属性的 加价
                        $goods_attr_id = str_replace('&',',',$arr[1]);
                        // 获取商品属性
                        $goods_attr    = $goodsModel->get_goods_attr($goods_attr_id);
                        //  属性总加价
                        $add_price     = array_sum(array_column($goods_attr,'attr_price'));
                        // 本店价 + 加价
                        $data['price'] = $data['price'] + $add_price;
                        $data['goods_attr'] = $goods_attr;
                    }

                    $total_price += $data['price'] * $data['number'];
                    $data['only'] = $v;  // 该商品的唯一标识
                    // 根据店铺id分类
                    $cars[$data['sid']][] = $data;

                }

                // 取出所有当前用户的收货地址
                $address = M('address')->where("user_id = '{$_SESSION['eater_uid']}'")->order("is_default asc")->select();

                $this->assign(array(
                    'cars' => $cars,
                    'total_price' => $total_price,
                    'address' => $address,
                    'total_points1' => M('member')->where("id = '{$_SESSION['eater_uid']}'")->getField('points'),
                    'goodsList' => $goodsList
                ));
                layout('Layout/layout');
                $this->display();
            }else{
                $this->redirect('Index/index');
            }

        }else{
            $this->redirect('Index/index');
        }

    }

    /*************** 提交订单，处理之后跳转到支付页面，状态为：待付款****************/
    public function submitOrder(){

        if(IS_AJAX){

            /* 判断用户是否登录 */
            if(!isset($_SESSION['eater_uid']) || $_SESSION['eater_uid'] == ""){
                $this->ajaxReturn(array('status'=>'error','result'=>'账号登录过期，请重新登录！'));exit;
            }

            $address_id = $_POST['address_id'];     // 收货地址id
            $goodsList  = $_POST['goodsList'];      // 商品
            $pay_type   = $_POST['pay_type'];       // 支付类别
            //$orderSn = date("Ymd").substr(time(),7,3).rand(111,999);    // 订单编号
            // 从字符串中分离出 商品信息
            $goodsList1 = explode(',',trim($goodsList,','));
            $time = date("Y-m-d H:i:s");

            /***********判断用户选择的id，是否是自己的收货地址***********/
            if(!M('address')->where("user_id = '{$_SESSION['eater_uid']}' && id = '{$address_id}'")->count()){
                $this->ajaxReturn(array('status'=>false,'result'=>'请使用自己的地址！'));exit;
            }
            /***************判断用户是否选择了，除以下两种情况外的支付方式************************/
            if(!in_array($pay_type,array('余额支付','货到付款'))){
                $this->ajaxReturn(array('status'=>false,'result'=>'请选择余额支付或货到付款！'));exit;
            }

            $orderModel     = M('orders');
            $goodsModel     = M('goods');
            $goodsAttrModel = M('goods_attr');
            $orderModel->startTrans();  // 开启事务

            /**************将积分按照商品的个数平分******************/
            $avgPoints = array();
            if($_POST['is_place'] == 'true'){
                $memberModel  = D('member');
                $total_points = $memberModel->where("id = '{$_SESSION['eater_uid']}'")->getField('points');
                $avgPoints    = $memberModel->pointsAvg($total_points,count($goodsList1));
                $memberModel->execute("update sh_member set points = points-{$total_points} where id = '{$_SESSION['eater_uid']}'"); // 从数据库中减掉用户的积分
            }


            /*************判断商品是否有在同一个店铺的，如果在同一个店铺，则使用相同的订单编号*******************/
            $goods_id_arr = array();
            foreach($goodsList1 as $k => $v){
                $goodsItem = explode('-',$v);
                $goods_id_arr[] = $goodsModel->field('store_id,id')->where("id = '{$goodsItem[0]}'")->find();

            }
            $orderSn_arr = array_column($goods_id_arr,'id','store_id');
            foreach($orderSn_arr as $k => $v){
                $orderSn_arr[$k] = date("Ymd").substr(time(),7,3).rand(111,999);
            }

            $orderSnArr = array();                      // 存放订单编号，用于url传参支付
            $data       = array();                      // 存放商品only，用于从购物车中删除
            foreach($goodsList1 as $k => $v){

                // $arr[0]：商品id   $arr[1]：商品属性   $arr[2]：商品购买数量
                $arr = explode('-',$v);

                // 为了避免用户后台到购物车页面时，再次选购，会出现数量为0的情况
                if(!$arr[2]){
                    $orderModel->rollback();            // 失败就回滚
                    $this->ajaxReturn(array('status'=>false,'result'=>'订单异常，请重新选购！'));exit;
                }

                $data[] = $arr[0].'-'.$arr[1];          // only存放在数组中， 从购物车删除

                $points_place_number = 0;               // 用于抵换的积分数量
                if($_POST['is_place'] == 'true'){
                    $points_place_number = $avgPoints[$k];
                }

                /********************计算商品价格*****************/
                $price = 0;
                $price = $goodsModel->where("id = '{$arr[0]}'")->getField('goods_shop_price');
                // 判断有无属性，有则加价
                if($arr[1]){
                    $goods_attr = str_replace('&',',',$arr[1]);
                    $add_price = $goodsAttrModel->where("id IN ($goods_attr)")->sum('attr_price');
                    $price += $add_price;
                }
                // 计算商品总价，价*数量-积分抵换
                $price = $price * $arr[2] -place_points($points_place_number);

                /****根据店铺id，从订单编号数组中取出编号，相同店铺使用同一个编号********/
                $store_id = $goodsModel->where("id = '{$arr[0]}'")->getField('store_id');
                $orderSn  = $orderSn_arr[$store_id];
                $orderSnArr[] = $orderSn;                                      // 存放订单编号

                if(!$orderModel->add(array(
                    'goods_id'            =>    $arr[0],                       // 商品id
                    'goods_attr'          =>    $arr[1],                       // 商品属性
                    'number'              =>    $arr[2],                       // 购买数量
                    'price'               =>    $price,                        // 价格
                    'user_id'             =>    $_SESSION['eater_uid'],        // 用户id
                    'status'              =>    '待付款',                      // 订单状态
                    'valid_time'          =>    60*60*24*3,                    // 订单有效时间 3天
                    'time'                =>    $time,                         // 订单生成时间
                    'pay_type'            =>    $pay_type,                     // 支付方式
                    'address_id'          =>    $address_id,                   // 收货地址id
                    'orderSn'             =>    $orderSn,                      // 订单编号
                    'points_place_number' =>    $points_place_number,          // 积分抵消金额数量
                ))){
                    $orderModel->rollback();                                   // 失败就回滚
                    $this->ajaxReturn(array('status'=>false,'result'=>'订单提交失败，请刷新重试！'));exit;
                }
            }
            $orderModel->commit();                                              // 提交事务

            /************** 从购物车中删除，并重新存入cookie中****************/
            $car = isset($_COOKIE['car']) ? unserialize($_COOKIE['car']) : '';
            foreach($data as $k => $v){
                unset($car[$v]);
            }
            setcookie('car',serialize($car),time()+60*60*24*30,'/');

            // 订单编号以o隔开
            $orderSnArr = implode('o',$orderSnArr);
            $this->ajaxReturn(array('status'=>true,'result'=>'订单提交成功，请付款！','orderSn'=>$orderSnArr));exit;
        }else{
            $this->redirect('Login/login');exit;
        }
    }

    /*************** 订单第三步，支付页面****************/
    public function pay(){

        if(isset($_GET['orderSn']) && $_GET['orderSn']){

            if(!isset($_SESSION['eater_uid']) || $_SESSION['eater_uid'] == ""){
                $this->redirect('Login/login');exit;
            }

            /*************** 判断订单号 是否是用户的订单******************/
            $orderModel = M('orders');
            $orderSn = str_replace('o',',',$_GET['orderSn']);
            $order = $orderModel->where("user_id = '{$_SESSION['eater_uid']}' and orderSn IN({$orderSn}) and status = '待付款'")->select();

            if(!count($order)){
                echo "<script>alert('该订单已过期或不存在该订单，请重新选购！');location.href='/eater';</script>";exit;
            }

            // 获取订单中的商品信息
            $data = $orderModel->
                    field("
                    a.number,a.goods_attr,a.points_place_number,a.address_id,a.pay_type,a.orderSn,
                    b.goods_title,b.goods_shop_price price")->
                    alias('a')->
                    join("left join sh_goods b on a.goods_id = b.id")->
                    where("a.orderSn IN ($orderSn) and a.user_id = '{$_SESSION['eater_uid']}' and a.status = '待付款'")->
                    select();
            // 获取收货地址
            $address = M('address')->field("name,phone,province,city,county,address")->find($data[0]['address_id']);
            // 获取用户余额，手机号
            $member  = M('member')->field("username,money")->where("id = '{$_SESSION['eater_uid']}'")->find();

            $goodsAttrModel = M('goods_attr');
            $total_price    = 0;   //总价
            foreach($data as $k => $v){

                // 属性加价
                if($v['goods_attr']){
                    $goods_attr         = str_replace('&',',',$v['goods_attr']);
                    $add_price          = $goodsAttrModel->where("id IN ($goods_attr)")->sum('attr_price');
                    $data[$k]['price'] += $add_price;
                }
                // 计算商品总价，  单价*数量-积分抵换
                $data[$k]['price'] = $data[$k]['price'] * $v['number'] - place_points($v['points_place_number']);

                // 总价
                $total_price += $data[$k]['price'];
            }

            $this->assign(array(
                'data'=>$data,
                'address'    => $address,
                'member'     => $member,
                'total_price'=> $total_price+C('EXPRESS_PRICE')
            ));
            layout('Layout/layout');
            $this->display();

        }else{
            $this->redirect('Login/login');exit;
        }

    }

    /**************** 支付 *****************/
    public function payOrder(){

        if(IS_AJAX){

            $code     = $_POST['code'];
            $orderSn  = str_replace('o',',',$_POST['orderSn']);
            $pay_type = $_POST['pay_type'];

            $memberModel = D('member');

//            /************************* 验证 验证码是否正确***************************/
//            // 获取返回数据，包括状态，以及提示信息
//            $return = $memberModel->chkSn($code);
//            if(!$return['status']){
//                $this->ajaxReturn($return);exit;
//            }

            /**************** 验证用户选择的支付类型，是否是数组中的内容***************/
            if(!in_array($pay_type,array('余额支付','货到付款'))){
                $this->ajaxReturn(array('status'=>false,'result'=>'请选择余额支付或货到付款！'));exit;
            }

            /********* 验证订单是否是该用户的订单，以及是否为待付款状态，以及是否超时***/
            $orderModel = M('orders');
            $order = $orderModel->
                        alias('a')->
                            field("a.*,b.goods_title,b.is_sell,b.goods_shop_price price,c.business_status,c.store_status")->
                                join("left join sh_goods b on a.goods_id = b.id")->
                                join("left join sh_store c on b.store_id = c.id")->
                                    where("a.orderSn IN ($orderSn) and a.status = '待付款' and a.user_id = '{$_SESSION['eater_uid']}' and UNIX_TIMESTAMP() - UNIX_TIMESTAMP(a.time) < a.valid_time")->
                                        select();




            if($order){

                $fp = fopen('./lock.txt','r');
                flock($fp,LOCK_EX); // 使用php文件锁，避免少量并发

                $stockModel     = M('stock');
                $goodsAttrModel = M('goods_attr');

                $stockModel->startTrans();  // 开启事务

                $total_price = 0;
                foreach($order as $k => $v){
                    $goods_price = 0;
                    /*****************判断库存，是否充足******************/
                    if($v['goods_attr']){
                        $status = $stockModel->where("goods_attr_id = '{$v['goods_attr']}' and goods_number >= {$v['number']}")->setDec('goods_number',$v['number']);
                    }else{
                        $status = $stockModel->where("goods_id = '{$v['goods_id']}' and goods_number >= {$v['number']}")->setDec('goods_number',$v['number']);
                    }
                    if(!$status){
                        $stockModel->rollback();    // 事务回滚
                        $this->ajaxReturn(array('status'=>'error','result'=>$v['goods_title'].'<br>库存不足，选购其他商品吧~'));exit;
                    }

                    /********** 如果商品下架，店铺打烊，店铺被停用******/
                    if($v['is_sell'] == '否' || $v['business_status'] == '已打烊' || $v['store_status'] == '停用')
                    {
                        $stockModel->rollback();    // 事务回滚
                        $this->ajaxReturn(array('status'=>'error','result'=>$v['goods_title'].'<br>已下架，选购其他商品吧~'));exit;
                    }

                    /********************** 属性加价********************/
                    if($v['goods_attr']){
                        $goods_attr = str_replace('&',',',$v['goods_attr']);
                        $order[$k]['price'] += $goodsAttrModel->where("id IN ($goods_attr)")->sum('attr_price');
                    }

                    // 商品总价
                    $goods_price = $order[$k]['price'] * $v['number'] - place_points($v['points_place_number']);
                    $total_price += $goods_price;

                    /************** 修改订单信息******************/
                    $arr = array(
                        'price'   => $goods_price,
                        'status'  => '待发货',
                        'pay_type'=> $pay_type,
                        'pay_time'=> date("Y-m-d H:i:s"),
                    );
                    if(!$orderModel->where("id='{$v['id']}'")->save($arr)){
                        $stockModel->rollback();    // 事务回滚
                        $this->ajaxReturn(array('status'=>false,'result'=>'订单异常，请尝试刷新重试！'));exit;
                    }

                }

                $total_price += C('EXPRESS_PRICE');     // 加上快递费后的总价

                /**********************如果支付方式是余额支付，则从账户中减去金额，否则就是货到付款**************************/
                if($pay_type == '余额支付'){

                    $money = $memberModel->where("id = '{$_SESSION['eater_uid']}'")->getField('money');
                    /****** 判断账号金额是否充足 *******/
                    if($money >= $total_price){
                        // 用户金额减少，积分和累计金额增加
                        if(!$memberModel->execute("update sh_member set money = money-{$total_price} where id='{$_SESSION['eater_uid']}'")){
                            $stockModel->rollback();    // 事务回滚
                            $this->ajaxReturn(array('status'=>false,'result'=>'订单异常，请尝试刷新重试！'));exit;
                        }
                    }else{
                        $stockModel->rollback();    // 事务回滚
                        $this->ajaxReturn(array('status'=>false,'result'=>'账户余额不足，请充值或选择其他支付方式！'));exit;
                    }
                }

                $stockModel->commit();  // 提交事务
                flock($fp,LOCK_UN);   // 释放文件锁
                fclose($fp);
                
                $this->ajaxReturn(array('status'=>true,'ordersn'=>$orderSn));exit;
            }else{
                echo 1;die;
                $this->ajaxReturn(array('status'=>'error','result'=>'订单已过期或不存在，请重新选购！'));exit;
            }

        }


    }

    /* 支付成功页面 */
    public function pay_success(){




        layout('Layout/layout');
        $this->display();


    }
}