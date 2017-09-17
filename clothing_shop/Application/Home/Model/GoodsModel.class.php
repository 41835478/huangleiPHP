<?php
namespace Home\Model;
use Think\Model;
use Think\Upload;

class GoodsModel extends Model
{
    protected function _before_insert(&$data,$option){


        if(isset($_FILES['goods_image']) && $_FILES['goods_image']['tmp_name']){
            $oldlogo = $_POST['oldlogo'];
            if($oldlogo){
                @unlink('./Uploads/'.$oldlogo);
            }
            $upload = new Upload();   // 实例化
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =      './Uploads/'; // 设置附件上传目录
            $upload->savePath  =      'Goods/'; // 设置附件上传目录
            $info = $upload->upload();
            $logo = $info['goods_image']['savepath'].$info['goods_image']['savename'];//拼接一个图片的地址
            $data['goods_image'] = $logo;

        }
        $data['goods_time'] = date("Y-m-d H:i:s");
    }

    protected function _before_update(&$data,$option){
        $this->_before_insert($data,$option);
    }
    protected function _before_delete($options){

        $child = $this->field('goods_image')->find($options['where']['id']);
        @unlink('./Uploads/'.$child['goods_image']);

    }
}