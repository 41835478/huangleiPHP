<?php
namespace Ad\Model;
use Think\Model;
class AdPosModel extends Model
{
    protected $_validate = array(
        array('ad_pos_name','require','广告位名称不能为空！',1),
        array('ad_pos_width','require','广告位宽度不能为空！',1),
        array('ad_pos_height','require','广告位高度不能为空！',1),
        array('ad_pos_limit','require','广告位限制个数不能为空！',1),
    );


    public function _before_delete($data){

        $model = M('ad');
        $adData = $model->where("ad_pos_id='{$data['where']['id']}'")->select();

        foreach($adData as $k => $v){
            @unlink('./Uploads/'.$v['ad_image_url']);
            $model->execute("delete from sh_ad where id='{$v['id']}'");
        }
    }
}