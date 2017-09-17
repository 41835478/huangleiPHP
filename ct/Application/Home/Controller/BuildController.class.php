<?php

namespace Home\Controller;
use Home\Controller\CommonController;
header('Content-type:text/html;charset=utf8');
date_default_timezone_set('PRC');   //为了避免time()的时间不准，设置时区为中国
class BuildController extends CommonController
{
    //添加
    public function add(){
        if(IS_POST){
            $model = D('build');
            $arr = array(
                'name'=>$_POST['name'],
                'time'=>time(),
            );
            if($model->data($arr)->add()){
                $this->success('添加成功',U(MODULE_NAME.'/build/lst'));
            }else{
                $this->error('添加失败,请重试！');
            }

        }else{

            $this->display();
        }
    }
    //修改
    public function save(){
        $id = $_GET['id'];
        $model = D('build');
        if(IS_POST){
            if($a = $model->create()){

                if($model->save() !== false){
                    $this->success('修改成功',U(MODULE_NAME.'/build/lst'));
                    exit;
                }else{
                    $this->error('修改失败,请重试！');
                }

            }else{
                //获取错误信息
                $this->error($model->getError());
            }
        }else{
            $this->data = D('build')->find($id);
            $this->img = M('build_images')->where('build_id='.$id)->select();
            $this->display();
        }
    }
    public function lst(){
        $this->data = M('build')->select();
        $this->img = M('build_images')->select();
        $this->display();
    }
    public function del(){
        $id = $_GET['id'];
        D('build')->delete($id);
        M('build_images')->where("build_id=".$id)->delete();
        $this->success('删除成功');

    }
    public function bdel(){
        $dels = $_POST['dels'];
        if($dels){
            $del = implode(',',$dels);
            $model = D('build');
            $model->delete($del);
            M('build_images')->where("build_id IN($del)")->delete();
        }
        $this->success('删除成功！');
    }
    public function ajaxDelPic($pid)
    {
        // 先取出图片
        $model = M('build_images');
        $data = $model->find($pid);
        // 从硬盘上删除图片
        @unlink('./Uploads/'.$data['images']);
        @unlink('./Uploads/'.$data['sm_images']);
        @unlink('./Uploads/'.$data['big_images']);
        // 从数据库中删除记录
        $model->delete($pid);
    }
}