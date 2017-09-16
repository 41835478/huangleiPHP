<?php
/**
 * 订单列表
 */
namespace Trade\Controller;
use Home\Controller\CommonController;
class OrderController extends CommonController
{

    public function _initialize()
    {
        /* 从哪个页面跳转过来的 */
        $refer = $_SERVER['HTTP_REFERER'];
        setcookie('refer',$refer);
        return parent::_initialize();

    }

    // 订单列表
    public function lst(){
        $where = "1";
        /**********根据订单状态查询**********/
        if(isset($_GET['status']) && in_array($_GET['status'],array('待付款','待发货','待收货','待评价','完成订单'))){
            $where .= " and a.status = '{$_GET['status']}'";
        }

        /************根据订单编号查询***********/
        if(isset($_GET['ordersn']) && $_GET['ordersn']){
            $where .= " and a.ordersn = '{$_GET['ordersn']}'";
        }

        $ordersWhere = '1';

        if($_SESSION['rid'] == '9'){

            $uid = $_SESSION['uid'];
            $goods_id_item = M('store')->query("select GROUP_CONCAT(b.id) goods_id_item from sh_store a left join sh_goods b on a.id = b.store_id where a.user_id = '{$uid}' group by a.id;");
            $where .= " and a.goods_id IN ({$goods_id_item[0]['goods_id_item']})";
            $ordersWhere .= " and goods_id IN ({$goods_id_item[0]['goods_id_item']})";
        }

        // 获取订单信息
        $model = M('orders');
        $data  = $model->
                    field("
                    a.goods_id,a.price,a.points_place_number,a.time,a.number,a.status,a.ordersn,a.pay_type,
                    b.goods_logo_url,b.goods_title")->
                        alias('a')->
                            join("left join sh_goods b on a.goods_id = b.id")->
                                where($where)->
                                    select();

        // 订单根据订单编号分组
        $arr = array();
        foreach($data as $k => $v){
            $arr[$v['ordersn']][] = $data[$k];
        }

        // 统计订单状态
        $orderModel    = M('orders');
        $_orders_count = $orderModel->query("select a.status,count(*) number from (select status from sh_orders where $ordersWhere group by ordersn) as a group by a.status");
        $orders_count  = array_column($_orders_count,'number','status');

        $this->assign('orders_count',$orders_count);
        $this->assign('orders',$arr);
        $this->display();

    }

    // 订单详细
    public function detailed(){

        $ordersn = $_GET['ordersn'];

        if($ordersn){

            $model = M('orders');

            $goodsAttrModel = M('goods_attr');

            /*********获取订单信息********/
            $data = $model->
                        field("b.goods_logo_url,b.goods_title,
                        a.goods_id,a.number,a.price,a.goods_attr,a.status,a.time,a.pay_type,a.points_place_number,a.address_id,a.pay_time,a.express_number,a.ordersn,
                        c.username")->
                        alias('a')->
                        join("left join sh_member c on a.user_id = c.id")->
                        join("left join sh_goods b on a.goods_id = b.id")->
                        where("ordersn = '{$ordersn}'")->
                        select();

            /******获取商品属性信息********/
            foreach($data as $k => $v){

                if($v['goods_attr']){
                    $goods_attr = str_replace('&',',',$v['goods_attr']);
                    $data[$k]['ga'] = $goodsAttrModel->
                        field('a.attr_value,b.attr_name')->
                        alias('a')->
                        join("left join sh_attribute b on a.attr_id = b.id")->
                    where("a.id IN ($goods_attr)")->
                    select();
                }

            }

            /************获取收货地址*************/
            $addressModel = M('address');
            $address = $addressModel->field("name,province,city,county,address,phone")->find($data[0]['address_id']);

            $this->assign(array(
                'address' => $address,
                'data'    => $data
            ));



            $this->display();
        }else{
            $this->redirect('Order/lst');
        }

    }

    // 发货，填写订单号，修改订单状态
    public function delivery(){

        if(IS_AJAX){

            $express_number = $_POST['express_number'];

            if(!$express_number){
                $this->ajaxReturn(array('status'=>false,'result'=>'请填写正确的订单号'));exit;
            }

            $ordersn = $_POST['ordersn'];
            $model = M('orders');
            if($model->where("ordersn = '{$ordersn}'")->setField(array('status'=>'待收货','express_number'=>$express_number))){
                $this->ajaxReturn(array('status'=>true,'result'=>'发货成功'));exit;
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'发货失败，尝试刷新重试！'));exit;
            }

        }

    }

}