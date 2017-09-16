<?php
namespace Member\Model;
use Think\Model;
class MemberLevelModel extends Model
{

    protected $_validate = array(
        array('level_name','require','等级名称不能为空！',0),
        array('lowest_cost','/^\d{1,10}$/','请填写最低消费要求金额！',0,'regex'),
    );

    
    public function getLevelData(){
        return $this->order("lowest_cost")->select();
    }


    // 统计所有等级各有多少人
    /* 以等级表为左，链会员表查询，需先查询出结果，然后对结果group，
        因为group比order先执行，会影响结果，所以先获取会员级别，再group等级，然后count获取数量即可 */
    public function getCountLevel(){
        $countLevel = $this->query("select d.level_name name,count(d.username) value from 
                                      (select * from 
                                            (select a.level_name,b.username,a.lowest_cost from 
                                                sh_member_level a 
                                                  left join sh_member b on b.total_cost>=a.lowest_cost 
                                                    order by a.lowest_cost desc
                                            )
                                        as c 
                                        group by c.username
                                        ) as d 
                                      group by d.level_name 
                                      order by d.lowest_cost");
        return $countLevel;
    }


}