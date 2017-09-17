<?php
namespace Home\Model;
use Think\Model;
class CategoryModel extends Model
{

    public function catTree(){
        $data = $this->select();
        return $this->_reSort($data);
    }

    private function _reSort($data,$parent_id = 0,$level = 0){
        static $ret = array();
        foreach($data as $v){

            if($v['parent_id'] == $parent_id){
                $v['level'] = $level;
                $ret[] = $v;

                $this->_reSort($data,$v['id'],$level+1);
            }
        }
        return $ret;
    }

    public function getNavCatTree(){
        $data = $this->where('parent_id=0')->select();
        foreach($data as $k => $v){

            $data[$k]['children'] = $this->where('parent_id='.$v['id'])->select();
            foreach($data[$k]['children'] as $k1 => $v1){
                $data[$k]['children'][$k1]['children'] = $this->where('parent_id='.$v1['id'])->select();
            }

        }
        return $data;
    }

    //获取一个分类的所有子分类的ID
    public function getChildrenId($catID){
        $data = $this->select();
        return $this->_getChildrenId($data,$catID);
    }
    //递归函数，根据父类将所有子分类的id整合在一起
    private function _getChildrenId($data,$parent_id){
        static $ret = array();
        foreach($data as $v){

            if($v['parent_id'] == $parent_id){
                $ret[] = $v['id'];
                $this->_getChildrenId($data,$v['id']);
            }
        }
        return $ret;
    }

    //钩子函数，删除之前调用此函数
    protected function _before_delete($options){

        if(is_array($options['where']['id'])){
            $id = explode(',',$options['where']['id'][1]);
            $child = array();
            foreach($id as $v){
                $child = $this->getChildrenId($v);
            }

            $child = array_unique($child);
        }else{
           $child = $this->getChildrenId($options['where']['id']);
        }
        
        $child = implode(',',$child);
        $this->execute("delete from sh_category where id IN($child)");
    }
}