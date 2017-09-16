<?php
/**
 * 文章分类列表
 */
namespace Article\Controller;
use Home\Controller\CommonController;

class ArticleCatController extends CommonController
{

    //添加
    public function add(){

        if(IS_POST){
            $model = D('article_cat');
            if($model->create()){
                if($model->add()){
                    $this->ajaxReturn(array('status'=>true,'result'=>'添加成功~'));exit;
                }else{
                    $this->ajaxReturn(array('status'=>false,'result'=>$model->getDbError()));exit;
                }
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>$model->getError()));exit;
            }
        }else{
            $this->display();
        }

    }

    public function lst(){
        $model = M('article_cat');
        $acData = $model->select();
        $this->assign('acData',$acData);
        $this->display();
    }

    //修改
    public function save($id){
        $model = D('article_cat');
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

            $acData = $model->find($id);
            $this->assign('data',$acData);
            $this->display();
        }
    }

    /**
     * 已绑定外键，所以不需要在删除前将该分类下的文章删除，文章会随着分类修改和删除
     *
     */
    public function delete($id){
        $model = D('article_cat');
        if($model->delete($id)){
            $this->ajaxReturn(array('status'=>true,'result'=>'删除成功~'));
        }else{
            $this->ajaxReturn(array('status'=>false,'result'=>'删除失败，刷新重试！'));
        }

    }


    //批量删除
    public function plDel(){
        $model = D('article_cat');
        $ids = $_POST['dels'];
        if($ids){
            $ids = implode(',',$ids);
            if(!$model->delete($ids)){
                $this->ajaxReturn(array('status'=>false,'result'=>'删除失败，刷新重试！'));
                exit;
            }
        }
        $this->ajaxReturn(array('status'=>true,'result'=>'删除成功~'));
    }

    //排序
    public function sort(){
        $num = $_POST['num'];
        $id = $_POST['id'];
        $model = M('article_cat');

        if($model->where('id='.$id)->setField('ar_cat_sort',$num))
            echo 1;
        else
            echo 2;

    }


    //设置该广告状态
    public function setStatus(){
        $model = M('article_cat');
        $id = $_POST['id'];
        $status = $_POST['status'];
        if($status){

            if($model->where('id='.$id)->setField('ar_cat_show_status','启用')){
                echo 1;     //成功
                exit;
            }else{
                echo 2;     //失败
                exit;
            }

        }else{
            if($model->where('id='.$id)->setField('ar_cat_show_status','停用')){
                echo 1;
                exit;
            }else{
                echo 2;
                exit;
            }
        }
    }


}