<?php
namespace Home\Controller;
use Home\Controller\CommonController;
use Think\Hook;
use Think\Page;
header("Content-type:text/html;charset=utf8");

class IndexController extends CommonController
{

    public function index(){

        Layout('Layout/layout');
        $catData        = D('category')->getCatNav();           // 获取所有分类，生成三级菜单，包含菜单中的同类推荐商品
        
        $adData         = D('Ad')->getAd();                     // 取出广告位

        $goodsRecommend = D('recommend')->getGoodsRecData();    // 获取首页商品热门推荐信息

        $catRecommend   = D('recommend')->getCatRecData();      // 获取首页分类推荐

        $this->assign(array(
            'adData'         => $adData,
            'catData'        => $catData,
            'goodsRecommend' => $goodsRecommend,
            'catRecommend'   => $catRecommend,

        ));
        $this->display();
    }


    public function item($id){


        $data = M('goods')->
            field('a.cat_id,a.id,a.store_id,a.goods_number,a.goods_logo_url,a.goods_title,a.goods_jl_title,a.goods_retail_price,a.goods_shop_price,a.goods_infomation,a.goods_add_time,a.is_sell,
                   b.cat_name,b.parent_id,
                   c.brand_name,
                   d.type_name,
                   e.store_name,e.store_logo_url,e.store_status,e.business_status')->
            alias('a')->
            join("left join sh_category b on a.cat_id = b.id")->
            join("left join sh_brand c on a.brand_id  = c.id")->
            join("left join sh_type d on a.type_id    = d.id")->
            join("left join sh_store e on a.store_id  = e.id")->
            where('a.id = '.$id." and a.pending_status = '通过审核'")->
            find();

        if(!$data){
            $this->redirect('Index/index');exit;
        }


        if($data['parent_id'] == 0){
            // 获取父类的所有子分类id
            $_cat_id_item = D('category')->getChildrenCatIdItem($data['cat_id']);
            $_cat_id_item[] = $data['cat_id'];
            $cat_id_item = implode(',',$_cat_id_item);

        }else{
            // 通过当前商品的父级分类id，取出父类的所有子分类
            $_cat_id_item = D('category')->getSameCatByCatParentID($data['parent_id']);
            $cat_id_item = implode(',',$_cat_id_item);
        }

        // 取出商品详情页同类推荐
        $sameCatRec = D('recommend')->getGoodsByRecName('商品详情页同类推荐',$cat_id_item,3);

        // 删除掉当前显示的商品
        foreach($sameCatRec as $k => $v){
            if($v['id'] == $data['id']){
                unset($sameCatRec[$k]);
            }
        }

        $ids = array_column($sameCatRec,'id');
        $ids[] = $id;
        $ids = implode(',',$ids);
        if($ids){
            // 取出 “用户还喜欢”（不在同类推荐中的）
            $like = M('record')->
                    alias('a')->
                    field('count(a.id) num,a.goods_id,b.goods_title,b.goods_logo_url,b.goods_shop_price')->
                    join("left join sh_goods b on a.goods_id = b.id")->
                    where("a.goods_id NOT IN ($ids) and b.is_sell = '是'")->
                    group("a.goods_id")->
                    order('num desc')->
                    limit(6)->
                    select();
        }else{
            $like = "";
        }

        // 取出 当前商品的所有图片
        $images = M('goods_image')->where('goods_id = '.$id)->select();


        /* 如果商品没有在销售，就不取出属性了 */
        if($data['is_sell'] == '是' && $data['store_status'] == '启用' && $data['business_status'] == '营业中') {
            // 取出 当前商品的所有属性
            $_goods_attr = M('goods_attr')->
                            field('a.id,a.attr_value,a.attr_price,b.attr_name,b.attr_type,a.attr_id')->
                            alias('a')->
                            join("left join sh_attribute b on a.attr_id = b.id")->
                            where("a.goods_id = '{$id}'")->
                            order("a.attr_value")->
                            select();

            $goods_attr_dx = array();   // 单选属性
            $goods_attr_no_dx = array();// 多选属性
            foreach ($_goods_attr as $k => $v) {
                if ($v['attr_type'] == '单选') {
                    $goods_attr_dx[$v['attr_id']][] = $v;
                } else {
                    $goods_attr_no_dx[] = $v;
                }
            }
        }else{
            $goods_attr_dx = "";
            $goods_attr_no_dx = "";
        }

        // 判断商品 是否被关注
        $is_follow = M('follow')->where("value_id = '{$data['id']}' and user_id = '{$_SESSION['eater_uid']}' and type = '商品'")->count();



        $this->assign(array(
            'data'             => $data,            // 商品信息
            'images'           => $images,          // 商品图片
            'goods_attr_dx'    => $goods_attr_dx,   // 商品单选属性
            'goods_attr_no_dx' => $goods_attr_no_dx,// 商品多选属性
            'sameCatRec'       => $sameCatRec,      // 同类推荐
            'is_follow'        => $is_follow,       // 是否被关注
            'like'             => $like,            // 用户还喜欢
//            'remark'           => $remark['data'],  // 评论
//            'remark_percent'   => $remark_percent,  // 评论百分比
//            'remark_page'      => $remark['page'],  // 评论分页
        ));

        layout('Layout/layout');

        $arr = array(
            'goods_id' => $id,
        );
        Hook::listen('action_name',$arr);

        $this->display();

    }

    // ajax 获取评论
    public function ajaxGetRemark(){
        if(IS_AJAX){
            $goods_id = $_GET['goods_id'];
            /* 获取评论 */
            $remarkModel = D('remark');
            $remark = $remarkModel->get_remark($goods_id);
            $remark_percent = $remarkModel->count_percent($goods_id);

            if($remark['data']){

                $this->ajaxReturn(array('status'=>true,'page'=>$remark['page'],'remark_data'=>$remark['data'],'remark_percent'=>$remark_percent));exit;
            }else{

                $this->ajaxReturn(array('status'=>false));
            }
        }
    }

        //  ajax获取商品内存
    public function ajaxGetStock(){
        if(IS_AJAX){

            $goods_attr_id = $_POST['goods_attr_id'];
            $goods_id = $_POST['goods_id'];

            $model = M('stock');
            // 统计当前属性加价的价格
            $goods_attr_id_arr = str_replace('&',',',$goods_attr_id);

                // 如果此商品有属性
            if($goods_attr_id)
            {
                $price = M('goods_attr')->where("id IN ({$goods_attr_id_arr})")->sum('attr_price');
                if($data = $model->where("goods_attr_id = '{$goods_attr_id}'")->getField('goods_number')){
                    $this->ajaxReturn(array('status'=>true,'number'=>$data,'price'=>$price));exit;
                }else{
                    $this->ajaxReturn(array('status'=>true,'number'=>0,'price'=>$price));exit;
                }
            }
            else
            {
                if($data = $model->where("goods_id = '{$goods_id}'")->getField('goods_number')){
                    $this->ajaxReturn(array('status'=>true,'number'=>$data,'price'=>'0.00'));exit;
                }else{
                    $this->ajaxReturn(array('status'=>true,'number'=>0,'price'=>'0.00'));exit;
                }
            }
        }
    }

        // ajax 收藏该商品和店铺
    public function ajaxFollow(){
        if(IS_AJAX){
            $value_id = $_POST['value_id'];
            $user_id  = $_POST['user_id'];
            $type = $_POST['type'];

            $model = M('follow');
                // 判断是否已经收藏过该商品
            if($model->where("value_id = '{$value_id}' and user_id = '{$user_id}' and type = '{$type}'")->count() > 0){
                $model->where("value_id = '{$value_id}' and user_id = '{$user_id}' and type = '{$type}'")->delete();
                $this->ajaxReturn(array('status'=>false,'result'=>"收藏$type"));
            }else{
                $model->add(array('value_id'=>$value_id,'user_id'=>$user_id,'type'=>$type));
                $this->ajaxReturn(array('status'=>true,'result'=>'已收藏'));
            }
        }
    }


        // 加入购物车
    public function buyCar(){

        if(IS_AJAX){

//            setcookie('car','',time()-3600,'/');die;

            $goods_id = $_POST['goods_id'];
            $goods_attr_id = $_POST['goods_attr_id'];
            $buy_number = $_POST['buy_number'];

            // 拼接成字符串，作为该商品的唯一标识，再次加入购物车的时候，如果存在该商品，购物车中购买数量就加1
            $key = $goods_id.'-'.$goods_attr_id;

                // 如果cookie car存在，就反序列取出，将新添加的放进去，重新序列化存入
            $car = isset($_COOKIE['car']) ? unserialize($_COOKIE['car']) : array();

            $car[$key]['number'] += $buy_number;        // 购买商品数量


                // 查看购物车页面，如果传来参数 type : update， 则替换购物车中的数量，而不再是累加
            if(isset($_POST['type']) && $_POST['type'] == 'update'){
                $car[$key]['number'] = $buy_number;
            }

            $number = count($car);
            $time = time()+60*60*24*30;
            setcookie('car',serialize($car),$time,'/');
            $this->ajaxReturn(array('status' => true,'result'=>'添加购物车成功','number'=>$number));
        }

    }

        // ajax 获取购物车中的信息， 在header中的购物车里面查看
    public function ajaxGetBuyCar(){

        if(isset($_COOKIE['car'])) {

            $car = unserialize($_COOKIE['car']);

            $cars = array();
            $model = M('goods');
            $gaModel = M('goods_attr');
            $total_price = 0;   // 总价
            $total_rows = 0;    // 总条数
            foreach ($car as $k => $v) {

                $arr = explode('-',$k);

                    // 获取商品的标题，图片，本店价
                $data = $model->field('id,goods_title,goods_logo_url,goods_shop_price price')->find($arr[0]);

                $data['number'] = $v['number']; // 购买数量

                    // 如果商品有属性，总价 = 本店价 + 加价，  否则就是本店价
                if($arr[1]){
                        // 获取属性的 加价
                    $goods_attr_id = str_replace('&',',',$arr[1]);
                    $add_price = $gaModel->where("id IN ($goods_attr_id)")->sum('attr_price');

                    // 本店价 + 加价
                    $data['price'] = $data['price'] + $add_price;
                }

                $data['only'] = $k;  // 该商品的唯一标识

                $cars[] = $data;

                $total_price += $data['price']*$v['number'];
                $total_rows++;

            }

            $this->ajaxReturn(array('status'=>true,'cars'=>$cars,'total_price'=>$total_price,'total_rows'=>$total_rows));

        }else{
            $this->ajaxReturn(array('status'=>false,'result'=>'购物车空空如也，快去填满它吧~'));
        }

    }

        // ajax 删除购物车信息
    public function ajaxDelBuyCar(){

        if(IS_AJAX){
            $only = $_POST['only'];
            $car = unserialize($_COOKIE['car']);
            unset($car[$only]);

            $time = time() + 60*60*24*30;
            setcookie("car",serialize($car),$time,'/');
        }
    }

        // 店铺首页
    public function store(){

        $id = $_GET['store_id'];
        if(!$id){
            $url = U('Index/index');
            echo "<script>alert('店铺未营业或不存在，挑选其他商品吧~');location.href='{$url}';</script>";exit;
        }
        $storeModel = M('store');
        $store = $storeModel->where("id= '{$id}' and store_status = '启用' and business_status = '营业中'")->field('store_name,store_logo_url')->find();

        /* 如果未查询到店铺信息 */
        if(!$store){
            $url = U('Index/index');
            echo "<script>alert('店铺未营业或不存在，挑选其他商品吧~');location.href='{$url}';</script>";exit;
        }

        /* 排序方式 */
        $order = 'id';
        if(isset($_GET['order']) && $_GET['order']){

            $o = $_GET['order'];
            switch($o){
                // 销量 从低到高
                case $o == 'sales_low':
                    $order = 'sales asc';break; // sales 是 count(c.id)  销量
                // 销量 从高到低
                case $o == 'sales_up':
                    $order = 'sales desc';break;
                // 价格 从低到高
                case $o == 'price_low':
                    $order = 'a.goods_shop_price asc';break;
                // 价格 从高到低
                case $o == 'price_up':
                    $order = 'a.goods_shop_price desc';break;
                // 新品
                case $o == 'new':
                    $order = 'a.goods_add_time desc';break;
                // 默认 全部
                default:
                    $order = 'id';break;
            }

        }

        /* 取出该店铺的商品信息 */
        $goodsModel = M('goods');
        $count = $goodsModel->where("store_id = '{$id}' and is_sell = '是' and pending_status = '通过审核'")->count();
        $page = new Page($count,16);
        $goods = $goodsModel->
                        alias('a')->
                            join("left join sh_orders c on c.goods_id = a.id and c.status != '待付款'")->
                                field("a.id,a.goods_title,a.goods_jl_title,a.goods_logo_url,a.goods_shop_price,a.store_rec,count(c.id) sales")->
                                    where("a.store_id = '{$id}' and a.is_sell = '是' and a.pending_status = '通过审核'")->
                                        order($order)->
                                            group("a.id")->
                                                limit($page->firstRow,$page->listRows)->
                                                    select();


        /* 获取店铺内推荐的内容 */
        $store_rec = array();
        foreach($goods as $k => $v){
            if($v['store_rec'] == '暂不选择')
                continue;
            $store_rec[$v['store_rec']][] = $v;
        }


        /* 获取收藏商品*/
        $followModel = M('follow');
        $follow = $followModel->field("value_id")->where("user_id = '{$_SESSION['eater_uid']}' and type = '商品'")->select();
        $is_follow_store = $followModel->where("user_id = '{$_SESSION['eater_uid']}' and type = '店铺' and value_id = '{$id}'")->count();

        /* 获取店铺评论得分 */
        $store_score = D('remark')->getStoreScore($id);


        $this->assign(array(
            'goods' => $goods,
            'page'  => $page->show(),
            'store' => $store,
            'store_rec' => $store_rec,
            'follow'=> array_column($follow,'value_id'),
            'is_follow_store' => $is_follow_store,
            'store_score' => $store_score
        ));
        layout('Layout/layout');
        $this->display();
    }

    // 账号充值
    public function recharge(){

        if(IS_AJAX){
            $username = $_POST['username'];
            $money = $_POST['money'];
            $model = M('member');
            if($model->where("username = '{$username}'")->setInc('money',$money) !== false){
                $this->ajaxReturn(array('status'=>true));
            }else{
                $this->ajaxReturn(array('status'=>false));
            }
        }

    }

    
    /* 匹配搜索关键词 */
    public function search_keywords(){

        if(IS_AJAX){

            $keyword = $_POST['keyword'];
            $type    = $_POST['type'];

            $data = "";
            if($type == "商品"){
                $model = M('keywords');
                $data  = $model->query("select keywords from sh_keywords where keywords like '%{$keyword}%' group by keywords");

            }elseif($type == "店铺"){
                $result = splitKeyword($keyword);
                $result = trim($result) . " ";
                $r2 = str_replace(' ', '* ', $result);  // *用于全文索引时的 通配符
                $storeModel = M('store');
                $data = $storeModel->query("select store_name keywords from sh_store where match(keyword) against('{$r2}'in boolean mode)");

            }

            if($data){
                $this->ajaxReturn(array('status'=>true,'result'=>$data));
            }else{
                $this->ajaxReturn(array('status'=>false));
            }

        }

    }


    /* 商品查询列表 */
    public function search(){

        $content = urldecode($_GET['content']);
        $goodsModel = M('goods');
        if($content){
            /* 拆分关键词 */
            $result = splitKeyword($content);
            $result = trim($result) . " ";
            $result = str_replace(' ', '* ', $result);  // *用于全文索引时的 通配符

            /************************** 拼接 where 条件查询********************/
            $where = "1";
            /* 筛选条件为 品牌 */
            if(isset($_GET['brand_id']) && $_GET['brand_id']){
                $where .= " and a.brand_id = '{$_GET['brand_id']}'";
            }
            /* 筛选条件为 分类 */
            if(isset($_GET['cat_id']) && $_GET['cat_id']){

                $catModel = D('category');
                // 查询出当前分类以及当前分类的子分类的商品
                $child_cat_id = $catModel->getChildrenCatIdItem($_GET['cat_id']);
                $child_cat_id[] = $_GET['cat_id'];
                $child_cat_id_str = implode(',',$child_cat_id);
                $where .= " and a.cat_id IN ($child_cat_id_str)";
            }
            /* 筛选条件为 类型 */
            if(isset($_GET['type_id']) && $_GET['type_id']){
                $where .= " and a.type_id = '{$_GET['type_id']}'";
            }

            /* 排序方式，默认以id排序*/
            $order = 'id';
            if(isset($_GET['order']) && $_GET['order']){

                $o = $_GET['order'];
                switch($o){
                    // 销量 从低到高
                    case $o == 'sales_low':
                        $order = 'sales asc';break; // sales 是 count(c.id)  销量
                    // 销量 从高到低
                    case $o == 'sales_up':
                        $order = 'sales desc';break;
                    // 价格 从低到高
                    case $o == 'price_low':
                        $order = 'a.goods_shop_price asc';break;
                    // 价格 从高到低
                    case $o == 'price_up':
                        $order = 'a.goods_shop_price desc';break;
                    // 新品
                    case $o == 'new':
                        $order = 'a.goods_add_time desc';break;
                    // 默认 全部
                    default:
                        $order = 'id';break;
                }

            }

            // 统计总条数
            $count = $goodsModel->alias('a')->join("left join sh_store b on a.store_id = b.id")->where("match(title_keyword) against('{$result}'in boolean mode) and a.pending_status = '通过审核' and a.is_sell = '是' and b.business_status = '营业中' and b.store_status='启用' and b.status='通过审核'")->count();
            // 分页，每页12个
            $page = new Page($count,12);
            /* 获取商品基本信息，销量，店铺信息 */
            $goods = $goodsModel->
                        alias('a')->
                            field('count(c.id) sales,a.type_id,a.cat_id,a.brand_id,a.id,a.goods_logo_url,a.goods_title,a.goods_shop_price,a.store_id,b.store_name')->
                                join("left join sh_store b on a.store_id = b.id")->
                                join("left join sh_orders c on c.goods_id = a.id and c.status != '待付款'")->
                                    where("$where and match(title_keyword) against('{$result}'in boolean mode) and a.pending_status = '通过审核' and a.is_sell = '是' and b.business_status = '营业中' and b.store_status='启用' and b.status='通过审核'")->
                                        limit($page->firstRow,$page->listRows)->
                                            order($order)->
                                                group("a.id")->
                                                    select();
            /* 获取关注的商品 */
            $followModel = M('follow');
            $follow      = $followModel->where("user_id = '{$_SESSION['eater_uid']}' and type = '商品'")->getField('GROUP_CONCAT(value_id)');

            if($goods){
                /* 取出所有查询到的商品品牌 */
                $brandModel = M('brand');
                $brand_id   = implode(',',array_unique(array_column($goods,'brand_id')));
                $brand      = $brandModel->field("id,brand_name")->where("id IN ($brand_id)")->select();

                /* 取出所有查询到的类型 */
                $typeModel = M('type');
                $type_id   = implode(',',array_unique(array_column($goods,'type_id')));
                $type      = $typeModel->field("id,type_name")->where("id IN ($type_id)")->select();

                /* 取出所有查询到的分类 */
                $catModel = M('category');
                $cat_id   = implode(',',array_unique(array_column($goods,'cat_id')));
                $category = $catModel->field("id,cat_name")->where("id IN ($cat_id)")->select();
            }

            $show = $page->show();  // 分页数据

        }

        /***************** 从浏览记录中取出5条， 这5条不包括已经被查询到的 *****************/
        $gid = array_column($goods,'id');   // 被查询到的商品id数组
        $record = isset($_COOKIE['record']) ? unserialize($_COOKIE['record']) : ''; // 从cookie中取出浏览记录
        if($record){
            $arr = array();
            foreach($record as $k => $v){
                // 限制5条
                if(count($arr) == 5){
                    break;
                }
                $a = explode(',',$v);
                // 排除已查询到的和已经在数组中的
                if(!in_array($a[0],$gid) && !in_array($a[0],$arr)){
                    $arr[] = $a[0];
                }
            }
            $ids = implode(',',$arr);
            $goods_record = $goodsModel->field("goods_jl_title,goods_shop_price,goods_logo_url,id")->where("id IN ({$ids})")->select();
        }else{
            $goods_record = array();
        }


        $this->assign(array(
            'goods'  => $goods,
            'record' => $goods_record,
            'follow' => $follow,
            'page'   => $show,
            'brand'  => $brand,
            'type'   => $type,
            'category'=> $category,
            'bid_bname'     => array_column($brand,'brand_name','id'),
            'tid_tname'     => array_column($type,'type_name','id'),
            'cid_cname'     => array_column($category,'cat_name','id'),
        ));

        layout('Layout/layout');
        $this->display();
    }

    public function store_list(){

        $content = $_GET['content'];
        $storeModel = D('store');

        $where = '1';
        if($content){
            /* 拆分关键词 */
            $result = splitKeyword($content);
            $result = trim($result) . " ";
            $result = str_replace(' ', '* ', $result);  // *用于全文索引时的 通配符

            $where .= " and match(keyword) against('{$result}'in boolean mode)";

        }
        // 店铺信息
        $store = $storeModel->query("select count(b.id) num,a.id,a.store_name,a.store_logo_url,format(sum(desc_points)/count(*),2) desc_points,format(sum(logistics_points)/count(*),2) logistics_points,format(sum(service_points)/count(*),2) service_points from sh_store a 
                                        left join sh_remark b on a.id = b.store_id 
                                          where $where and a.business_status = '营业中' and a.store_status = '启用' and a.status = '通过审核'
                                            group by b.store_id 
                                              order by id");

        if($store){
            /* 取出店铺列表的右侧商品信息 */
            $store_id_array = array_column($store,'id');  // 所有查询出来的店铺id数组
            $goodsData = $storeModel->getStoreRightGoodsData($store_id_array);

            $store_id_str = implode(',',$store_id_array);
            /* 计算店铺销量 */
            $_store_sales  = $storeModel->query("select count(*) num,b.goods_title,b.store_id from sh_orders a 
                                                  left join sh_goods b on a.goods_id = b.id
                                                    where b.store_id IN ({$store_id_str})
                                                      group by b.store_id");
            $store_sales  = array_column($_store_sales,'num','store_id');

        }


        $this->assign(array(
            'store'        => $store,
            'goodsData'    => $goodsData,
            'store_sales' => $store_sales
        ));
        layout('Layout/layout');
        $this->display();

    }

    /* 意见反馈 */
    public function feedback(){

        if(IS_AJAX){

            $content = htmlspecialchars($_POST['content']);

            if(!$content){
                $this->ajaxReturn(array('status'=>false,'result'=>'请输入意见反馈，谢谢~'));exit;
            }

            if(!isset($_SESSION['eater_uid']) || $_SESSION['eater_uid'] == ""){
                $this->ajaxReturn(array('status'=>'error'));exit;
            }

            $arr = array(
                'user_id'   =>  $_SESSION['eater_uid'],
                'content'   =>  $content,
                'time'      =>  date('Y-m-d H:i:s'),
            );

            $model = M('feedback');

            if($model->add($arr)){
                $this->ajaxReturn(array('status'=>true,'result'=>'我们已经收到您的意见，感谢！'));exit;
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'提交失败，刷新重试！'));exit;
            }
        }

    }

}