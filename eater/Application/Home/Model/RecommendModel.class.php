<?php
/**
 * Created by PhpStorm.
 * User: hi~
 * Date: 2017/3/14
 * Time: 10:17
 * 推荐
 */

namespace Home\Model;
use Think\Model;
header("Content-type:text/html;charset=utf8");
class RecommendModel extends Model
{

        //获取商品首页热门推荐
    public function getGoodsRecData(){

            //获取首页热门推荐位的id
        $rec_pos_id = $this->where('rec_name = "首页热门推荐" and rec_type = "商品"')->getField('id');

            //根据推荐位的id，取出被推荐的商品id
        $_goods_rec_id_item = M('recommend_item')->field('value_id')->where("rec_id = '{$rec_pos_id}' and pending_status = '通过审核' ")->select();
        if($_goods_rec_id_item){
            //将取出的商品id转成一维数组，并整合成字符串
            $goods_rec_id_item = implode(',',array_column($_goods_rec_id_item,'value_id'));

            //查询出所有在该推荐位被推荐的商品
            $goodsRecData = M('goods')->
            alias('a')->
            field('a.id,a.goods_logo_url,a.goods_title,a.goods_jl_title,a.goods_shop_price')->
            join("left join sh_store b on a.store_id = b.id")->
            where("a.id IN ($goods_rec_id_item) and a.is_sell = '是' and a.pending_status = '通过审核' and b.business_status='营业中' and b.store_status = '启用'")->
            limit(5)->
            select();
        }else{
            $goodsRecData = "";
        }


        return $goodsRecData;

    }

        // 获取首页分类推荐
    public function getCatRecData(){

        $rec_pos_id = $this->where('rec_name = "首页分类推荐" and rec_type = "分类"')->getField('id');
            // 取出所有被推荐的父级分类
        $catParentRecData = M('recommend_item')->
                                        alias('a')->
                                        field('b.id,b.cat_name,b.parent_id')->
                                        join("left join sh_category b on a.value_id = b.id")->
                                        where("a.rec_id = '{$rec_pos_id}' and b.parent_id = 0 and a.pending_status = '通过审核'")->
                                        select();
        if($catParentRecData){
            // 循环所有被推荐的父级分类
            foreach($catParentRecData as $k => $v){

                if($v['parent_id'] == 0){

                    //根据当前父级id取出所有子分类id
                    $_catIdItem = D('category')->getChildrenCatIdItem($v['id']);

                    $catIdItem  = implode(',',$_catIdItem);

                    //  判断当前分类是否有子分类
                    if($catIdItem)
                    {

                        //  获取所有被推荐的子分类，包括二级和三级，整合在数组中
                        $recCatData    = M('recommend_item')->
                                            field('b.id,b.cat_name')->
                                            alias('a')->
                                            where("a.value_id IN ($catIdItem) and a.rec_id = '{$rec_pos_id}'")->
                                            join("left join sh_category b on a.value_id = b.id and pending_status = '通过审核'")->
                                            select();

                        $catParentRecData[$k]['recCatData']   = $recCatData;
                       
                        // 所有被推荐的子分类的id
                        $recCatId      = array_column($recCatData,'id');

                        // 所有没有被推荐的子分类的id
                        $_notRecCatId  = array_diff($_catIdItem,$recCatId);
                        $notRecCatId   = implode(',',$_notRecCatId);

                        // 查询出所有没有被推荐的分类，存在数组中
                        $notRecCatData = M('category')->field('id,cat_name')->where("id IN ($notRecCatId)")->select();
                        $catParentRecData[$k]['notRecCatData'] = $notRecCatData;

                        //将父级id也放到子类id的数组中，用来查询出当前分类下所有被推荐的商品
                        $catIdItem .= ','.$v['id'];


                        // 取出首页分类推荐中的左中右被推荐的商品
                        $catParentRecData[$k]['left']  =  $this->getGoodsByRecName('商品（首页大类左侧轮播）同类推荐',$catIdItem);
                        $catParentRecData[$k]['mid']   =  $this->getGoodsByRecName('商品（首页大类中间）同类推荐',$catIdItem,6);
                        $catParentRecData[$k]['right'] =  $this->getGoodsByRecName('商品（首页大类右侧）同类推荐',$catIdItem,2);


                    }
                    else
                    {
                        $catParentRecData[$k]['catChildrenRec'] = "";
                        $catParentRecData[$k]['notRecCatData'] = "";
                        $catParentRecData[$k]['left']  =  $this->getGoodsByRecName('商品（首页大类左侧轮播）同类推荐',$v['id']);
                        $catParentRecData[$k]['mid']   =  $this->getGoodsByRecName('商品（首页大类中间）同类推荐',$v['id'],6);
                        $catParentRecData[$k]['right'] =  $this->getGoodsByRecName('商品（首页大类右侧）同类推荐',$v['id'],2);

                    }

                }
            }
        }else{
            $catParentRecData = "";
        }


//        echo "<pre>";
//        print_r($catParentRecData);
//        echo "</pre>";die;
        return $catParentRecData;
    }


        //  根本分类名称获取被推荐的商品
    public function getGoodsByRecName($rec_name, $cat_id_item, $limit=10){

            // 根据推荐位的名称获取推荐位的id
        $rec_id = $this->where("rec_name = '{$rec_name}' and rec_type = '商品'")->getField("id");

            // 取出当前推荐位的所有推荐商品的id
        $_recGoodsId = M('recommend_item')->field('value_id')->where("rec_id = '$rec_id' and type = '商品' and pending_status = '通过审核'")->select();
        if($_recGoodsId){

            $recGoodsId = implode(',',array_column($_recGoodsId,'value_id'));
            // 取出所有被推荐的商品
            $recGoodsData = M('goods')->
                    alias('a')->
                    join("left join sh_store b on a.store_id = b.id")->
                    field('a.id,a.goods_logo_url,a.goods_title,a.goods_jl_title,a.goods_shop_price')->
                    where("a.id IN ($recGoodsId) and a.cat_id IN ($cat_id_item) and a.is_sell = '是' and a.pending_status = '通过审核' and b.business_status='营业中' and b.store_status = '启用'")->
                    limit($limit)->
                    select();

        }else{
            $recGoodsData = "";
        }

        return $recGoodsData;
    }


        //   根据推荐名称 ， 取出分类
    public function getRecCatByRecName($rec_name,$limit = 5){
            // 获取推荐为id
        $rec_id = M('recommend')->where("rec_name = '{$rec_name}' and rec_type = '分类'")->getField('id');

        $_recCatId = M('recommend_item')->field('value_id')->where("rec_id = '$rec_id' and type = '分类' and pending_status = '通过审核'")->select();

        if($_recCatId){

            $recCatId = implode(',',array_column($_recCatId,'value_id'));

            $recCatData = M('category')->field('id,cat_name')->where("id IN ($recCatId)")->limit($limit)->select();

        }else{
            $recCatData = "";
        }

        return $recCatData;


    }



}