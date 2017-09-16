<?php
namespace Goods\Model;
use Think\Model;
class GoodsAttrModel extends Model
{


    //获取该商品ID的,单选属性ID相同的二维数组
    public function getSameAttrIDArray($id){

        $goods_attr = $this->field('a.id,a.attr_value,a.attr_id,b.attr_name,b.attr_type,c.type_name')->
                                alias('a')->
                                where('a.goods_id='.$id.' and b.attr_type = "单选"')->
                                join('left join sh_attribute b on a.attr_id = b.id')->
                                join('left join sh_type c on b.type_id = c.id')->
                                select();


        $arr = array();
        foreach($goods_attr as $k => $v){
            $arr[$v['attr_id']][] = $v;
        }
        sort($arr);
        return $arr;
    }
}