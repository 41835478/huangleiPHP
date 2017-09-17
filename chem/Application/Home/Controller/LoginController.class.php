<?php
namespace Home\Controller;
use Think\Controller;
use Think\Verify;
class LoginController extends Controller
{
    public function login(){
        if(IS_POST){
            //验证码验证
            $verify = new Verify();
            if(!$verify->check($_POST['code'])){
                $this->error('验证码错误！');
            }else {
                $admin = D('admin');
                //验证用户名和密码
                if ($row = $admin->where(array('username' => $_POST['username'], 'password' => $_POST['password'], 'level' => $_POST['level']))->select()) {
                    session('uid', $row[0]['id']);
                    session('username', $row[0]['username']);
                    session('level', $row[0]['level']);
                    session('name', $row[0]['name']);
                    $this->success('登录成功', U(MODULE_NAME . '/Back/index'));
                } else {
                    $this->error('账号信息有误！');
                }
            }
        }else{
            $this->display();
        }

    }
    //退出的时候，清空session
    public function logout(){
        session_unset();
        session_destroy();
        $this->success('退出成功!',U(MODULE_NAME.'/Login/login'));
    }
    //验证码
    public function verify(){
        $config = array(
            'fontSize'  =>  18,              // 验证码字体大小(px)
            'useCurve'  =>  false,            // 是否画混淆曲线
            'useNoise'  =>  false,            // 是否添加杂点
            'imageH'    =>  50,               // 验证码图片高度
            'imageW'    =>  100,               // 验证码图片宽度
            'length'    =>  2,               // 验证码位数
        );
        $verify = new Verify($config);
        $verify->entry();
    }
}