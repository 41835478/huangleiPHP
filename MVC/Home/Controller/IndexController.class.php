<?php
class IndexController extends Controller {
    
	public function __construct() {
        $obj = Factory::setModel();
		parent::__construct($obj);
	}
	
	//实现初始页面
	public function index() {
        $this->model->index();
		$this->tpl->assign('name', '首页');
		$this->tpl->display('default/index.tpl');
	}
	
	public function add() {
		echo '新增！';
	}

}
