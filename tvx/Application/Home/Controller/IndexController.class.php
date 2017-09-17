<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class IndexController extends CommonController{

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
        //在主页面显示处所有 经销商 物业 业主
        $this->jsx = M('category')->where(array('level'=>1))->select();
        $this->wy = M('category')->where(array('level'=>2))->select();
        $this->yz = M('category')->where(array('level'=>3))->select();
        $this->display();
    }


}