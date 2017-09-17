<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type:text/html;charset=utf8');
class CommonController extends Controller
{/*
    //其他控制器都集成这个Common控制器，防止有人直接在网址上面输入，直接就进来
    public function _initialize(){
        if(!isset($_SESSION['username'])) {
            $this->error('请先登录！', U(MODULE_NAME . '/Login/login'));
        }

    }*/
}