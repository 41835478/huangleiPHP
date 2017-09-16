<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="/eater/Public/css/style.css" />
    <script type="text/javascript" src="/eater/Public/js/jquery-1.11.1.min_044d0927.js"></script>
    <script type="text/javascript" src="/eater/Public/js/jquery.bxslider_e88acd1b.js"></script>
    <script type="text/javascript" src="/eater/Public/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="/eater/Public/js/menu.js"></script>
    <script type="text/javascript" src="/eater/Public/js/select.js"></script>
    <script type="text/javascript" src="/eater/Public/js/lrscroll.js"></script>
    <script type="text/javascript" src="/eater/Public/js/iban.js"></script>
    <script type="text/javascript" src="/eater/Public/js/fban.js"></script>
    <script type="text/javascript" src="/eater/Public/js/f_ban.js"></script>
    <script type="text/javascript" src="/eater/Public/js/mban.js"></script>
    <script type="text/javascript" src="/eater/Public/js/bban.js"></script>
    <script type="text/javascript" src="/eater/Public/js/hban.js"></script>
    <script type="text/javascript" src="/eater/Public/js/tban.js"></script>
    <script type="text/javascript" src="/eater/Public/js/lrscroll_1.js"></script>
    <script type="text/javascript" src="/eater/Public/layer/layer.js"></script>

    <title>尤洪</title>
</head>
<script>
    $(function(){

        $.ajax({
            type : 'post',
            url : "<?php echo U('Login/ajaxChkUser');?>",
            dataType : 'json',
            success : function(response){
                var login_url = "<?php echo U('Login/login');?>";
                var register_url = "<?php echo U('Login/register');?>";
                var logout_url = "<?php echo U('Login/logout');?>";
                var personal_url = "<?php echo U('Personal/user');?>";
                if(response.status){
                    $('#logo1').html("欢迎您：<a href='"+personal_url+"' style='color: #ff4e00;' target='_blank'>"+response.nickname+"</a> <a href='"+logout_url+"'>退出</a>&nbsp;");
                    ajaxGetBuyCar();    //   获取购物车信息
                }else{
                    $('#logo1').html("<a href='"+login_url+"'>你好，请登录</a>&nbsp; <a href='"+register_url+"' style='color:#ff4e00;'>免费注册</a>&nbsp;");
                }
            }
        });
    });

</script>
<body>
<!--Begin Header Begin-->
<div class="soubg">
    <div class="sou">

        <!--End 所在收货地区 End-->
        <span class="fr">
        	<span class="fl">
                <span id="logo1"></span>|&nbsp;<a href="<?php echo U('Personal/order');?>">我的订单</a>&nbsp;|</span>

        	<span class="ss">
            	<div class="ss_list">
                    <a href="#">收藏夹</a>
                    <div class="ss_list_bg">
                        <div class="s_city_t"></div>
                        <div class="ss_list_c">
                            <ul>
                                <li><a href="<?php echo U('Personal/follow',array('type'=>'商品'));?>">收藏的商品</a></li>
                                <li><a href="<?php echo U('Personal/follow',array('type'=>'店铺'));?>">收藏的店铺</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="ss_list">
                    <a href="#">卖家中心</a>
                    <div class="ss_list_bg">
                        <div class="s_city_t"></div>
                        <div class="ss_list_c">
                            <ul>
                                <li><a href="<?php echo U('Personal/apply_list');?>">我的申请</a></li>
                                <li><a href="<?php echo U('Personal/apply_store');?>">申请店铺</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="ss_list">
                    <a href="#">关于网站</a>
                    <div class="ss_list_bg">
                        <div class="s_city_t"></div>
                        <div class="ss_list_c">
                            <ul>
                                <li><a href="#" onclick="feedback()">意见反馈</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </span>
        </span>
    </div>
</div>
<div class="feedback" style="width:480px;height:280px;margin-top:20px;display: none;">
    <textarea name="content" id="feedback" style="width:440px;height:280px;outline: none;resize: none;border:1px solid #fff;background:#FFFACD;padding:10px 20px;" placeholder="意见反馈.."></textarea>
