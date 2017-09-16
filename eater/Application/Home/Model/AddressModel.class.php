<?php
namespace Home\Model;
use Think\Model;
class AddressModel extends Model
{

    protected $_validate = array(

        array('province','请选择省份','请选择省份！',1,'notequal',1),
        array('city','请选择城市','请选择城市！',1,'notequal',1),
        array('county','请选择地区','请选择地区！',1,'notequal',1),

        array("name",'/^[\x{4e00}-\x{9fa5}]{2,4}$/u',"请输入正确的收货人姓名！",1,'regex'),

        array('address','require','详细地址不能为空！',1),

        array('phone','/^\d{5,15}$/','请输入正确的联系方式！',1,'regex'),

    );

    public function _before_update(&$data){

        if($_POST['province'] == '请选择省份'){
            unset($data['province']);
            unset($data['city']);
            unset($data['county']);
        }else{
            if($_POST['province'] == '请选择省份' || $_POST['city'] == '请选择城市' || $_POST['county'] == '请选择地区'){
                echo json_encode(array('status'=>false,'result'=>'请选择修改地区，不选择请清空，则不修改！'));exit;
            }
        }
    }

}