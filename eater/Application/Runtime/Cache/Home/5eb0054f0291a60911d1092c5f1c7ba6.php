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

<link rel="stylesheet" type="text/css" href="/eater/Public/css/ShopShow.css" />
<link rel="stylesheet" type="text/css" href="/eater/Public/css/MagicZoom.css" />
<script type="text/javascript" src="/eater/Public/js/MagicZoom.js"></script>

<script type="text/javascript" src="/eater/Public/js/num.js">
    var jq = jQuery.noConflict();
</script>

<script type="text/javascript" src="/eater/Public/js/p_tab.js"></script>

<script type="text/javascript" src="/eater/Public/js/shade.js"></script>
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
<!--End Menu End-->
<div class="i_bg">
	<div class="postion">
    </div>
    <div class="content">

        <div id="tsShopContainer">
            <div id="tsImgS"><a href="<?php echo IMG_URL.$images[0]['goods_big_image_url'];?>" title="Images" class="MagicZoom" id="MagicZoom"><img src="<?php echo IMG_URL.$images[0]['goods_big_image_url'];?>" width="390" height="390" /></a></div>
            <div id="tsPicContainer">
                <div id="tsImgSArrL" onclick="tsScrollArrLeft()"></div>
                <div id="tsImgSCon">
                    <ul>
                        <?php foreach($images as $k => $v): ?>
                        <li onclick="showPic('<?php echo $k;?>')" rel="MagicZoom" <?php echo $k == 0? "class='tsSelectImg'":'';?>><img src="<?php echo IMG_URL.$v['goods_big_image_url'];?>" tsImgS="<?php echo IMG_URL.$v['goods_big_image_url'];?>" width="79" height="79" /></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div id="tsImgSArrR" onclick="tsScrollArrRight()"></div>
            </div>
            <img class="MagicZoomLoading" width="16" height="16" src="/eater/Public/images/loading.gif" alt="Loading..." />
        </div>
<!-- ======================  商品详情  =============================-->
        <div class="pro_des">
        	<div class="des_name">
            	<p><?php echo $data['goods_title'];?></p>
                <label style="font-size: 13px;color:#888888;"><?php echo $data['goods_jl_title'];?></label>
            </div>
            <div class="des_price" style="height:70px;margin-bottom: 10px;">
            	零售价：<span style="text-decoration: line-through">￥<?php echo $data['goods_retail_price'];?></span><br />
            	本店价：<b>￥<span id="price" style="font-size: 28px;"><?php echo $data['goods_shop_price'];?></span></b><br />
            </div>


            <!--  ==========================  输出 属性 ======================-->
            <?php if($data['is_sell'] == '是' && $data['store_status'] == '启用' && $data['business_status'] == '营业中'){ ?>
                <?php foreach($goods_attr_dx as $k => $v): ?>
                    <div class="des_choice">
                        <span class="fl"><?php echo $v[0]['attr_name']?>：</span>
                        <ul>
                            <?php foreach($v as $k1 => $v1): ?>
                            <li class="attr <?php echo $k1 == 0? 'checked' : '';?>" aid="<?php echo $v1['id'];?>"><?php echo $v1['attr_value'];?><div class="ch_img"></div></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>


                <div class="des_price" style="height:33px;margin-top:0;margin-bottom: 0;">
                    库存：&nbsp;<span style="font-size: 23px;color: red;" id="stock"></span> 件<br />
                </div>
            <?php } ?>
            <div class="des_share" style="height:23px;margin-top:0;">
                <div class="d_care" id="heart" style="margin-left: 20px;<?php if($is_follow){echo 'background-image: url(/eater/Public/images/heart_h.png)';}else{echo 'background-image: url(/eater/Public/images/heart.png)';}?>">
                    <a onclick="ajaxFollow('<?php echo $data[id];?>','<?php echo $_SESSION[eater_uid];?>')" id="is_follow"><?php echo $is_follow ? "已收藏":'收藏商品';?></a>
                </div>
                <div class="d_care" style="margin-left: 20px;"><a href="/eater/index.php/Home/Index/store/store_id/<?php echo $data['store_id'];?>" target="_blank">进入店铺（<b><?php echo $data['store_name'];?></b>）</a></div>
            </div>
            <div class="des_price" style="height:33px;margin-top:0;margin-bottom: 0;">
                <span style="display:block;font-size: 15px;font-weight: bold;color:gray;text-align: center;">
                    <?php if($data['is_sell'] == '否' || $data['store_status'] == '停用' || $data['business_status'] == '已打烊'){ ?>
                        商品下架啦~
                    <?php }?>
                </span>
                <center id="message" style="font-size: 15px;font-weight: bold;color:orange;"></center>
            </div>
            <?php if($data['is_sell'] == '是' && $data['store_status'] == '启用' && $data['business_status'] == '营业中'){ ?>
                <div class="des_join">
                    <div class="j_nums">
                        <input type="text" value="1" name="number" class="n_ipt" id="number" />
                        <input type="button" value=""  class="n_btn_1"/>
                        <input type="button" value="" class="n_btn_2" />
                    </div>
                    <span class="fl"><a href="javascript:void(0);" onclick="joinBuyCar()" style="height:43px;width:200px;font-size: 17px;border:1px solid gray;" id="car" class="b_sure"><!-- b_sure -->&nbsp;加入购物车&nbsp;</a></span>
                </div>
            <?php } ?>
        </div>

