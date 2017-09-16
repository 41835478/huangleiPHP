<?php
/**
 * 基础控制器，判断权限以及登录状态
 */
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller
{
    public function _initialize(){

        if(!isset($_SESSION[md5('user'.'黄磊')])){
            $this->redirect(MODULE_NAME.'/Login/login');
            exit;
        }
        

        if(MODULE_NAME == 'Home' && CONTROLLER_NAME == 'Index'){
            return true;
        }

            $str = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;


            if($_SESSION['url'] != '*' && !in_array($str,$_SESSION['url'])){
                $this->error('无权访问');
            }









    }
}