<?php
/**
 * 文章列表
 */
namespace Article\Controller;
use Home\Controller\CommonController;

class ArticleController extends CommonController
{

    //添加
    public function add(){

        if(IS_POST){
            $model = D('article');

            if($model->create()){

                if($model->add()){
                    $this->ajaxReturn(array('status'=>true,'result'=>'添加成功~'));exit;
                }else{
                    $this->ajaxReturn(array('status'=>false,'result'=>$model->getDbError()));exit;
                }
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>$model->getError()));exit;
            }
        }
        $acData = M('article_cat')->field('id,ar_cat_name')->select();
        $this->assign('acData',$acData);
        $this->display();

    }

    public function lst(){

            //取出文章分类
        $acData = M('article_cat')->select();


            //取出所有文章
        $where = "1";
        if(isset($_GET['ac_id']) && $_GET['ac_id']){
            $where .= " and ac_id = '{$_GET['ac_id']}'";
        }
        $model = M('article');
        $articles = $model->alias('a')->
                            field('a.*,b.ar_cat_name')->
                            join('left join sh_article_cat b on a.ac_id = b.id')->
                            where($where)->
                            select();

        $this->assign('articles',$articles);
        $this->assign('acData',$acData);
        $this->display();
    }


        //修改
    public function save($id){
        $model = D('article');
        if(IS_POST){

            if($model->create()){
                if($model->save()!== false)
                    $this->ajaxReturn(array('status'=>true,'result'=>'修改成功~'));
                else
                    $this->ajaxReturn(array('status'=>false,'result'=>'删除失败，刷新重试！'));
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>$model->getError()));
            }
        }else{
                /////查询该篇文章内容
            $article = $model->find($id);
                /////查询出所有文章分类
            $acData = M('article_cat')->field('id,ar_cat_name')->select();


            $this->assign('data',$article);
            $this->assign('acData',$acData);
            $this->display();
        }
    }

        ///删除
    public function delete($id){
        $model = D('article');
        if($model->delete($id)){
            $this->ajaxReturn(array('status'=>true,'result'=>'删除成功~'));
        }else{
            $this->ajaxReturn(array('status'=>false,'result'=>'删除失败，刷新重试！'));
        }

    }

        //排序
    public function sort(){
        $num = $_POST['num'];
        $id = $_POST['id'];
        $model = M('ad');

        if($model->where('id='.$id)->setField('ad_sort',$num))
            echo 1;
        else
            echo 2;

    }

    //设置该文章状态
    public function setStatus(){
        $model = M('article');
        $id = $_POST['id'];
        $status = $_POST['status'];
        if($status){

            if($model->where('id='.$id)->setField('ar_show_status','启用')){
                echo 1;     //成功
                exit;
            }else{
                echo 2;     //失败
                exit;
            }

        }else{
            if($model->where('id='.$id)->setField('ar_show_status','停用')){
                echo 1;
                exit;
            }else{
                echo 2;
                exit;
            }
        }
    }



}