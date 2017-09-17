<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller
{

    public function index(){
        $model = D('category');
        $catData = $model->getNavCatTree();

        $where = "1";
        if(isset($_GET['search']) && $_GET['search']){
            $where .= " AND goods_name like '%{$_GET['search']}%'";

        }

        if(isset($_GET['cid']) && $_GET['cid']){
            $where .= " AND cat_id = {$_GET['cid']}";
        }

        $admin = D('goods');
        $goodsData = $admin->field('a.*,b.cat_name')->where($where)->alias('a')->join('left join sh_category b on a.cat_id = b.id')->select();
        $this->assign('goodsData',$goodsData);
        $this->assign('catData',$catData);

        $this->display();
    }

    public function login(){
        if(IS_POST){

            $model = M('member');
            if($info = $model->create()){
                $password = md5($info['password']);
                if($model->where("username='{$info['username']}' and password = '{$password}'")->count() > 0){
                    session('u',$info['username']);
                    $action = M('action');
                    $data1['username'] = $info['username'];
                    if($_SERVER['SERVER_ADDR'] == "::1"){
                        $data1['ip'] = '127.0.0.1';
                    }else{
                        $data1['ip'] = $_SERVER['SERVER_ADDR'];
                    }

                    $data1['last_login_time'] = date("Y-m-d H:i:s");
                    if($action->where('username="'.$info['username'].'"')->count() > 0){
                        $action->where('username="'.$info['username'].'"')->data($data1)->save();
                    }else{
                        $action->add($data1);
                    }


                    $this->success('登录成功,快来购物吧~！',U('Index/index'));
                }else{
                    $this->error('登录失败，用户名或密码错误~！');
                }

            }else{
                $this->error('登录失败，刷新重试~！');

            }

        }else{
            $this->display();
        }

    }

    public function register(){
        if(IS_POST){
            $model = M('member');

            if($info = $model->create()){
                $info['time'] = date("Y-m-d H:i:s");
                $info['password'] = md5($_POST['password']);
                if($model->add($info)){
                    $this->success('注册成功,快去登录吧~！',U('Index/login'));
                }else{
                    $this->error('注册失败，刷新重试~！');
                }
            }else{
                $this->error('注册失败，刷新重试~！');
            }


        }else{
            $this->display();
        }

    }

    public function content(){

        $goodsModel = M('goods');
        $gid = $_GET['gid'];
        $data = $goodsModel->field('a.*,b.cat_name')->alias('a')->join('left join sh_category b on a.cat_id = b.id')->where('a.id='.$gid)->find();
        $model = D('category');
        $catData = $model->getNavCatTree();

        $messages = M('message')->where('gid='.$gid)->select();
        $this->assign('message',$messages);

        $this->assign('catData',$catData);
        $this->assign('data',$data);
        $this->display();
    }


    public function aaa(){
        $action = M('action');
        $username = $_SESSION['u'];
        $data1['username'] = $username;
        $data1['last_logout_time'] = date("Y-m-d H:i:s");
        if($action->where('username="'.$username.'"')->count() > 0){
            $action->where('username="'.$username.'"')->data($data1)->save();
        }else{
            $action->add($data1);
        }

    }
    public function logout(){
        session_unset();
        session_destroy();
        $action = M('action');
        $username = $_GET['username'];
        $data1['username'] = $username;
        $data1['last_logout_time'] = date("Y-m-d H:i:s");
        if($action->where('username="'.$username.'"')->count() > 0){
            $action->where('username="'.$username.'"')->data($data1)->save();
        }else{
            $action->add($data1);
        }
        $this->success('退出成功，欢迎再来~！',U('Index/index'));
    }

    public function buy(){
        if(!isset($_SESSION['u'])){
            $this->error('请登录后再购买哦~',U('Index/login'));
        }
        $info['gid'] = $_POST['gid'];
        $info['username'] = $_SESSION['u'];
        $info['goods_size'] = $_POST['goods_size'];
        $info['number'] = $_POST['number'];

        $model = M('buy');
        if($model->add($info)){
            $this->success('购买成功，继续挑选吧~',U('Index/index'));
        }else{
            $this->error('购买失败，刷新重试~');
        }

    }

    public function comment(){
        if(IS_POST){

            if(!isset($_SESSION['u'])){
                $this->error('您还未登录，不能进行评论！');exit;
            }
            $info['gid'] = $_POST['gid'];
            $model = M('buy');
            if($model->where('username="'.$_SESSION['u'].'" and gid = "'.$info['gid'].'"')->count() > 0){
                $info['message'] = $_POST['message'];
                $info['gid'] = $_POST['gid'];
                $info['username'] = $_SESSION['u'];
                $info['time'] = date("Y-m-d H:i:s");
                if(M('message')->add($info)){
                    $this->success('评论成功~',U('Index/content',array('gid'=>$info['gid'])));
                }else{
                    $this->error('评论失败，刷新重试！');
                }

            }else{
                $this->error('您尚未购买过此商品，禁止评论！');
            }


        }else{

            $this->display();
        }

    }
}