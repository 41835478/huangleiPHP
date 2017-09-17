<?php

namespace Home\Controller;
use Home\Controller\CommonController;

class SafetyController extends CommonController
{
    //添加
    public function add(){
        if(IS_POST){
            $model = D('safety');
            $arr = array(
                'title'=>$_POST['title'],
                'content'=>$_POST['content'],
                'time'=>time(),
            );

            if($model->data($arr)->add()){
                $this->success('添加成功',U(MODULE_NAME.'/safety/lst'));
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
        $model = M('safety');
        if(IS_POST){
            if($model->create()){
                if($model->save() !== false){
                    $this->success('修改成功',U(MODULE_NAME.'/safety/lst'));
                    exit;
                }else{
                    $this->error('修改失败,请重试！');
                }

            }else{
                //获取错误信息
                $this->error($model->getError());
            }
        }else{
            $this->data = M('safety')->find($id);
            $this->display();
        }
    }
    public function lst(){
        $this->data = M('safety')->select();
        $this->display();
    }
    public function del(){
        $id = $_GET['id'];
        D('safety')->delete($id);
        $this->success('删除成功');

    }
    public function bdel(){
        $dels = $_POST['dels'];
        if($dels){
            $del = implode(',',$dels);
            $model = D('safety');
            $model->delete($del);
        }
        $this->success('删除成功！');
    }

}