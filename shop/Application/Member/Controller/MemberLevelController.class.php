<?php
/**
 * 会员等级 控制器
 */
namespace Member\Controller;
use Home\Controller\CommonController;

class MemberLevelController extends CommonController
{

    // 列表
    public function lst(){
        // 获取所有等级
        $model = D('member_level');
        $mlData = $model->getLevelData();
        $this->assign('mlData',$mlData);
        $this->display();
    }

    // 添加-会员等级
    public function add(){

        if(IS_AJAX){
            $model = D('member_level');
            C('TOKEN_ON',false);
            if($model->create()){
                if($model->add()){
                    $this->ajaxReturn(array('status'=>true,'result'=>'添加成功'));
                }else{
                    $this->ajaxReturn(array('status'=>false,'result'=>'添加失败'));
                }
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>$model->getError()));
            }
        }
    }

    //删除会员等级
    public function delete($id){
        $model = D('member_level');
        if($model->delete($id)){
            echo 1;
        }else{
            echo 2;
        }
    }

    public function save($id){

        $model = M('member_level');
        if(IS_POST){

            C('TOKEN_ON',false);
            if($model->create()){
                if($model->save() !== false){
                    $this->ajaxReturn(array('status'=>true,'result'=>'修改成功'));exit;
                }else{
                    $this->ajaxReturn(array('status'=>false,'result'=>'修改失败'));exit;
                }
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>$model->getError()));exit;
            }

        }else{

            // 获取会员等级信息
            $levelData = $model->find($id);
            if($levelData){
                $this->ajaxReturn(array('status'=>true,'result'=>$levelData));exit;
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'信息获取失败，刷新重试'));exit;
            }

        }

    }

}