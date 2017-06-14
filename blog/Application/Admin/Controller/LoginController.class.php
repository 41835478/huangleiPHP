<?php
/**
 *
 * 登录控制器
 */
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller
{

            //登录
    public function login(){
       
        //echo $_COOKIE['user'];
        if(IS_POST){
        
            $userModel = D('user');

            $user = $_POST['username'];
            $pass = $_POST['password'];
            
            if($userModel->login($user,$pass) === TRUE){


                $this->ajaxReturn(array('status'=>true,'result'=>'登录成功','time'=>$_SESSION['time']));
            }else{

                $this->ajaxReturn(array('status'=>false,'result'=>'账号或密码错误'));
                exit;
            }
        }else{
            $this->display();
        }

    }

            //修改密码 1：原密码错误 2：修改失败 4：修改成功
    public function change_pwd(){

        $old_pwd = $_POST['old_pwd'];
        $new_pwd = $_POST['new_pwd'];

        $id = $_SESSION['id'];
        $userModel = M('user');
        $res = $userModel->find($id);
        if($res['password'] != $old_pwd){

            $this->ajaxReturn(array('status'=>'1','result'=>'原密码错误！'));
            exit;
        }else{

            if($userModel->where('id='.$id)->setField('password',$new_pwd)){

                $this->ajaxReturn(array('status'=>'4','result'=>'修改成功，请牢记~'));
                exit;
            }else{

                $this->ajaxReturn(array('status'=>'2','result'=>'修改失败！'));
                exit;
            }
        }

    }


            //退出
    public function logout(){
        session_unset();
        session_destroy();
        cookie('user',null);
        cookie('pass',null);
        $this->redirect('Login/login');
    }


}