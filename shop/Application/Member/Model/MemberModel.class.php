<?php
namespace Member\Model;
use Think\Model;
class MemberModel extends Model
{

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

    public function getAllMemberLevel($data){

        foreach($data as $k => $v){ 

        }




    }

}