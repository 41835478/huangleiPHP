<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class CategoryController extends CommonController
{
    public function add(){
        if(IS_POST){
            $model = D('category');

            if($model->create()){

                if($model->add()){
                    $this->success('添加成功',U(MODULE_NAME.'/Category/lst'));
                }else{
                    $this->error('添加失败,请重试！');
                }
            }else{
                
                $this->error('添加失败,请重试！');
            }
        }else{
            $a = D('category');
            $catData = $a->catTree();
            $this->assign('catData',$catData);
            $this->display();
        }
    }

    public function lst(){
        $admin = D('category');
        $catData = $admin->catTree();
        $this->assign('catData',$catData);
        $this->display();
    }

    public function save(){
        $id = $_GET['id'];
        $admin = D('category');
        if(IS_POST){

            if($admin->create()){

                if($admin->save() !== false){
                    $this->success('修改成功',U(MODULE_NAME.'/Category/lst'));
                    exit;
                }else{
                    $this->error('修改失败,请重试！');
                }

            }else{

                $this->error('修改失败,请重试！');
            }
        }else{
            $catData = $admin->catTree();
            $data = $admin->find($id);
            $this->assign(array(
                'data'=>$data,
                'catData'=>$catData
            ));
          $this->display();
        }
    }


    public function del(){
        $id = $_GET['id'];
        $admin = D('category');
        $admin->delete($id);
        $this->success('删除成功');

    }

}