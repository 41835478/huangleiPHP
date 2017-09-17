<?php
/**
 * Created by PhpStorm.
 * User: huanglei_pc
 * Date: 2016/4/27
 * Time: 8:48
 */

namespace Home\Controller;
use Home\Controller\CommonController;

class DeviceController extends CommonController
{
    //添加
    public function add(){
        if(IS_POST){
            $admin = D('device');
            $arr = array(
                'dev_id'=>$_POST['dev_id'],
                'dev_place'=>$_POST['dev_place'],
                'dev_dj_status'=>$_POST['dev_dj_status'],
                'dev_ts_status'=>$_POST['dev_ts_status'],
                'dev_name'=>$_POST['dev_name'],
                'status'=>$_POST['status'],
                'qjmj'=>$_POST['qjmj'],
                'dev_num'=>$_POST['dev_num'],
                'time'=>time(),
                'role_id'=>$_SESSION['uid'],
            );

            if($admin->data($arr)->add()){
                $this->success('添加成功',U(MODULE_NAME.'/device/lst'));
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
        $admin = M('device');
        if(IS_POST){
            if($admin->create()){
                if($admin->save() !== false){
                    $this->success('修改成功',U(MODULE_NAME.'/device/lst'));
                    exit;
                }else{
                    $this->error('修改失败,请重试！');
                }

            }else{
                //获取错误信息
                $this->error($admin->getError());
            }
        }else{
            $this->data = M('device')->find($id);
            $this->display();
        }
    }
    public function lst(){
        //根据用户登录的id，查询出属于这个用户的设备
        if(empty($_SESSION['level'])){
            $a = 1;
        }else{
            $a = array('role_id'=>$_SESSION['uid']);
        }
        $this->data = M('device')->where($a)->select();
        $this->display();
    }
    public function del(){
        $id = $_GET['id'];
        D('device')->delete($id);
        $this->success('删除成功');

    }
    public function bdel(){
        $dels = $_POST['dels'];
        if($dels){
            $del = implode(',',$dels);
            $admin = D('device');
            //delete方法中的参数有两种写法，单独一个数字则是删除id为当前数字的条数，参数中也可以是 1,2，3，这个样式的参数，删除多条
            $admin->delete($del);
        }
        $this->success('删除成功！');
    }

}