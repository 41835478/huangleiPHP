<?php
/*
 * 系统首页 控制器
 */
namespace Admin\Controller;
use Admin\Controller\CommonController;
class IndexController extends CommonController
{

            //首页
    public function index(){
        $this->display();
    }


            //首页右侧页面home
    public function home(){

        $tagModel = M('tag');
        $tagNum = $tagModel->count();

        $artModel = M('article');
        $artNum = $artModel->count();

        $catModel = M('category');
        $catNum = $catModel->count();

        $this->assign(array(
            'tagNum' => $tagNum,
            'artNum' => $artNum,
            'catNum' => $catNum,
        ));

        $this->display();
    }



}