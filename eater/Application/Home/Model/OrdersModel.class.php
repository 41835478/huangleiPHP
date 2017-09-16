<?php
namespace Home\Model;
use Think\Model;
class OrdersModel extends Model
{

    /* 统计用户各个订单状态的数量*/
    public function getOrderCount($user_id,$where = '1'){

        $order_count = $this->query("select count(*) number,a.status from (select status from sh_orders where user_id = '{$user_id}' and is_delete = '否' and $where group by ordersn) as a group by a.status");

        return $order_count;


    }


}