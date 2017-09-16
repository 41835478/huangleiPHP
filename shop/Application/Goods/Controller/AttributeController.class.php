<?php
/**
 * 商品属性
 */
namespace Goods\Controller;
use Home\Controller\CommonController;
header('Content-type:text/html;charset=utf8');
class AttributeController extends CommonController
{
    //添加
    public function add(){

        if(IS_POST){
            $model = D('Attribute');
            $msg = array();
            if($model->create()){

                if($model->add()){
                    $msg['status'] = 1;
                    $msg['id'] = $_POST['type_id'];
                    $this->ajaxReturn($msg);
                }else{
                    $msg['status'] = 2;
                    $this->ajaxReturn($msg);
                }
            }else{
                $msg['status'] = 2;
                $this->ajaxReturn($msg);
            }
        }else{

            $this->display();
        }

    }

    //列表
    public function lst($id){
        //取出所有属性
        $model = D('Attribute');
        $attrData = $model->where('type_id='.$id)->select();
        //取出所有类型
        $typeModel = M('type');
        $typeData = $typeModel->field('id,type_name')->select();

        $this->assign(array(
            'attrData'=>$attrData,
            'typeData'=>$typeData
        ));

        $this->display();
    }

    //修改
    public function save(){
        $model = D('Attribute');
        $msg = array();
        $id = $_GET['id'];
        if(IS_POST){

            if($model->create()){
                if($model->save()!== false){
                    $msg['status'] = 1;
                    $msg['id'] = $_POST['type_id'];
                    $this->ajaxReturn($msg);
                }else{
                    $msg['status'] = 2;
                    $this->ajaxReturn($msg);
                }


            }else{
                $msg['status'] = 2;
                $this->ajaxReturn($msg);
            }
        }else{

            $attrData = $model->find($id);
            $this->assign('data',$attrData);
            $this->display();
        }
    }

    //删除
    public function delete($id){
        $model = D('Attribute');
        if($model->delete($id))
            echo 1;
        else
            echo 2;

    }

    //批量删除
    public function plDel(){
        $model = D('Attribute');
        $ids = $_POST['dels'];
        if($ids){
            $ids = implode(',',$ids);
            if(!$model->delete($ids)){
               echo 2;
                exit;
            }
        }
        echo 1;

    }
}