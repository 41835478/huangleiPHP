<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class messageController extends CommonController
{


    public function lst(){
        $admin = D('message');
        $messageData = $admin->field('a.*,b.goods_name')->alias('a')->join('left join sh_goods b on a.gid = b.id')->select();
        $this->assign('messageData',$messageData);
        $this->display();
    }

    public function del(){
        $id = $_GET['id'];
        $admin = D('message');
        $admin->delete($id);
        $this->success('删除成功');

    }

}