<?php
namespace Goods\Model;
use Think\Model;
use Think\Upload;
date_default_timezone_set("PRC");
class BrandModel extends Model
{

    public function _before_insert(&$data){
        $data['brand_add_time']= date("Y-m-d H:i:s");

    }

    public function _before_delete($data){
        if(is_array($data['where']['id'])){

            $img = $this->field('brand_img_url')->where("id IN ({$data['where']['id'][1]})")->select();
            foreach ($img as $k => $v)
            {
                @unlink('./Uploads/'.$v['brand_img_url']);
            }

        }else{
            $img_url = $this->field('brand_img_url')->find($data['where']['id']);
            @unlink('./Uploads/'.$img_url['brand_img_url']);
        }

    }

    

}