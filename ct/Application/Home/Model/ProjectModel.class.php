<?php
namespace Home\Model;
use Think\Model;
class ProjectModel extends Model
{
    protected function _after_insert(&$data,$option){
        if(isset($_FILES['project']) && $_FILES['project']['tmp_name']){
            /************   添加图片到一个指定位置**********************/
            $upload = new \Think\Upload();   // 实例化
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            //./Uploads/代表  和入口文件（index.html）同级的一个文件夹
            $upload->rootPath  =      './Uploads/'; // 设置附件上传目录
            $upload->savePath  =      'Project/'; // 设置附件上传目录
            $info = $upload->upload();
            $model = M('pro_images');
            $data = $this->order('id DESC')->limit(1)->select();
            foreach($info as $v){
                $images = $v['savepath'].$v['savename'];//拼接一个图片的地址
                $smimages = $v['savepath'].'sm_'.$v['savename'];
                $bigimages = $v['savepath'].'big_'.$v['savename'];
                $image = new \Think\Image();    //实例化
                $image->open('./Uploads/'.$images);
                $image->thumb(700, 400)->save('./Uploads/'.$bigimages);
                $image->thumb(50, 50)->save('./Uploads/'.$smimages);
                $model->add(array('pro_id'=>$data[0]['id'],'images'=>$images,'sm_images'=>$smimages,'big_images'=>$bigimages));
            }
        }
    }
    protected function _before_update($data,$option){

        if(isset($_FILES['project']) && $_FILES['project']['tmp_name'][0]){

            /************   添加图片到一个指定位置**********************/
            $upload = new \Think\Upload();   // 实例化
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            //./Uploads/代表  和入口文件（index.html）同级的一个文件夹
            $upload->rootPath  =      './Uploads/'; // 设置附件上传目录
            $upload->savePath  =      'Project/'; // 设置附件上传目录
            $info = $upload->upload();
            $model = M('pro_images');
            $data = $this->order('id DESC')->limit(1)->select();
            foreach($info as $v){
                $images = $v['savepath'].$v['savename'];//拼接一个图片的地址
                $smimages = $v['savepath'].'sm_'.$v['savename'];
                $bigimages = $v['savepath'].'big_'.$v['savename'];
                $image = new \Think\Image();    //实例化
                $image->open('./Uploads/'.$images);
                $image->thumb(700, 400)->save('./Uploads/'.$bigimages);
                $image->thumb(50, 50)->save('./Uploads/'.$smimages);
                $model->add(array('pro_id'=>$data[0]['id'],'images'=>$images,'sm_images'=>$smimages,'big_images'=>$bigimages));
            }
        }

    }

    protected function _before_delete($options){

        if(is_array($options['where']['id'])){
            //当删除多个的时候
            $id = $options['where']['id'][1];
            $child = M('pro_images')->field('images,sm_images,big_images')->where("pro_id IN($id)")->select();
            //遍历删除
            foreach($child as $v){
                @unlink('./Uploads/'.$v['images']);
                @unlink('./Uploads/'.$v['sm_images']);
                @unlink('./Uploads/'.$v['big_images']);
            }

        }else{

            //当删除一个的时候，在Uploads这个文件夹中删除这个文件
            $child = M('pro_images')->field('images,sm_images,big_images')->where("pro_id=".$options['where']['id'])->select();
            foreach($child as $v){
                @unlink('./Uploads/'.$v['images']);
                @unlink('./Uploads/'.$v['sm_images']);
                @unlink('./Uploads/'.$v['big_images']);
            }
        }

    }

}