<?php
namespace Goods\Model;
use Think\Model;
date_default_timezone_set("PRC");
class AttributeModel extends Model
{

    public function _before_insert(&$data){
        $data['attr_values'] = str_replace('，',',',$data['attr_values']);
    }

    public function _before_update(&$data){
        $data['attr_values'] = str_replace('，',',',$data['attr_values']);
    }


}