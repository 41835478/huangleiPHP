<?php
/**
 * Created by PhpStorm.
 * User: hi~
 * Date: 2017/3/16
 * Time: 10:06
 */

namespace Home\Controller;
use Think\Controller;


class CommonController extends Controller
{
    public function _initialize(){
        

            //  没办法准确的获取到上一个页面的url，都试过了。。。
        $refer = $_SERVER['HTTP_REFERER'];
        setcookie('refer',$refer);

        $catData  = D('category')->getCatNav();           // 获取所有分类，生成三级菜单，包含菜单中的同类推荐商品

        $articles = D('article')->getAllArticle();  // 获取所有文章

            // 搜索栏下方推荐
        $search_next_cat_rec = D('recommend')->getRecCatByRecName('搜索栏下方推荐',5);


        $this->assign(array(
            'catData'  => $catData,
            'articles' => $articles,
            'search_next_cat_rec' => $search_next_cat_rec
        ));





    }


}