</div>
<script>

    function feedback(){
        // 如果用户没有登录，跳转到登录页面
        var user_id = "<?php echo $_SESSION[eater_uid]?>";
        if(user_id == "" || typeof(user_id) == "undefined" ){
            window.location.href="<?php echo U('Login/login');?>";
            return false;
        }
        $('#feedback').val('');

        layer.open({
            type: 1,
            title: '意见反馈',
            maxmin: true,
            skin: 'layui-layer-demo', //样式类名
            shadeClose: false, //点击遮罩关闭层
            area : ['600px' , '450px'],
            content:$('.feedback'),
            btn:['提交','取消'],
            yes : function(){

                $.ajax({
                    type : 'post',
                    url : "<?php echo U('Index/feedback');?>",
                    data : {
                        content : $('#feedback').val(),
                    },
                    success : function(response){

                        if(response.status == 'error'){
                            window.location.href="<?php echo U('Login/login');?>";
                            return false;
                        }

                        if(response.status){
                            layer.closeAll();
                            layer.msg(response.result,{time:2000});
                        }else{
                            layer.alert(response.result,{icon:6,title:'提示'});
                        }
                    }
                });

            }
        });

    }


</script>
<style>

    #search_type .query{
        width: 50px;
        text-align :center;
        display: inline-block;
        margin :0;
        padding: 0;
    }

    #search_type .yes{
        background: #ff4e00;
        color:white;
    }
    #shelper{


        position: absolute;
        z-index: 9999;
        margin-left: 0;
        margin-top:39px;
        width:418px;

        border: 1px solid #ccc;
        background: #fff;

    }
    .search {
        width: 520px;
        height: 65px;
        /*overflow:visible;*/
        float: left;
        display: inline;
        margin-left: 134px;
        margin-top: 50px;
    }

    .she_li{
        width: 100%;
        cursor: pointer;

    }
    .she_li p{
        margin:0px;
        display: block;
        padding-left: 8px;
        padding-right: 8px;
    }
    .she_li label{
        font-weight: bold;

    }
    .she_li i {
        font-style: normal;
        font-size: 15px;
        font-weight: 700;
        color:Red;
    }

    .she_li span{
        display:block;
        float: right;
        color:#aaa;
    }

    .she_li:hover{
        background: rgb(228,228,228);
    }

</style>
<script>
    $(function(){
        $('.query').click(function(){
            $(this).addClass('yes').siblings('.query').removeClass('yes');

            var type = $('.yes').html();
            var val  = $("input[name='search']").val().trim();
            if(val == ""){
                $('#shelper').css('display','none');
                return false;
            }
            kw_search(val,type);
        });
    });

</script>
<div class="top" style="z-index: 1">
    <div class="logo" style="margin-top:50px;"><a href="<?php echo U('Index/index');?>"><img src="/eater/Public/images/logo.png"/></a></div>
    <div class="search" style="">

        <div id="search_type">
            <a href="javascript:void(0);" class="query <?php echo ACTION_NAME != 'store_list' ? 'yes' : '';?>">商品</a>
            <a href="javascript:void(0);" class="query <?php echo ACTION_NAME == 'store_list' ? 'yes' : '';?>" style="margin-left:-3px;">店铺</a>
        </div>

            <input type="text" name="search" class="s_ipt" id="search" value="<?php echo $_GET['content'];?>" style="outline: none;padding:0 5px;" autocomplete="off"/>
            <input type="button" value="搜索" onclick="submit_search();" class="s_btn" style="outline: none;height:39px;"/>

        <ul id="shelper" style="display: none"></ul>
        <span class="fl">
            <?php foreach($search_next_cat_rec as $k => $v): ?>
            <a href="#"><?php echo $v['cat_name'];?></a>
            <?php endforeach; ?>
        </span>
    </div>
    <div class="i_car">
        <div class="car_t">购物车 [ <span id="car_goods_number">0</span> ]</div>
        <div class="car_bg">
            <!--Begin 购物车未登录 Begin-->
            <div class="un_login">您还未登录，<a href="<?php echo U('Login/login');?>" style="color:#ff4e00;">马上登录</a> 查看购物车~</div>
            <!--End 购物车未登录 End-->
            <!--Begin 购物车已登录 Begin-->
            <div id="login" style="display: none;">
                <ul class="cars">

                </ul>
                <div class="price_sum">共计&nbsp; <font color="#ff4e00">￥</font><span id="total_price"></span></div>
                <div class="price_a"><a href="<?php echo U('pay/showPayCar');?>">查看我的购物车</a></div>
            </div>
            <!--End 购物车已登录 End-->
        </div>
    </div>
