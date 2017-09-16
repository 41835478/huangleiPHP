<?php
namespace Home\Model;
use Think\Model;
class RoleModel extends Model
{
    protected $_validate = array(
        array('role_name','require','角色名称不能为空！'),


    );

    public function _before_insert(&$data,$option){
        $data['role_pri_id'] = implode(',',$data['role_pri_id']);
    }

    public function _before_update(&$data,$option){
        $data['role_pri_id'] = implode(',',$data['role_pri_id']);
    }
}