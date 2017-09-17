<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class ApplyController extends CommonController
{
    //添加
    public function add(){
        if(IS_POST){
            $model = D('apply');
            //接收数据，角色的不同，部分值不同
            $arr = array(
                'stock_id'=>$_POST['stock_id'],
                'app_name'=>$_SESSION['name'],
                'app_phoneNum'=>$_POST['app_phoneNum'],
                'time'=>time(),
                'stock'=>$_POST['stock'],
                'sector'=>$_POST['sector'],
                'use'=>$_POST['use'],
                'uid'=>$_SESSION['uid'],
                'status'=>$_SESSION['level'],
            );
            if($_SESSION['level'] == 3){
                $arr['teacher']=$_POST['teacher'];
            }
            $style = M('stock')->field('style')->find($_POST[stock_id]);
            if($_SESSION['level'] == 2 && $style['style'] == '否'){
                $arr['status'] = 1;
            }
            if($_SESSION['level'] == 3){
                $arr['student_id'] = $_SESSION['uid'];
            }else if($_SESSION['level'] == 2){
                $arr['teacher_id'] = $_SESSION['uid'];
            }else if($_SESSION['level'] == 1){
                $arr['charge_id'] = $_SESSION['uid'];
            }else{
                $arr['admin_id'] = $_SESSION['uid'];
            }

            if($model->data($arr)->add()){
                $this->success('添加成功',U(MODULE_NAME.'/apply/lst'));
            }else{
                $this->error('添加失败,请重试！');
            }

        }else{
            $this->goods = M('stock')->select();
            $this->display();
        }
    }
    //修改
    public function save(){
        $id = $_GET['id'];
        $model = M('apply');
        if(IS_POST){
            if($model->create()){
                if($model->save() !== false){
                    $this->success('修改成功',U(MODULE_NAME.'/apply/lst'));
                    exit;
                }else{
                    $this->error('修改失败,请重试！');
                }

            }else{
                //获取错误信息
                $this->error($model->getError());
            }
        }else{
            $this->data = M('apply')->find($id);
            $this->display();
        }
    }
    //申领同意
    public function agree(){
        $id = $_GET['id'];
        $stock_id = $_GET['stock_id'];
        if($_SESSION['level'] == 2){
            $arr['teacher_id'] = $_SESSION['uid'];
        }else if($_SESSION['level'] == 1){
            $arr['charge_id'] = $_SESSION['uid'];
        }else{
            $arr['admin_id'] = $_SESSION['uid'];
        }
        $arr['status'] = $_SESSION['level'];
        $style = M('stock')->field('style')->find($stock_id);
        if($_SESSION['level'] == 2 && $style['style'] == '否'){
            $arr['status'] = 1;
        }
        M('apply')->where('id='.$id)->save($arr);
        $this->success("操作成功",U(MODULE_NAME.'/Apply/passlst'));
    }
    //申领拒绝
    public function refuse(){

        if(IS_POST){
            $id = $_POST['id'];
            $arr['status'] = 4;
            $arr['reason'] = $_POST['reason'];
            $arr['refuse_id'] = $_SESSION['uid'];
            M('apply')->where('id='.$id)->save($arr);
            $this->success("添加成功",U(MODULE_NAME.'/Apply/applst'));
        }else{
            $this->display();
        }
    }
    //申领列表
    public function lst(){
        $this->data = M('apply')->where(array('uid'=>$_SESSION['uid']))->select();
        $this->goods = M('stock')->select();
        $this->display();
    }
    //审批列表
    public function applst(){
        $this->data = M('apply')->where(array('status'=>$_SESSION['level']+1))->order('time DESC')->select();
        $this->goods = M('stock')->select();
        $this->display();
    }
    //审批通过列表
    public function passlst(){
        if($_SESSION['level'] == 2){
            $this->data = M('apply')->where(array('teacher_id'=>$_SESSION['uid']))->order('time DESC')->select();
        }else if($_SESSION['level'] == 1){
            $this->data = M('apply')->where(array('charge_id'=>$_SESSION['uid']))->order('time DESC')->select();
        }else if($_SESSION['level'] == 0){
            $this->data = M('apply')->where(array('status'=>0))->order('time DESC')->select();
        }

        $this->goods = M('stock')->select();
        $this->display();
    }
    //结算清单列表
    public function clearlst(){
        $where = 1;
        if(isset($_GET['un']) && $_GET['un']){
           $where =  "operator='$_GET[un]'";
        }
        $this->data = M('clear')->where($where)->order('time DESC')->select();
        $this->goods = M('stock')->select();
        $this->display();
    }
    //已结算清单列表
    public function clearlst1(){
        $where = 1;
        if(isset($_GET['un']) && $_GET['un']){
            $where =  "operator='$_GET[un]'";
        }
        $this->data = M('clear')->where($where)->order('time DESC')->select();
        $this->goods = M('stock')->select();
        $this->display();
    }
    //删除
    public function del(){
        $id = $_GET['id'];
        $arr['status'] = 1;
        $this->success('移除成功');
    }
    //批量删除
    public function bdel(){
        $dels = $_POST['dels'];
        if($dels){
            $model = D('clear');
            foreach($dels as $v){
                $arr['status'] = 1;
                D('clear')->where('id='.$v)->save($arr);
            }
        }
        $this->success('移除成功！');
    }

}