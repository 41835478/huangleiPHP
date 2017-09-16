<?php
/**
 * 角色列表
 */
namespace Home\Controller;
use Home\Controller\CommonController;
header('Content-type:text/html;charset=utf8');
class RoleController extends CommonController
{
    //添加
    public function add(){

        if(IS_POST){

            $model = D('role');
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
            $model = D('Privilege');
            $data = $model->getPriArr();
            $privilegeData = $model->generateTree($data);
            $this->assign('data',$privilegeData);
            $this->display();
        }

    }

    //列表
    public function lst(){
        $where = 1;
        if(isset($_GET['search']) && $_GET['search']){
            $where = "role_name like '%".$_GET['search']."%'";

        }
        $model = D('role');
        $roleData = $model->where($where)->select();
        $priModel = D('privilege');
        $priData = $priModel->select();
        $this->assign('data',$roleData);
        $this->assign('priData',$priData);
        $this->display();
    }

    //修改
    public function save($id){
        $model = D('role');
        if($id==1){
            die('呵呵哒');
        }
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
            $priModel = D('Privilege');
            $data = $priModel->getPriArr();
            $privilegeData = $priModel->generateTree($data);
            $this->assign('priData',$privilegeData);

            $roleData = $model->find($id);
           
            $this->assign('data',$roleData);
            $this->display();
        }
    }

    //删除
    public function delete($id){
        $model = D('role');
        if($id==1){
            die('呵呵哒');
        }
        if($model->delete($id))
            echo 1;
        else
            echo 2;

    }
    //批量删除
    public function plDel(){
        $model = D('role');
        $ids = $_POST['dels'];
        if(in_array('1',$ids)){
            die('呵呵哒');
        }

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