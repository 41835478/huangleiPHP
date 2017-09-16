<?php
namespace Goods\Model;
use Think\Model;
class RecommendModel extends Model
{
    protected $_validate = array(
        array('rec_name','require','推荐名称不能为空！',1),
        array('rec_info','require','推荐说明不能为空！',1),
    );
}