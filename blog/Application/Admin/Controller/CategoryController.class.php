<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class CategoryController extends CommonController
{
        //添加
    public function add(){

        if(IS_POST){

            $model = M('category');

            $data['cat_name'] = $_POST['cat_name'];
            $data['cat_show_status'] = $_POST['cat_show_status'];

            if($model->add($data)){

                $this->ajaxReturn(array('status'=>true,'result'=>'添加成功~'));exit;
            }else{

                $this->ajaxReturn(array('status'=>false,'result'=>'添加失败，请刷新重试'));exit;
            }
        }else{

            $this->display();
        }


    }

        //列表
    public function lst(){

        $where = "1";
        if(isset($_GET['search']) && $_GET['search']){
            $where .= " and cat_name = '{$_GET['search']}'";
        }

        $model = M('category');
        $catData = $model->where($where)->select();
        $this->assign('catData',$catData);
        $this->display();
    }

        //修改
    public function save($id){

        $model = M('category');
        if(IS_POST){

            $data['id'] = $_POST['id'];
            $data['cat_name'] = $_POST['cat_name'];
            $data['cat_show_status'] = $_POST['cat_show_status'];

            if($model->save($data) !== false){


                $this->ajaxReturn(array('status'=>true,'result'=>'修改成功~'));exit;
            }else{

                $this->ajaxReturn(array('status'=>false,'result'=>'修改失败，请刷新重试'));exit;
            }
        }else{
            $data = $model->find($id);
            $this->assign('data',$data);
            $this->display();
        }


    }

        //删除
    public function delete($id){

        $model = M('category');

        if($model->delete($id)){
            $this->ajaxReturn(array('status'=>true,'result'=>'删除成功~'));
        }else{
            $this->ajaxReturn(array('status'=>false,'result'=>'删除失败！'));
        }
    }

        //修改显示状态
    public function setShowStatus(){
        $model = M('category');
        $id = $_POST['id'];
        $status = $_POST['status'];
        if($status){
            if($model->where('id='.$id)->setField('cat_show_status','启用')){

                $this->ajaxReturn(array('status'=>true,'result'=>'已启用~'));exit;
            }else{

                $this->ajaxReturn(array('status'=>false,'result'=>'启用失败！'));exit;
            }

        }else{
            if($model->where('id='.$id)->setField('cat_show_status','停用')){

                $this->ajaxReturn(array('status'=>true,'result'=>'已停用~'));exit;
            }else{

                $this->ajaxReturn(array('status'=>false,'result'=>'停用失败！'));exit;
            }
        }
    }
        //排序
    public function sort(){
        $num = $_POST['num'];
        $id = $_POST['id'];
        $model = M('category');

        if($model->where('id='.$id)->setField('cat_order',$num) !== false)
            $this->ajaxReturn(array('status'=>true,'result'=>'更改成功~'));
        else
            $this->ajaxReturn(array('status'=>false,'result'=>'更改失败！'));

    }


}