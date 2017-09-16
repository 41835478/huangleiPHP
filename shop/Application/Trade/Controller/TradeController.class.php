<?php
/**
 * 交易信息
 */
namespace Trade\Controller;
use Home\Controller\CommonController;
class TradeController extends CommonController
{

    public function trade(){

        $model = M('orders');
        $data = $model->query("select status,sum(price) total from sh_orders group by ordersn");
//        dump($data);
        $trade_money   = 0.00;
        $order_number  = 0;
        $trade_success = 0;
        foreach($data as $k => $v){
            if($v['status'] != '待付款'){
                $trade_money += $v['total'];
                $trade_success++;
            }
            $order_number++;
        }

        $this->assign(array(
            'trade_money'   => $trade_money,
            'order_number'  => $order_number,
            'trade_success' => $trade_success
        ));
        $this->display();

    }

    public function getOrderData(){
        if(IS_AJAX){
            $model = M('orders');
            $orders = $model->query("select month(a.time) month from sh_orders a where a.status != '待付款' group by a.ordersn");
            $data = array();
            foreach($orders as $k => $v){
                $data[$v['month']][] = $v;
            }
            $month = array();
            for($i=1;$i<=12;$i++){
                $month[] = count($data[$i]);
            }
            $this->ajaxReturn(array('data'=>$month));
        }



    }

}