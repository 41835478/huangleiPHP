<?php
/**
 * 权限列表
 */
namespace Home\Controller;
use Home\Controller\CommonController;
class PrivilegeController extends CommonController
{
    //添加
    public function add(){

        if(IS_POST){
            $model = D('Privilege');
            

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
            $priData = D('privilege')->priTree();
            $this->assign('priData',$priData);
            $this->display();
        }

    }

    //列表
    public function lst(){
        $model = D('Privilege');
        $privilegeData = $model->priTree();
        $this->assign('data',$privilegeData);
        $this->display();
    }

    //修改
    public function save($id){
        $model = D('Privilege');
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
            $privilegeData = $model->find($id);
            $priData = D('privilege')->priTree();
            $this->assign(array(
                'data'=>$privilegeData,
                'priData'=>$priData,
            ));
            $this->display();
        }
    }

    //删除
    public function delete(){
        $model = D('privilege');
        $id = $_POST['id'];
        $model->delete();
        //获取当前id的所有子id
        $priId = $model->getChildrenPriId($id);
        //将当前id也放到子id的数组中
        $priId[] = $id;
        $priId = implode(',',$priId);

        if($model->delete($priId)){
            echo 1;
        }else{
            echo 2;
        }


    }

}