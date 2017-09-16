<?php
/**
 * 广告列表
 */
namespace Ad\Controller;
use Home\Controller\CommonController;

class AdController extends CommonController
{

    //添加
    public function add(){

        if(IS_POST){
            $model = D('ad');
            C('TOKEN_ON',false);

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

    }

    public function lst(){

            //取出所有广告位
        $adPosData = M('ad_pos')->select();
        $this->assign('adPosData',$adPosData);

        $where = "1";

        if(isset($_GET['api']) && $_GET['api']){
            $where .= " and a.ad_pos_id = {$_GET['api']}";
        }
        $model = M('ad');
        $adData = $model->
            alias('a')->
            field('a.*,b.ad_pos_name,b.ad_pos_width,b.ad_pos_height')->
            join('left join sh_ad_pos b on a.ad_pos_id = b.id')->
            where($where)->
            select();

        $this->assign('adData',$adData);
        $this->assign('adPosData',$adPosData);
        $this->display();
    }

    public function ajaxGetAdPos(){
        $id = $_GET['id'];
        $model = M('ad_pos');
        $data = $model->find($id);
        $num = M('ad')->where('ad_pos_id='.$id.' and ad_show_status = "启用"')->count();
        if($num >=$data['ad_pos_limit']){
            echo 1;exit;
        }
        $this->ajaxReturn($data);
    }

        //设置该广告状态
    public function setStatus(){
        $model = M('ad');
        $id = $_POST['id'];
        $status = $_POST['status'];
        if($status){
            $data = $model->find($id);
            $num = $model->where('ad_pos_id='.$data['ad_pos_id'].' and ad_show_status="启用"')->count();

            $adPosData = M('ad_pos')->find($data['ad_pos_id']);

            if($num >= $adPosData['ad_pos_limit']){
                echo 3; //代表 超出广告位的限制
                exit;
            }

            if($model->where('id='.$id)->setField('ad_show_status','启用')){
                echo 1;     //成功
                exit;
            }else{
                echo 2;     //失败
                exit;
            }

        }else{
            if($model->where('id='.$id)->setField('ad_show_status','停用')){
                echo 1;
                exit;
            }else{
                echo 2;
                exit;
            }
        }
    }

        //修改
    public function save($id){
        $model = D('ad');
        if(IS_POST){

            if($model->create()){

                if($model->save())
                    $this->ajaxReturn(array('status'=>true,'result'=>'修改成功~'));
                else
                    $this->ajaxReturn(array('status'=>false,'result'=>'修改失败，刷新重试！'));
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>$model->getError()));
            }
        }else{

            $adData = $model->
            field('a.*,b.ad_pos_width,b.ad_pos_height,b.ad_pos_name')->
            alias('a')->
            join("left join sh_ad_pos b on a.ad_pos_id = b.id")->
            where('a.id='.$id)->
            find();
            $this->assign('data',$adData);
            $this->display();
        }
    }

    //删除
    public function delete($id){
        $model = D('ad');
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



}