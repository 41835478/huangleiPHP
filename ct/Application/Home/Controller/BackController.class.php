<?php
namespace Home\Controller;
use Home\Controller\CommonController;
header('Content-type:text/html;charset=utf8');
class BackController extends CommonController
{
    public function index(){
        $this->display();
    }
    public function menu(){
        $this->display();
    }
    public function main(){
        $this->display();
    }
    public function top(){
        $this->display();
    }
}