</div>

<script>


    /* 给搜索按钮绑定一个按“回车”事件*/
    $('body').keypress(function (e) {
        var key = e.which; //e.which是按键的值
        if (key == 13) {
            submit_search();
        }
    });


    /* 关闭关键词框 */
    function close_search(){
        $('#shelper').css('display','none');
    }

    /* 文本框输入内容，获取焦点事件 */
    $('#search').bind('input propertychange focus',function(){
        var val = $(this).val().trim();
        if(val == ""){
            $('#shelper').css('display','none');
            return false;
        }

        var type = $('.yes').html();    // 查询类别
        kw_search(val,type);
    });

    /* 点击搜索按钮，ajax查询，查询所有商品id，然后跳转到商品列表页面 */
    function submit_search(keyword,type){

        var content = $("input[name='search']").val().trim();
        var t    = $('.yes').html();
        if(keyword){
            $("input[name='search']").val(keyword);
            content = keyword;
            t = type;
        }
        var app = "/eater/index.php";
        if(t == '店铺'){
            location.href=app+"/Home/Index/store_list/content/"+encodeURI(content);
        }else{
            location.href=app+"/Home/Index/search/content/"+encodeURI(content);
        }

    }


    /* 关键词查询 val：内容，type：商品或店铺 */
    function kw_search(val,type){

        $.ajax({

            type : 'post',
            url  : "<?php echo U('Index/search_keywords');?>",
            data : {
                keyword : val,
                type    : type,
            },

            success : function(response){

                if(response.status){

                    var str = "";

                    $.each(response.result,function(k,v){
                        var keyword = v.keywords.replace(val,"<label>"+val+"</label>");
                        str += '<li class="she_li" onclick="submit_search(\''+v.keywords+'\',\''+type+'\');"><p>'+keyword+'</p></li>';

                    });
                    str += '<li class="she_li" onclick="close_search();" style="text-align: right"><p><i>x</i> 关闭</p></li>';

                    $('#shelper').html(str).css('display','block');

                }else{
                    $('#shelper').html('').css('display','none');
                }
            }

        });

    }

        // 获取购物车中的最新三条数据，并更改页面中购物车旁边的数字为总数，以及显示购物车中的总额
    function ajaxGetBuyCar(){


        $.ajax({
            type : 'post',
            url : "<?php echo U('Index/ajaxGetBuyCar');?>",
            dataType : 'json',
            success : function(response){

                if(response.status){

                    $('#car_goods_number').html(response.total_rows);

                    var str = '';

                    var i = 0;
                    $.each(response.cars,function(k,v){
                        if(i == 3){
                            return false;
                        }

                        var img_url = "<?php echo IMG_URL?>"+v.goods_logo_url;
                        var goods_url = "<?php echo U('Index/item')?>"+'/id/'+v.id;

                        str += "<li>";
                        str += "<div class='img'><a href="+goods_url+"><img src="+img_url+" width='58' height='58' /></a></div>";

                        str += "<div class='name'><a href="+goods_url+">"+v.goods_title+"</a></div>";
                        var click = 'onclick='+'ajaxDelBuyCar(this,"'+v.only+'")';
                        str += '<div class="price"><font color="#ff4e00">￥'+v.price+'</font> x'+v.number+'<a href="javascript:void(0);" '+click+' style="float:right">删除</a></div>';
                        str += "</li>";
                        i++;
                    });


                    $('.un_login').html("<b style='font-size:14px;'>购物车中共有 "+response.total_rows+" 件商品</b>");

                    $('.cars').html(str);
                    $('#total_price').html(response.total_price);
                    $('#login').css('display','block');

                }else{
                    $('.un_login').html("<b>"+response.result+"</b>");
                    $('#login').css('display','none');
                }

            }
        });
    }

        // ajax删除购物车中的信息
    function ajaxDelBuyCar(obj,only){

        $.ajax({
            type : 'post',
            url : "<?php echo U('Index/ajaxDelBuyCar');?>",
            data : {
                only : only
            },
            success : function(){

                var tr_num = $(obj).parents('table').find('tr').length;
                // 购物车中该店铺的商品，仅有一件的时候，将店铺信息也要删除掉
                if(tr_num == 2){
                    $(obj).parents('.store_list').first().hide(200,function(){$(this).remove();});
                }else{
                    $(obj).parent().parent().hide(300,function(){
                        $(this).remove();
                    });
                }
                ajaxGetBuyCar();


            },


        });

    }
