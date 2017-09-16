<?php
/**
 * Class Controller : 控制器基类
 * 		自动调用TPL类中的实例化方法，生成一个smarty的对象，用$tpl变量储存
 * 		$model 用来储存子类中实例化 Model 的对象
 */
class Controller {

	protected $tpl = null;   //储存实例化smarty的对象
	protected $model = null;	//储存实例化model的对象

	//自动调用smarty的继承类TPL
	protected function __construct($model) {
		$this->tpl = TPL::getInstance();
		$this->model = $model;
	}

	//根据c参数，执行c控制器中的方法
	public function run() {
		//接收url中的m参数，判断是哪个方法
		$a = isset($_GET['a']) ? $_GET['a'] : 'index';

		//判断子类中是否存在$m这个方法，存在就运行这个方法，否则提示不存在
		//method_exists($this, $a) ? eval('$this->'.$a.'();') : exit($a.'方法不存在！');

		if(method_exists($this, $a))
            eval('$this->'.$a.'();');
		else
			$this->error($a);

	}

	//错误页面
	public function error($method) {
		$this->tpl->assign('method',$method);
		$this->tpl->display('jump/error.tpl');
	}

    //成功页面
    public function success($str) {
        $arr = explode('/',$str);
        $c = ucfirst($arr[0]);
        $a = $arr[1];
        $url = "?c={$c}&a={$a}";
        $this->tpl->assign('url',$url);
        $this->tpl->display('jump/success.tpl');


    }


}

