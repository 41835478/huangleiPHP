<?php
/**
 * Created by PhpStorm.
 * User: hi~
 * Date: 2017/3/16
 * Time: 9:48\
 * 前台用户 登录 注册 退出
 */

namespace Home\Controller;
use Home\Controller\CommonController;
use Think\Crypt;

class LoginController extends CommonController
{


    public function register(){

        if(isset($_SESSION['eater_uid']) && $_SESSION['eater_uid']){
            $this->redirect('Index/index');exit;
        }

        if(IS_POST){

            $model = D('member');
            C('TOKEN_ON',false);
            if($model->create()){
                // 获取返回数据，包括状态，以及提示信息
                $return = $model->chkSn($_POST['code']);
                if(!$return['status']){
                    $this->ajaxReturn($return);exit;
                }
                // 注册成功
                if($model->add()){
                    $this->ajaxReturn(array('status'=>true,'result'=>'注册成功，快去购物吧~'));exit;
                }else{
                    $this->ajaxReturn(array('status'=>false,'result'=>'注册失败，稍候重试！'));exit;
                }

            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>$model->getError()));exit;
            }

        }
            /// 开启模板布局
        layout('Layout/layout1');

        $this->display();
    }


    public function login(){

        if(isset($_SESSION['eater_uid']) && $_SESSION['eater_uid']){
            $this->redirect('Index/index');exit;
        }

        if(IS_POST){

            $model = D('member');
            C('TOKEN_ON',false);
            if($model->create($_POST,3)){

                if($model->login()){

                    $this->ajaxReturn(array('status'=>true,'result'=>'登录中..','refer'=>$_COOKIE['refer']));exit;
                }else{
                    $this->ajaxReturn(array('status'=>false,'result'=>'手机号或密码错误！'));exit;
                }
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>$model->getError()));exit;
            }


        }

        layout('Layout/layout1');
        $this->display();
    }

        // 忘记密码
    public function forget_password(){
        if(IS_POST){

            $username = $_POST['username'];

            $model = D('member');
            // 获取返回数据，包括状态，以及提示信息
            $return = $model->chkSn($_POST['code']);
            if(!$return['status']){
                $this->ajaxReturn($return);exit;
            }

            $forget_pwd_id = $model->where("username = '{$username}'")->getField('id');
            session("forget_pwd_id",$forget_pwd_id);

            if(isset($_SESSION['forget_pwd_id']) && $_SESSION['forget_pwd_id']){
                $this->ajaxReturn(array('status'=>true,'result'=>'跳转中..'));exit;
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'提交失败，请刷新重试！'));exit;
            }

        }
        layout('Layout/layout1');
        $this->display();
    }

        // 重置密码
    public function forget_password_1(){

        if(!isset($_SESSION['forget_pwd_id']) || empty($_SESSION['forget_pwd_id'])){
            $this->redirect("Login/login");exit;
        }

        if(IS_POST){

            $model = D('member');
            if($model->create()){

                if($model->where("id = '{$_SESSION['forget_pwd_id']}'")->save() !== false){
                    $_SESSION['forget_pwd_id'] = "";
                    $this->ajaxReturn(array('status'=>true,'result'=>'修改成功！'));
                }else{
                    $this->ajaxReturn(array('status'=>false,'result'=>'修改失败，请刷新重试！'));
                }

            }else{

                $this->ajaxReturn(array('status'=>false,'result'=>$model->getError()));
            }


        }

        layout('Layout/layout1');
        $this->display();
    }

        //退出登录， 情况session以及cookie
    public function logout(){

        session_unset();
        session_destroy();
        setcookie('eater_username','',1,'/');
        setcookie('eater_password','',1,'/');
        $this->redirect('Login/login');
    }

    // ajax 判断用户是否存在cookie
    public function ajaxChkUser(){
     
        $uid = $_SESSION['eater_uid'];
        if(isset($uid) && $uid){
            $this->ajaxReturn(array('status'=>true,'uid'=>$_SESSION['eater_uid'],'nickname'=>$_SESSION['eater_nickname'],'username'=>$_SESSION['eater_username']));exit;
        }

        if(isset($_COOKIE['eater_username']) && $_COOKIE['eater_username']){
            $model = D('member');
            $des = new Crypt();
            $des_key = C('DES_KEY');
            $model->username = $des->decrypt($_COOKIE['eater_username'],$des_key);
            $model->password = $des->decrypt($_COOKIE['eater_password'],$des_key);

            if($model->login()){
                $this->ajaxReturn(array('status'=>true,'uid'=>$_SESSION['eater_uid'],'nickname'=>$_SESSION['eater_nickname'],'username'=>$_SESSION['eater_username']));exit;
            }
        }

        $this->ajaxReturn(array('status'=>false));exit;

    }

        // 验证用户名（手机号） 是否存在
    public function chkUsername(){
        $username = trim($_GET['username']);
        if(M('member')->where("username = '{$username}'")->count() > 0){
            echo 1;
        }else{
            echo 2;
        }
    }


            // 阿里大于 发送验证码，ajax发送6位验证码
    public function get_code(){

        $username = $_GET['username'];

        vendor('alidayu.TopClient');
        vendor('alidayu.AlibabaAliqinFcSmsNumSendRequest');
        vendor('alidayu.RequestCheckUtil');
        vendor('alidayu.ResultSet');
        vendor('alidayu.TopLogger');

        $c = new \TopClient;
        $c->appkey = '23702609';
        $c->secretKey = '3d5d3f37cccd38e40260046e6e657564';
        $c->format = "json";
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("eater商城");

        $randNum = getRandNum(6);
        $arr = array(
            'number'=>$randNum,
        );
        $req->setSmsParam(json_encode($arr));
        $req->setRecNum($username);
        $req->setSmsTemplateCode("SMS_55835019");
        $resp = $c->execute($req);
        $arr = objectArray($resp);
        if(isset($arr['code'])){
            $this->ajaxReturn(array('status'=>false,'result'=>$arr['sub_msg']));exit;
        }
        setcookie('eater_randNum',$randNum,time()+60*5,'/');
        setcookie('eater_randNum_time',time(),time()+60*5,'/');
        $this->ajaxReturn(array('status'=>true,'result'=>'验证码已发送，有效期5分钟'));


    }

    
}