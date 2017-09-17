<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class AdminController extends CommonController
{
    //添加
    public function add(){
        if(IS_POST){
            $admin = D('Admin');
            //收集数据
            if($admin->create()){
                //对密码进行加密
                $admin->password = md5($admin->password);
                //添加数据
                if($admin->add()){
                    $this->success('添加成功',U(MODULE_NAME.'/Admin/lst'));
                }else{
                    $this->error('添加失败,请重试！');
                }
            }else{
                //获取错误信息
                $this->error($admin->getError());
            }
        }else{
            //因为登录的时候 ，如果是超级管理员的话，他的session中是没有level字段的
            if(empty($_SESSION['level'])){
                $d=1;
            }else{
                //若是非超级管理员，则让level+1
                $d=array('level'=>$_SESSION['level']+1);
            }
            //将数据分配到模板中
            $this->roleData = M('category')->where($d)->select();
            $this->display();
        }
    }
    //修改
    public function save(){
        $id = $_GET['id'];
        $admin = D('admin');
        if(IS_POST){
            if($admin->create()){
                //如果密码为空，则清楚password这个字段清除，以免将空值添加进数据库
                if(trim($admin->password)){
                    $admin->password = md5($admin->password);
                }else{
                    unset($admin->password);
                }
                if($admin->save() !== false){
                    $this->success('修改成功',U(MODULE_NAME.'/Admin/lst'));
                    exit;
                }else{
                    $this->error('修改失败,请重试！');
                }

            }else{
                //获取错误信息
                $this->error($admin->getError());
            }
        }else{
            //查询出所有经销商 物业 业主，并分配到前台模板
            $this->roleData = M('category')->select();
            //查询出所有用户，并分配到前台模板
            $this->data = $admin->find($id);
            $this->display();
        }
    }
    //列表
    public function lst(){
        //查询出所有经销商 物业 业主，并分配到前台模板
        $this->roleData = M('category')->select();
        /*
        **
         * 调用模型中的无限极分类，返回的是一个而且数组，foreach这个二维数组，整合成一维数组分配到前台模板
         */
        $a = array();
        $data = D('admin')->catTree($_SESSION['role_id']);
        foreach($data as $v){
            $a[]=$v['id'];
        }
        $arr = array();
        foreach($a as $v){
            $arr[] = M('admin')->where(array('role_id'=>$v))->select();
        }
        $this->arr = $arr;
        $this->display();


    }
    //删除
    public function del(){
        $id = $_GET['id'];
        $role_id=$_GET['role_id'];
        //防止外部提交表单，删除超级管理员
        if($id>1){
            D('admin')->delete($id);
            $cat = D('category');
            $a = $cat->select();
            foreach($a as $v){
                if($v['id']==$role_id){
                    $cat->delete($v['id']);
                }
            }
        }
        $this->success('删除成功');

    }
    // 批量删除
    public function bdel(){
        $dels = $_POST['del'];
        if($dels){
            //安全！ 防止外部表单提交，删除超级管理员，array_search返回的是找到的值所在的位置
            $key = array_search(1,$dels);
            if($key !==false){
                unset($dels[$key]);
            }

            if($dels){
                $del = implode(',',$dels);

                $admin = M('admin');
                //delete方法中的参数有两种写法，单独一个数字则是删除id为当前数字的条数，参数中也可以是 1,2，3，这个样式的参数，删除多条
                $admin->delete($del);
            }
        }
        $this->success('删除成功！');
    }

}