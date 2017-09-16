<?php
namespace Home\Behaviors;
use Think\Behavior;

/**
 * Class LookRecordBehavior
 * @package Home\Behaviors
 *
 * 监听用户浏览记录，统计商品的访问次数
 *
 */
class LookRecordBehavior extends Behavior
{

    public function run(&$param){


        ////// 统计商品浏览记录

        if(isset($_SESSION['eater_uid']) && $_SESSION['eater_uid']){
            $info['user_ip']  = get_client_ip();     // 用户ip
            $info['user_id']  = $_SESSION['eater_uid'];  // 用户id
            $info['time']     = date('Y-m-d');    // 浏览时间
            $info['goods_id'] = $param['goods_id'];
            $model = M('record');
            if($id = $model->where("user_id = '{$info['user_id']}' and user_ip = '{$info['user_ip']}' and goods_id = '{$info['goods_id']}'")->getField('id')){
                $model->where('id='.$id)->setField('time',$info['time']);
            }else{
                $model->add($info);
            }
        }


        $record = isset($_COOKIE['record']) ? unserialize($_COOKIE['record']) : array();

        array_unshift($record,$param['goods_id'].','.date('Y-m-d'));      // 向数组顶部，添加一个最新浏览记录

        $record = array_unique($record);    // 去重

        if(count($record) > 30){
            array_pop($record);             // 如果超过数量，去掉最后一个
        }

        setcookie('record',serialize($record),time()+60*60*24*30,'/');

    }

}