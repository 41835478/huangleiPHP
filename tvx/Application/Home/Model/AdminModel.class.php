<?php
namespace Home\Model;
use Think\Model;
use Think\Page;
class AdminModel extends Model{
    //通过这个方法，调用无限极分类
    public function catTree($catID){
        //$data = $this->select();
        $data = M('category')->select();
        return $this->_reSort($data,$catID);
    }
    //无限极分类
    private function _reSort($data,$parent_id = 0){
        static $ret = array();
        foreach($data as $v){

            if($v['parent_id'] == $parent_id){
                $ret[] = $v;

                $this->_reSort($data,$v['id']);
            }
        }
        return $ret;
    }
}