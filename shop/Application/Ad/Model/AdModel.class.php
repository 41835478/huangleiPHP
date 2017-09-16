<?php
namespace Ad\Model;
use Think\Model;
use Think\Upload;

class AdModel extends Model
{
    protected $_validate = array(

        array('ad_pos_id','0','请选择广告位！','1','notequal',1),
        array('ad_link_url','require','广告链接地址不能为空！',1),
    );

    public function _before_insert(&$data){
        $data['ad_insert_time'] = date('Y-m-d H:i:s');

        if(isset($_FILES['ad_image']['tmp_name']) && $_FILES['ad_image']['tmp_name']){

            $upload = new Upload();
            $upload->maxsize = 5242880;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
            $upload->savePath = 'ad/';
            $info = $upload->upload();
            $path = $info['ad_image']['savepath'].$info['ad_image']['savename'];
            $data['ad_image_url'] = $path;
        }else{

            echo json_encode(array('status'=>false,'result'=>'未上传广告图片！'));exit;
        }

    }

    public function _before_delete($data){

        $ad = $this->find($data['where']['id']);
        @unlink('./Uploads/'.$ad['ad_image_url']);

    }


    public function _before_update(&$data){

        if(isset($_FILES['ad_image']['tmp_name']) && $_FILES['ad_image']['tmp_name']){
            
            $upload = new Upload();
            $upload->maxsize = 5242880;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
            $upload->savePath = 'ad/';
            $info = $upload->upload();
            $path = $info['ad_image']['savepath'].$info['ad_image']['savename'];
            $data['ad_image_url'] = $path;
            @unlink('./Uploads/'.$_POST['old_img']);
        }


    }
}