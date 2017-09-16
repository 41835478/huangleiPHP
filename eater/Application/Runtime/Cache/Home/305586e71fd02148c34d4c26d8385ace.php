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
                                <a href="/eater/index.php/Home/Pay/item/id/<?php echo $v1['id'];?>" style="width:210px;height:210px;"><img src="<?php echo IMG_URL.$v1['goods_logo_url']?>" style="width:210px;height:210px;"/></a>
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

    <script type="text/javascript" src="/eater/Public/layer/layer.js"></script>
    <script type="text/javascript" src="/eater/Public/js/n_nav.js"></script>
    
    <script type="text/javascript" src="/eater/Public/js/num.js">
    	var jq = jQuery.noConflict();
    </script>     
    
    <script type="text/javascript" src="/eater/Public/js/shade.js"></script>

<style>
    .a_btn{
        height: 30px;
        line-height: 30px;
        padding: 0 11px;
        background: #02bafa;
        border: 1px #26bbdb solid;
        border-radius: 3px;
        color:#fff;
        /*color: #fff;*/
        display: inline-block;
        text-decoration: none;
        font-size: 15px;
        outline: none;
    }
    .a_btn:hover{
        color:#ccc;
    }
</style>
<!--End Menu End--> 
<div class="i_bg">  
    <div class="content mar_20">
    	<img src="/eater/Public/images/img1.jpg" />        
    </div>

    <!--Begin 第一步：查看购物车 Begin -->
    <div class="content mar_20">
        <?php if(count($cars) > 0){?>

    <form action="/eater/index.php/Home/Pay/confirmOrder" method="post" id="form1">
        <input type="checkbox" id="chkbox"><span style="font-size: 18px;font-weight: bold">全选</span>

        <?php foreach($cars as $k1 => $v1): ?>

            <span class="store_list">
                <div class="two_t" style="width:100%;">
                    <input type="checkbox" class="chk_store">
                    <span style="font-size: 13px;color: black">店铺: <a href="<?php echo U('Index/store',array('store_id'=>$v1[0]['sid'])); ?>"><?php echo $v1[0]['store_name']?></a></span>&emsp;&emsp;&emsp;
                    <span style="font-size: 13px;color: black">卖家: <?php echo $v1[0]['store_owner_name'];?></span>
                </div>
                <table border="0" class="car_tab" style="width:1200px; margin-bottom:50px;" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="car_th" width="15" style="text-align: left;"><!--<input type="checkbox" id="chkbox">全选--></td>
                        <td class="car_th" width="490">商品名称</td>
                        <td class="car_th" width="140">属性</td>
                        <td class="car_th" width="140">单价</td>
                        <td class="car_th" width="150">购买数量</td>
                        <td class="car_th" width="130">小计</td>
                        <td class="car_th" width="100">赠送积分</td>
                        <td class="car_th" width="200">操作</td>
                    </tr>

                    <?php foreach($v1 as $k => $v): ?>

                        <tr class="car_list <?php echo $k%2 == 1 ? 'car_tr' : ''?>" >
                            <td align="left"><input type="checkbox" class="chk" name="order[]" value="<?php echo $v[only];?>" onclick="getTotalPrice()"></td>
                            <!-- 商品logo  标题-->
                            <td>
                                <div class="c_s_img"><img src="<?php echo IMG_URL.$v['goods_logo_url'];?>" width="73" height="73" /></div>
                                <a href="{:U('Index/item',array('id'=>$v['id']))}"><?php echo $v['goods_title'];?></a>
                            </td>
                            <!-- 商品属性 -->
                            <td align="center">
                                <?php if(count($v['goods_attr']) > 0){?>
                                    <?php foreach($v['goods_attr'] as $k1 => $v1): ?>
                                    <?php echo $v1['attr_name'];?>：<?php echo $v1['attr_value'];?><br>
                                    <?php endforeach; ?>
                                <?php }else{?>
                                    无
                                <?php }?>
                            </td>
                            <td align="center">￥<span class="one_price"><?php echo $v['price'];?></span></td>
                            <!--  修改数量 -->
                            <td align="center">
                                <span style="color:red;" class="stock_message"></span>
                                <div class="c_num">
                                        <?php $arr = array();$arr = explode('-',$v['only']);?>
                                    <input type="button" value="" class="car_btn_1" onclick="decNum(this,'<?php echo $v[id]?>','<?php echo $arr[1];?>')"/>
                                    <input type="text" value="<?php echo $v['number'];?>" name="number" class="car_ipt" onblur="chkStock(this,'<?php echo $v[id]?>','<?php echo $arr[1];?>');"/>
                                    <input type="button" value="" class="car_btn_2" onclick="addNum(this,'<?php echo $v[id]?>','<?php echo $arr[1];?>')"/>
                                </div>
                            </td>
                            <!--  小计 -->
                            <td align="center" style="color:#ff4e00;">￥<span class="subtotal"><?php echo $v['price']*$v['number'];?></span></td>
                            <!-- 赠送积分 -->
                            <td align="center"><span class="points"><?php echo round($v['price']*$v['number']/10);?></span>R</td>
                            <!-- 操作 -->
                            <td align="center">
                                <a onclick="delCar(this,'<?php echo $v[only];?>');">删除</a>&nbsp; &nbsp;
                                <a onclick="ajaxFollow(this,'<?php echo $v[id];?>','<?php echo $_SESSION[eater_uid];?>')" class="is_follow">
                                    <?php if($v['is_follow'] > 0){?>
                                        已收藏
                                    <?php }else{?>
                                        收藏商品
                                    <?php }?>
                                </a>
                            </td>
                        </tr>
                     <?php endforeach; ?>
                </table>
            </span>

        <?php endforeach; ?>
        <?php }else{?>
        <center><a href="/eater">购物车空空如也，快去填满它吧~</a></center>
        <?php }?>
            <!-- 结算 -->
            <table border="0" style="width:1200px; margin-top:20px;" cellspacing="0" cellpadding="0">
                <tr height="70">
                <td colspan="8" style="font-family:'Microsoft YaHei'; border-bottom:0;">
                <label class="r_rad"></label><label class="r_txt"><a href="javascript:void(0);" onclick="delAllCar()" class="a_btn">清空购物车</a></label>
                <span class="fr">合计（不含运费）：<b style="font-size:22px; color:#ff4e00;">￥<span id="total_price1">0.00</b></span>
                </td>
                </tr>
                <tr height="70">
                    <td colspan="8" align="right">
                    <a href="<?php echo U('Index/index');?>"><img src="/eater/Public/images/buy1.gif" /></a>&nbsp; &nbsp; <a href="javascript:void(0);" id="submit2"><img src="/eater/Public/images/buy2.gif" /></a>
                    </td>
                </tr>
            </table>
    </form>

    </div>
	<!--End 第一步：查看购物车 End-->
    <script>
            // 提交表单
        $('#submit2').click(function(){
            var num = 0;
            $('.chk').each(function(){
                    // 判断是否有商品被选中
                if($(this).prop('checked')){
                    num++;
                    return false;
                }
            });

            if(num == 0){
                layer.alert('请先选择您想要购买的商品', {icon: 6,title : '温馨提示'});
                return false;
            }
            $('#form1').submit();

        });


        /***** ajax 关注该商品  ***********/
        function ajaxFollow(obj,value_id,user_id){

            // 如果用户没有登录，跳转到登录页面
            if(user_id == "" || user_id != '<?php echo $_SESSION[eater_uid]?>'){
                window.location.href="<?php echo U('Login/login');?>";
                return false;
            }
            $.ajax({
                type : 'post',
                url  : "<?php echo U('Index/ajaxFollow');?>",
                data : {
                    value_id : value_id,
                    user_id  : user_id,
                    type : '商品',
                },
                success : function(response){
                    if(response.status){
                        layer.msg('收藏成功~', {icon: 6,time : 1000});
                        $(obj).html(response.result);
                    }else{
                        layer.msg('已取消~', {icon: 5,time : 1000});
                        $(obj).html(response.result);
                    }

                }
            });
        }

         /*********** 复选框 全选 *********/
        $('#chkbox').click(function(){
            if($(this).prop('checked')){
                $('.chk,.chk_store').each(function(){
                    $(this).prop('checked',true);
                });
            }else{
                $('.chk,.chk_store').each(function(){
                    $(this).prop('checked',false);
                });
            }
                // 计算 合计
            getTotalPrice();
            chk_is_all_checked();
        });

        /* 点击选中商品时 */
        $('.chk').click(function(){
            var now_chked_num = $(this).parents('table').find('.chk:checked').length;
            var total_chk_num = $(this).parents('table').find('.chk').length;
            if(now_chked_num >= total_chk_num){
                $(this).parents('table').prev().find("input[type='checkbox']").prop("checked",true);
            }else{
                $(this).parents('table').prev().find("input[type='checkbox']").prop("checked",false);
            }
            chk_is_all_checked();
        });

        /* 判断所有商品是否都被选中 */
        function chk_is_all_checked(){
            var total = $('.chk').length;
            var chked_total = $('.chk:checked').length;
            if(total == chked_total){
                $('#chkbox').prop("checked",true);
            }else{
                $('#chkbox').prop("checked",false);
            }
        }

        /* 点击店铺全选的时候 */
        $('.chk_store').click(function(){
            if($(this).prop('checked')){
                $(this).parent().next().find('.chk').each(function(){
                    $(this).prop('checked',true);
                });
            }else{
                $(this).parent().next().find('.chk').each(function(){
                    $(this).prop('checked',false);
                });
            }
            chk_is_all_checked();
            getTotalPrice();
        });


            /******** 计算 合计 **********/
        function getTotalPrice(){
            var total = 0;
            $('.chk').each(function(){
                if($(this).prop('checked')){
                    var subtotal = $(this).parents('tr').find('.subtotal').text();
                    total += parseFloat(subtotal);
                }
            });
            $('#total_price1').html(total.toFixed(2));
        }


            /********** 减少 数量 ***************/
        function decNum(obj,goods_id,goods_attr_id){

            $(obj).parents('tr').find('.stock_message').html('');

            var input = $(obj).parent().find('.car_ipt');
            var c = input.val();
            if(c==1){
                c=1;
            }else{
                c=parseInt(c)-1;
                input.val(c);

                // 获取库存
                var stock = ajaxGetStock(goods_id,goods_attr_id);
                // 如果数量大于库存
                if(c > parseInt(stock)){
                    input.val(stock);
                    $(obj).parents('tr').find('.stock_message').html('最多只能购买'+stock+'件！');
                }
                    // 更改页面信息， 价格，积分等
                updatePrice(obj,goods_id,goods_attr_id);
                    // 计算 总价格
                getTotalPrice();
            }
        }

            /***** 增加 数量  **************/
        function addNum(obj,goods_id,goods_attr_id){

            $(obj).parents('tr').find('.stock_message').html('');
            var input = $(obj).parent().find('.car_ipt');
            var c = input.val();
            c=parseInt(c)+1;
            input.val(c);

                // 获取库存
            var stock = ajaxGetStock(goods_id,goods_attr_id);

                // 如果数量大于库存
            if(c > parseInt(stock)){
                input.val(stock);
                $(obj).parents('tr').find('.stock_message').html('最多只能购买'+stock+'件！');
            }

                // 更改页面信息，价格，积分等
            updatePrice(obj,goods_id,goods_attr_id);
                // 计算 总价格
            getTotalPrice();

        }

            /** 判断输入的 购买数量 是否大于库存  ****/
        function chkStock(obj,goods_id,goods_attr_id){

            var number = $(obj).parents('tr').find("input[name='number']");
            $(obj).parents('tr').find('.stock_message').html('');

            var reg = /^\+?[1-9][0-9]*$/;       // 验证非0正整数
            if(!reg.test($(obj).val())){
                number.val('1');
                return false;
            }

            // 获取库存
            var stock = ajaxGetStock(goods_id,goods_attr_id);

            if(number.val() > parseInt(stock)){
                number.val(stock);
                $(obj).parents('tr').find('.stock_message').html('最多只能购买'+stock+'件！');
            }
                //  更改页面信息，价格，积分等
            updatePrice(obj,goods_id,goods_attr_id);
                // 计算 总价格
            getTotalPrice();

        }

            /********** 修改价格  ***************/
        function updatePrice(obj,goods_id,goods_attr_id){
            var tr = $(obj).parents('tr').first();
            var one_price = tr.find('.one_price').text(); //  单价
            var number = tr.find("input[name='number']").val();  // 数量
            var subtotal = (parseFloat(one_price) * number).toFixed(2); // 小计
            var points = parseInt(subtotal/10);     // 赠送积分
            tr.find('.subtotal').html(subtotal);    // 更改小计
            tr.find('.points').html(points);        // 更改赠送积分

            $.post("<?php echo U('Index/buyCar');?>",{goods_id:goods_id, goods_attr_id:goods_attr_id, buy_number:number,type:'update'});
        }

            /********** ajax 获取库存  *************/
        function ajaxGetStock(goods_id,goods_attr_id){
            var stock = 0;
            $.ajax({
                type : 'post',
                url : '/eater/index.php/Home/Pay/ajaxGetStock',
                async : false,
                data : {
                    goods_id : goods_id,
                    goods_attr_id : goods_attr_id
                },
                success : function(number){
                    stock = number;
                }
            });
            return stock;
        }


            /****** 从购物车删除单间商品 **********/
        function delCar(obj,only,choose){
            layer.confirm('确定从购物车中删除吗？',function(){

                    //  从cookie中删除
                ajaxDelBuyCar(obj,only,choose);

                    // 如果当前商品被选中的话，就减掉价格
                if($(obj).parents('tr').find('.chk').prop('checked')){

                    var price = $(obj).parents('tr').find('.subtotal').text(); // 当前这件商品的价格
                    var _total_price1 = $('#total_price1').text();    // 总价
                    var total_price1 = _total_price1 - price;     // 删除掉商品 剩余的总价
                    $('#total_price1').html(total_price1.toFixed(2));
                }

                layer.msg('删除成功~', {icon: 6,time : 1000});
            });
        }

            /******* 清空购物车 **********/
        function delAllCar(){

            layer.confirm('确定清空购物车吗？',function(){
                $.ajax({
                    type : 'post',
                    url : '/eater/index.php/Home/Pay/delAllCar',
                    success : function(response){

                        if(response.status){

                            $('.car_list').hide(300,function(){$(this).remove();});
                            $('#total_price1').html(0);
                            layer.msg('已清空购物车，快去购物吧~', {icon: 6,time : 2000},function(){
                                location.href="<?php echo U('Index/index');?>";
                            });
                        }else{
                            layer.msg('清空失败', {icon: 5,time : 1000});
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