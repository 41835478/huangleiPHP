<?php
namespace Goods\Model;
use Think\Model;
class CategoryModel extends Model
{


    public function _after_insert($data){
        $recId = $_POST['rec_id'];
        if($recId){

            $model = M('recommend_item');
            foreach($recId as $k => $v){
                $model->add(array(
                    'rec_id' => $v,
                    'value_id' => $data['id'],
                    'type' => '分类',
                    'pending_status' => '通过审核'
                ));
            }
        }

    }

    public function _after_update($data){
        M('recommend_item')->where('value_id='.$data['id'].' and type="分类"')->delete();
        $this->_after_insert($data);
    }



    public function catTree(){
        $catData = $this->query("select a.*,GROUP_CONCAT(c.rec_name) rec_name
                    from sh_category a 
                    left join sh_recommend_item b on a.id = b.value_id and b.type='分类' 
                    left join sh_recommend c on b.rec_id = c.id group by a.id"
        );

       
        return $this->reSort($catData);
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



    //取出所有下级id
    public function getChildrenPriId($catId){
        $catData = $this->select();
        return $this->_getChildrenPriId($catData,$catId);
    }
    public function _getChildrenPriId($data,$parent_id){
        static $catId = array();
        foreach($data as $k => $v){
            if($v['parent_id'] == $parent_id){
                $catId[] = $v['id'];
                $this->_getChildrenPriId($data,$v['id']);
            }
        }
        return $catId;
    }




}