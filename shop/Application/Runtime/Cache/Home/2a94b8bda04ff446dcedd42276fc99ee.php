<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>网站后台管理系统  </title>
		<!--<<meta name="viewport" content="width=device-width, initial-scale=1.0" />-->

		<link href="/shop/Public/assets/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/shop/Public/assets/css/font-awesome.min.css" />
		<!--[if IE 7]>
		  <link rel="stylesheet" href="/shop/Public/assets/css/font-awesome-ie7.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="/shop/Public/assets/css/ace.min.css" />
		<link rel="stylesheet" href="/shop/Public/assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="/shop/Public/assets/css/ace-skins.min.css" />
        <link rel="stylesheet" href="/shop/Public/css/style.css"/>
		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="/shop/Public/assets/css/ace-ie.min.css" />
		<![endif]-->
		<script src="/shop/Public/assets/js/ace-extra.min.js"></script>
		<!--[if lt IE 9]>
		<script src="/shop/Public/assets/js/html5shiv.js"></script>
		<script src="/shop/Public/assets/js/respond.min.js"></script>
		<![endif]-->
        <!--[if !IE]> -->
		<script src="/shop/Public/js/jquery-1.9.1.min.js"></script>        
		<!-- <![endif]-->
		<!--[if IE]>
         <script type="text/javascript">window.jQuery || document.write("<script src='/shop/Public/assets/js/jquery-1.10.2.min.js'>"+"<"+"script>");</script>
        <![endif]-->
		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='/shop/Public/assets/js/jquery.mobile.custom.min.js'>"+"<"+"script>");
		</script>
		<script src="/shop/Public/assets/js/bootstrap.min.js"></script>
		<script src="/shop/Public/assets/js/typeahead-bs2.min.js"></script>
		<!--[if lte IE 8]>
		  <script src="/shop/Public/assets/js/excanvas.min.js"></script>
		<![endif]-->
		<script src="/shop/Public/assets/js/ace-elements.min.js"></script>
		<script src="/shop/Public/assets/js/ace.min.js"></script>
        <script src="/shop/Public/assets/layer/layer.js" type="text/javascript"></script>
		<script src="/shop/Public/assets/laydate/laydate.js" type="text/javascript"></script>
        
        
<script type="text/javascript">	
 $(function(){ 
 var cid = $('#nav_list> li>.submenu');
	  cid.each(function(i){ 
       $(this).attr('id',"Sort_link_"+i);
   
    })  
 })
 jQuery(document).ready(function(){ 	
    $.each($(".submenu"),function(){
	var $aobjs=$(this).children("li");
	var rowCount=$aobjs.size();
	var divHeigth=$(this).height();
    $aobjs.height(divHeigth/rowCount);	  	
  }); 
    //初始化宽度、高度    
    $("#main-container").height($(window).height()-76); 
	$("#iframe").height($(window).height()-140); 
	 
	$(".sidebar").height($(window).height()-99); 
    var thisHeight = $("#nav_list").height($(window).outerHeight()-173); 
	$(".submenu").height();
	$("#nav_list").children(".submenu").css("height",thisHeight);
	
    //当文档窗口发生改变时 触发  
    $(window).resize(function(){
	$("#main-container").height($(window).height()-76); 
	$("#iframe").height($(window).height()-140);
	$(".sidebar").height($(window).height()-99); 
	
	var thisHeight = $("#nav_list").height($(window).outerHeight()-173); 
	$(".submenu").height();
	$("#nav_list").children(".submenu").css("height",thisHeight);
  });
    $(".iframeurl").click(function(){
                var cid = $(this).attr("name");
				var cname = $(this).attr("title");
                $("#iframe").attr("src",cid).ready();
				$("#Bcrumbs").attr("href",cid).ready();
				$(".Current_page a").attr('href',cid).ready();	
                $(".Current_page").attr('name',cid);
				$(".Current_page").html(cname).css({"color":"#333333","cursor":"default"}).ready();	
				$("#parentIframe").html('<span class="parentIframe iframeurl"> </span>').css("display","none").ready();	
				$("#parentIfour").html(''). css("display","none").ready();		
      });
    
		
});
 

