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


<div class="i_bg bg_color">
    <!--Begin 用户中心 Begin -->
    <div class="m_content">
        <div class="m_left">
            <div class="left_n">管理中心</div>

            <div class="left_m">
                <div class="left_m_t t_bg2">个人中心</div>
                <ul>
                    <li><a href="<?php echo U('Personal/user');?>" <?php echo ACTION_NAME == 'user' ? "class = 'now'" : '';?>>用户信息</a></li>
                    <li><a href="<?php echo U('Personal/follow',array('type'=>'商品'));?>" <?php echo $_GET['type'] == "商品" && ACTION_NAME == 'follow' ? "class='now'" : '';?>>收藏商品</a></li>
                    <li><a href="<?php echo U('Personal/follow',array('type'=>'店铺'));?>" <?php echo $_GET['type'] == "店铺" && ACTION_NAME == 'follow' ? "class='now'" : '';?>>收藏店铺</a></li>
                    <li><a href="<?php echo U('Personal/record');?>" <?php echo ACTION_NAME == 'record' ? "class = 'now'" : '';?>>浏览记录</a></li>
                </ul>
            </div>
            <div class="left_m">
                <div class="left_m_t t_bg1">订单中心</div>
                <ul>
                    <li><a href="<?php echo U('Personal/order');?>" <?php echo ACTION_NAME == 'order' ? "class = 'now'" : '';?>>我的订单</a></li>
                    <li><a href="<?php echo U('Personal/address');?>" <?php echo ACTION_NAME == 'address' ? "class = 'now'" : '';?>">收货地址</a></li>

                </ul>
            </div>
            <div class="left_m">
                <div class="left_m_t t_bg3">账户中心</div>
                <ul>
                    <li><a href="Member_Safe.html">账户安全</a></li>

                    <li><a href="Member_Money.html">资金明细</a></li>
                </ul>
            </div>
            <div class="left_m">
                <div class="left_m_t t_bg4">成为商家</div>
                <ul>
                    <li><a href="<?php echo U('Personal/apply_list');?>" <?php echo ACTION_NAME == 'apply_list' ? "class='now'" : '';?>>我的申请</a></li>
                    <li><a href="<?php echo U('Personal/apply_store');?>" <?php echo ACTION_NAME == 'apply_store' ? "class='now'" : '';?>>申请店铺</a></li>
                </ul>
            </div>
        </div>



