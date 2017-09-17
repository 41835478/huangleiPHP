<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller
{
    public function login(){
        if(IS_POST){

            $admin = M('user');
            if($row = $admin->where(array('username'=>$_POST['username'],'password'=>md5($_POST['password'])))->select()){

                session('username',$_POST['username']);
                session('password',$_POST['password']);

                $this->success('登录成功',U(MODULE_NAME.'/Admin/index'));

            }else{
                $this->error('账号信息有误！');
            }

        }else{
            $this->display();
        }

    }
    public function logout(){
        session_unset();
        session_destroy();
        $this->success('退出成功!',U(MODULE_NAME.'/Login/login'));
    }

}