<?php
namespace Goods\Model;
use Think\Image;
use Think\Model;
use Think\Upload;

class GoodsModel extends Model
{
    protected $_validate = array(
        array('goods_title','require','商品标题不能为空！',1),
        array('goods_jl_title','require','简略标题不能为空！',1),
        array('keywords','require','关键词不能为空！',1),
        array('goods_retail_price','require','零售价不能为空！',1),
        array('goods_shop_price','require','本店价不能为空！',1),
        array('goods_infomation','require','产品信息不能为空！',1),
        array('brand_id','0','请选择商品品牌！','1','notequal'),
        array('cat_id','0','请选择商品分类！','1','notequal'),
        array('goods_attr','chkAttrIsRepeat','存在重复的属性信息，请核查！','1','callback'),

    );
        // 判断属性是否存在重复
    public function chkAttrIsRepeat(){
        $attrStr = "";
        foreach ($_POST['goods_attr'] as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k1 => $v1) {
                        // 判断是否重复
                    if ($v1 == $attrStr) {
                        return false;
                    }
                    $attrStr = $v1;
                }
            } else {
                    // 判断是否重复
                if ($v == $attrStr) {
                    return false;
                }
                $attrStr = $v;
            }
        }
    }

        //查询出所有商品
    public function getAllGoods(){
        
        $where = "1";
        //根据产品名称关键字查询
        if(isset($_GET['goods_name']) && $_GET['goods_name']){
            $where .= " AND a.goods_title like '%{$_GET['goods_name']}%'";
        }
        //根据产品分类查询
        if(isset($_GET['cat']) && $_GET['cat']){
            $where .= " AND b.cat_name like '%{$_GET['cat']}%'";
        }
        //根据产品品牌查询
        if(isset($_GET['brand']) && $_GET['brand']){
            $where .= " AND c.brand_name like '%{$_GET['brand']}%'";
        }
        //根据产品类型查询
        if(isset($_GET['tid']) && $_GET['tid']){
            $where .= " AND a.type_id ={$_GET['tid']}";
        }
        // 如果登录的用户是商家，商家的角色id为9
        if($_SESSION['rid'] == '9'){
            $store_id = M('store')->where("user_id = '{$_SESSION['uid']}'")->getField('id');
            $where .= " AND store_id = '{$store_id}'";
        }

            //返回查询结果
        return $this->query("
                        select a.id,a.goods_number,a.goods_title,a.goods_retail_price,a.goods_shop_price,a.is_sell,a.pending_status,b.cat_name,c.brand_name,d.type_name from sh_goods a 
                          left join sh_category b on a.cat_id = b.id
                            left join sh_brand c on a.brand_id = c.id
                              left join sh_type d on a.type_id = d.id
                                where $where
                                  order by goods_number asc
                            ");
    }

    // 获取所有审核的商品
    public function getAllPendingGoods(){

        $where = "1 and pending_status !='通过审核'";
        //根据产品名称关键字查询
        if(isset($_GET['goods_name']) && $_GET['goods_name']){
            $where .= " AND a.goods_title like '%{$_GET['goods_name']}%'";
        }
        //根据产品分类查询
        if(isset($_GET['cat']) && $_GET['cat']){
            $where .= " AND b.cat_name like '%{$_GET['cat']}%'";
        }
        //根据产品品牌查询
        if(isset($_GET['brand']) && $_GET['brand']){
            $where .= " AND c.brand_name like '%{$_GET['brand']}%'";
        }
        //根据产品类型查询
        if(isset($_GET['tid']) && $_GET['tid']){
            $where .= " AND a.type_id ={$_GET['tid']}";
        }
        //返回查询结果
        return $this->query("
                        select a.id,a.goods_number,a.goods_title,a.goods_retail_price,a.goods_shop_price,a.is_sell,a.pending_status,b.cat_name,c.brand_name,d.type_name from sh_goods a 
                          left join sh_category b on a.cat_id = b.id
                            left join sh_brand c on a.brand_id = c.id
                              left join sh_type d on a.type_id = d.id
                                where $where
                            ");
    }

    public function _before_insert(&$data){

            // 关键词
        $data['title_keyword'] = splitKeyword($data['goods_title']);
        
            //商品封面图片处理 缩略
        if(isset($_FILES['goods_logo']['tmp_name']) && $_FILES['goods_logo']['tmp_name']){
            $upload = new Upload();
            $upload->maxsize = 5242880;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
            $upload->savePath = 'goods/';
            $msg = $upload->upload();
            $path = $msg['goods_logo']['savepath'].$msg['goods_logo']['savename'];
            $image  = new Image();
            $image->open('./Uploads/'.$path);
            $image->thumb(C('GOODS_LOGO_IMG_WIDTH'),C('GOODS_LOGO_IMG_HEIGHT'))->save('./Uploads/'.$path);
            $data['goods_logo_url'] = $path;
        }else{
            echo json_encode(array('status'=>false,'result'=>'请先上传商品封面！'));exit;
        }


        $data['goods_number'] = substr(time(),2,10).rand(0000,9999);
        $data['goods_add_time'] = date("Y-m-d H:i:s");

        // 如果这个人的身份是商家，store_id 是这个用户的店铺id，否则就是自营商品
        if($_SESSION['rid'] == '9'){

            $uid = $_SESSION['uid'];
            $store_id = M('store')->where("user_id = '{$uid}'")->getField('id');
            $data['store_id'] = $store_id;
        }else{
            $data['store_id'] = "1";
        }

    }



    public function _after_insert($data){

        /************************************添加商品属性*****************************************/
        $attr_price = $_POST['attr_price'];

        if($attr_price){
            $i = 0;
            $model = M('goods_attr');
            $info = array();
            foreach($_POST['goods_attr'] as $k => $v){

                if(is_array($v)){
                    foreach($v as $k1 => $v1){
                        $info[] = array(
                            'goods_id' => $data['id'],
                            'attr_id' => $k,
                            'attr_value'=>$v1,
                            'attr_price'=>$attr_price[$i]
                        );
                        $i++;
                    }
                }else{
                    $info[] = array(
                        'goods_id' => $data['id'],
                        'attr_id' => $k,
                        'attr_value'=>$v,
                        'attr_price'=>$attr_price[$i]
                    );
                    $i++;
                }
            }

            $model->addAll($info);
        }

        /* 添加关键词 */
        $keywords = str_replace('，',',',$_POST['keywords']);
        $words    = explode(',',$keywords);
        $keyModel = M('keywords');
        $arr      = array();
        foreach($words as $k => $v){
            $arr[] = array('goods_id'=>$data['id'],'keywords'=>$v);
        }
        $keyModel->addAll($arr);

    }



    public function _before_update(&$data){


        $goods_attr = $_POST['goods_attr'];
        $old_goods_attr = $_POST['old_goods_attr'];
        $old_attr_price = $_POST['old_attr_price'];

        // 关键词
        $data['title_keyword'] = splitKeyword($data['goods_title']);


         /********************修改时，添加的新属性*************************/
        if($goods_attr) {
            foreach ($goods_attr as $k => $v) {
                if (is_array($v)) {
                    if (array_intersect($old_goods_attr[$k], $v)) {
                        echo json_encode(array('status' => false, 'result' => '存在重复的属性值，请核查！'));
                        exit;
                    }
                }
            }
            $data['id'] = $_POST['gid'];
            $this->_after_insert($data);
        }

        /******************************修改时，处理旧的属性*****************************/
        if($old_attr_price) {
            $i=0;
            $model = M('goods_attr');
            $ids = array_keys($old_attr_price);
            $prices = array_values($old_attr_price);
            foreach ($old_goods_attr as $k => $v) {

                if(is_array($v)){
                    foreach($v as $k1 => $v1){
                        $model->where("id=".$ids[$i])->save(array(
                            'attr_value'=>$v1,
                            'attr_price'=>$prices[$i],
                        ));
                        $i++;
                    }
                }else{
                    $model->where('id='.$ids[$i])->save(array(
                        'attr_value' => $v,
                        'attr_price' => $prices[$i],
                    ));
                    $i++;
                }
            }
        }


        /* 如果修改了商品封面 */
        if(isset($_FILES['goods_logo']['tmp_name']) && $_FILES['goods_logo']['tmp_name']){
            $upload = new Upload();
            $upload->maxsize = 5242880;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
            $upload->savePath = 'goods/';
            $msg = $upload->upload();
            $path = $msg['goods_logo']['savepath'].$msg['goods_logo']['savename'];
            $image  = new Image();
            $image->open('./Uploads/'.$path);
            $image->thumb(C('GOODS_LOGO_IMG_WIDTH'),C('GOODS_LOGO_IMG_HEIGHT'))->save('./Uploads/'.$path);
            $data['goods_logo_url'] = $path;
            @unlink('./Uploads/'.$_POST['old_img']);
        }

        /**************************** 关键词 *********************************/
        /* 删除掉原来的关键词 */
        $this->execute("delete from sh_keywords where goods_id = {$_POST['gid']}");
        /* 添加关键词 */
        $keywords = str_replace('，',',',$_POST['keywords']);
        $words    = explode(',',$keywords);
        $keyModel = M('keywords');
        $arr      = array();
        foreach($words as $k => $v){
            $arr[] = array('goods_id'=>$_POST['gid'],'keywords'=>$v);
        }
        $keyModel->addAll($arr);

    }


    public function _before_delete($data){

        $goods_logo = $this->field('goods_logo_url')->find($data['where']['id']);
        @unlink('./Uploads/'.$goods_logo['goods_logo_url']);
            //查询出所有商品图片信息，为了删除图片
        $images = $this->query("select * from sh_goods_image where goods_id={$data['where']['id']}");

            //删除商品之前，删除掉该商品的所有属性信息
        $this->execute("delete from sh_goods_attr where goods_id = {$data['where']['id']}");

            //删除关于该商品的推荐内容
        $this->execute("delete from sh_recommend_item where value_id={$data['where']['id']} and type='商品'");

            //删除该商品的所有库存信息
        $this->execute("delete from sh_stock where goods_id={$data['where']['id']}");

            //删除该商品的所有关键词信息
        $this->execute("delete from sh_keywords where goods_id = '{$data['where']['id']}'");

            //遍历商品图片，删除图片及图片信息
        foreach($images as $k => $v){
            @unlink('./Uploads/'.$v['goods_big_image_url']);
            @unlink('./Uploads/'.$v['goods_small_image_url']);
            $this->execute("delete from sh_goods_image where id={$v['id']}");

        }

    }
}