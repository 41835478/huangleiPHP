<?php
/**
 * 商品
 */
namespace Goods\Controller;
use Home\Controller\CommonController;
use Think\Image;
use Think\Upload;

class GoodsController extends CommonController
{

        //添加商品基本信息
    public function add(){

        if(IS_POST){

            $model = D('goods');
            C('TOKEN_ON',false);
            if($model->create()){

                if($last_insert_id = $model->add()){

                    setcookie('goods_id',$last_insert_id);
                    $this->ajaxReturn(array('status'=>true,'result'=>'提交成功，请继续完善商品信息~'));exit;
                }else{

                    $this->ajaxReturn(array('status'=>false,'result'=>'添加失败，刷新重试！'));
                }
            }else{

                $this->ajaxReturn(array('status'=>false,'result'=>$model->getError()));
            }

        }else{
                //取出所有分类
            $catData = D('category')->catTree();
                //取出所有品牌
            $brandData = M('brand')->field('id,brand_name')->order('brand_sort ASC')->select();
                //取出所有类型
            $typeData = M('type')->field('id,type_name')->select();

            $this->assign(array(
                'catData' => $catData,
                'brandData' => $brandData,
                'typeData' => $typeData,

            ));
            $this->display();
        }

    }

        //添加商品图片
    public function addImage(){

        if(IS_POST){

            $model = M('goods_image');
            $images = explode(',',$_POST['goods_image_url']);
            $info['goods_big_image_url'] = $images[0];
            $info['goods_small_image_url'] = $images[1];
            $info['goods_id'] = $_POST['gid'];

            if($model->add($info)){

                $_COOKIE['goods_id'] = "";
                $this->ajaxReturn(array('status'=>true,'result'=>'提交成功，审核会在1-3个工作日内完成！'));
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'提交失败，刷新重试~'));
            }

        }else{
            $gid = $_COOKIE['goods_id'];
            $this->assign('gid',$gid);
            $this->display();
        }

    }

        //库存管理
    public function stock(){
        if(IS_POST){

            $goods_attr = $_POST['goods_attr'];
            $goods_number = $_POST['goods_number'];
            $gid = $_POST['gid'];

                    // 如果该商品有属性
            if($goods_attr) {

                $attrStr = "";      //用于存放implode后的字符串，目的找出重复
                foreach ($goods_number as $k => $v) {

                    $attr = array();
                    foreach ($goods_attr as $k1 => $v1) {
                        $attr[] = $v1[$k];

                    }
                    sort($attr);
                    $str = implode('&', $attr);
                    if ($str == $attrStr) {
                        $this->ajaxReturn(array('status' => false, 'result' => '存在重复的库存信息，请核查！！'));
                        exit;
                    }
                    $attrStr = $str;

                    $info[] = array(
                        'goods_id' => $gid,
                        'goods_number' => $v,
                        'goods_attr_id' => $str
                    );

                }
            }else{

                $info[] = array(
                    'goods_id' => $gid,
                    'goods_number' => array_sum($goods_number),
                    'goods_attr_id' => '此商品无属性',
                );

            }

            $model = M('stock');
            $model->startTrans();   //开启 事务
                //添加库存信息之前，先将该商品的库存信息删除掉
            $result = $model->where("goods_id=$gid")->delete();     //返回影响条数 或 false  ，没删除 返回0

            $result1 = $model->addAll($info);    //添加所有

                    //如果删除成功并且添加成功，提交事务，否则事务回滚
            if($result!==false && $result1){
                $model->commit();
                $this->ajaxReturn(array('status'=>true,'result'=>'保存成功~'));
            }else{
                $model->rollback();
                $this->ajaxReturn(array('status'=>false,'result'=>'保存失败，刷新重试！'));exit;
            }


        }else{
            $id = $_GET['id'];
                //获取当前商品的信息
            $goodsData = M('goods')->find($id);
                //获取当前ID的所有单选属性ID相同的二维数组
            $goods_attr = D('goods_attr')->getSameAttrIDArray($id);
                //获取当前商品的库存信息
            $stock = M('stock')->where('goods_id='.$id)->select();
            
            $this->assign('data',$goodsData);
            $this->assign('stock',$stock);
            $this->assign('goods_attr',$goods_attr);
            $this->display();
        }

    }

            //商品修改
    public function save(){
        $id = $_GET['id'];
        if(IS_POST){
            C('TOKEN_ON',false);
            $model = D('goods');
            if($info = $model->create()){
                if($model->where('id='.$_POST['gid'])->save($info) !== false){
                    $this->ajaxReturn(array('status'=>true,'result'=>'保存修改成功~'));
                }else{
                    $this->ajaxReturn(array('status'=>false,'result'=>'修改失败，刷新重试~'));
                }

            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>$model->getError()));
            }

        }else{

            $goodsData = M('goods')->find($id);     //取出当前商品信息

            $images    = M('goods_image')->where('goods_id='.$id)->select();       //  取出所有商品图片

            $catData   = D('category')->catTree();    //取出商品所有分类

            $brandData = M('brand')->field('id,brand_name')->order('brand_sort ASC')->select(); //取出所有品牌

            $typeData  = M('type')->field('id,type_name')->where('id='.$goodsData['type_id'])->select();     //取出当前商品类型

            $keyword   = M('keywords')->where("goods_id = '{$id}'")->group('goods_id')->getField('GROUP_CONCAT(keywords)');   // 取出所有关键词

            $goods_attr = M('goods_attr')->
                            field('a.attr_value,a.attr_id,a.id,a.attr_price,b.attr_name,b.id aid,b.attr_type,b.attr_values')->
                                alias('a')->
                                    join('left join sh_attribute b on a.attr_id = b.id')->
                                        where('goods_id='.$id)->
                                            order("b.attr_name")->
                                                select();
            //dump($goods_attr);
            $this->assign(array(

                'catData' => $catData,
                'brandData' => $brandData,
                'typeData' => $typeData,
                'data' => $goodsData,
                'images' => $images,
                'goods_attr' => $goods_attr,
                'keywords' => $keyword,

            ));

            $this->display();
        }

    }


        // ajax 删除商品属性
    public function ajaxDelAttr(){
        $id = $_GET['id'];
        M('goods_attr')->delete($id);
    }

        //修改页面，ajax删除已上传图片
    public function ajaxDelImg(){

        $id = $_POST['img_id'];
        $url = $_POST['url'];
        $model = M('goods_image');
        @unlink('./Uploads/'.$url);

        if($model->delete($id)){
            $this->ajaxReturn(array('status'=>true,'result'=>'删除成功~'));
        }else{
            $this->ajaxReturn(array('status'=>false,'result'=>'删除失败！'));

        }
    }

        //商品列表
    public function lst(){
        
            //取出所有类型
        $typeModel = M('type');
        $typeData = $typeModel->field('id,type_name')->select();

            //获取所有商品信息
        $goodsModel = D('goods');
        $goodsData = $goodsModel->getAllGoods();

            // 根据当前登录的用户取出该用户的店铺信息
        $uid = $_SESSION['uid'];
        $store = M('store')->field('id,store_name,store_status,business_status')->where("user_id = '{$uid}'")->find();

        $this->assign(array(
            'typeData'=>$typeData,
            'goodsData'=>$goodsData,
            'store'=>$store,
        ));
        $this->display();
    }

        // 商品审核列表
    public function pending_lst(){
        //取出所有类型
        $typeModel = M('type');
        $typeData = $typeModel->field('id,type_name')->select();

        //获取所有商品信息
        $goodsModel = D('goods');
        $goodsData = $goodsModel->getAllPendingGoods();

        $this->assign(array(

            'typeData'=>$typeData,
            'goodsData'=>$goodsData,
        ));
        $this->display();

    }

        // ajax设置商品审核状态
    public function set_pending_status(){
        $id = $_POST['id'];
        $status = $_POST['status'];
        $model = M('goods');
        if($status == "1"){
            if($model->where('id='.$id)->setField('pending_status','通过审核') !== false){
                $this->ajaxReturn(array('status'=>true,'result'=>'操作成功~'));
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'操作失败！'));
            }
        }else{
            if($model->where('id='.$id)->setField('pending_status','审核未通过') !== false){
                $this->ajaxReturn(array('status'=>true,'result'=>'操作成功~'));
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'操作失败！'));
            }
        }

    }


        //删除产品
    public function delete($id){
        $model = D('goods');
        if($model->delete($id)){
            echo 1;
        }else{
            echo 2;
        }
    }


        //修改是否上架
    public function setStatus(){
        $model = M('goods');
        $id = $_POST['id'];
        $status = $_POST['status'];
        if($status){
            if($model->where('id='.$id)->setField('is_sell','是')){
                echo 1;exit;
            }else{
                echo 2;exit;
            }

        }else{
            if($model->where('id='.$id)->setField('is_sell','否')){
                echo 1;exit;
            }else{
                echo 2;exit;
            }
        }
    }

        //ajax获取当前选中类型的属性
    public function ajaxGetAttr($tid){

        $attr = M('attribute')->where('type_id='.$tid)->select();
        if($attr){
            $this->ajaxReturn(array('status'=>true,'result'=>$attr));exit;
        }
        $this->ajaxReturn(array('status'=>false,'result'=>'获取属性失败，刷新重试~'));exit;

    }

        //webuploader上传类，目的是为了获取到图片路径
    public function webup(){

        $config = array(
            'mimes'         =>  array(), //允许上传的文件MiMe类型
            'maxSize'       =>  0, //上传的文件大小限制 (0-不做限制)
            'exts'          =>  array('jpg', 'gif', 'png', 'jpeg'), //允许上传的文件后缀
            'autoSub'       =>  true, //自动子目录保存文件
            'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
            'rootPath'      =>  './Uploads/', //保存根路径
            'savePath'      =>  'goods/',//保存路径
        );
        $upload = new Upload($config);// 实例化上传类
        $info   = $upload->upload();
        $url    = $config['rootPath'].$info['file']['savepath'].$info['file']['savename'];     // goods/16845894123.jpg

            //将图片按配置文件中的大小缩略
        $image  = new Image();
        $image->open($url);
        $big_img_url   = $info['file']['savepath'].'big_'.$info['file']['savename'];
        $small_img_url = $info['file']['savepath'].'small_'.$info['file']['savename'];
        $image->thumb(C('GOODS_IMG_BIG_WIDTH'),C('GOODS_IMG_BIG_HEIGHT'))->save('./Uploads/'.$big_img_url);
        $image->thumb(C('GOODS_IMG_SMALL_WIDTH'),C('GOODS_IMG_SMALL_HEIGHT'))->save('./Uploads/'.$small_img_url);
        @unlink($url);  //删除原图
            //返回以逗号隔开的字符串，用来处理
        $data = array($big_img_url,$small_img_url);
        $data = implode(',',$data);
        $this->ajaxReturn($data,'json');
        if(!$info) {
            $this->error($upload->getError());// 上传错误提示错误信息
        }
    }


        // 商品详情
    public function goods_detailed(){

        $id = $_GET['id'];
                // 取出和当前商品相关的所有数据
        $data = M('goods')->
                    field('a.*,b.cat_name,c.type_name,d.brand_name,e.store_name')->
                    alias('a')->
                    join("left join sh_category b on a.cat_id = b.id")->
                    join("left join sh_type c on a.type_id = c.id")->
                    join("left join sh_brand d on a.brand_id = d.id")->
                    join("left join sh_store e on a.store_id = e.id")->
                    where("a.id = '{$id}'")->
                    find();

                // 取出当前商品的所有推荐
        $recData = M('recommend_item')->
                    field('a.pending_status,b.rec_name')->
                    alias('a')->
                    join('left join sh_recommend b on a.rec_id = b.id')->
                    where("a.value_id = '{$id}' and a.type = '商品'")->
                    select();
                // 取出商品的所有图片信息
        $images = M('goods_image')->where("goods_id = '{$id}'")->select();
        $keyword = M('keywords')->where("goods_id = '{$id}'")->group('goods_id')->getField('GROUP_CONCAT(keywords)');   // 取出所有关键词

        $this->assign('data',$data);
        $this->assign('images',$images);
        $this->assign('recData',$recData);
        $this->assign('keywords',$keyword);
        $this->display();

    }

    // 店铺是否营业
    public function setStoreStatus(){
        $model = M('store');
        $id = $_POST['id'];
        $status = $_POST['status'];
        if($status){
            if($model->where('id='.$id)->setField('business_status','营业中')){
                echo 1;exit;
            }else{
                echo 2;exit;
            }

        }else{
            if($model->where('id='.$id)->setField('business_status','已打烊')){
                echo 1;exit;
            }else{
                echo 2;exit;
            }
        }
    }
        // 设置店铺页面中的推荐
    public function setStoreRec(){
        if(IS_AJAX){
            $goods_id = $_POST['goods_id'];
            $type = $_POST['type'];
            $model = M('goods');
            if($model->where("id=".$goods_id)->setField('store_rec',$type) !== false){
                $this->ajaxReturn(array('status'=>true,'result'=>'设置成功~'));
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'设置失败！'));
            }
        }
    }



}