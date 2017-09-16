<?php
/**
 * 首页
 */
namespace Home\Controller;
use Home\Controller\CommonController;
class IndexController extends CommonController
{
    public function index(){
        $this->display();
    }

    public function home(){

        $memberCount = M('member')->count();

        $model = M('orders');
        $data = $model->query("select status,sum(price) total from sh_orders group by ordersn");
        $trade_money   = 0.00;
        $order_number  = 0;
        foreach($data as $k => $v){
            if($v['status'] != '待付款'){
                $trade_money += $v['total'];
            }
            $order_number++;
        }

        $this->assign(array(
            'trade_money'   => number_format($trade_money,'2'),
            'order_number'  => $order_number,
            'memberCount' => $memberCount,

        ));
        $this->display();
    }


}