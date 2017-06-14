<?php
namespace Admin\Model;
use Think\Model;
class UserModel extends Model
{

    public function login($user,$pass){


        $res = $this->where('username="'.$user.'" and password="'.$pass.'"')->find();
        if($res){
            session('id',$res['id']);
            session('username',$user);
            
                    //当用户选择“一周内免登录”时
            if($_POST['save']){

                $time = time() + 60*60*24*7;
                setcookie('user',$user,$time,'/');
                setcookie('pass',$pass,$time,'/');

            }


            return TRUE;
        }else{

            return FALSE;
        }


    }


}