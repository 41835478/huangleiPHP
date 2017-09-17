<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class GoodsController extends CommonController
{
    //添加
    public function add(){
        if(IS_POST){
            $model = D('goods');
            if($model->create()){
                if($model->add()){
                    $this->success('添加成功',U(MODULE_NAME.'/goods/lst'));
                }else{
                    $this->error('添加失败,请重试！');
                }
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
        $model = M('goods');
        if(IS_POST){
            if($model->create()){
                if($model->save() !== false){
                    $this->success('修改成功',U(MODULE_NAME.'/goods/lst'));
                    exit;
                }else{
                    $this->error('修改失败,请重试！');
                }
            }else{
                //获取错误信息
                $this->error($model->getError());
            }
        }else{
            $this->data = M('goods')->find($id);
            $this->display();
        }
    }

    public function lst(){
        $this->data = M('goods')->select();
        $this->display();
    }
    public function del(){
        $id = $_GET['id'];
        D('goods')->delete($id);
        $this->success('删除成功');
    }
    public function bdel(){
        $dels = $_POST['dels'];
        if($dels){
            $del = implode(',',$dels);
            $model = D('goods');
            $model->delete($del);
        }
        $this->success('删除成功！');
    }
    //详细信息
    public function message(){
        $this->data = M('goods')->find($_GET[id]);
        $this->display();
    }
    //研究生，教师，主管界面中的列表
    public function msg(){
        $this->row = M('goods')->select();
        $this->display();
    }


}