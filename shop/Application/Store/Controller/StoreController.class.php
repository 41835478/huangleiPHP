<?php
/**
 * 店铺列表
 */
namespace Store\Controller;
use Home\Controller\CommonController;
class StoreController extends CommonController
{

    public function lst(){

        $model = M('store');
        $store = $model->field("a.store_status,a.id,a.store_name,a.store_logo_url,a.store_major_type,a.store_owner_name,a.store_owner_number,b.user_name,b.time")->
            alias('a')->
            join("left join sh_user b on a.user_id = b.id")->
            where("a.status = '通过审核'")->
            select();
        $this->assign('store',$store);

        $this->display();
    }

    // 设置店铺状态
    public function setStatus(){
        $model = M('store');
        $id = $_POST['id'];
        if($id == 1){
            die('呵呵哒~');
        }
        $status = $_POST['status'];
        if($status){
            if($model->where('id='.$id)->setField('store_status','启用')){
                echo 1;     //成功
                exit;
            }else{
                echo 2;     //失败
                exit;
            }

        }else{
            if($model->where('id='.$id)->setField('store_status','停用')){
                echo 1;
                exit;
            }else{
                echo 2;
                exit;
            }
        }
    }

    // 删除
    public function delete(){
        $id = $_GET['id'];
        if($id == 1){
            die('呵呵哒~');
        }
        $model = D('store');
        if($model->delete($id)){
            $this->ajaxReturn(array('status'=>true,'result'=>'删除成功~'));exit;
        }else{
            $this->ajaxReturn(array('status'=>false,'result'=>'删除失败，请刷新重试！'));exit;
        }
    }


        // 审核列表
    public function pending_lst(){
        $model = M('store');
        $storeData = $model->
            field('a.nopass_reason,a.id,a.store_name,a.store_logo_url,a.store_major_type,a.store_owner_name,a.store_owner_number,a.store_owner_img,a.status,a.time,b.username')->
            alias('a')->
            join("left join sh_member b on a.member_id = b.id")->
            where("a.status != '通过审核'")->
            select();
        $this->assign('storeData',$storeData);
        $this->display();
    }
        // 不通过审核
    public function nopass(){
        if(IS_POST){
            $id = $_POST['id'];
            $model = M('store');
            $info['nopass_reason'] = $_POST['nopass_reason'];
            $info['status'] = '审核未通过';
            if($model->where("id = '{$id}'")->save($info) !== false){
                $this->ajaxReturn(array('status'=>true,'result'=>'提交成功~'));exit;
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'提交失败，请刷新重试！'));exit;
            }
        }
    }
        // ajax 获取不通过的原因
    public function ajaxGetReason(){
        if(IS_AJAX){
            $id = $_GET['id'];
            $model = M('store');
            if($reason = $model->where("id = '{$id}'")->getField('nopass_reason')){
                $this->ajaxReturn(array('status'=>true,'result'=>$reason));exit;
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'获取失败，请刷新重试！'));exit;
            }
        }
    }

    // 通过
    public function pass(){
        if(IS_AJAX){
            $id = $_POST['id'];
            $model = D('store');

            if($user_id = $model->buildSeller()){

                $info['user_id'] = $user_id;
                $info['status'] = '通过审核';
                if($model->where('id='.$id)->save($info) !== false){
                    $this->ajaxReturn(array('status'=>true,'result'=>'操作成功~'));exit;
                }else{
                    $this->ajaxReturn(array('status'=>true,'result'=>'操作失败，请刷新重试！'));exit;
                }

            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'操作失败，请刷新重试！'));exit;

            }

        }
    }

    // 修改店铺信息
    public function save(){
        $model = D('store');
        if(IS_POST){
            C('TOKEN_ON',false);
            if($model->create()){
                if($model->save() !== false){
                    $this->ajaxReturn(array('status'=>true,'result'=>'修改成功~'));exit;
                }else{
                    $this->ajaxReturn(array('status'=>false,'result'=>'修改失败，刷新重试'));exit;
                }
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>$model->getError()));exit;
            }
        }
        $id = $_GET['id'];
        $data = $model->field("id,store_name,store_logo_url,store_major_type,store_keyword")->where("id = '{$id}'")->find();
        $this->assign('data',$data);
        $this->display();
    }
}