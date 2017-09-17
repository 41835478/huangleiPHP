<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class ActionController extends CommonController
{


    public function lst(){
        $admin = D('action');
        $actionData = $admin->select();
        $this->assign('actionData',$actionData);
        $this->display();
    }

    public function del(){
        $id = $_GET['id'];
        $admin = D('action');
        $admin->delete($id);
        $this->success('删除成功');

    }

}