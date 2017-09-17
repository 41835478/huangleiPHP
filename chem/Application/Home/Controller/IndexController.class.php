<?php
namespace Home\Controller;
use Think\Controller;
use Think\Page;
class IndexController extends Controller
{
    public function index(){
        $model = M('safety'); // 实例化User对象
        $count = $model->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $this->safety = $model->order('time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->show  = $Page->show();// 分页显示输出
        $this->rules = M('rules')->order('time DESC')->limit(4)->select();
        //$this->safety = M('safety')->order('time DESC')->limit(5)->select();
        $this->notice = M('notice')->order('time DESC')->limit(4)->select();
        $this->display();
    }
    public function main(){
        $id = $_GET['id'];
        $this->msg = M('safety')->find($id);
        $this->display();
    }
    public function main1(){
        $id = $_GET['id'];
        $this->msg = M('rules')->find($id);
        $this->display('main');
    }
    public function main2(){
        $id = $_GET['id'];
        $this->msg = M('notice')->find($id);
        $this->display('main');
    }
}