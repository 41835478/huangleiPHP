<?php
/**
 * 意见反馈
 */
namespace Message\Controller;
use Home\Controller\CommonController;
class FeedbackController extends CommonController
{

    public function lst(){
        C('token_on',false);

        $where = '1';

        if(isset($_GET['search']) && $_GET['search']){
            $where .= " and content like '%{$_GET['search']}%'";
        }

        if(isset($_GET['is_look']) && $_GET['is_look']){
            $where .= " and is_look = '{$_GET['is_look']}'";
        }


        $model = M('feedback');
        $feedback = $model->
                        alias('a')->
                        field("b.nickname,b.username phone,b.email,a.id,a.content,a.is_look,a.time")->
                        join("left join sh_member b on a.user_id = b.id")->
                        where($where)->
                        order("a.time desc")->
                        select();
        $this->assign('feedback',$feedback);

        $this->display();
    }

    /* 设置反馈内容为已浏览 */
    public function setIsLook(){
        if(IS_AJAX){
            $id = $_GET['id'];
            $model = M('feedback');
            if($model->where('id='.$id)->setField('is_look','已浏览') !== false){
                $this->ajaxReturn(array('status'=>true,'result'=>'已浏览'));exit;
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'失败，刷新重试'));exit;
            }
        }
    }

    /* 反馈删除 */
    public function delete(){
        if(IS_AJAX){
            $id = $_GET['id'];
            $model = M('feedback');
            if($model->delete($id)){
                $this->ajaxReturn(array('status'=>true,'result'=>'删除成功'));exit;
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'删除失败，刷新重试'));exit;
            }
        }
    }

    /* 反馈批量删除 */
    public function plDelete(){
        if(IS_AJAX){
            $ids = implode(',',$_POST['ids']);
            if($ids){
                $model = M('feedback');
                if($model->where("id IN ({$ids})")->delete() !== false){
                    $this->ajaxReturn(array('status'=>true,'result'=>'批量删除成功'));exit;
                }else{
                    $this->ajaxReturn(array('status'=>true,'result'=>'批量删除失败，刷新重试'));exit;
                }
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'请先勾选您要删除的反馈'));exit;
            }

        }
    }

    /* 获取反馈内容 */
    public function ajaxGetFeedback(){
        if(IS_AJAX){
            $id = $_GET['id'];
            $model = M('feedback');
            $data = $model->field("content,reply_content")->find($id);
            if($data){
                $this->ajaxReturn(array('status'=>true,'result'=>$data));exit;
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'反馈内容获取失败，请刷新重试'));exit;
            }
        }
    }
    /* 反馈回复 */
    public function replay_feedback(){

        if(IS_AJAX){

            $id = $_POST['id'];
            $reply_content = $_POST['reply_content'];
            $model = M('feedback');
            if($model->where("id = '{$id}'")->setField('reply_content',$reply_content) !== false){
                $this->ajaxReturn(array('status'=>true,'result'=>'回复成功'));exit;
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'回复失败，请刷新重试'));exit;
            }

        }

    }
}