</script>

<!--End Header End-->
<!--Begin Menu Begin-->

<div class="menu_bg">
    <div class="menu">
        <!--Begin 商品分类详情 Begin-->
        <div class="nav">
            <div class="nav_t">全部商品分类</div>
                <!-- =======  页面中不需要打开分类菜单的数组   ======== -->
            <?php $catArr = array('item','store','showPayCar','confirmOrder','pay','search','store_list','pay_success');?>
            <div class="leftNav <?php echo in_array(ACTION_NAME,$catArr) ? 'none' : ''; ?>">
                <ul>
                    <?php foreach($catData as $k => $v): ?>
                    <li>
                        <?php $url = U('Index/search',array('cat_id'=>$v['id']));?>
                        <div class="fj" onclick="submit_search('<?php echo str_replace('/',',',$v[cat_name]);?>','商品')">
                            <span class="n_img"><span></span><img src="/eater/Public/images/nav1.png" /></span>
                            <span class="fl"><?php echo $v['cat_name'];?></span>
                        </div>
                        <div class="zj" style="top:-<?php echo $k*40;?>px;">
                            <div class="zj_l">
                                <?php foreach($v['children'] as $k1 => $v1): ?>
                                <div class="zj_l_c">
                                    <h2 onclick="submit_search('<?php echo str_replace('/',',',$v1[cat_name]);?>','商品')"><?php echo $v1['cat_name'];?></h2>
                                    <?php foreach($v1['children'] as $k2 => $v2): ?>
                                    <a href="javascript:void(0);" onclick="submit_search('<?php echo str_replace('/',',',$v2[cat_name]);?>','商品')"><?php echo $v2['cat_name'];?></a>|
                                    <?php endforeach; ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="zj_r">
                                <?php foreach($v['recGoods'] as $k1 => $v1): ?>
                                <a href="/eater/index.php/Home/Index/item/id/<?php echo $v1['id'];?>" style="width:210px;height:210px;"><img src="<?php echo IMG_URL.$v1['goods_logo_url']?>" style="width:210px;height:210px;"/></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <!--End 商品分类详情 End-->
        <ul class="menu_r">
            <li><a href="Index.html">首页</a></li>
            <li><a href="Food.html">美食</a></li>
            <li><a href="Fresh.html">生鲜</a></li>
            <li><a href="HomeDecoration.html">家居</a></li>
            <li><a href="SuitDress.html">女装</a></li>
            <li><a href="MakeUp.html">美妆</a></li>
            <li><a href="Digital.html">数码</a></li>
            <li><a href="GroupBuying.html">团购</a></li>
        </ul>

    </div>
</div>