<!--==========================   同类推荐   ============================ -->
        <div class="l_history" style="float: right;">
            <div class="fav_t">同类推荐</div>
            <ul>

                <?php if(!$sameCatRec){ ?>

                <center>暂无</center>
                <?php }else{?>
                    <?php $i=0;foreach($sameCatRec as $k => $v): if($i == 2) break; ?>
                    <li>
                        <div class="img"><a href="/eater/index.php/Home/Index/item/id/<?php echo $v['id'];?>"><img src="<?php echo IMG_URL.$v['goods_logo_url']?>" width="185" height="162" /></a></div>
                        <div class="name"><a href="/eater/index.php/Home/Index/item/id/<?php echo $v['id'];?>"><?php echo $v['goods_title'];?></a></div>
                        <div class="price">
                            <font>￥<span><?php echo $v['goods_shop_price'];?></span></font>
                        </div>
                    </li>
                    <?php $i++;endforeach; ?>
                <?php } ?>

            </ul>
        </div>

    </div>
<!-- =================  用户还喜欢   ==========================-->
    <div class="content mar_20">
    	<div class="l_history">
        	<div class="fav_t">用户还喜欢</div>
        	<ul>
                <?php foreach($like as $k => $v): ?>
            	<li>
                    <div class="img"><a href="/eater/index.php/Home/Index/item/id/<?php echo $v['goods_id'];?>"><img src="<?php echo IMG_URL.$v['goods_logo_url'];?>" width="185" height="162" /></a></div>
                	<div class="name"><a href="/eater/index.php/Home/Index/item/id/<?php echo $v['goods_id'];?>"><?php echo $v['goods_title']; ?></a></div>
                    <div class="price">
                    	<font>￥<span><?php echo $v['goods_shop_price'];?></span></font>
                    </div>
                </li>
                <?php endforeach; ?>
        	</ul>
        </div>
        <div class="l_list">

            <div class="des_border">
                <div class="des_tit">
                	<ul>
                        <li class="current"><a href="javascript:void(0);" class="link">商品详情</a></li>
                    	<li><a href="javascript:void(0);" class="link">商品属性</a></li>
                        <li><a href="javascript:void(0);" class="link">商品评论</a></li>
                    </ul>
                </div>
                <div class="des_con" id="p_attribute" style="display: none;">
                	<ul>

                        <?php if($goods_attr_no_dx){?>

                        <?php foreach($goods_attr_no_dx as $k => $v): ?>
                        <li style="float:left;width:230px;"><?php echo $v['attr_name'];?>：<?php echo $v['attr_value'];?></li>
                        <?php endforeach; ?>
                        <?php }else{?>
                        <li style="float:left;width:230px;">该商品暂无属性介绍</li>
                        <?php }?>
                    </ul>
                </div>
          	</div>

            <div class="des_con" id="p_details">
                <div class="des_con">
                	<?php echo htmlspecialchars_decode($data['goods_infomation']);?>

                </div>
          	</div>

            <div class="des_con" id="p_comment" style="display: none">

                <table border="0" class="jud_tab" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="175" class="jud_per">
                    	<p id="hao2"></p>好评度
                    </td>
                    <td width="300" colspan="3">
                    	<table border="0" style="width:100%;" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="90">好评<font color="#999999" id="hao">（0%）</font></td>
                            <td><span style="display: block;background: #efefef;width:170px;;height:13px;"><div id="hao1" style="width:0px;height:13px;float:left;background: rgb(227,23,12)"></div></span></td>
                          </tr>
                          <tr>
                            <td>中评<font color="#999999" id="zhong">（0%）</font></td>
                              <td><span style="display: block;background: #efefef;width:170px;;height:13px;"><div id="zhong1" style="width:0px;height:13px;float:left;background: rgb(227,23,12)"></div></span></td>
                          </tr>
                          <tr>
                            <td>差评<font color="#999999" id="cha">（0%）</font></td>
                            <td><span style="display: block;background: #efefef;width:170px;;height:13px;"><div id="cha1" style="width:0px;height:13px;float:left;background: rgb(227,23,12)"></div></span></td>
                          </tr>
                        </table>
                    </td>
                    <td width="185" class="jud_bg">
                    	购买过此商品的用户，并且确认收货后，方可评论
                    </td>
                    <td class="jud_bg"><a href="<?php echo U('Personal/order',array('status'=>'待评价'));?>"><img src="/eater/Public/images/btn_jud.gif" /></a></td>
                  </tr>
                </table>

                <table border="0" class="jud_list" id="remark_content1" style="width:100%; margin-top:30px;" cellspacing="0" cellpadding="0">


                </table>

                <div class="pages">

                </div>

          	</div>


        </div>
    </div>

