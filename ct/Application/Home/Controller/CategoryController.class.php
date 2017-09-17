<?php

namespace Home\Controller;
use Home\Controller\CommonController;
header('Content-type:text/html;charset=utf8');
date_default_timezone_set('PRC');   //为了避免time()的时间不准，设置时区为中国
class CategoryController extends CommonController
{
    //添加
    public function add(){
        if(IS_POST){
            $model = D('category');
            $arr = array(
                'name'=>$_POST['name'],
            );
            if($model->data($arr)->add()){
                $this->success('添加成功',U(MODULE_NAME.'/Category/lst'));
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
        $model = M('category');
        if(IS_POST){
            if($model->create()){
                if($model->save() !== false){
                    $this->success('修改成功',U(MODULE_NAME.'/category/lst'));
                    exit;
                }else{
                    $this->error('修改失败,请重试！');
                }

            }else{
                //获取错误信息
                $this->error($model->getError());
            }
        }else{
            $this->data = M('category')->find($id);
            $this->display();
        }
    }
    public function lst(){
        $this->data = M('category')->select();
        $this->display();
    }
    public function del(){
        $id = $_GET['id'];
        D('category')->delete($id);
        $this->success('删除成功');

    }
    public function bdel(){
        $dels = $_POST['dels'];
        if($dels){
            $del = implode(',',$dels);
            $model = D('category');
            $model->delete($del);
        }
        $this->success('删除成功！');
    }

}