<!--[if IE 6]>
<script src="/eater/Public/js/iepng.js" type="text/javascript"></script>
<script type="text/javascript">
    EvPNG.fix('div, ul, img, li, input, a');
</script>
<![endif]-->
<script type="text/javascript" src="/eater/Public/js/n_nav.js"></script>
<script type="text/javascript" src="/eater/Public/js/milk_ban.js"></script>
<script type="text/javascript" src="/eater/Public/js/paper_ban.js"></script>
<script type="text/javascript" src="/eater/Public/js/baby_ban.js"></script>

<style>
    .span1{
        width:65px;
        height:20px;
        text-align:center;
        color:white;
        border-radius:5px;
        display:inline-block;
        line-height:20px;
        background:#FF9900;
    }



</style>
<!--End Menu End--> 
<div class="i_bg">

    <div class="content mar_20">

        <div class="l_list" style="width:100%;">
        	<table border="0" style="width:100%; margin-bottom:30px; border:1px solid #eaeaea;" cellspacing="0" cellpadding="0">
              <tr valign="top">
                <td width="248"><div class="brand_img" style="height:150px;"><img src="<?php echo IMG_URL1.$store['store_logo_url'];?>" width="225" height="150" /></div></td>

                  <td width="150" style="padding:15px 30px;">

                      <a style="cursor: default;font-size:20px;color:blue;"><?php echo $store['store_name'];?></a><br />
                      <p>

                          描述相符 &nbsp; <span style="color:Red;"><?php echo $store_score['desc'];?> ↑</span><br>
                          物流服务 &nbsp; <span style="color:Red;"><?php echo $store_score['logistics'];?> ↑</span><br>
                          服务态度 &nbsp; <span style="color:Red;"><?php echo $store_score['service'];?> ↑</span><br>
                            <a href="javascript:void(0);" style="width:140px;<?php echo $is_follow_store ?'background: #FF9900;': 'background: #ccc;';?>" class="span1" onclick="ajaxFollow(this,'<?php echo $_GET[store_id]?>','<?php echo $_SESSION[eater_uid];?>','店铺')">
                                <?php if($is_follow_store){ ?>
                                     已收藏
                                <?php }else{?>
                                     收藏店铺
                                <?php }?>

                            </a><br>
                      </p>
                  </td>
                  <td class="td_b" style="padding:15px 40px;">

                      <?php foreach($store_rec as $k => $v): ?>

                	<span class="span1"
                      <?php
 if($k == '店铺新品'){ echo "style='background:#2D93CA;'"; }else if($k == '打折特卖'){ echo "style='background:orangered'"; } ?>
                      ><?php echo $k;?></span><br />
                      <?php foreach($v as $k1 => $v1): ?>
                    <a href="/eater/index.php/Home/Index/item/id/<?php echo $v1['id'];?>"><?php echo $v1['goods_jl_title']; ?></a>
                      <?php endforeach; ?>
                      <br>
                    <?php endforeach; ?>


                </td>
              </tr>
            </table>
        	<div class="list_t">
            	<span class="fl list_or">
                    <a href="<?php echo U('Index/store',getParameter('order','',false));?>" <?php echo !$_GET['order'] ? 'class="now"' : '';?>>全部</a>
                    <a href="#" class="sales <?php echo in_array($_GET['order'],array('sales_low','sales_up')) ? 'now':'';?>" style="width:100px;">
                    	<span class="fl">
                            <?php
 if($_GET['order'] == 'sales_low'){ echo '销量从低到高'; }elseif($_GET['order'] == 'sales_up'){ echo '销量从高到低'; }else{ echo '销量'; } ?>

                        </span>
                        <ul style="display: none">
                            <?php $sales_low = U('Index/store',getParameter('order','sales_low'));?>
                            <?php $sales_up = U('Index/store',getParameter('order','sales_up'));?>
                            <li onclick="location.href='<?php echo $sales_low;?>'">销量从低到高</li>
                            <li onclick="location.href='<?php echo $sales_up;?>'">销量从高到低</li>
                        </ul>
                    </a>

                    <a href="#" class="price <?php echo in_array($_GET['order'],array('price_low','price_up')) ? 'now':'';?>" style="width:100px;">
                    	<span class="fl">
                            <?php
 if($_GET['order'] == 'price_low'){ echo '价格从低到高'; }elseif($_GET['order'] == 'price_up'){ echo '价格从高到低'; }else{ echo '价格'; } ?>
                        </span>
                        <ul style="display: none">
                            <?php $price_low = U('Index/store',getParameter('order','price_low'));?>
                            <?php $price_up = U('Index/store',getParameter('order','price_up'));?>
                            <li onclick="location.href='<?php echo $price_low;?>'">价格从低到高</li>
                            <li onclick="location.href='<?php echo $price_up;?>'">价格从高到低</li>
                        </ul>
                    </a>

                    <a href="<?php echo U('Index/store',getParameter('order','new'));?>" <?php echo $_GET['order']=='new' ? 'class="now"' : '';?>>新品</a>
                </span>
                <span class="fr">共发现<?php echo count($goods);?>件</span>
            </div>
            <div class="list_c" style="width:100%;">
            	
                <ul class="cate_list" style="width:100%;">
                    <?php foreach($goods as $k => $v): ?>
                	<li style="height:350px;">
                    	<div class="img"><a href="/eater/index.php/Home/Index/item/id/<?php echo $v['id'];?>"><img src="<?php echo IMG_URL . $v['goods_logo_url'];?>" width="210" height="185" /></a></div>
                        <div class="price">
                            <font>￥<span><?php echo $v['goods_shop_price'];?></span><label style="display: block;float: right;color:#888;cursor: text;font-size: 13px;"><?php echo $v['sales'].'人付款';?></label></font>
                        </div>
                        <div class="name" style="height:60px;font-size: 12px;line-height: 20px;"><a href="/eater/index.php/Home/Index/item/id/<?php echo $v['id'];?>"><?php echo $v['goods_title'];?></a></div>
                        <div class="carbg">
                        	<a href="#" <?php echo in_array($v['id'],$follow) ? "style='background-image:url(/eater/Public/images/heart_h.png);'":'';?> class="ss heart"  onclick="ajaxFollow(this,'<?php echo $v[id];?>','<?php echo $_SESSION[eater_uid];?>','商品')">
                                <?php if(in_array($v['id'],$follow)){ ?>
                                    取消
                                <?php }else{ ?>
                                    收藏
                                <?php }?>
                            </a>
                            <a href="/eater/index.php/Home/Index/item/id/<?php echo $v['id'];?>" class="j_car">加入购物车</a>
                        </div>
                    </li>
                    <?php endforeach; ?>

                </ul>
                <div class="pages">
                    <?php echo $page;?>
                	<!--<a href="#" class="p_pre">上一页</a><a href="#" class="cur">1</a><a href="#">2</a><a href="#">3</a>...<a href="#">20</a><a href="#" class="p_pre">下一页</a>-->
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript" src="/eater/Public/layer/layer.js"></script>

    <script>
        // ajax 关注该商品
        function ajaxFollow(obj,value_id,user_id,type){

            // 如果用户没有登录，跳转到登录页面
            if(user_id == "" || user_id != '<?php echo $_SESSION[eater_uid]?>'){
                window.location.href="<?php echo U('Login/login');?>";
                return false;
            }
            $.ajax({
                type : 'post',
                url  : '/eater/index.php/Home/Index/ajaxFollow',
                data : {
                    value_id : value_id,
                    user_id  : user_id,
                    type : type,
                },
                success : function(response){
                    if(response.status){

                        if(type == '商品'){
                            $(obj).css('background-image',"url(/eater/Public/images/heart_h.png)");
                            $(obj).html('取消');
                        }else{
                            $(obj).css('background','#FF9900');
                            $(obj).html("已收藏");
                        }


                    }else{
                        if(type == '商品'){
                            $(obj).css('background-image',"url(/eater/Public/images/heart.png)");
                            $(obj).html('收藏');
                        }else{
                            $(obj).css('background','#ccc');
                            $(obj).html("收藏店铺");
                        }

                    }

                }
            });
        }
        $('.sales,.price').mouseover(function(){
            $(this).find('ul').css('display','block');
        });
        $('.sales ul,.price ul').mouseleave(function(){
            $(this).css('display','none');
        });
    </script>
    <style>
        .pages .current {
            display: inline-block;
            height:36px;
            line-height: 36px;
            text-align: center;
            font-size: 16px;
            color:#FFF;
            background-color: #ff4e00;
            border: 1px solid #ff4e00;
            padding:0 12px;
            margin:0 4px;
            border-radius:2px;
            overflow: hidden;

        }
    </style>



