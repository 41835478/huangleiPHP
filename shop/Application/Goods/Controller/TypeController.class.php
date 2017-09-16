<?php
/**
 * 商品类型
 */
namespace Goods\Controller;
use Home\Controller\CommonController;
header('Content-type:text/html;charset=utf8');
class TypeController extends CommonController
{
    //添加
    public function add(){

        if(IS_POST){
            $model = D('type');
            if($model->create()){

                if($model->add()){
                    echo 1;
                }else{
                    echo 2;
                }
            }else{
                echo 2;
            }
        }else{

            $this->display();
        }

    }

    //列表
    public function lst(){
        $model = D('type');
        $typeData = $model->select();
        $this->assign('data',$typeData);
        $this->display();
    }

    //修改
    public function save($id){
        $model = D('type');
        if(IS_POST){

            if($model->create()){
                if($model->save()!== false)
                    echo 1;
                else
                    echo 2;

            }else{
                echo 2;
            }
        }else{

            $typeData = $model->find($id);
            $this->assign('data',$typeData);
            $this->display();
        }
    }

    //删除
    public function delete($id){
        $model = D('type');
        $count = $model->delete($id);
        /**
         *
         * 切记  不可以写成  if($model->delete($id))
         *      这样写， 会和钩子函数冲突。
         *
         */
        if($count > 0)
            echo 1;
        else
            echo 2;
    }

    //批量删除
    public function plDel(){
        $model = D('type');
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