/*********************点击事件*********************/
$( document).ready(function(){
  $('#nav_list').find('li.home').click(function(){
	$('#nav_list').find('li.home').removeClass('active');
	$(this).addClass('active');
  });	
												

//时间设置
  function currentTime(){ 
    var d=new Date(),str=''; 
    str+=d.getFullYear()+'年'; 
    str+=d.getMonth() + 1+'月'; 
    str+=d.getDate()+'日'; 
    str+=d.getHours()+'时'; 
    str+=d.getMinutes()+'分'; 
    str+= d.getSeconds()+'秒'; 
    return str; 
} 
setInterval(function(){$('#time').html(currentTime)},1000); 
//修改密码
$('.change_Password').on('click', function(){
    layer.open({
    type: 1,
	title:'修改密码',
	area: ['300px','300px'],
	shadeClose: true,
	content: $('#change_Pass'),
	btn:['确认修改'],
	yes:function(index, layero){		
		   if ($("#password").val()==""){
			  layer.alert('原密码不能为空!',{
              title: '提示框',				
				icon:0,
			    
			 });
			return false;
          } 
		  if ($("#Nes_pas").val()==""){
			  layer.alert('新密码不能为空!',{
              title: '提示框',				
				icon:0,
			    
			 });
			return false;
          } 
		   
		  if ($("#c_mew_pas").val()==""){
			  layer.alert('确认新密码不能为空!',{
              title: '提示框',				
				icon:0,
			    
			 });
			return false;
          }
		    if(!$("#c_mew_pas").val || $("#c_mew_pas").val() != $("#Nes_pas").val() )
        {
            layer.alert('密码不一致!',{
              title: '提示框',				
				icon:0,
			    
			 });
			 return false;
        }   
		 else{			  
			  layer.alert('修改成功！',{
               title: '提示框',				
			icon:1,		
			  }); 
			  layer.close(index);      
		  }	 
	}
    });
});
  $('#Exit_system').on('click', function(){
      layer.confirm('是否确定退出系统？', {
     btn: ['是','否'] ,//按钮
	 icon:2,
    }, 
	function(){
	  location.href="<?php echo U('Login/logout');?>";
        
    });
});
})
</script>	
	</head>
	<body>
		<div class="navbar navbar-default" id="navbar">
        <script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>
			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>					
						<img src="/shop/Public/images/logo.png">
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->
			   <div class="navbar-header pull-right" role="navigation">
               <ul class="nav ace-nav">	
                <li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<span  class="time"><em id="time"></em></span><span class="user-info"><small>欢迎光临,</small><?php echo $_SESSION['03ca6fa17384fff4732f70ffe5f27920'];?>	</span>
								<i class="icon-caret-down"></i>
							</a>
							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li><a href="javascript:void(0);" name="<?php echo U('Person/person');?>" class="iframeurl"><i class="icon-user"></i>个人资料</a></li>
								<li class="divider"></li>
								<li><a href="javascript:void(0)" id="Exit_system"><i class="icon-off"></i>退出</a></li>
							</ul>
						</li>
	                   <li class="purple">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-bell-alt"></i><span class="badge badge-important">8</span></a>
							<ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
                            <li class="dropdown-header"><i class="icon-warning-sign"></i>8条通知</li>
                            <li>
                              <a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-pink icon-comment"></i>
												新闻评论
											</span>
											<span class="pull-right badge badge-info">+12</span>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<i class="btn btn-xs btn-primary icon-user"></i>
										切换为编辑登录..
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-success icon-shopping-cart"></i>
												新订单
											</span>
											<span class="pull-right badge badge-success">+8</span>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-info icon-twitter"></i>
												粉丝
											</span>
											<span class="pull-right badge badge-info">+11</span>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										查看所有通知
										<i class="icon-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

					
					</ul>
                <!-- <div class="right_info">
                 
                   <div class="get_time" ><span id="time" class="time"></span>欢迎光临,管理员</span></div>
					<ul class="nav ace-nav">	
						<li><a href="javascript:ovid(0)" class="change_Password">修改密码</a></li>
                        <li><a href="javascript:ovid(0)" id="Exit_system">退出系统</a></li>
                       
					</ul>
				</div>-->
                </div>
			</div>
		</div>
		<div class="main-container" id="main-container">
        <script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>
			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>
				<div class="sidebar" id="sidebar">
