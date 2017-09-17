<?php
/**
 * Created by PhpStorm.
 * User: huanglei_pc
 * Date: 2016/4/27
 * Time: 8:48
 */

namespace Home\Controller;
use Home\Controller\CommonController;

class RecordController extends CommonController
{
    //添加
    public function add(){
        if(IS_POST){
            $admin = D('record');
            $b = M('device')->where(array('id'=>$_POST['dev_id']))->find();
            $arr = array(
                'dev_name'=>$b['dev_name'],
                'xj_time'=>$_POST['xj_time'],
                'xj_content'=>$_POST['xj_content'],
                'xj_record'=>$_POST['xj_record'],
                'role_id'=>$_SESSION['uid'],
            );
            
            if($admin->data($arr)->add()){
                $this->success('添加成功',U(MODULE_NAME.'/record/lst'));
            }else{
                $this->error('添加失败,请重试！');
            }
        }else{

            $this->data = M('device')->where(array('role_id'=>$_SESSION['uid']))->select();
            $this->display();
        }
    }
    //修改
    public function save(){
        $id = $_GET['id'];
        $admin = M('record');
        if(IS_POST){
            if($admin->create()){
                if($admin->save() !== false){
                    $this->success('修改成功',U(MODULE_NAME.'/record/lst'));
                    exit;
                }else{
                    $this->error('修改失败,请重试！');
                }

            }else{
                //获取错误信息
                $this->error($admin->getError());
            }
        }else{
            $this->data = M('record')->find($id);
            $this->devData = M('device')->select();
            $this->display();
        }
    }
    public function lst(){
        if(empty($_SESSION['level'])){
            $a = 1;
        }else{
            $a = array('role_id'=>$_SESSION['uid']);
        }
        $this->data = M('record')->where($a)->select();
        $this->display();
    }
    public function del(){
        $id = $_GET['id'];
        D('record')->delete($id);
        $this->success('删除成功');

    }
    public function bdel(){
        $dels = $_POST['dels'];
        if($dels){
            $del = implode(',',$dels);
            $admin = D('record');
            //delete方法中的参数有两种写法，单独一个数字则是删除id为当前数字的条数，参数中也可以是 1,2，3，这个样式的参数，删除多条
            $admin->delete($del);
        }
        $this->success('删除成功！');
    }

}