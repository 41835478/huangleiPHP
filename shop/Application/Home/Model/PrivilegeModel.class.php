<?php
namespace Home\Model;
use Think\Model;
class PrivilegeModel extends Model
{

    protected $_validate = array(

        array('pri_name','require','权限名称不能为空'),
        array('module_name','require','模块名称不能为空'),
        array('controller_name','require','控制器名称不能为空'),
        array('action_name','require','方法名称不能为空'),

    );


    public function priTree(){
        $priData = $this->select();
        return $this->reSort($priData);
    }

    //无限极分类，排序生成树形结构
    public function reSort($data, $parent_id = 0, $level = 0){
        static $sortData = array();

        foreach($data as $k => $v){
            //先找到数组中的顶级权限
            if($v['parent_id'] == $parent_id){
                $v['level'] = $level;
                $sortData[] = $v;
                //再找到顶级权限的下级权限
                $this->reSort($data,$v['id'],$level+1);
            }
        }

        return $sortData;
    }

    //将数组键值更改为id值，用于生成树形数组
    public function getPriArr(){
        $data = $this->select();
        $arr = array();
        foreach($data as $k => $v){
            $arr[$v['id']] = $v;
        }
        return $arr;
    }

    //巧用引用，生成树形结构
    function generateTree($data){
        $tree = array();
        foreach($data as $v){

            if(isset($data[$v['parent_id']])){
                
                $data[$v['parent_id']]['children'][] = &$data[$v['id']];
            }else{
                $tree[] = &$data[$v['id']];
            }
        }
        return $tree;
    }

    //取出所有下级id
    public function getChildrenPriId($priId){
        $priData = $this->select();
        return $this->_getChildrenPriId($priData,$priId);
    }
    public function _getChildrenPriId($data,$parent_id){
        static $priId = array();
        foreach($data as $k => $v){
            if($v['parent_id'] == $parent_id){
                $priId[] = $v['id'];
                $this->_getChildrenPriId($data,$v['id']);
            }
        }
        return $priId;
    }
/*
 *
 * 因ajax 与tp中的钩子函数，有冲突
 *//*
    public function _before_delete($data){

        if(is_array($data['where']['id'])){

            $ids = explode(',',$data['where']['id'][1]);
            $child = array();
            foreach($ids as $k => $v){
                $child = $this->getChildrenPriId($v);

            }
            $child = array_unique($child);  //去重
            $child = implode(',',$child);
            $this->execute("delete from sh_privilege where id IN($child)");
        }else{

            $priId = $this->getChildrenPriId($data['where']['id']);
            $priId = implode(',',$priId);
            /**
             * tp中的query方法是执行查询的方法，并返回结果集
             *      execute 是执行删除 增加 更改，并返回影响的记录数
             *//*

            $this->execute("delete from sh_privilege where id IN ($priId)");

        }


    }
*/



}