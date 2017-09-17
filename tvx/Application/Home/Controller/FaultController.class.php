<?php
/**
 * Created by PhpStorm.
 * User: huanglei_pc
 * Date: 2016/4/27
 * Time: 8:48
 */

namespace Home\Controller;
use Home\Controller\CommonController;

class FaultController extends CommonController
{
    //添加
    public function add(){
        if(IS_POST){
            $admin = D('fault');
            $b = M('device')->where(array('id'=>$_POST['dev_id']))->find();
            $arr = array(
                'dev_name'=>$b['dev_name'],
                'gz_time'=>$_POST['gz_time'],
                'gz_content'=>$_POST['gz_content'],
                'gz_inc'=>$_POST['gz_inc'],
                //添加的时候，将登录者的id存入这个设备的role_id字段中，为了区分是属于哪个用户的设备
                'role_id'=>$_SESSION['uid'],
            );
            if($admin->data($arr)->add()){
                $this->success('添加成功',U(MODULE_NAME.'/fault/lst'));
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
        $admin = M('fault');
        if(IS_POST){
            if($admin->create()){
                if($admin->save() !== false){
                    $this->success('修改成功',U(MODULE_NAME.'/fault/lst'));
                    exit;
                }else{
                    $this->error('修改失败,请重试！');
                }

            }else{
                //获取错误信息
                $this->error($admin->getError());
            }
        }else{
            $this->data = M('fault')->find($id);
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
        $this->data = M('fault')->where($a)->select();
        $this->display();
    }
    public function del(){
        $id = $_GET['id'];
        D('fault')->delete($id);
        $this->success('删除成功');

    }
    public function bdel(){
        $dels = $_POST['dels'];
        if($dels){
            $del = implode(',',$dels);
            $admin = D('fault');
            //delete方法中的参数有两种写法，单独一个数字则是删除id为当前数字的条数，参数中也可以是 1,2，3，这个样式的参数，删除多条
            $admin->delete($del);
        }
        $this->success('删除成功！');
    }

}