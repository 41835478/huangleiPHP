<?php
class DetailsController extends Controller {


	public function __construct() {
        ///实例化Details的Model类
		$obj = Factory::setModel();
		parent::__construct($obj);

	}
	
	//实现初始页面
	public function index() {

		echo 123;
		/*
		$this->tpl->assign('name', '详情页');
		$this->tpl->display('default/details.tpl');*/
	}



}
