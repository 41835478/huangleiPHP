<?php
/**
 * 根据url中的 c（控制器） 和 a（方法） 参数 ，调用对应的控制器  以及 控制器中的方法
 */
class Factory {

	static private $obj = null;				//用来储存实例化的对象

	//实例controller 对象
	static public function setController() {

		if(isset($_GET['c']) && !empty($_GET['c']) && file_exists(ROOT_PATH.'/Home/Controller/'.ucfirst($_GET['c']).'Controller.class.php')){
			$c = $_GET['c'];
		}else{
			$c = 'Index';
		}

		eval('self::$obj = new '.ucfirst($c).'Controller();');
		return self::$obj;
	}

	//实例model 对象
	static public function setModel() {

		if(isset($_GET['c']) && !empty($_GET['c']) && file_exists(ROOT_PATH.'/Home/Model/'.ucfirst($_GET['c']).'Model.class.php')){
			$c = $_GET['c'];
		}else{
			$c = 'Index';
		}

		eval('self::$obj = new '.ucfirst($c).'Model();');

		return self::$obj;
	}


	
}
