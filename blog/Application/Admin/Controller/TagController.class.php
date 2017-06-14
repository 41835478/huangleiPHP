<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class TagController extends CommonController
{
        //添加
    public function add(){

        if(IS_POST){

            $model = M('tag');

            $data['tag_name'] = trim($_POST['tag_name']);
            $data['tag_background_color'] = $_POST['tag_background_color'];

            $isExist = $model->where('tag_name="'.$data['tag_name'].'"')->count();

            if($isExist > 0){
                $this->ajaxReturn(array('status'=>false,'result'=>'标签已存在！'));exit;
            }

            if($model->add($data)){

                if(isset($_POST['article']) && $_POST['article'] == '1'){
                    $new = $model->limit(1)->order('id DESC')->select();
                    $this->ajaxReturn(array('new'=>$new,'status'=>true,'result'=>'添加成功~'));exit;
                }

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
            $where .= " and tag_name = '{$_GET['search']}'";
        }

        $model = M('tag');
        $tagData = $model->where($where)->select();
        $this->assign('tagData',$tagData);
        $this->display();
    }

        //修改
    public function save($id){

        $model = M('tag');
        if(IS_POST){

            $data['id'] = $_POST['id'];
            $data['tag_name'] = trim($_POST['tag_name']);
            $data['tag_background_color'] = $_POST['tag_background_color'];

            $isExist = $model->where('tag_name="'.$data['tag_name'].'" and id != "'.$data['id'].'"')->count();

            if($isExist > 0){
                $this->ajaxReturn(array('status'=>false,'result'=>'标签已存在！'));exit;
            }

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

        $model = M('tag');

        if($model->delete($id)){
            $this->ajaxReturn(array('status'=>true,'result'=>'删除成功~'));
        }else{
            $this->ajaxReturn(array('status'=>false,'result'=>'删除失败！'));
        }
    }

    //批量删除
    public function plDel(){
        $model = M('tag');
        $ids = $_POST['dels'];

        if($ids){
            $ids = implode(',',$ids);
            if(!$model->delete($ids)){
                $this->ajaxReturn(array('status'=>false,'result'=>'批量删除失败！'));
                exit;
            }
        }
        $this->ajaxReturn(array('status'=>true,'result'=>'批量删除成功~'));

    }

}