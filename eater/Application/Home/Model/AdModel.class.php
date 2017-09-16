<?php
namespace Home\Model;
use Think\Model;
class AdModel extends Model
{

    public function getAd(){

        $_adData = $this->where('ad_show_status="启用"')->select();
        $adPosData = M('ad_pos')->select();
        $adData = array();

        foreach($adPosData as $k=> $v){
            foreach($_adData as $k1 => $v1){
                if($v['id'] == $v1['ad_pos_id']){
                    $v1['width'] = $v['ad_pos_width'];
                    $v1['height'] = $v['ad_pos_height'];
                    $adData[$v['id']][] = $v1;
                    if(count($adData[$v['id']]) >= $v['ad_pos_limit']){     //如果超出限制
                        break;
                    }
                }
            }

        }

        return $adData;

    }
}