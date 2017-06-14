<?php
namespace Home\Controller;

use Think\Controller;
use Think\Page;
class IndexController extends Controller
{

    public $arr;
    public $now_here = "";
    public function _initialize()
    {

        $model   = M('article');

        $pageUrl = 'articles';

        $memcache = new \Memcache();
        $memcache->connect("localhost",11211);
        //$memcache->flush();die;

        /****** 获取所有分类 ******/
        if(!$catData = unserialize($memcache->get("catData"))){
            $catData = M('category')->field('id,cat_name,cat_order')->order('cat_order DESC')->where('cat_show_status="启用"')->select();
            $memcache->set("catData",serialize($catData),false,'3000');
        }

        /****** 获取所有标签 ******/
        if(!$tagData = unserialize($memcache->get("tagData"))){
            //列出所有标签,group by 比 distinct性能要好
            $tagData = $model->query("
                                    select b.* from article_tag_id a 
                                      left join blog_tag b on a.tag_id = b.id
                                        group by b.id
                                    ");
            $memcache->set("tagData",serialize($tagData),60*60*24*30);
        }



        $where   = "1 and a.ar_show_status = '启用'";
        //当点击其他分类时，根据分类，查询文章
        if(isset($_GET['category']) && $_GET['category']){

            $where .= " and a.ar_category_id = {$_GET['category']}";
                    //显示当前页面所在的位置
            foreach($catData as $k => $v){

                if($v['id'] == $_GET['category']){

                    $url = U('/articles/category/'.$v['id']);
                    $this->now_here .= ' > '.'<a href='.$url.'>'.$v['cat_name']."</a>".' 栏目';
                }
            }

            $pageUrl .= '/category/'.$_GET['category'];
        }


        //当点击其他标签时,根据标签，查询文章
        if(isset($_GET['tag']) && $_GET['tag']){

            $article_id_list = $model->query("select article_id from article_tag_id where tag_id = {$_GET['tag']}");
            if(!empty($article_id_list)){

                $article_id_list = array_column($article_id_list,'article_id');
                $article_id_list = implode(',',$article_id_list);
                $where .= " and a.id IN ($article_id_list)";

                    //显示当前页面所在的位置
                foreach($tagData as $k => $v){

                    if($v['id'] == $_GET['tag']){

                        $url = U('/articles/tag/'.$v['id']);
                        $this->now_here .= ' > '.'<a href='.$url.'>'.$v['tag_name']."</a>".' 标签';
                    }
                }

                $pageUrl .= '/tag/'.$_GET['tag'];
            }

        }

        //查询总条数
        $total = $model->alias('a')->where($where)->count();

        //实例化分页，每页显示 6 条
        $page  = new Page($total,5,'',$pageUrl.'/page');

        //定制分页显示信息的样式
        $page->setConfig('theme','%HEADER% %NOW_LOCATION% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');

        /** 获取文章 */
        $articles = $model->cache('articles',60*60*24*7)->query("
                            select a.*,b.cat_name,b.id cat_id,GROUP_CONCAT(d.tag_name separator ',') tags,GROUP_CONCAT(d.id separator ',') tags_id from blog_article a 
                              left join blog_category b on a.ar_category_id = b.id 
                                left join article_tag_id c on c.article_id = a.id 
                                  left join blog_tag d on c.tag_id = d.id 
                                    where $where
                                      group by a.id
                                        order by a.ar_order,a.ar_time desc
                                          limit $page->firstRow,$page->listRows
                            ");



        /* 最近发布 */
        if(!$time_list = unserialize($memcache->get("time_list")))
        {
            $time_list  = $model->query("select id,ar_title from blog_article where ar_show_status = '启用' order by ar_time desc limit 10");
            $memcache->set("time_list",serialize($time_list),60*60*24*30);
        }
        /* 阅读排行 */
        if(!$click_list = unserialize($memcache->get("click_list")))
        {
            $click_list = $model->query("select id,ar_title from blog_article where ar_show_status = '启用' order by ar_click_num desc limit 10");
            $memcache->set("click_list",serialize($click_list),60*60*24*30);
        }

        /** 当前ip点赞的文章 */
        $ip = GetIp();
        $like = M('like')->query("select article_id from blog_like where ip = '{$ip}'");
        if($like){
            $like = array_column($like,'article_id');
        }

        $this->arr  = array(
            'show'        => $page->show(),     //分页代码
            'catData'     => $catData,          //文章分类
            'tagData'     => $tagData,          //文章标签
            'articles'    => $articles,         //文章
            'time_list'   => $time_list,        //最近发布
            'click_list'  => $click_list,       //阅读排行
            'like'        => $like              //当前ip点赞的文章
        );

    }

    public function index(){

        $this->assign($this->arr);
        $this->assign('now_here',$this->now_here);   //页面当前位置
        $this->display();
    }






    public function content(){

        $ar    = $_GET['ar'];

        $model = M('article');
        $data  = $model->query("
                            select a.*,b.cat_name,b.id cat_id,GROUP_CONCAT(d.tag_name separator ',') tags,GROUP_CONCAT(d.id separator ',') tags_id from blog_article a 
                                  left join blog_category b on a.ar_category_id = b.id 
                                    left join article_tag_id c on c.article_id = a.id 
                                      left join blog_tag d on c.tag_id = d.id 
                                        where a.id=$ar
                                          group by a.id
                        ");

        $model->where('id='.$ar)->setInc('ar_click_num');

        $this ->assign('data',$data[0]);

        $this->now_here .= "> {$data[0]['ar_title']}";
        $this->assign('now_here',$this->now_here);
        $this ->assign($this->arr);
        $this ->display();
    }

    public function ajaxSetGood(){
        $id    = $_GET['id'];
        $model = M('article');
        $ip = GetIp();
        $location = GetIpLocation($ip);

        if(M('like')->where("ip = '{$ip}' and article_id = '{$id}'")->count() > 0){
            $this->ajaxReturn(array('status'=>false,'result'=>'已赞过了，感谢~'));exit;
        }


        if($model->where()->where('id='.$id)->setInc('ar_good_num')){
            $model->execute("insert into blog_like values(null,'{$ip}','{$location}','{$id}')");
            $this->ajaxReturn(array('status'=>true,'result'=>'点赞成功~'));
        }else{
            $this->ajaxReturn(array('status'=>false,'result'=>'点赞失败！'));
        }
    }


    public function _empty(){
        echo "Hello~~";
    }



}