<script type="text/javascript" src="/eater/Public/js/star-rating.js"></script>
<link rel="stylesheet" type="text/css" href="/eater/Public/css/star-rating.css" media="all"/>
<link rel="stylesheet" type="text/css" href="/eater/Public/css/myOrder.css" media="all"/>
<script type="text/javascript" src="/eater/Public/layer/layer.js"></script>

    <div class="m_right">
        <div class="mem_tit">
            我的订单
        </div>
        <div class="mem_tit" style="height:80px;">
            <div class="itemlist <?php echo !in_array($_GET['status'],array('待付款','待发货','待收货','待评价'))?'item_active':'';?>" onclick="location.href='/eater/index.php/Home/Personal/order';">
                <span>所有订单</span>
                <label>|</label>
            </div>
            <div class="itemlist <?php echo $_GET['status']=='待付款'?'item_active':'';?>" onclick="location.href='/eater/index.php/Home/Personal/order/status/待付款';">
                <span>待付款 <span style="color:#ff6000;font-weight: 400;"><?php echo $orders_count['待付款'];?></span></span>
                <label>|</label>
            </div>

            <div class="itemlist <?php echo $_GET['status']=='待发货'?'item_active':'';?>" onclick="location.href='/eater/index.php/Home/Personal/order/status/待发货';">
                <span>待发货 <span style="color:#ff6000;font-weight: 400;"><?php echo $orders_count['待发货'];?></span></span>
                <label>|</label>
            </div>
            <div class="itemlist <?php echo $_GET['status']=='待收货'?'item_active':'';?>" onclick="location.href='/eater/index.php/Home/Personal/order/status/待收货';">
                <span>待收货 <span style="color:#ff6000;font-weight: 400;"><?php echo $orders_count['待收货'];?></span></span>
                <label>|</label>
            </div>
            <div class="itemlist <?php echo $_GET['status']=='待评价'?'item_active':'';?>" onclick="location.href='/eater/index.php/Home/Personal/order/status/待评价';">
                <span>待评价 <span style="color:#ff6000;font-weight: 400;"><?php echo $orders_count['待评价'];?></span></span>
            </div>
        </div>

        <?php if(count($orders) > 0){ ?>

        <?php
 foreach($orders as $k => $v): ?>
            <span class="goods_list">
           	<table border="0" class="order_tab" style="width:930px;" cellspacing="0" cellpadding="0">
                <tr style="background: #eeeeee;">
                    <td colspan="5">
                        订单号：<span style="color:#ff4e00"><?php echo $k;?></span>&emsp;
                        下单时间：<span><?php echo $v[0]['time'];?></span>&emsp;
                        店铺：<span><a href="<?php echo U('Index/store',array('store_id'=>$v[0]['store_id']));?>"><?php echo $v[0]['store_name'];?></a></span>
                    </td>
                </tr>

                <tr>
                    <td align="center" width="500">商品名称</td>
                    <td align="center" width="30">数量</td>
                    <td align="center" width="100">小计</td>
                    <td align="center" width="100">支付方式</td>
                    <td align="center" width="100">订单状态</td>
                </tr>
                <?php
 $total_price = 0; $again_buy_order = array(); foreach($v as $k1 => $v1): $again_buy_order[] = $v1['goods_id'].'-'.$v1['goods_attr']; $total_price += $v1['price']; ?>
                      <tr>

                        <td style="font-family:'宋体';">
                            <div class="sm_img"><img src="<?php echo IMG_URL.$v1['goods_logo_url'];?>" width="48" height="48" /></div>
                            <div style="float: right;width:430px;">
                                <a href="<?php echo U('Index/item',array('id'=>$v1['goods_id']));?>"><?php echo $v1['goods_title'];?></a>
                                <span style="display:block;font-size: 10px;color:#888888">
                                    <?php foreach($v1['ga'] as $k2 => $v2): ?>
                                    <?php echo $v2['attr_name'];?>：<?php echo $v2['attr_value'];?>&nbsp;
                                    <?php endforeach; ?>
                                </span>
                            </div>
                        </td>
                        <td align="center"><?php echo $v1['number'];?></td>
                        <td align="center">￥ <?php echo $v1['price'];?></td>
                        <td align="center"><?php echo $v1['pay_type'];?></td>
                        <td align="center"><?php echo $v1['status'];?></td>

                      </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="5" style="text-align: right;">
                        <span>共3件商品&nbsp;&nbsp;合计：￥ <span style="color:#ff4e00;font-size: 16px;"><?php echo $total_price+C('EXPRESS_PRICE');?></span>&nbsp;（含运费￥<?php echo C('EXPRESS_PRICE');?>）</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: right;">
                        <form action="<?php echo U('pay/confirmOrder');?>" method="post">
                            <input type="hidden" name="ordersn" value="<?php echo $k?>">
                        </form>
                        <?php if($v[0]['status'] == '待付款'){?>
                            <a href="javascript:void(0);" onclick="cancel_order(this,'<?php echo $v[0][ordersn];?>');" class="order_btn">取消订单</a>
                            <a href="<?php echo U('Pay/pay',array('orderSn' => $v[0]['ordersn']));?>" class="order_btn order_btn_active">付款</a>
                        <?php }else if($v[0]['status'] == '待发货'){ ?>
                            <a href="javascript:void(0);" onclick="warn_send('<?php echo $v[0][ordersn]?>')" class="order_btn">提醒发货</a>
                        <?php }else if($v[0]['status'] == '待收货'){ ?>
                            <a href="javascript:void(0);" onclick="see_logistics('<?php echo $v[0][ordersn];?>');" class="order_btn logistics">查看物流</a>
                            <a href="javascript:void(0);" onclick="take_delivery(this,'<?php echo $v[0][ordersn];?>')" class="order_btn order_btn_active">确认收货</a>
                        <?php }else if($v[0]['status'] == '待评价'){ ?>
                            <a href="javascript:void(0);" onclick="delete_order(this,'<?php echo $v[0][ordersn];?>');" class="order_btn">删除订单</a>
                            <a href="javascript:void(0);" onclick="again_buy(this,'<?php echo $v[0][ordersn];?>')" class="order_btn">再次购买</a>
                            <a href="javascript:void(0);" onclick="remark(this,'<?php echo $v[0][ordersn];?>');" class="order_btn order_btn_active">评价</a>
                        <?php }else if($v[0]['status'] == '完成订单'){?>
                        <a href="javascript:void(0);" onclick="delete_order(this,'<?php echo $v[0][ordersn];?>');" class="order_btn">删除订单</a>
                        <?php }?>
                    </td>
                </tr>
            </table>
        <br />
        <br />
        </span>
        <?php endforeach; ?>
        <?php }else{?>
            <center style="font-size: 20px;font-weight: 700;">您还没有相关的订单^_^</center>
        <?php }?>
        <div class='pages1'>
            <?php echo $show;?>
        </div>
        </div>

    </div>

