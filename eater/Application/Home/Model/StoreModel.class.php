<?php
/**
 * Created by PhpStorm.
 * User: hi~
 * Date: 2017/3/18
 * Time: 10:03\
 * 店铺 模型
 */
namespace Home\Model;
use Think\Image;
use Think\Model;
use Think\Upload;

class StoreModel extends Model
{

    protected $_validate = array(
        array('store_name','5,15','店铺名称为5-15个字符',0,'length'),
        array('store_name','','店铺名称已被注册',0,'unique'),
        array('store_major_type','1,100',"店铺主营描述在100字以内",0,'length'),
        array("store_owner_name",'/^[\x{4e00}-\x{9fa5}]{2,4}$/u',"店铺主人姓名格式有误",0,'regex'),
        array("store_owner_number",'/^\d{18}$/',"店铺主人身份证格式有误",0,'regex'),
        array("store_owner_number",'',"抱歉，您已申请过店铺！",0,'unique'),
    );

        //  验证图片是否上传，如果都上传返回false，没上传返回错误信息数组
    public function chkImgExist(){
        if(!isset($_FILES['store_logo']['tmp_name']) || $_FILES['store_logo']['tmp_name'] == ""){
            return array('status'=>false,'result'=>'店铺logo未上传');
        }else if(!isset($_FILES['store_owner_img']['tmp_name']) || $_FILES['store_owner_img']['tmp_name'] == ""){
            return array('status'=>false,'result'=>'店铺主人手持身份证照片未上传');
        }else{
            return false;
        }
    }


    public function _before_insert(&$data){

            // 如果都上传，返回false，否则返回错误信息数组
        $result = $this->chkImgExist();
        if(!$result){

            $upload = new Upload();
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->savePath  =      'store/'; // 设置附件上传目录

            $info = $upload->upload();
            if($info){
                $data['store_logo_url'] = $info['store_logo']['savepath'].$info['store_logo']['savename'];
                $image = new Image();
                $image->open('./Uploads/'.$data['store_logo_url']);
                $image->thumb(150, 100)->save('./Uploads/'.$data['store_logo_url']);

                $data['store_owner_img'] = $info['store_owner_img']['savepath'].$info['store_owner_img']['savename'];
                $data['member_id'] = $_SESSION['eater_uid'];
                $data['time'] = date("Y-m-d H:i:s");
            }else{
                echo json_encode(array('status'=>false,'result'=>$upload->getError()));exit;
            }

        }else{
            echo json_encode($result);exit;
        }

    }

    public function _before_update(&$data){


        $upload = new Upload();
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->savePath  =      'store/'; // 设置附件上传目录
            // 如果上传了 店铺logo照片
        if(isset($_FILES['store_logo']['tmp_name']) && $_FILES['store_logo']['tmp_name']){

            $info = $upload->uploadOne($_FILES['store_logo']);

            if($info){
                $data['store_logo_url'] = $info['savepath'].$info['savename'];
                $image = new Image();
                $image->open('./Uploads/'.$data['store_logo_url']);
                $image->thumb(150, 100)->save('./Uploads/'.$data['store_logo_url']);
                @unlink('./Uploads/'.$_POST['old_store_logo_url']);
            }else{
                echo json_encode(array('status'=>false,'result'=>$upload->getError()));exit;
            }

        }
            // 如果上传了 手持身份证照片
        if(isset($_FILES['store_owner_img']['tmp_name']) && $_FILES['store_owner_img']['tmp_name']){
            $info = $upload->uploadOne($_FILES['store_owner_img']);
            if($info){
                $data['store_owner_img'] = $info['savepath'].$info['savename'];
                @unlink('./Uploads/'.$_POST['old_store_owner_img']);
            }else{
                echo json_encode(array('status'=>false,'result'=>$upload->getError()));exit;
            }
        }
        $data['status'] = '审核中';


    }


        // 取消申请之前，将图片删除掉
    public function _before_delete($data){
        $id = $data['where']['id'];
        $images_url = $this->field("store_logo_url,store_owner_img")->find($id);
        @unlink('./Uploads/'.$images_url['store_logo_url']);
        @unlink('./Uploads/'.$images_url['store_owner_img']);
    }

    /* 获取店铺列表右侧商品数据，用户浏览过的商品优先排在前面 */
    public function getStoreRightGoodsData($store_id_array){

        $goodsModel = M('goods');

        /* 取出所有用户浏览的商品，优先显示在店铺查询列表前面 */
        $record  = isset($_COOKIE['record']) ? unserialize($_COOKIE['record']) : '';// 浏览记录
        if($record){

            $goods_id = array();    // 存放所有浏览商品的id

            foreach($record as $k => $v){
                //  分割  39,2017-03-27
                $arr = explode(',',$v);
                $goods_id[] = $arr[0];
            }

            /* 查询出浏览商品信息，并存在索引为store_id的二维数组$goods中 */
            $goods_id = implode(',',array_unique($goods_id));
            $record_goods = $goodsModel->field("id,store_id,goods_logo_url,goods_shop_price")->where("id IN ({$goods_id})")->select();
            $goods = array();
            foreach($record_goods as $k => $v){
                if(count($goods[$v['store_id']]) >= 4){
                    continue;
                }
                $goods[$v['store_id']][] = $v;
            }
        }else{
            $goods = "";
        }

        /* 如果用户浏览的数目小于4条，则查询出4-$num条，补充在数组中*/
        foreach($store_id_array as $k => $v){

            if($goods[$v]){
                $num = count($goods[$v]);                           // 用户浏览该店铺商品的个数
                $ids = implode(',',array_column($goods[$v],'id'));  // 用户浏览的商品id，用于NOT IN
                if($num < 4){
                    $gd = $goodsModel->field('id,store_id,goods_logo_url,goods_shop_price')->limit(4-$num)->where("store_id = '{$v}' and id NOT IN ({$ids})")->select();
                    $goods[$v] = array_merge($goods[$v],$gd);
                }
            }else{
                $goods[$v] = $goodsModel->field('id,store_id,goods_logo_url,goods_shop_price')->limit(4)->where("store_id  = '{$v}'")->select();
            }

        }
        return $goods;


    }



}