<?php

/**
 * Created by PhpStorm.
 * User: hi~
 * Date: 2017/3/19
 * Time: 14:46
 * 店铺 模型
 */
namespace Store\Model;
use Think\Image;
use Think\Model;
use Think\Upload;

class StoreModel extends Model
{

    protected $_validate = array(

        array('store_name','require','店铺名称不能为空'),
        array('store_keyword','require','店铺关键词不能为空'),
        array('store_major_type','require','店铺主营类型不能为空'),
        array('new_store_password','6,12','店铺密码长度为6-12位',2,'length')

    );


    public function _before_update(&$data){

        $data['store_keyword'] = str_replace('，',',',$data['store_keyword']);

        $str = $data['store_name'].$data['store_keyword'];

        $result = splitKeyword($str);   // 拆分店铺名称和关键词，获得一些用于搜索的词语
        $data['keyword'] = $result;

        /* 修改店铺密码 */
        if(isset($_POST['new_store_password']) && $_POST['new_store_password']){

            $store_id = $_POST['id'];
            $new_pwd  = $_POST['new_store_password'];
            // 获取商家的id
            $user_id  = $this->where("id = '{$store_id}'")->getField('user_id');
            $model = M('user');
            if($model->where("id = '{$user_id}'")->setField('user_pwd',$new_pwd) === false){
                echo json_encode(array('status'=>false,'result'=>'修改失败，刷新重试！'));exit;
            }

        }





    }



        // 审核通过之前，建立一个商家的信息
    public function buildSeller(){

        $store = $this->
                    alias('a')->
                    field('a.member_id,a.store_owner_number,b.username,b.email')->
                    join("left join sh_member b on a.member_id = b.id")->
                    where("a.id = '{$_POST['id']}'")->
                    find();
        $info['phone'] = $store['username'];                                                // 手机号
        $info['email'] = $store['email'];                                                   // 邮箱
        $info['time']  = date("Y-m-d H:i:s");                                               // 时间
        $info['sex']   = substr($store['store_owner_number'],-1,1) %2 == 1? '女' : '男';    // 性别
            // 先获取角色“商家”的id值
        $role_id = M('role')->where("role_name = '商家'")->getField('id');
        $info['role_id']   = $role_id;    // 角色id
        $info['remark']    = '商家';      // 用户描述

        $info['user_name'] = substr(time(),-5).rand(000,999);   //商家账号
        $info['user_pwd']  = 'eatershop';                       //商家密码

        $lastInsertID = M('user')->add($info);

        return $lastInsertID;

    }

    public function _before_delete($data){

        $id = $data['where']['id'];
        $info = $this->field('id,user_id')->find($id);
            // 删除掉该商家的账号
        $this->execute("delete from sh_user where id = '{$info['user_id']}'");

            //  删除该商家店铺的所有商品的相关数据
        $goodsId = $this->query("select id from sh_goods where store_id = '{$id}'");

        foreach($goodsId as $k => $v){

            $goods_logo = $this->field('goods_logo_url')->find($v['id']);
            @unlink('./Uploads/'.$goods_logo['goods_logo_url']);
            //查询出所有商品图片信息，为了删除图片
            $images = $this->query("select * from sh_goods_image where goods_id={$v['id']}");

            //删除商品之前，删除掉该商品的所有属性信息
            $this->execute("delete from sh_goods_attr where goods_id = {$v['id']}");

            //删除关于该商品的推荐内容
            $this->execute("delete from sh_recommend_item where value_id={$v['id']} and type='商品'");

            //删除该商品的所有库存信息
            $this->execute("delete from sh_stock where goods_id={$v['id']}");

            //遍历商品图片，删除图片及图片信息
            foreach($images as $k1 => $v1){
                @unlink('./Uploads/'.$v1['goods_big_image_url']);
                @unlink('./Uploads/'.$v1['goods_small_image_url']);
                $this->execute("delete from sh_goods_image where id={$v1['id']}");

            }

        }



    }

}