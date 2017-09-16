<?php

/***************引入smarty文件*********************/
header('Content-type:text/html;Charset=utf8');
define('ROOT_PATH',dirname(__FILE__));//创建一个实际路径
require ROOT_PATH.'/smarty/smarty/Smarty.class.php';

///////////////////////////////////////////////////////////////////////////////////////////////
/************常量****************/





//////////////////////////////////////////////////////////////////////////////////////////////
/**********************自动加载类************************/
function __autoload($className) {

    if (substr($className, -10) == 'Controller') {
        require ROOT_PATH.'/Home/Controller/'.$className.'.class.php';
    } elseif (substr($className, -5) == 'Model') {
        require ROOT_PATH.'/Home/Model/'.$className.'.class.php';
    } else {
        require ROOT_PATH.'/Public/'.$className.'.class.php';
    }

}

/////////////////////////////////////////////////////////////////////////////////////////////
/*************调用Factory类，根据url中的参数，调用相应控制器以及控制器中的方法****************/
Factory::setController()->run();



?>