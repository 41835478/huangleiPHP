<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class BackController extends CommonController{

    public function index(){
        $this->display();
    }
    public function top(){
        $this->display();
    }
    public function menu(){
        $this->display();
    }
    public function main(){
        $this->display();
    }
    public function sav(){
        $admin = M('admin');
        if(IS_POST){
                $id = $_POST['id'];
                $arr['password'] = $_POST['password'];
                if(!trim($arr['password'])){
                    unset($arr);
                }
                if($admin->where('id='.$id)->save($arr) !== false){
                    $this->success('修改成功',U(MODULE_NAME.'/Back/main'));
                    exit;
                }else{
                    $this->error('修改失败,请重试！');
                }

        }else{
            $this->display();
        }
    }


}