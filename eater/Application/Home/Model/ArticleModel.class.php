<?php
/**
 * Created by PhpStorm.
 * User: hi~
 * Date: 2017/3/23
 * Time: 15:56
 * 文章 模型
 */
namespace Home\Model;
use Think\Model;
class ArticleModel extends Model
{


        // 获取所有文章
    public function getAllArticle(){

        $_article = $this->
            field("a.id,a.ar_title,a.ac_id,b.ar_cat_name")->
            alias('a')->
            join("left join sh_article_cat b on a.ac_id = b.id")->
            where("b.ar_cat_show_status = '启用' and a.ar_show_status = '启用'")->
            order("b.ar_cat_sort desc")->
            select();
        $article = array();
        foreach($_article as $k => $v){
            $article[$v['ac_id']][] =$v;
        }
        
        return $article;

    }

}