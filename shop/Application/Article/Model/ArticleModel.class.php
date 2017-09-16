<?php
namespace Article\Model;
use Think\Model;

class ArticleModel extends Model
{
    protected $_validate = array(
        array('ac_id','0','请选择文章分类！','1','notequal'),
        array('ar_title','require','文章标题不能为空！','1'),
        array('ar_content','require','文章内容不能为空！','1'),
    );

    public function _before_insert(&$data){
        $data['ar_insert_time'] = date('Y-m-d H:i:s');
    }

}