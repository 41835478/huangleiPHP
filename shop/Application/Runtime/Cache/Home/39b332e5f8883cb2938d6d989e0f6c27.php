<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="/shop/Public/assets/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="/shop/Public/css/style.css"/>
        <link rel="stylesheet" href="/shop/Public/assets/css/font-awesome.min.css" />
        <link href="/shop/Public/assets/css/codemirror.css" rel="stylesheet">
		<!--[if IE 7]>
		  <link rel="stylesheet" href="/shop/Public/assets/css/font-awesome-ie7.min.css" />
		<![endif]-->
        <!--[if lte IE 8]>
		  <link rel="stylesheet" href="/shop/Public/assets/css/ace-ie.min.css" />
		<![endif]-->
		<script src="/shop/Public/assets/js/ace-extra.min.js"></script>
		<!--[if lt IE 9]>
		<script src="/shop/Public/assets/js/html5shiv.js"></script>
		<script src="/shop/Public/assets/js/respond.min.js"></script>
		<![endif]-->
        		<!--[if !IE]> -->
		<script src="/shop/Public/assets/js/jquery.min.js"></script>        
		<!-- <![endif]-->
           	<script src="/shop/Public/assets/dist/echarts.js"></script>
        <script src="/shop/Public/assets/js/bootstrap.min.js"></script>
        
      
       <title>无标题文档</title>
       </head>
		
<body>
<div class="page-content clearfix">
 <div class="alert alert-block alert-success">
  <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
  <i class="icon-ok green"></i>欢迎使用<strong class="green">后台管理系统<small>(v1.2)</small></strong>,你本次登陆时间为<?php echo date("Y年m月d日 H时i分");?>，登陆IP:<?php echo getIp();?>.
 </div>
 <div class="state-overview clearfix">
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                      <a href="<?php echo U('Member/Member/lst');?>" title="商城会员">
                          <div class="symbol terques">
                             <i class="icon-user"></i>
                          </div>
                          <div class="value">
                              <h1><?php echo $memberCount;?></h1>
                              <p>商城用户</p>
                          </div>
                          </a>
                      </section>
                  </div>
                  <!--<div class="col-lg-3 col-sm-6">-->
                      <!--<section class="panel">-->
                          <!--<div class="symbol red">-->
                              <!--<i class="icon-tags"></i>-->
                          <!--</div>-->
                          <!--<div class="value">-->
                              <!--<h1>140</h1>-->
                              <!--<p>分销记录</p>-->
                          <!--</div>-->
                      <!--</section>-->
                  <!--</div>-->
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol yellow">
                              <i class="icon-shopping-cart"></i>
                          </div>
                          <div class="value">
                              <h1><?php echo $order_number;?></h1>
                              <p>商城订单</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol blue">
                              <i class="icon-bar-chart"></i>
                          </div>
                          <div class="value">
                              <h1>￥<?php echo $trade_money; ?></h1>
                              <p>交易记录</p>
                          </div>
                      </section>
                  </div>
              </div>
             <!--实时交易记录-->
             <div class="clearfix" style="width: 100%;">
             <div class="t_Record" style="width: 100%;">
               <div id="main" style="height:300px; overflow:hidden; width:100%; overflow:auto" ></div>     
              </div> 
         <!--<div class="news_style">-->
          <!--<div class="title_name">最新消息</div>-->
          <!--<ul class="list">-->
           <!--<li><i class="icon-bell red"></i><a href="#">后台系统找那个是开通了。</a></li>-->
           <!--<li><i class="icon-bell red"></i><a href="#">6月共处理订单3451比，作废为...</a></li>-->
           <!--<li><i class="icon-bell red"></i><a href="#">后台系统找那个是开通了。</a></li>-->
           <!--<li><i class="icon-bell red"></i><a href="#">后台系统找那个是开通了。</a></li>-->
           <!--<li><i class="icon-bell red"></i><a href="#">后台系统找那个是开通了。</a></li>-->
          <!--</ul>-->
         <!--</div> -->
         </div>
 
<script type="text/javascript">
     $(document).ready(function(){
		 
		  $(".t_Record").width($(window).width()-320);
		  //当文档窗口发生改变时 触发  
    $(window).resize(function(){
		 $(".t_Record").width($(window).width()-320);
		});
 });


     var data = [];
     $.ajax({
         url : "<?php echo U('Trade/Trade/getOrderData');?>",
         async : false,
         success : function(res){
             data = res.data;
         }
     });

     require.config({
         paths: {
             echarts: '/shop/Public/assets/dist'
         }
     });
     require(
             [
                 'echarts',
                 'echarts/theme/macarons',
                 'echarts/chart/line',   // 按需加载所需图表，如需动态类型切换功能，别忘了同时加载相应图表
                 'echarts/chart/bar'
             ],
             function (ec,theme) {
                 var myChart = ec.init(document.getElementById('main'),theme);
                 option = {
                     title : {
                         text: '月订单完成记录',
                         subtext: '实时获取用户订单完成记录'
                     },
                     tooltip : {
                         trigger: 'axis'
                     },

                     toolbox: {
                         show : true,
                         feature : {
                             restore : {show: true},
                             saveAsImage : {show: true}
                         }
                     },
                     calculable : true,
                     xAxis : [
                         {
                             type : 'category',
                             data : ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
                         }
                     ],
                     yAxis : [
                         {
                             type : 'value'
                         }
                     ],
                     series : [
                         {
                             name:'完成订单',
                             type:'line',
                             data:data,
                             markPoint : {
                                 data : [
                                     {type : 'max', name: '最大值'},
                                     {type : 'min', name: '最小值'}
                                 ]
                             }
                         }
                     ]
                 };

                 myChart.setOption(option);
             }
     );
    </script> 
     </div>
</body>
</html>