<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
					</script>
					<div class="sidebar-shortcuts" id="sidebar-shortcuts">
                     <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						网站后台管理系统  
						</div>
						<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
							<span class="btn btn-success"></span>
							<span class="btn btn-info"></span>
							<span class="btn btn-warning"></span>
							<span class="btn btn-danger"></span>
						</div>
					</div><!-- #sidebar-shortcuts -->
                    <!-- ********************菜单*************-->
					<ul class="nav nav-list" id="nav_list">
				     <li class="home"><a href="javascript:void(0)" name="home.html" class="iframeurl" title=""><i class="icon-dashboard"></i><span class="menu-text"> 系统首页 </span></a></li>
                     <li>
                        <a href="#" class="dropdown-toggle"><i class="icon-group"></i><span class="menu-text"> 管理员管理 </span><b class="arrow icon-angle-down"></b></a>
                        <ul class="submenu">
                            <li class="home"><a  href="javascript:void(0)" name="<?php echo U('Home/Privilege/lst');?>"  title="权限管理" class="iframeurl"><i class="icon-double-angle-right"></i>权限管理</a></li>
                            <li class="home"><a  href="javascript:void(0)" name="<?php echo U('Home/Role/lst');?>" title="角色管理"  class="iframeurl"><i class="icon-double-angle-right"></i>角色管理</a></li>
                            <li class="home"><a href="javascript:void(0)" name="<?php echo U('Home/User/lst');?>" title="用户管理"  class="iframeurl"><i class="icon-double-angle-right"></i>用户管理</a></li>
                            <li class="home"><a href="javascript:void(0)" name="<?php echo U('Home/Person/person');?>" title="个人信息"  class="iframeurl"><i class="icon-double-angle-right"></i>个人信息</a></li>

                        </ul>
                    </li>
                        <li>
                            <a href="#" class="dropdown-toggle"><i class="icon-desktop"></i><span class="menu-text"> 产品管理 </span><b class="arrow icon-angle-down"></b></a>
                            <ul class="submenu">
                                <li class="home"><a  href="javascript:void(0)" name="<?php echo U('Goods/Goods/lst');?>"  title="产品管理" class="iframeurl"><i class="icon-double-angle-right"></i>产品管理</a></li>
                                <li class="home"><a  href="javascript:void(0)" name="<?php echo U('Goods/Goods/pending_lst');?>"  title="产品审核管理" class="iframeurl"><i class="icon-double-angle-right"></i>产品审核管理</a></li>
                                <li class="home"><a  href="javascript:void(0)" name="<?php echo U('Goods/Brand/lst');?>"  title="品牌管理" class="iframeurl"><i class="icon-double-angle-right"></i>品牌管理</a></li>
                                <li class="home"><a  href="javascript:void(0)" name="<?php echo U('Goods/Category/lst');?>"  title="分类管理" class="iframeurl"><i class="icon-double-angle-right"></i>分类管理</a></li>
                                <li class="home"><a  href="javascript:void(0)" name="<?php echo U('Goods/Type/lst');?>"  title="类型管理" class="iframeurl"><i class="icon-double-angle-right"></i>类型管理</a></li>
                                <li class="home"><a  href="javascript:void(0)" name="<?php echo U('Goods/recommend/lst');?>"  title="推荐管理" class="iframeurl"><i class="icon-double-angle-right"></i>推荐管理</a></li>

                            </ul>
                        </li>
                        <li>
                            <a href="#" class="dropdown-toggle"><i class="icon-picture"></i><span class="menu-text"> 广告管理 </span><b class="arrow icon-angle-down"></b></a>
                            <ul class="submenu">
                                <li class="home"><a  href="javascript:void(0);" name="<?php echo U('Ad/Ad/lst');?>"  title="广告列表" class="iframeurl"><i class="icon-double-angle-right"></i>广告列表</a></li>
                                <li class="home"><a  href="javascript:void(0)" name="<?php echo U('Ad/AdPos/lst');?>"  title="广告位列表" class="iframeurl"><i class="icon-double-angle-right"></i>广告位列表</a></li>

                            </ul>
                        </li>

						<li>
							<a href="#" class="dropdown-toggle"><i class="icon-list"></i><span class="menu-text"> 交易管理 </span><b class="arrow icon-angle-down"></b></a>
							<ul class="submenu">
								<li class="home"><a  href="javascript:void(0);" name="<?php echo U('Trade/Trade/trade');?>"  title="交易信息" class="iframeurl"><i class="icon-double-angle-right"></i>交易信息</a></li>
								<li class="home"><a  href="javascript:void(0);" name="<?php echo U('Trade/Order/lst');?>"  title="订单列表" class="iframeurl"><i class="icon-double-angle-right"></i>订单列表</a></li>
							</ul>
						</li>
						<li>
							<a href="#" class="dropdown-toggle"><i class="icon-user"></i><span class="menu-text"> 会员管理 </span><b class="arrow icon-angle-down"></b></a>
							<ul class="submenu">
								<li class="home"><a  href="javascript:void(0);" name="<?php echo U('Member/Member/lst');?>"  title="会员列表" class="iframeurl"><i class="icon-double-angle-right"></i>会员列表</a></li>
								<li class="home"><a  href="javascript:void(0);" name="<?php echo U('Member/MemberLevel/lst');?>"  title="等级管理" class="iframeurl"><i class="icon-double-angle-right"></i>等级管理</a></li>
								<li class="home"><a  href="javascript:void(0);" name="<?php echo U('Member/Member/record');?>"  title="会员记录管理" class="iframeurl"><i class="icon-double-angle-right"></i>会员记录管理</a></li>
							</ul>
						</li>

						<li>
							<a href="#" class="dropdown-toggle"><i class="icon-edit"></i><span class="menu-text"> 消息管理 </span><b class="arrow icon-angle-down"></b></a>
							<ul class="submenu">
								<li class="home"><a  href="javascript:void(0);" name="<?php echo U('Message/Feedback/lst');?>"  title="意见反馈" class="iframeurl"><i class="icon-double-angle-right"></i>意见反馈</a></li>
							</ul>
						</li>

						<li>
							<a href="#" class="dropdown-toggle"><i class="icon-edit"></i><span class="menu-text"> 文章管理 </span><b class="arrow icon-angle-down"></b></a>
							<ul class="submenu">
								<li class="home"><a  href="javascript:void(0)" name="<?php echo U('Article/article/lst');?>"  title="文章列表" class="iframeurl"><i class="icon-double-angle-right"></i>文章列表</a></li>
								<li class="home"><a  href="javascript:void(0)" name="<?php echo U('Article/articleCat/lst');?>"  title="文章分类" class="iframeurl"><i class="icon-double-angle-right"></i>文章分类</a></li>

							</ul>
						</li>

						<li>
							<a href="#" class="dropdown-toggle"><i class="icon-home"></i><span class="menu-text"> 店铺管理 </span><b class="arrow icon-angle-down"></b></a>
							<ul class="submenu">
								<li class="home"><a  href="javascript:void(0)" name="<?php echo U('Store/Store/lst');?>"  title="店铺列表" class="iframeurl"><i class="icon-double-angle-right"></i>店铺列表</a></li>
								<li class="home"><a  href="javascript:void(0)" name="<?php echo U('Store/Store/pending_lst');?>"  title="店铺审核列表" class="iframeurl"><i class="icon-double-angle-right"></i>店铺审核列表</a></li>

							</ul>
						</li>

					</ul>
					<div class="sidebar-collapse" id="sidebar-collapse">
						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
					</div>
                    <script type="text/javascript">
						try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
					</script>
				</div>
				<div class="main-content">
                <script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>
					<div class="breadcrumbs" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="/shop/index.php/Home/Index/index">首页</a>
							</li>
							<li class="active"><span class="Current_page iframeurl"></span></li>
                            <li class="active" id="parentIframe"><span class="parentIframe iframeurl"></span></li>
							<li class="active" id="parentIfour"><span class="parentIfour iframeurl"></span></li>
						</ul>
					</div>
                    
                 <iframe id="iframe" style="border:0; width:100%; background-color:#FFF;"name="iframe" frameborder="0" src="/shop/index.php/Home/Index/home">  </iframe>
				 


				</div>
                  </div>
	</div>
			
		</div>
         <!--底部样式-->
       
         <div class="footer_style" id="footerstyle">  
          <p class="l_f">版权所有：南京四美软件  苏ICP备11011739号</p>
          <p class="r_f">地址：南京市鼓楼区阅江楼街道公共路64号  邮编：210011 技术支持：XXXX</p>
         </div>
         <!--修改密码样式-->
         <div class="change_Pass_style" id="change_Pass">
            <ul class="xg_style">
             <li><label class="label_name">原&nbsp;&nbsp;密&nbsp;码</label><input name="原密码" type="password" class="" id="password"></li>
             <li><label class="label_name">新&nbsp;&nbsp;密&nbsp;码</label><input name="新密码" type="password" class="" id="Nes_pas"></li>
             <li><label class="label_name">确认密码</label><input name="再次确认密码" type="password" class="" id="c_mew_pas"></li>
              
            </ul>
     <!--       <div class="center"> <button class="btn btn-primary" type="button" id="submit">确认修改</button></div>-->
         </div>
        <!-- /.main-container -->
		<!-- basic scripts -->

        <div class="change_Pass_style" id="change_Pass">
            <ul class="xg_style">
                <li><label class="label_name">原&nbsp;&nbsp;密&nbsp;码</label><input name="old_pwd" type="password" class="" id="password"></li>
                <li><label class="label_name">新&nbsp;&nbsp;密&nbsp;码</label><input name="new_pwd" type="password" class="" id="Nes_pas"></li>
                <li><label class="label_name">确认密码</label><input name="rep_new_pwd" type="password" class="" id="c_mew_pas"></li>

            </ul>
            <!--       <div class="center"> <button class="btn btn-primary" type="button" id="submit">确认修改</button></div>-->
        </div>
		
</body>
</html>