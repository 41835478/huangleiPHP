<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class AdminController extends CommonController {
    public function index(){
        $this->display();
    }

    
    public function menu(){
        $this->display();
    }

    public function top(){
        $this->display();
    }
}