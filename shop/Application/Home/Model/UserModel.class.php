<?php
namespace Home\Model;
use Think\Model;
header('Content-type:text/html;charset=utf8');
date_default_timezone_get("PRC");
class UserModel extends Model
{
    protected $_validate = array(
        array('user_name','require','用户名不能为空！'),
        //array('user_pwd','require','密码不能为空！'),

    );

    public function login(){

        $username = $_POST['username'];
        $password = $_POST['password'];

        $data = $this->where('user_name="'.$username.'" AND user_pwd = "'.$password.'"')->find();

        if($data){

            session('uid',$data['id']);
            session(md5('user'.'黄磊'),$username);
            session('rid',$data['role_id']);
            //取出当前用户的角色所属权限
            $rpi = M('role')->field('role_pri_id')->where('id='.$data['role_id'])->find();

            //判断是否为超级管理员
            if($rpi['role_pri_id'] == '*'){
                $privilege = M('privilege')->field('parent_id,pri_name,id,CONCAT(module_name,"/",controller_name,"/",action_name) url')->select();
                $menu = array(); // 菜单
                $arr = array();
                //取出一级菜单
                foreach($privilege as $k => $v){
                    if($v['parent_id'] == 0){
                        $menu[] = $v;
                        $arr[] = $v['url'];
                    }
                }
                //取出二级菜单
                foreach($menu as $k => $v){
                    foreach($privilege as $k1 => $v1){
                        if($v1['parent_id'] == $v['id']){
                            $menu[$k]['sub'][]=$v1;

                        }
                    }
                }
                //菜单信息存入session
                session('menu',$menu);
                session('url','*');
            }else{



                $privilege = M('privilege')->field('parent_id,pri_name,id,CONCAT(module_name,"/",controller_name,"/",action_name) url')->where("id IN ({$rpi['role_pri_id']})")->select();

                $menu = array(); // 菜单
                $arr = array();
                foreach($privilege as $k => $v){
                    if($v['parent_id'] == 0){
                        $menu[] = $v;
                    }
                    //将所属权限的对应模块、控制器、方法拼装成一个字符串，合并成一维数组
                    $arr[] = $v['url'];
                }
                foreach($menu as $k => $v){
                    foreach($privilege as $k1 => $v1){
                        if($v1['parent_id'] == $v['id']){
                            $menu[$k]['sub'][]=$v1;
                        }
                    }
                }

                session('menu',$menu);
                session('url',$arr);

            }

            return TRUE;
        }else{
            
            return FALSE;
        }
    }

    public function _before_insert(&$data){
        $data['time'] = date("Y-m-d H:i:s",time());
    }

    public function _before_update(&$data){
        $pwd = trim($data['user_pwd']);
        if(empty($pwd)){
            unset($data['user_pwd']);
        }

    }
}