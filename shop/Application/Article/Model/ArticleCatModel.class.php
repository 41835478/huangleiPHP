<?php
namespace Article\Model;
use Think\Model;
class ArticleCatModel extends Model
{
    protected $_validate = array(
        array('ar_cat_name','require','文章分类名称不能为空！',1),
    );


    public function _before_insert(&$data){

        $data['ar_cat_insert_time'] = date("Y-m-d H:i:s");

    }
}