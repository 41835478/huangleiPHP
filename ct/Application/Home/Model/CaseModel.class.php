<?php
namespace Home\Model;
use Think\Model;
class CaseModel extends Model
{
    protected function _after_insert(&$data,$option){

        if(isset($_FILES['case']) && $_FILES['case']['tmp_name']){
            /************   添加图片到一个指定位置**********************/
            $upload = new \Think\Upload();   // 实例化
            $upload->maxSize   =     3145728;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            //./Uploads/代表  和入口文件（index.html）同级的一个文件夹
            $upload->rootPath  =      './Uploads/'; // 设置附件上传目录
            $upload->savePath  =      'Case/'; // 设置附件上传目录
            $info = $upload->upload();      //上传，并返回一个每张图片的相关信息，比如size，savepath，savename等等

            $model = M('images');
            $data = $this->order('id DESC')->limit(1)->select();
            foreach($info as $v){
                $images = $v['savepath'].$v['savename'];//拼接一个图片的地址
                $smimages = $v['savepath'].'sm_'.$v['savename'];
                $bigimages = $v['savepath'].'big_'.$v['savename'];
                $image = new \Think\Image();    //实例化
                //缩略图之前，要open这个图片(打开图像资源)
                $image->open('./Uploads/'.$images);
                $image->thumb(600, 400)->save('./Uploads/'.$bigimages);
                $image->thumb(50, 50)->save('./Uploads/'.$smimages);
                $model->add(array('case_id'=>$data[0]['id'],'images'=>$images,'sm_images'=>$smimages,'big_images'=>$bigimages));
            }
        }
    }

    protected function _before_update($data,$option){

        if(isset($_FILES['case']) && $_FILES['case']['tmp_name'][0]){

            /************   添加图片到一个指定位置**********************/
            $upload = new \Think\Upload();   // 实例化
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            //./Uploads/代表  和入口文件（index.html）同级的一个文件夹
            $upload->rootPath  =      './Uploads/'; // 设置附件上传目录
            $upload->savePath  =      'Case/'; // 设置附件上传目录
            $info = $upload->upload();
            $model = M('images');
            $data = $this->order('id DESC')->limit(1)->select();
            foreach($info as $v){
                $images = $v['savepath'].$v['savename'];//拼接一个图片的地址
                $smimages = $v['savepath'].'sm_'.$v['savename'];
                $bigimages = $v['savepath'].'big_'.$v['savename'];
                $image = new \Think\Image();    //实例化
                $image->open('./Uploads/'.$images);
                $image->thumb(700, 400)->save('./Uploads/'.$bigimages);
                $image->thumb(50, 50)->save('./Uploads/'.$smimages);
                $model->add(array('case_id'=>$data[0]['id'],'images'=>$images,'sm_images'=>$smimages,'big_images'=>$bigimages));
            }
        }

    }

    protected function _before_delete($options){

        if(is_array($options['where']['id'])){
            //当删除多个的时候
            $id = $options['where']['id'][1];
            $child = M('images')->field('images,sm_images,big_images')->where("case_id IN($id)")->select();
            //遍历删除
            foreach($child as $v){
                @unlink('./Uploads/'.$v['images']);
                @unlink('./Uploads/'.$v['sm_images']);
                @unlink('./Uploads/'.$v['big_images']);
            }

        }else{

            //当删除一个的时候，在Uploads这个文件夹中删除这个文件
            $child = M('images')->field('images,sm_images,big_images')->where("case_id=".$options['where']['id'])->select();
            foreach($child as $v){
                @unlink('./Uploads/'.$v['images']);
                @unlink('./Uploads/'.$v['sm_images']);
                @unlink('./Uploads/'.$v['big_images']);
            }
        }

    }

}