<?php if($data['is_sell'] == '是' && $data['store_status'] == '启用' && $data['business_status'] == '营业中'){ ?>

    <!--Begin 弹出层-加入购物车 Begin-->
    <div id="fade1" class="black_overlay"></div>
    <div id="MyDiv1" class="white_content">
        <div class="white_d">
            <div class="notice_t">
                <span class="fr" style="margin-top:10px; cursor:pointer;" onclick="CloseDiv_1('MyDiv1','fade1')"><img src="/eater/Public/images/close.gif" /></span>
            </div>
            <div class="notice_c">

                <table border="0" align="center" style="margin-top:;" cellspacing="0" cellpadding="0">
                    <tr valign="top">
                        <td width="40"><img src="/eater/Public/images/suc.png" /></td>
                        <td>
                            <span style="color:#3e3e3e; font-size:18px; font-weight:bold;">宝贝已成功添加到购物车</span><br />
                            购物车中共有 <span id="number111"></span> 件商品
                        </td>
                    </tr>
                    <tr height="50" valign="bottom">
                        <td>&nbsp;</td>
                        <td><a href="<?php echo U('Pay/showPayCar');?>" class="b_sure">查看我的购物车</a><a href="javascript:void(0);" onclick="CloseDiv_1('MyDiv1','fade1')" class="b_buy">继续购物</a></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
    <!--End 弹出层-加入购物车 End-->
<?php } ?>
    <div class="showImage" style="display:none;">
        <img src="" width="500px">
    </div>
    <script src="/eater/Public/js/ShopShow.js"></script>
    <script type="text/javascript" src="/eater/Public/layer/layer.js"></script>
    <?php if($data['is_sell'] == '是' && $data['store_status'] == '启用' && $data['business_status'] == '营业中'){ ?>
    <script>

            //  商品详情，属性，评论三个窗口切换
        var num = 0;    // 如果再次点击商品评论，则不运行获取评论的函数，因为已经获取过
        $('.link').click(function(){
            $(this).parent().addClass('current').siblings('li').removeClass('current');
            var text = $(this).text();
            if(text == '商品详情'){
                $('#p_attribute').hide();
                $('#p_comment').hide();
                $('#p_details').show();
            }else if(text == '商品属性'){
                $('#p_attribute').show();
                $('#p_comment').hide();
                $('#p_details').hide();
            }else if(text == '商品评论'){
                $('#p_attribute').hide();
                $('#p_comment').show();
                $('#p_details').hide();
                if(num == 0){
                    ajaxGetRemark();    // 当点击商品评论时，才获取评论内容
                }
                num++;
            }
        });


        var number = ajaxGetStock();    //   保存当前属性的库存数，用于比较

        $('.attr').click(function(){
            $(this).addClass("checked").siblings('li').removeClass('checked');
            number = ajaxGetStock();    // 更新当前页面中的number变量（库存）
        });

            // ajax 获取内存
        function ajaxGetStock(){
            var number = 0;
            var _goods_attr_id = [];

                // 获取所有被选中的属性id
            $('.checked').each(function(){
                _goods_attr_id.push($(this).attr('aid'));   // 将属性id值放到数组中
            });
            _goods_attr_id.sort();      //重新排序，为了和数据库中的形式保持统一，由小到大的顺序
            var goods_attr_id = _goods_attr_id.join('&');   // 组合成1&2 的形式，在数据库中查询出库存

            $.ajax({
                type : 'post',
                url : "/eater/index.php/Home/Index/ajaxGetStock",
                data : {
                    goods_attr_id : goods_attr_id,
                    goods_id : "<?php echo $data['id']?>",
                },
                dataType : 'json',
                async : false,
                success : function(response){
                    if(response.status){

                        number = response.number;
                        if(parseInt($('#number').val()) > parseInt(response.number)){
                            $('#message').html('您所填写的商品数量超过库存！');
                            $('#car').removeClass().addClass('b_buy').css('cursor','default').css('color','gray').removeAttr('onclick');
                        }else{
                            $('#message').html(' ');
                            $('#car').removeClass().addClass('b_sure').css('cursor','pointer').css('color','#fff').attr('onclick',"joinBuyCar()");
                        }

                        $('#price').html((parseFloat("<?php echo $data['goods_shop_price'];?>")+parseFloat(response.price)).toFixed(2));
                        $('#stock').html(response.number);
                    }
                }
            });
            return number;

        }
            // 加号 按钮
        $('.n_btn_1').click(function(){
            var input = $(this).parent().find('.n_ipt');
            var c = input.val();
            c=parseInt(c)+1;
            input.val(c);

            if(parseInt(c) > parseInt(number)){
                $('#message').html('您所填写的商品数量超过库存！');
                $('#car').removeClass().addClass('b_buy').css('cursor','default').css('color','gray').removeAttr('onclick');
            }else{
                $('#message').html(' ')
                $('#car').removeClass().addClass('b_sure').css('cursor','pointer').css('color','#fff').attr('onclick',"joinBuyCar()");
            }
        });
            // 减号 按钮
        $('.n_btn_2').click(function(){
            var input = $(this).parent().find('.n_ipt');

            var c = input.val();
            if(c==1){
                c=1;
            }else{
                c=parseInt(c)-1;
                input.val(c);
            }
            if(parseInt(c) <= parseInt(number)){
                $('#message').html(' ')
                $('#car').removeClass().addClass('b_sure').css('cursor','pointer').css('color','#fff').attr('onclick',"joinBuyCar()");
            }else{
                $('#message').html('您所填写的商品数量超过库存！');
                $('#car').removeClass().addClass('b_buy').css('cursor','default').css('color','gray').removeAttr('onclick');
            }
        });
            // 数量 输入监测
        $('#number').bind('input propertychange',function(){

            var reg = /^\+?[1-9][0-9]*$/;       // 验证非0正整数
            if(!reg.test($(this).val())){
                $('#number').val('1');
                return false;
            }
           if(parseInt($(this).val()) > parseInt(number)){
                $('#message').html('您所填写的商品数量超过库存！');
                $('#car').removeClass().addClass('b_buy').css('cursor','default').css('color','gray').removeAttr('onclick');
            }else{
                $('#message').html(' ')
                $('#car').removeClass().addClass('b_sure').css('cursor','pointer').css('color','#fff').attr('onclick',"joinBuyCar()");
            }
        });





            // 加入购物车
        function joinBuyCar(){

            // 如果用户没有登录，跳转到登录页面
            var user_id = "<?php echo $_SESSION[eater_uid]?>";
            if(user_id == "" || typeof(user_id) == "undefined" ){
                window.location.href="<?php echo U('Login/login');?>";
                return false;
            }

            var _goods_attr_id = [];
            $('.checked').each(function(){
                _goods_attr_id.push($(this).attr('aid'));   // 将属性id值放到数组中
            });
            _goods_attr_id.sort();      //重新排序，为了和数据库中的形式保持统一，由小到大的顺序
            var goods_attr_id = _goods_attr_id.join('&');   // 组合成1&2 的形式，在数据库中查询出库存

            var buy_number = $('#number').val(); // 购买数量

            $.ajax({
                type : 'post',
                url : '/eater/index.php/Home/Index/buyCar',
                data : {
                    goods_id : "<?php echo $data['id'];?>",
                    goods_attr_id : goods_attr_id,
                    buy_number : buy_number,
                },
                success : function(response){
                    if(response.status){
                        ajaxGetBuyCar();
                        $('#number111').html(response.number);
                        ShowDiv_1('MyDiv1','fade1');
                    }
                }

            });

        }
</script>
    <?php  }?>
    <script>
        $('.pages').on('click','a',function(){

            var now = $('.pages span').html();
            var p = $(this).html();

            if(!isNaN(parseInt(p))){
                ajaxGetRemark(p);
            }else{

                if(p == '下一页'){
                    ajaxGetRemark(parseInt(now)+1);
                }else if(p == '上一页'){
                    ajaxGetRemark(parseInt(now)-1);
                }


            }



        });
        // ajax获取商品评论
        function ajaxGetRemark(p){
            $('#remark_content1').html('加载中..');
            $.ajax({
                type : 'get',
                url  : '/eater/index.php/Home/Index/ajaxGetRemark',
                data : {
                    goods_id : "<?php echo $_GET['id'];?>",
                    p : p,
                },
                success : function(response){

                    if(response.status){

                        /* 好评 中评 差评 */
                        $('#hao').html("（"+response.remark_percent.hao+"）");
                        $('#hao1').css("width",response.remark_percent.hao);
                        $('#hao2').html(response.remark_percent.hao);
                        $('#zhong').html("（"+response.remark_percent.zhong+"）");
                        $('#zhong1').css("width",response.remark_percent.zhong);
                        $('#cha').html("（"+response.remark_percent.cha+"）");
                        $('#cha1').css("width",response.remark_percent.cha);

                        var str = "";
                        $.each(response.remark_data,function(k,v){

                            str += '<tr valign="top">';
                            str += '<td width="150"><img src="/eater/Public/images/touxiang.png" width="50" height="50" align="absmiddle" />&nbsp;'+v.nickname+'</td>';
                            str += '<td width="100">'+v.goods_attr+'</td>';
                            str += '<td width="300">'+v.remark_content+'<br /><font color="#999999">'+v.time+'</font></td>';
                            str += '<td>';
                            if(v.image != null){
                                var image = v.image.split(',');
                                $.each(image,function(k1,v1){
                                    str += '<a href="javascript:void(0);" onclick="showImage(this)"><img src=<?php echo IMG_URL1;?>'+v1+' width="80" height="80">';
                                });
                            }

                            str += '</td></tr>';
                        });

                        $('#remark_content1').html(str);
                        $('.pages').html(response.page);

                    }else{
                        $('#remark_content1').html('<center style="font-size: 18px;margin-top:20px;">暂无评论哦，赶快购买商品来抢占评论席吧~</center>');
                    }
                }
            });

        }

        // ajax 关注该商品
        function ajaxFollow(value_id,user_id){

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
                    type : '商品',
                },
                success : function(response){
                    if(response.status){
                        $('#heart').css('background-image',"url(/eater/Public/images/heart_h.png)");
                        $('#is_follow').html(response.result);
                    }else{
                        $('#heart').css('background-image',"url(/eater/Public/images/heart.png)");
                        $('#is_follow').html(response.result);
                    }

                }
            });
        }
            function showImage(obj){
                var img_url = $(obj).children('img').attr('src');
                $('.showImage').find('img').attr('src',img_url);

                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    area: '500px',
                    skin: 'layui-layer-nobg', //没有背景色
                    shadeClose: true,
                    content: $('.showImage')
                });


            }

    </script>


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