<!-- 评论-->
<form id="remark_form" enctype="multipart/form-data">
<div class="remark-goods-store" style="display: none">
    <div class="remark_all">
        <div class="remark">

            <div class="remark_top">
                <div class="remark_top_l">
                    <img src="" width="100%" height="100%">
                </div>
                <div class="remark_top_r">
                    <span>NIKE官方旗舰店 最新款男士价格4556798798</span>
                </div>

            </div>
            <!--<form id="remark_form">-->
            <div class="remark_left">
                <dl>
                    <dt>评论内容</dt>
                    <dd>
                        <textarea name="remark_content[]"></textarea>
                    </dd>
                </dl>
                <dl>
                    <dt>晒图</dt>
                    <dd style="height:85px;">
                        <span>
                            <div class="share_img"><img src="/eater/Public/images/dl3-tu2.gif" width="100%" height="100%"></div>
                            <input type="file" name="share_img[]"  class="pic">
                        </span>
                        <span>
                            <div class="share_img"><img src="/eater/Public/images/dl3-tu2.gif" width="100%" height="100%"></div>
                            <input type="file" name="share_img[]"  class="pic">
                        </span>
                        <span>
                            <div class="share_img"><img src="/eater/Public/images/dl3-tu2.gif" width="100%" height="100%"></div>
                            <input type="file" name="share_img[]"  class="pic">
                        </span>
                        <span>
                            <div class="share_img"><img src="/eater/Public/images/dl3-tu2.gif" width="100%" height="100%"></div>
                            <input type="file" name="share_img[]" class="pic">
                        </span>
                    </dd>
                </dl>

            </div>
        </div>
    </div>
    <div class="store_remark">
        <span style="display: block;font-size: 18px;font-weight:700;margin-left:50px;">店铺评分</span>
        <ul style="margin-left:100px;">
            <li>
                <p class="p1" style="display:inline-block;width:60px;"> 描述相符</p>&emsp;
                <span style="display: inline-block;width:300px;">
                    <input value="0" type="number" class="rating desc" min=0 max=5 step=0.5 data-size="xs" >
                </span>
            </li>
            <li>
                <p class="p1" style="display:inline-block">物流服务</p>&emsp;
                <span style="display: inline-block;width:300px;">
                    <input value="0" type="number" class="rating logistics" min=0 max=5 step=0.5 data-size="xs" >
                </span>
            </li>
            <li>
                <p class="p1" style="display:inline-block">服务态度</p>&emsp;
                <span style="display: inline-block;width:300px;">
                    <input value="0" type="number" class="rating service" min=0 max=5 step=0.5 data-size="xs" >
                </span>
            </li>
        </ul>
    </div>
</div>
</form>

	<!--End 用户中心 End-->
