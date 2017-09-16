<?php
/**
 * Created by PhpStorm.
 * User: hi~
 * Date: 2017/3/15
 * Time: 18:36
 *  个人中心 控制器  主要控制 个人中心模块
 */
namespace Home\Controller;
use Home\Controller\CommonController;
use Think\Page;

class PersonalController extends CommonController
{
    /* 构造函数，判断用户是否登录 */
    public function _initialize()
    {
        parent::_initialize();
        if(!isset($_SESSION['eater_uid']) || $_SESSION['eater_uid'] == ""){
            $this->redirect('Login/login');exit;
        }
    }

    /* 申请店铺 */
    public function apply_store(){

        if(IS_POST){

            $model = D('store');

            if($model->create()){
                if($model->add()){
                    $this->ajaxReturn(array('status'=>true,'result'=>'申请成功'));exit;
                }else{
                    $this->ajaxReturn(array('status'=>false,'result'=>'申请失败，请刷新重试'));exit;
                }
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>$model->getError()));exit;
            }
        }
        layout('Layout/layout2');
        $this->display();
    }

    /* 列表，我的申请 */
    public function apply_list(){

        $uid = $_SESSION['eater_uid'];
        $storeData = M('store')->field('user_id,nopass_reason,id,store_name,store_major_type,store_owner_name,store_owner_number,store_owner_img,store_logo_url,status')->where("member_id = '{$uid}'")->select();
        $this->assign("storeData",$storeData);
        layout('Layout/layout2');
        $this->display();
    }

    /* 取消申请 */
    public function cancel_apply(){
        if(IS_AJAX){
            $id = $_POST['id'];
            $model = D('store');
            if($model->delete($id)){
                $this->ajaxReturn(array('status'=>true,'result'=>'取消成功~'));exit;
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'取消失败，请刷新重试'));exit;
            }
        }
    }

    /* ajax 获取不通过的原因 */
    public function ajaxGetReason(){
        if(IS_AJAX){
            $id = $_POST['id'];
            $model = M('store');
            if($reason = $model->where("id = '{$id}'")->getField('nopass_reason')){
                $this->ajaxReturn(array('status'=>true,'result'=>$reason));exit;
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'获取失败，请刷新重试！'));exit;
            }
        }
    }

    /* 店铺申请，修改 */
    public function apply_store_save($id){

        if(IS_POST){

            $model = D('store');
            if($model->create()){

                if($model->save() !== false){
                    $this->ajaxReturn(array('status'=>true,'result'=>'修改成功，预计1-3日内审核完成！'));exit;
                }else{
                    $this->ajaxReturn(array('status'=>false,'result'=>'修改失败，请刷新重试！'));exit;
                }
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>$model->getError()));exit;
            }

        }

        $data = M('store')->find($id);
        $this->assign('data',$data);
        layout('Layout/layout2');
        $this->display();

    }

    /* 获取商家账号 */
    public function show_user(){

        if(IS_AJAX){
            $user_id = $_POST['user_id'];
            $data = M('user')->field('user_name,user_pwd')->find($user_id);
            if($data){
                $this->ajaxReturn(array('status'=>true,'result'=>$data));exit;
            }else{
                $this->ajaxReturn(array('status'=>false));exit;
            }
        }
    }


    /* 收藏的商品或店铺 */
    public function follow($type){

        $model = M('follow');
        // 查看收藏的店铺或商品，拼接不同的sql语句
        if($type == '店铺') {
            $fields = "a.id,a.value_id,b.store_name,b.store_logo_url";
            $join = "store";
        }else{
            $fields = "a.id,a.value_id,b.goods_title,b.goods_logo_url,b.goods_shop_price";
            $join = "goods";
        }

        $follow = $model->
                    field($fields)->
                    alias('a')->
                    join("left join sh_$join b on a.value_id = b.id")->
                    where("a.type = '{$type}' and a.user_id = '{$_SESSION['eater_uid']}'")->
                    select();

        $this->assign('follow',$follow);

        layout('Layout/layout2');
        $this->display();
    }

    /* 取消收藏 */
    public function cancel_follow(){
        $id    = $_GET['id'];
        $model = M('follow');

        if($model->delete($id)){
            $this->ajaxReturn(array('status'=>true,'result'=>'已取消'));
        }else{
            $this->ajaxReturn(array('status'=>false,'result'=>'取消失败'));
        }
    }



    /* 浏览记录列表 */
    public function record(){


        if(isset($_COOKIE['record']) && $_COOKIE['record'] != ""){

            $record = unserialize($_COOKIE['record']);

            $data = array();
            $model = M('goods');
            foreach($record as $k => $v){
                //  分割  39,2017-03-27
                $arr = explode(',',$v);
                //  取出当前商品信息
                $goodsData = $model->field("id,goods_title,goods_logo_url,goods_shop_price")->where("is_sell = '是'")->find($arr[0]);
                //  判断是否关注
                $goodsData['is_follow'] = M('follow')->where("value_id = '{$goodsData['id']}' and user_id = '{$_SESSION['eater_uid']}'")->count();

                $data[$arr[1]][] = $goodsData;
            }

        }else{
            $data = "";
        }

        krsort($data);  // 时间近的排在前面

        $this->assign('data',$data);

       //echo "昨天:".date("Y-m-d",strtotime("-1 day")), "<br>";
        layout('Layout/layout2');
        $this->display();
    }

    /*  删除浏览记录 */
    public function delRecord(){
        if(IS_AJAX){

            $goods_id = $_GET['goods_id'];
            $time = $_GET['time'];
                //  取出cookie record
            $record = unserialize($_COOKIE['record']);
                // 遍历寻找，删除
            foreach($record as $k => $v){
                if($v == $goods_id.','.$time){
                    unset($record[$k]);
                }
            }
                // 重新存入cookie
            setcookie('record',serialize($record),time()+60*60*24*30,'/');
        }
    }

    /* 显示当前用户的所有地址 */
    public function address(){

        $model = M('address');
        $data = $model->order('id desc')->where("user_id = '{$_SESSION['eater_uid']}'")->select();
        $this->assign('data',$data);
        layout('Layout/layout2');
        $this->display();
    }

    /* 添加新地址 */
    public function add_new_address(){

        if(IS_AJAX){

            $model = D('address');
            if($info = $model->create()){

                $info['user_id'] = $_SESSION['eater_uid'];
                if($id = $model->add($info)){
                    $info['id'] = $id;
                    $this->ajaxReturn(array('status'=>true,'result'=>'添加成功~','content'=>$info));
                    exit;
                }else{
                    $this->ajaxReturn(array('status'=>false,'result'=>'添加失败，刷新重试！'));
                    exit;
                }
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>$model->getError()));
                exit;
            }
        }
    }

    /* 删除地址 */
    public function address_del(){
        if(IS_AJAX){
            $id = $_GET['id'];
            $model = M('address');
            $model->delete($id);
        }
    }

    /* 地址，设为默认*/
    public function setFault(){

        if(IS_AJAX){

            $id = $_GET['id'];
            $type = $_GET['type'];
            $model = M('address');
            if($type == '1'){
                $model->where("1")->setField('is_default','否');
                if($model->where('id='.$id)->setField('is_default','是') !== false){
                    $this->ajaxReturn(array('status'=>true));exit;
                }
            }else if($type == '2'){
                if($model->where('id='.$id)->setField('is_default','否') !== false){
                    $this->ajaxReturn(array('status'=>true));exit;
                }
            }
        }
    }

    /* 修改地址 */
    public function update_address(){

        if(IS_AJAX){

            $model = D('address');

            if($model->create()){

                if($model->where("id = '{$model->id}' and user_id = '{$_SESSION['eater_uid']}'")->save() !== false){
                    $this->ajaxReturn(array('status'=>true,'result'=>'修改成功~'));exit;
                }else{
                    $this->ajaxReturn(array('status'=>false,'result'=>'修改失败，刷新重试！'));exit;
                }
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>$model->getError()));exit;
            }
        }
    }

    /* 用户信息 */
    public function user(){
        /* 统计 用户 订单状态 的数量 */
        $ordersModel = D('orders');
        $_orders_count = $ordersModel->getOrderCount($_SESSION['eater_uid']);
        $orders_count = array_column($_orders_count,'number','status');

        /* 获取用户基本信息 */
        $memberModel = D('member');
        $data = $memberModel->field("id,username,email,time,money,points,total_cost")->find($_SESSION['eater_uid']);

        //获取用户级别
        $level = $memberModel->getLevelInfoByCost($data['total_cost']);

        $this->assign(array(
            'data' => $data,
            'orders_count' => $orders_count,
            'level'=> $level
        ));
        layout('Layout/layout2');
        $this->display();
    }

    /* 我的订单 */
    public function order(){

        $where = "1";

        if(isset($_GET['status']) && in_array($_GET['status'],array('待付款','待发货','待收货','待评价'))){
            $where .= " and status = '{$_GET['status']}'";
        }

        /**
         * 订单分页： 先group订单编号，统计group后的订单总数量
         *           再从group订单编号中取出5条
         *           再查询出该5条订单编号的订单信息
         */
        $model = D('orders');

        // 计算总记录数
        $count = $model->getOrderCount($_SESSION['eater_uid'],$where);

        // 每页5条
        $page = new Page($count[0]['number'],5);

        // 取出分页中的订单号，逗号隔开
        $_ordersn_arr = $model->field("ordersn")->group("ordersn")->order("time desc")->where("user_id = '{$_SESSION['eater_uid']}' and $where  and is_delete = '否'")->limit($page->firstRow.','.$page->listRows)->select();
        $ordersn = implode(',',array_column($_ordersn_arr,'ordersn'));

        if($ordersn){
            /* 获取商品信息 */
            $data = $model->
                        field("a.id,a.number,a.goods_attr,a.price,a.status,a.time,a.pay_type,a.orderSn,b.store_id,b.id goods_id,b.goods_title,b.goods_logo_url,c.store_name")->
                            alias("a")->
                                join("left join sh_goods b on b.id = a.goods_id")->
                                join("left join sh_store c on b.store_id = c.id")->
                                    where("a.ordersn IN ($ordersn)")->
                                        order("a.time desc")->
                                            select();

            /* 获取商品属性 */
            $goodsAttrModel = M('goods_attr');
            $arr = array();
            foreach($data as $k => $v){
                if($v['goods_attr']){
                    $goods_attr = str_replace('&',',',$v['goods_attr']);
                    $ga = $goodsAttrModel->
                                    alias('a')->
                                        field('a.attr_value,b.attr_name')->
                                            join("left join sh_attribute b on a.attr_id = b.id")->
                                                where("a.id IN ($goods_attr)")->
                                                    select();
                    $data[$k]['ga'] = $ga;
                }
                $arr[$v['ordersn']][] = $data[$k];
            }
        }else{
            $arr = array();
        }

        /* 统计订单数量 */
        $_orders_count = $model->getOrderCount($_SESSION['eater_uid']);
        $orders_count = array_column($_orders_count,'number','status');


        $this->assign(array(
            'orders_count' => $orders_count,
            'orders'       => $arr,
            'show'         => $page->show()
        ));
        layout('Layout/layout2');
        $this->display();
    }

    /* 取消订单 */
    public function cancel_order(){

        if(IS_AJAX){

            $ordersn = $_POST['ordersn'];

            $orderModel = M('orders');

            $orderModel->startTrans();  // 开启事务

            // 返还积分
            $return_points = $orderModel->where("user_id = '{$_SESSION['eater_uid']}' and status = '待付款' and ordersn = '{$ordersn}'")->sum('points_place_number');
            if(M('member')->where("id = '{$_SESSION['eater_uid']}'")->setInc('points',$return_points) === false){
                $orderModel->rollback();
                $this->ajaxReturn(array('status'=>false,'result'=>'取消失败，请刷新重试！'));exit;
            }
            // 删除订单
            if($orderModel->where("user_id = '{$_SESSION['eater_uid']}' and status = '待付款' and ordersn = '{$ordersn}'")->delete()){
                $orderModel->commit();
                $this->ajaxReturn(array('status'=>true,'result'=>'取消订单成功~'));exit;
            }else{
                $orderModel->rollback();
                $this->ajaxReturn(array('status'=>false,'result'=>'取消订单失败！'));exit;
            }
        }
    }

    /* 查看物流，获取快递单号 */
    public function get_express_number($ordersn){

        if(IS_AJAX){
            $model = M('orders');
            if($osn = $model->where("ordersn = '{$ordersn}'")->getField('express_number')){
                $this->ajaxReturn(array('status'=>true,'result'=>'快递单号：'.$osn));exit;
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'快递单号获取失败！'));exit;
            }
        }

    }

    /* 提醒发货 */
    public function warn_send($ordersn){

        if(IS_AJAX){

            /* 获取店铺id */
            $model = M('orders');
            $store_id = $model->
                            alias('a')->
                            join("left join sh_goods b on a.goods_id = b.id")->
                            where("a.ordersn = '{$ordersn}'")->
                            getField('b.store_id');

            /* 获取店铺商家的email */
            $storeModel = M('store');
            $store_email = $storeModel->
                                alias('a')->
                                join("left join sh_user b on a.user_id = b.id")->
                                where("a.id = '{$store_id}'")->
                                getField('b.email');

            /**********限制每天的发送次数为 3次***********/
            $number = isset($_COOKIE['warn_send_number']) ? $_COOKIE['warn_send_number'] : 0;
            $number = $number + 1;
            setcookie("warn_send_number",$number,time()+60*60*24,'/');
            if($number <= 3 ){
                $content = "订单编号：".$ordersn.'，提醒发货，请您尽快发货！';
                sendMail($store_email,'买家提醒您发货啦~',$content);  // 发送邮件
            }

        }
    }

    /* 删除订单 */
    public function delete_order(){
        if(IS_AJAX){
            $ordersn    = $_POST['ordersn'];
            $orderModel = M('orders');
            /* 并非真正的删除，只是更改字段，让该订单不再在该用户的订单中显示 */
            if($orderModel->where("user_id = '{$_SESSION['eater_uid']}' and ordersn = '{$ordersn}'")->setField('is_delete','是') !== false){
                $this->ajaxReturn(array('status'=>true,'result'=>'删除成功'));exit;
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'删除失败'));exit;
            }
        }
    }

    /* 确认收货 */
    public function take_delivery(){

        if(IS_AJAX){

            $ordersn     = $_POST['ordersn'];
            $password    = md5($_POST['password']);
            $memberModel = M('member');

            // 判断用户输入的登录密码是否正确
            if(!$memberModel->where("id = '{$_SESSION['eater_uid']}' and password = '{$password}'")->count()){
                $this->ajaxReturn(array('status'=>false,'result'=>'您输入的密码有误'));exit;
            }

            $model = M('orders');
            $model->startTrans();    // 开启事务

            // 统计当前订单的总金额
            $total_price = $model->where("ordersn = '{$ordersn}'")->sum('price');

            // 用户的累计消费 增加
            if($memberModel->where("id = '{$_SESSION['eater_uid']}'")->setInc('total_cost',$total_price) ===  false){
                $model->rollback();  // 事务回滚
                $this->ajaxReturn(array('status'=>false,'result'=>'收货失败'));exit;
            }

            // 修改订单状态为 待评价
            if($model->where("user_id = '{$_SESSION['eater_uid']}' and ordersn = '{$ordersn}'")->setField('status','待评价')){
                $model->commit();    // 提交事务
                $this->ajaxReturn(array('status'=>true,'result'=>'收货成功'));exit;
            }else{
                $model->rollback();  // 事务回滚
                $this->ajaxReturn(array('status'=>false,'result'=>'收货失败'));exit;
            }
        }
    }

    /* 获取被评论的商品信息 */
    public function get_remark_goods_info(){

        if(IS_AJAX){
            $ordersn = $_POST['ordersn'];
            $model   = M('orders');
            $data    = $model->
                            field("a.goods_id,a.goods_attr,b.goods_title,b.goods_logo_url,b.store_id")->
                            alias('a')->
                            join("left join sh_goods b on a.goods_id = b.id")->
                            where("a.ordersn = '{$ordersn}' and a.user_id = '{$_SESSION['eater_uid']}' and status = '待评价'")->
                            group("a.goods_id")->
                            select();
            if($data){
                $this->ajaxReturn(array('status'=>true,'result'=>$data));exit;
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'数据获取失败，尝试刷新重试'));exit;
            }
        }
    }

    /* 评论 */
    public function remark(){

        if(IS_AJAX){

            $remark_content = $_POST['remark_content']; // 评论内容
            $desc           = $_POST['desc'];           // 描述相符分数
            $logistics      = $_POST['logistics'];      // 物流服务分数
            $service        = $_POST['service'];        // 服务态度分数
            $ordersn        = $_POST['ordersn'];        // 订单编号
            $goods_attr     = $_POST['goods_attr'];     // 商品属性
            $keys = array_keys($desc);  // $keys为店铺id

            $model = D('remark');

            /* 验证表单数据，验证失败，返回错误信息 */
            $return = $model->valid();
            if(!$return['status']){
                $this->ajaxReturn($return);exit;
            }

            $model->startTrans();   // 开启事务
            $orderModel     = M('orders');
            $goodsAttrModel = M('goods_attr');
            $remark_id = array();
            /**
             * 此处想获取返添加的最新id值，用于添加评论图片，所以就不能addAll，只能循环add
             */
            foreach($remark_content as $k => $v){
                $remark = array();

                /* 获取购买该商品时所选的属性 */
                if($goods_attr[$k]){
                    $ga = str_replace('&',',',$goods_attr[$k]);
                    $_gaData = $goodsAttrModel->query("select CONCAT(b.attr_name,'：',a.attr_value) goods_attr from sh_goods_attr a 
                                                            left join sh_attribute b on a.attr_id = b.id 
                                                                where a.id IN ({$ga});");
                    $gaData = implode('<br>',array_column($_gaData,'goods_attr'));
                }else{
                    $gaData = "";
                }

                $remark['goods_attr']       = $gaData;
                $remark['goods_id']         = $k;
                $remark['remark_content']   = $v;
                $remark['desc_points']      = $desc[$keys[0]];
                $remark['logistics_points'] = $logistics[$keys[0]];
                $remark['service_points']   = $service[$keys[0]];
                $remark['store_id']         = $keys[0];
                $remark['user_id']          = $_SESSION['eater_uid'];
                $remark['time']             = date("Y-m-d H:i:s");
                if($id = $model->add($remark)){
                    $remark_id[$k] = $id;
                }else{
                    $model->rollback();
                    $this->ajaxReturn(array('status'=>false,'result'=>'评价失败，尝试刷新重试！'));exit;
                }

            }

            /****修改订单状态为：完成订单***/
            if($orderModel->where("ordersn = '{$ordersn}' and user_id = '{$_SESSION['eater_uid']}'")->setField('status','完成订单') === false){
                $model->rollback();
                $this->ajaxReturn(array('status'=>false,'result'=>'评价失败'));exit;
            }

            // 获取所有晒图的地址
            $remark_image = $model->get_remark_image_url($remark_id);
            if($remark_image){
                $remarkImageModel = M('remark_image');

                /* 如果添加失败，删除所有图片，并事务回滚 */
                if(!$remarkImageModel->addAll($remark_image)){
                    foreach($remark_image as $k => $v){
                        @unlink('./Uploads/'.$v['image_url']);
                    }
                    $model->rollback();
                    $this->ajaxReturn(array('status'=>false,'result'=>'评价失败'));exit;
                }
            }

            /* 若以上均成立，提交事务，评价成功 */
            $model->commit();
            $this->ajaxReturn(array('status'=>true,'result'=>'评价成功'));exit;

        }
    }

}