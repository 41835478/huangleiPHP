<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class StockController extends CommonController
{
    //添加
    public function add(){
        if(IS_POST){
            $model = D('stock');
            if($a = $model->create()){
                if($a['stock']>=0){     //防止库存是负数
                    if($model->add()){
                        $this->success('添加成功',U(MODULE_NAME.'/stock/lst'));
                    }else{
                        $this->error('添加失败,请重试！');
                    }
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
        $model = M('stock');
        if(IS_POST){
            if($a = $model->create()){
                if($a['stock']>=0){     //防止库存为负数
                    if($model->save() !== false){
                        $this->success('修改成功',U(MODULE_NAME.'/stock/lst'));
                        exit;
                    }else{
                        $this->error('修改失败,请重试！');
                    }
                }else{
                    $this->error('修改失败,请重试！');
                }
            }else{
                $this->error('修改失败,请重试！');
            }
        }else{
            $this->data = M('stock')->find($id);
            $this->display();
        }
    }
    //列表
    public function lst(){
        $this->data = M('stock')->select();
        $this->display();
    }
    //删除
    public function del(){
        $id = $_GET['id'];
        D('stock')->delete($id);
        $this->success('删除成功！');
    }
    //批量删除
    public function bdel(){
        $dels = $_POST['dels'];
        if($dels){
            $del = implode(',',$dels);
            $model = D('stock');
            $model->delete($del);
        }
        $this->success('删除成功！');
    }
}