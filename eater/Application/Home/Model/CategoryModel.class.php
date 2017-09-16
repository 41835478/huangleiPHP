<?php
/**
 * User: 黄磊
 * Date: 2017/3/11
 * Time: 18:05
 * 分类Model
 */
namespace Home\Model;
use Think\Model;
class CategoryModel extends Model
{
        //获取商品分类导航
    public function getCatNav(){
        $catData = $this->field('id,cat_name,parent_id')->select();
        $catSubTree = $this->_getCatNav($catData);
            //获取当前分类中的同级分类商品
        foreach($catSubTree as $k => $v){
            if($v['parent_id'] == 0)
            {
                    // 获取当前父级分类的所有子分类的id
                $_catIdItem = $this->getChildrenCatIdItem($v['id']);
                $catIdItem  = implode(',',$_catIdItem);

                if($catIdItem)
                {
                    $recCatData = M('recommend_item')->
                                    field('b.id')->
                                    alias('a')->
                                    where("value_id IN ($catIdItem)")->
                                    join("left join sh_category b on a.value_id = b.id")->
                                    select();

                    // 所有被推荐的子分类的id
                    $recCatId   = array_column($recCatData,'id');
                    $recCatId[] = $v['id'];
                    $allRecCatId = implode(',',$recCatId);
                    $catSubTree[$k]['recGoods'] = D('recommend')->getGoodsByRecName("商品（三级菜单中）同类推荐", $allRecCatId, 2);
                }
                else
                {
                    $catSubTree[$k]['catGoods'] = D('recommend')->getGoodsByRecName('商品（三级菜单中）同类推荐',$v['id'],2);
                }
            }
        }
        
        return $catSubTree;
    }
    
            ////巧用引用，实现无限极分类
    public function _getCatNav($data){
            //用数组的id值作为索引，才可使用此方法进行无限极分类
        $arr = array_column($data,null,'id');

        $tree = array();
        foreach($arr as $k => $v){
                //判断是否为顶级分类
            if(isset($arr[$v['parent_id']])){
                $arr[$v['parent_id']]['children'][] = &$arr[$v['id']];
            }else{
                $tree[] = &$arr[$v['id']];
            }
        }
        return $tree;
    }

    
        // 取出当前分类id的所有子分类id数组集合
    public function getChildrenCatIdItem($cat_id){
        $catData = $this->select();
        return $this->_getChildrenCatId($catData,$cat_id,true);
    }
    public function _getChildrenCatId($catData,$cat_id,$is_clear = false){
        static $arr = array();
        if($is_clear)
            $arr = array();
        foreach($catData as $k => $v){
            if($v['parent_id'] == $cat_id){
                $arr[] = $v['id'];
                $this->_getChildrenCatId($catData,$v['id']);
            }
        }
        return $arr;
    }

        // 根据当前分类的父级id，获取同类的所有id
    public function getSameCatByCatParentID($parent_id){
        $data = $this->select();
        return  $this->_getSameCatByCatParentID($data,$parent_id);

    }   
    public function _getSameCatByCatParentID($data,$parent_id){

        static $arr = array();
        foreach($data as $k => $v){
                if($v['id'] == $parent_id){
                    if($v['parent_id'] == 0){
                        $arr = $this->getChildrenCatIdItem($v['id']);
                        $arr[] = $v['id'];
                    }
                    $this->_getSameCatByCatParentID($data,$v['parent_id']);
                }
        }
        return $arr;
    }

}