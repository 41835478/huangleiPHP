<?php
/**
 * 个人信息
 */
namespace Home\Controller;
use Think\Controller;
class PersonController extends Controller
{

    public function person(){
        $model = M('user');
        $person = $model->field('a.id,a.user_name,a.user_pwd,a.role_id,a.phone,a.email,a.time,a.sex,a.remark,b.role_name')
                        ->alias('a')
                        ->join("left join sh_role b on a.role_id = b.id")
                        ->where('a.id='.$_SESSION['uid'])
                        ->find();

        
        $loginMsg = M('loginMsg')->select();

        $this->assign(array(
            'person'=>$person,
            'loginMsg'=>$loginMsg
        ));
        $this->display();
    }



    public function save(){

        $model = M('user');
        if($model->create()){
            if($model->save() !== false)
                echo 1;
            else
                echo 2;

        }else
            echo 2;

    }

    public function change_Password(){
        $old_pwd = $_POST['old_pwd'];
        $new_pwd = $_POST['new_pwd'];
        $id = $_POST['id'];
        $model = M('user');
        $num = $model->where('id='.$id.' AND user_pwd="'.$old_pwd.'"')->count();
        if($num == 1){

            if($model->where('id='.$id)->setField('user_pwd',$new_pwd) !== false)
                echo 1;
            else
                echo 2;

        }else if($num == 0){
            echo 3;
        }

    }

}