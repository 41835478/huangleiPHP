<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class BuyController extends CommonController
{


    public function lst(){
        $admin = D('buy');
        $buyData = $admin->field('a.*,b.goods_name,b.goods_price,c.cat_name')->alias('a')->join('left join sh_goods b on a.gid = b.id')->join('left join sh_category c on b.cat_id = c.id')->select();
        $this->assign('buyData',$buyData);
        $this->display();
    }

    public function del(){
        $id = $_GET['id'];
        $admin = D('buy');
        $admin->delete($id);
        $this->success('删除成功');

    }

}