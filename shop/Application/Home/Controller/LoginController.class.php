<?php
/**
 * 登录
 */
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller
{

    public function login(){
        if(IS_POST){
        
            $model = D('User');

        
            if($model->login()){
                
                $loginMsg['login_username'] = $_POST['username'];
                $location = GetIpLocation();
                $loginMsg['login_location'] =$location['province'].$location['city'];
                $loginMsg['login_ip'] = GetIp();
                $loginMsg['login_time'] = date("Y-m-d H:i:s");
                $loginMsg['status'] = '登录成功';
                M('loginMsg')->data($loginMsg)->add();
                echo 1;
            }else{
                $loginMsg['login_username'] = $_POST['username'];
                $location = GetIpLocation();
                $loginMsg['login_location'] =$location['province'].$location['city'];
                $loginMsg['login_ip'] = GetIp();
                $loginMsg['login_time'] = date("Y-m-d H:i:s");
                $loginMsg['status'] = '登录失败';
                M('loginMsg')->data($loginMsg)->add();

                echo 2;

            }
        }else{
            $this->display();
        }

    }

    public function logout(){
        session_unset();
        session_destroy();
        $this->redirect('Login/login');
    }

}