<script>

    /****当选择图片时，会立刻显示图片在span中*****/
    $(".remark-goods-store").on('change','.pic',function(){
        var pic = this.files[0];
        var picUrl = window.URL.createObjectURL(pic);
        $(this).prev('.share_img').html('<img src="'+picUrl+'" width="100%" height="100%" />');
    });


    // 评论
    function remark(obj,ordersn){

        $.ajax({
            type : 'post',
            url : '/eater/index.php/Home/Personal/get_remark_goods_info',
            data : {
                ordersn : ordersn,
            },
            dataType : 'json',
            async : false,
            success : function (response){
                if(response.status){
                    //清空textarea中的值
                    $('#remark_form').find('textarea').val('');
                    // 设置选择文件为默认图片
                    $('.share_img').html("<img src='/eater/Public/images/dl3-tu2.gif' width='100%' height='100%'>");
                    // 清空选择文件的值
                    $("input[type='file']").val('');
                    /* 店铺评分初始化 */
                    $("input[type='number']").val('0');
                    $(".rating-stars").css('width','0');
                    $('.caption').html('');
                   $.each(response.result,function(k,v){

                        /**  定义form表单中的name属性  ***/
                        var remark_div = $('.remark_all').find('.remark').first().clone();
                        remark_div.find('.remark_top_r').html("<span>"+v.goods_title+"</span>");
                        remark_div.find('.remark_top_r').append("<input type='hidden' name='goods_attr["+v.goods_id+"]' value='"+v.goods_attr+"'>");
                        remark_div.find('.remark_top_l').html("<img src='<?php echo IMG_URL?>"+v.goods_logo_url+"' width='100%' height='100%'>");
                        remark_div.find('.remark_left').find('textarea').attr("name","remark_content["+v.goods_id+"]");
                        remark_div.find('.remark_left').find("input[type='file']").attr("name","share_img&"+v.goods_id+"[]");
                        $('.remark-goods-store').find('.desc').attr("name","desc["+v.store_id+"]");
                        $('.remark-goods-store').find('.logistics').attr("name","logistics["+v.store_id+"]");
                        $('.remark-goods-store').find('.service').attr("name","service["+v.store_id+"]");
                       if(k == 0){
                            $('.remark_all').empty();
                       }
                       $('.remark_all').append(remark_div);
                   });

                }else{
                    layer.alert(response.result,{title:'提示'});
                }
            }
        });

        layer.open({
            type: 1,
            title: '评论',
            maxmin: true,
            skin: 'layui-layer-demo', //样式类名
            shadeClose: false, //点击遮罩关闭层
            area : ['1030px' , '600px'],
            content:$('.remark-goods-store'),
            btn:['提交','取消'],
            yes : function(){

                // loading加载
                var loading = layer.load(1, {
                    shade: [0.1,'#fff']
                });

                /* 获取表单数据 */
                var data = new FormData($('#remark_form')[0]);
                data.append('ordersn',ordersn);
                $.ajax({
                    type : 'post',
                    url : '/eater/index.php/Home/Personal/remark',
                    data : data,
                    processData: false,  // 告诉jQuery不要去处理发送的数据
                    contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
                    success : function(response){
                        if(response.status){
                            layer.closeAll();
                            $(obj).parents('.goods_list').animate({width:'500px',opacity: 'hide'}, 'normal',function(){ $(this).remove();});
                            layer.msg(response.result,{time:2000});
                        }else{
                            layer.close(loading);
                            layer.alert(response.result,{icon:6,title:'提示'});
                        }
                    }
                });

            },
            cancel: function(){
                return confirm("确定取消评价吗？");
            }
        });

    }


    // 查看物流，获取快递单号
    function see_logistics(ordersn){
        $.ajax({
            type : 'post',
            url : '/eater/index.php/Home/Personal/get_express_number/ordersn/'+ordersn,
            success : function(response){
                if(response.status){
                    layer.alert(response.result, {skin: 'layui-layer-lan',closeBtn: 0,title : '物流信息'});
                }else{
                    layer.alert(response.result, {skin: 'layui-layer-lan',closeBtn: 0,title : '提示'});
                }
            }
        });
    }
    // 再次购买
    function again_buy(obj,ordersn){
        $(obj).prevAll('form').submit();
    }
    // 删除订单
    function delete_order(obj,ordersn){

        layer.confirm('确定删除订单吗？',{icon:5,title:'提示'},function(){

            $.ajax({
                type : 'post',
                url : '/eater/index.php/Home/Personal/delete_order',
                data : {
                    ordersn : ordersn
                },
                success : function(response){
                    if(response.status){
                        layer.msg(response.result,{time:1500});
                        $(obj).parents('.goods_list').animate({width:'500px',opacity: 'hide'}, 'normal',function(){ $(this).remove();});
                    }else{
                        layer.alert(response.result,{title:'提示'});
                    }
                }
            });
        });
    }
    // 取消订单
    function cancel_order(obj,ordersn){

        layer.confirm('确定取消订单吗？',{icon:5,title:'提示'},function(){

            $.ajax({
                type : 'post',
                url : '/eater/index.php/Home/Personal/cancel_order',
                data : {
                    ordersn : ordersn
                },
                success : function(response){
                    if(response.status){
                        layer.msg(response.result,{icon:6,time:1500});
                        $(obj).parents('.goods_list').animate({width:'500px',opacity: 'hide'}, 'normal',function(){ $(this).remove();});
                    }else{
                        layer.alert(response.result,{icon : 5,title:'提示'});
                    }
                }
            });
        });
    }

    // 提醒发货
    function warn_send(ordersn){

        $.ajax({
            type : 'post',
            url : '/eater/index.php/Home/Personal/warn_send/ordersn/'+ordersn,
            success : function(){
                layer.msg('提醒发货成功',{time:3000});
            }
        });
    }
    // 确认收货
    function take_delivery(obj,ordersn){
        layer.alert("<input type='password' name='password' style='border: 1px solid gray;height:20px;margin-left:10px;background:#eeeeee;' placeholder='输入密码'>", {
            icon:4
            ,skin: 'layui-layer-lan'
            ,title : '输入密码，完成收货'
        },function(index){


            var password = $("input[name='password']").val().trim();
            if(password == ""){
                layer.msg('请输入您的登录密码');
                return false;
            }
            layer.close(index);
            $.ajax({
                type : 'post',
                url : '/eater/index.php/Home/Personal/take_delivery',
                data : {
                    ordersn : ordersn,
                    password : password
                },
                success : function(response){

                    if(response.status){
                        layer.msg(response.result,{time:2000});
                        $(obj).parents('.goods_list').animate({width:'500px',opacity: 'hide'}, 'normal',function(){ $(this).remove();});
                    }else{
                        layer.alert(response.result,{icon:5,title:'提示'});
                    }
                }
            });

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