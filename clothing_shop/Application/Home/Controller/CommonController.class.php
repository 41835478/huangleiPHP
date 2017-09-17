<?php
/**
 * Created by PhpStorm.
 * User: huanglei_pc
 * Date: 2016/4/21
 * Time: 18:57
 */
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller
{
    public function _initialize(){
        if(!isset($_SESSION['username'])) {
            $this->redirect(MODULE_NAME . '/Login/login');
        }

    }
}