<!--Begin Footer Begin -->
<div class="b_btm_bg b_btm_c">
    <div class="b_btm">
        <table border="0" style="width:210px; height:62px; float:left; margin-left:75px; margin-top:30px;" cellspacing="0" cellpadding="0">
            <tr>
                <td width="72"><img src="/eater/Public/images/b1.png" width="62" height="62" /></td>
                <td><h2>正品保障</h2>正品行货  放心购买</td>
            </tr>
        </table>
        <table border="0" style="width:210px; height:62px; float:left; margin-left:75px; margin-top:30px;" cellspacing="0" cellpadding="0">
            <tr>
                <td width="72"><img src="/eater/Public/images/b2.png" width="62" height="62" /></td>
                <td><h2>满38包邮</h2>满38包邮 免运费</td>
            </tr>
        </table>
        <table border="0" style="width:210px; height:62px; float:left; margin-left:75px; margin-top:30px;" cellspacing="0" cellpadding="0">
            <tr>
                <td width="72"><img src="/eater/Public/images/b3.png" width="62" height="62" /></td>
                <td><h2>天天低价</h2>天天低价 畅选无忧</td>
            </tr>
        </table>
        <table border="0" style="width:210px; height:62px; float:left; margin-left:75px; margin-top:30px;" cellspacing="0" cellpadding="0">
            <tr>
                <td width="72"><img src="/eater/Public/images/b4.png" width="62" height="62" /></td>
                <td><h2>准时送达</h2>收货时间由你做主</td>
            </tr>
        </table>
    </div>
