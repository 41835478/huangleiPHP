<?php
/**
 * Created by PhpStorm.
 * User: hi~
 * Date: 2017/3/16
 * Time: 10:52
 * 登录注册 模型
 */

namespace Home\Model;
use Think\Crypt;
use Think\Model;

header('Content-type:text/html;charset=utf8');
date_default_timezone_set('PRC');
class MemberModel extends Model
{

    protected $_validate = array(


        array('nickname','require','别忘记给自己起个昵称哦~'),
        array('nickname','6,10','昵称长度6到10个字哦~',0,'length',1),
        array('username','require','手机号不能为空！'),
        array('username','/^\d{11}$/','请输入11位手机号！',0,'regex'),
        array('username','','用户名已经存在！',0,'unique',1),

        array('password','require','密码不能为空！'),
        array('password','6,10','密码格式有误，格式为6-10位！',0,'length',1),
        array('c_password','password','两次输入的密码不一致',0,'confirm'),
        array('email','/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i','邮箱格式有误',0,'regex'),
        array('code','require','验证码不能为空'),
        array('code','6','验证码有误，请输入6位验证码',0,'length'),

    );


    /**
     * @param $cost_money ： 用户消费金额
     * 返回用户的当前等级和下一等级
     */
    public function getLevelInfoByCost($cost_money){

        // 取出所有等级
        $mlData = $this->query("select level_name,lowest_cost from sh_member_level order by lowest_cost");

        $now  = array();            // 当前级别
        $next = array();            // 下一级别
        $distance_next_level = 0;   // 距离下一级别
        $max  = 0.00;               // 最高等级的，最低消费
        foreach($mlData as $k => $v){
            // 获取最高等级的最低消费
            $max = max($v['lowest_cost'],$max);
            // 判断在哪个区间中
            if($cost_money >= $v['lowest_cost'] && $cost_money < $mlData[$k+1]['lowest_cost']){
                $now  = $v;
                $next = $mlData[$k+1];
            }
        }

        // 还需消费多少金额到下一级
        $distance_next_level = number_format($next['lowest_cost'] - $cost_money,2,'.','');

        // 以lowest_cost为键，便于查询
        $mlData_1 = array_column($mlData,null,'lowest_cost');

        /* 如果消费金额超过最高等级 */
        if($cost_money > $max)
        {
            $now  = $mlData_1[$max];
            $next = array();
            $distance_next_level = 0.00;
        }

        return array('now'=>$now['level_name'],'next'=>$next['level_name'],'distance_next_level'=>$distance_next_level);

    }
    


        // 积分平均分配
    function pointsAvg($number,$avgNumber)
    {

        $avg     = floor($number / $avgNumber);
        $ceilSum = $avg * $avgNumber;
        $arr     = array();
        for($i = 0; $i < $avgNumber; $i++) {
            if($i < $number - $ceilSum) {
                array_push($arr, $avg + 1);
            } else {
                array_push($arr, $avg);
            }
        }

        return $arr;
    }

        // 验证 验证码是否正确以及过期时间
    public function chkSn($code){
        // 判断验证码是否过期
        if(time() - $_COOKIE['eater_randNum_time']<60*5 && isset($_COOKIE['eater_randNum_time'])){
            // 判断验证码 是否正确
            if(trim($code) != $_COOKIE['eater_randNum']){
                return array('status'=>false,'result'=>'验证码错误，请仔细填写！');
                //$this->ajaxReturn();exit;
            }
        }else{
            return array('status'=>false,'result'=>'请点击获取验证码！');
//            $this->ajaxReturn();exit;
        }

        return array('status'=>true,'result'=>'验证码正确');
    }


    public function _before_insert(&$data){
        $data['password'] = md5($_POST['password']);
        $data['time'] = date("Y-m-d H:i:s");
    }

    public function login(){

            // 这里最好不要用post接受数据，否则如果用户选择了七天免登陆，无法获取到用户名和密码
        $username = $this->username;
        $password = $this->password;

        $pwd = md5($password);

        $arr = $this->where("username = '{$username}' and password = '{$pwd}'")->find();

        if($arr)
        {
            session('eater_uid',$arr['id']);
            session('eater_username',$arr['username']);
            session('eater_nickname',$arr['nickname']);

            if(isset($_POST['save']) && $_POST['save'] == "1"){

                $des_key = C('DES_KEY');

                $des = new Crypt();
                $username = $des->encrypt($username,$des_key);
                $password = $des->encrypt($password,$des_key);

                $time = time() + 60*60*24*7;
                setcookie('eater_username',$username,$time,'/');
                setcookie('eater_password',$password,$time,'/');

            }
            return true;
        }
        else
        {
            return false;
        }

    }


    public function _before_update(&$data){
        $data['password'] = md5($data['password']);
    }
}