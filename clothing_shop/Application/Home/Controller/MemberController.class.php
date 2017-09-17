<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class MemberController extends CommonController
{

    public function lst(){

        $where = "1";

        if(isset($_GET['un']) && $_GET['un']){
            $where .= " AND username = {$_GET['un']}";

        }
        $admin = D('member');
        $mData = $admin->where($where)->select();
        $this->assign('mData',$mData);
        $this->display();
    }



    public function del(){
        $id = $_GET['id'];
        $admin = D('member');
        $admin->delete($id);
        $this->success('删除成功');

    }

}