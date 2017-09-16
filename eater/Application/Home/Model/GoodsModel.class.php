<?php
namespace Home\Model;
use Think\Model;
class GoodsModel extends Model
{

    // 获取商品信息以及店铺信息
    public function get_goods_store_info($goods_id){
        $data = $this->
                    alias('a')->
                    join("left join sh_store b on a.store_id = b.id")->
                    field('a.id,a.goods_title,a.goods_logo_url,a.goods_shop_price price,b.store_name,b.id sid,b.store_owner_name')->
                    where("a.id = '{$goods_id}'")->
                    find();
        return $data;
    }

    // 获取商品属性
    public function get_goods_attr($goods_attr_id_str){
        $data = M('goods_attr')->
                alias('a')->
                field('a.attr_value,a.attr_price,b.attr_name')->
                join("left join sh_attribute b on a.attr_id = b.id")->
                where("a.id IN ($goods_attr_id_str)")->
                select();
        return $data;

    }



}