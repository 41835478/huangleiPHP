<?php

namespace Home\Controller;
use Home\Controller\CommonController;

class NoticeController extends CommonController
{
    //添加
    public function add(){
        if(IS_POST){
            $model = D('notice');
            $arr = array(
                'title'=>$_POST['title'],
                'content'=>$_POST['content'],
                'time'=>time(),
            );

            if($model->data($arr)->add()){
                $this->success('添加成功',U(MODULE_NAME.'/notice/lst'));
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
        $model = M('notice');
        if(IS_POST){
            if($model->create()){
                if($model->save() !== false){
                    $this->success('修改成功',U(MODULE_NAME.'/notice/lst'));
                    exit;
                }else{
                    $this->error('修改失败,请重试！');
                }

            }else{
                //获取错误信息
                $this->error($model->getError());
            }
        }else{
            $this->data = M('notice')->find($id);
            $this->display();
        }
    }
    public function lst(){
        $this->data = M('notice')->select();
        $this->display();
    }
    public function del(){
        $id = $_GET['id'];
        D('notice')->delete($id);
        $this->success('删除成功');

    }
    public function bdel(){
        $dels = $_POST['dels'];
        if($dels){
            $del = implode(',',$dels);
            $model = D('notice');
            $model->delete($del);
        }
        $this->success('删除成功！');
    }

}