</div>
<div class="b_nav">
    <?php foreach($articles as $k => $v): ?>
    <dl>
        <dt><?php echo $v[0]['ar_cat_name'];?></dt>
        <?php foreach($v as $k1 => $v1): ?>
            <dd><a href="#"><?php echo $v1['ar_title'];?></a></dd>
        <?php endforeach; ?>
    </dl>
    <?php endforeach; ?>

    <div class="b_tel_bg">

        <p>
            服务热线：<br />
            <span>400-123-4567</span>
        </p>
    </div>
    <div class="b_er">
        <div class="b_er_c"><img src="/eater/Public/images/er.gif" width="118" height="118" /></div>
        <img src="/eater/Public/images/ss.png" />
    </div>
</div>
<div class="btmbg">
    <div class="btm">
        备案/许可证编号：蜀ICP备12009302号-1-www.dingguagua.com   Copyright © 2015-2018 尤洪商城网 All Rights Reserved. 复制必究 , Technical Support: Dgg Group <br />
        <img src="/eater/Public/images/b_1.gif" width="98" height="33" /><img src="/eater/Public/images/b_2.gif" width="98" height="33" /><img src="/eater/Public/images/b_3.gif" width="98" height="33" /><img src="/eater/Public/images/b_4.gif" width="98" height="33" /><img src="/eater/Public/images/b_5.gif" width="98" height="33" /><img src="/eater/Public/images/b_6.gif" width="98" height="33" />
    </div>
</div>
<!--End Footer End -->


</body>


<!--[if IE 6]>
<script src="//letskillie6.googlecode.com/svn/trunk/2/zh_CN.js"></script>
<![endif]-->
</html>