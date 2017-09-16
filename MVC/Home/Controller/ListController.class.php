<?php
class ListController extends Controller {


	public function __construct() {
        
		$obj = Factory::setModel();
		parent::__construct($obj);
     
	}
	
	//实现初始页面
	public function index() {

        $this->model->page();
		$this->tpl->assign('name', '列表页');
		$this->tpl->display('default/list.tpl');
	}

    public function head() {
        $this->success('details/index');
    }

	public function update() {
		echo '更新！';
	}

}
