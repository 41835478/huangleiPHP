<?php
/**
 * 基础控制器
 */
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller
{
    public function _initialize(){
        $chkLogin = false;

        if(isset($_COOKIE['user']) && isset($_COOKIE['pass'])){

            $chkLogin = D('user')->login($_COOKIE['user'],$_COOKIE['pass']);
        }
        
                //判断session是否存在，或者，是否选择了一周免登陆
        if(!(isset($_SESSION['username']) || $chkLogin)){
            redirect(__ROOT__."/Admin/Login/login");
            //$this->error('Login/login');
            //header("location:http://localhost/blog/index.php/Admin/Login/login");
        }

    }
}