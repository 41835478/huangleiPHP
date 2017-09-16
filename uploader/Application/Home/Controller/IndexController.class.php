<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index(){
    	$this->display();
    }
    
    public function webup(){
               $config = array(
		   				'mimes'         =>  array(), //允许上传的文件MiMe类型
		   				'maxSize'       =>  0, //上传的文件大小限制 (0-不做限制)
		   				'exts'          =>  array('jpg', 'gif', 'png', 'jpeg'), //允许上传的文件后缀
		   				'autoSub'       =>  true, //自动子目录保存文件
		   				'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		   				'rootPath'      =>  './Public/Uploads/', //保存根路径
		   				'savePath'      =>  '',//保存路径
		   		);
		   		$upload = new \Think\Upload($config);// 实例化上传类
		   		$info   =   $upload->upload();
                $data['url'] = $info['file']['savepath'].$info['file']['savename'];
                $this->ajaxReturn($data,'json');
		   		if(!$info) {
		   			$this->error($upload->getError());// 上传错误提示错误信息
		   		}
    }


   
}