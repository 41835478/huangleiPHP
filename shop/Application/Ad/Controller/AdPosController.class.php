<?php
/**
 * 广告位列表
 */
namespace Ad\Controller;
use Home\Controller\CommonController;

class AdPosController extends CommonController
{

    //添加
    public function add(){

        if(IS_POST){
            $model = D('ad_pos');
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
        $model = M('ad_pos');
        $adData = $model->select();
        $this->assign('adData',$adData);
        $this->display();
    }

    //修改
    public function save($id){
        $model = D('ad_pos');
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

            $adData = $model->find($id);
            $this->assign('data',$adData);
            $this->display();
        }
    }

    //删除
    public function delete($id){
        $model = D('ad_pos');
        if($model->delete($id)){
            $this->ajaxReturn(array('status'=>true,'result'=>'删除成功~'));
        }else{
            $this->ajaxReturn(array('status'=>false,'result'=>'删除失败，刷新重试！'));
        }

    }


    //批量删除
    public function plDel(){
        $model = D('ad_pos');
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


}