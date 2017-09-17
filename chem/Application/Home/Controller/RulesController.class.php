<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class RulesController extends CommonController
{
    //添加
    public function add(){
        if(IS_POST){
            $model = D('rules');
            $arr = array(
                'title'=>$_POST['title'],
                'content'=>$_POST['content'],
                'time'=>time(),
            );
            if($model->data($arr)->add()){
                $this->success('添加成功',U(MODULE_NAME.'/rules/lst'));
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
        $model = M('rules');
        if(IS_POST){
            if($model->create()){
                if($model->save() !== false){
                    $this->success('修改成功',U(MODULE_NAME.'/rules/lst'));
                    exit;
                }else{
                    $this->error('修改失败,请重试！');
                }
            }else{
                //获取错误信息
                $this->error($model->getError());
            }
        }else{
            $this->data = M('rules')->find($id);
            $this->display();
        }
    }
    //列表
    public function lst(){
        $this->data = M('rules')->select();
        $this->display();
    }
    //删除
    public function del(){
        $id = $_GET['id'];
        D('rules')->delete($id);
        $this->success('删除成功');

    }
    //批量删除
    public function bdel(){
        $dels = $_POST['dels'];
        if($dels){
            $del = implode(',',$dels);
            $model = D('rules');
            $model->delete($del);
        }
        $this->success('删除成功！');
    }

}