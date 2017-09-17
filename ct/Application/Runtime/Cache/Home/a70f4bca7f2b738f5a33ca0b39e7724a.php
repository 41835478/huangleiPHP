<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>创特装饰工程有限公司</title>
<meta name="author" content="" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="/ct/Public/Yourphp/Tpl/Home/Default/Public/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link rel="stylesheet" href="/ct/Public/Yourphp/Tpl/Home/Default/Public/css/common.css" type="text/css" />
<link rel="stylesheet" href="/ct/Public/Yourphp/Tpl/Home/Default/Public/css/style.css" type="text/css" />
<script type="text/javascript">var jQuery_1_3_2 = $.noConflict(true);
</script>
<script src="/ct/Public/Public/Js/jquery.min.js"></script>
<script src="/ct/Public/Public/Js/yourphp.nav.js"></script>
  <script language="javascript" src="Js/jquery-1.4.2.min.js"></script>
<script src="/ct/Public/Public/Js/yourphp.js"></script>
<script type="text/javascript" src="/ct/Public/Yourphp/Tpl/Home/Default/Public/Js/jquery.artDialog.js?skin=default"></script>
<script type="text/javascript" src="/ct/Public/Public/Js/iframeTools.js"></script>
<script type="text/javascript" src="/ct/Public/Public/Js/swfupload.js"></script>
<script type="text/javascript" src="/ct/Public/Public/Js/jquery.validate.js"></script>
    <script type="text/javascript" src="/ct/Public/Js/meiqia.js"></script>
    <style>
        .box_r_title p a:hover{color:blue}
        #fanye h4 a:hover{color:blue}
    </style>
</head>
<body class="lybg">
<div id="header">
  <div class="logo"><a href="" target="_blank" ><img src="/ct/Public/Uploads/201212/logo.jpg" style="width:260px;" title="" /></a></div>
  <div class="top_icon">
    <div class="tel"><img src="/ct/Public/Yourphp/Tpl/Home/Default/Public/images/tel.png"  title="" /></div>
  </div>
</div>
<div class="w980">
    <div class="page">
        <div class="box_t"></div>
        <div class="box_m">
            <div class="nav" id="nav">
                <ul id="nav_box">
                    <li id="nav_0"><span class="fl_ico"></span><a href="<?php echo U('Index/index');?>" title="网站首页"><span class="fl">网站首页</span></a></li>
                    <li id="nav_37" class="first folder"><span class="fl_ico"></span><a href="<?php echo U('Index/project');?>" title="工程案例"><span class="fl">工程案例</span></a></li>
                    <li id="nav_40" class="folder"><span class="fl_ico"></span><a href="<?php echo U('Index/cas');?>" title="案例展示"><span class="fl">案例展示</span></a></li>
                    <li id="nav_29" class="folder"><span class="fl_ico"></span><a href="<?php echo U('Index/build');?>" title="施工现场"><span class="fl">施工现场</span></a></li>
                    <li id="nav_25" class="folder"><span class="fl_ico"></span><a href="<?php echo U('Index/newslst');?>" title="资讯中心"><span class="fl">资讯中心</span></a></li>
                    <li id="nav_20" class="foot folder"><span class="fl_ico"></span><a href="<?php echo U('Index/about');?>" title="关于我们"><span class="fl">关于我们</span></a></li>
                </ul>
            </div>
      <script type="text/javascript">var APP	 =	 'index.php';
var ROOT =	 '';
var PUBLIC = 'Public';
yourphpnav.init({navid: "nav"});
var nav = document.getElementById('nav_37');nav.className=nav.className+" on";
</script>
      <img src="/ct/Public/Yourphp/Tpl/Home/Default/Public/images/banner1.jpg" width="944" height="260" />
      <div class="clear"></div>
    </div>
    <div class="box_b"></div>
  </div>
</div>
<div class="clear"></div>
<div class="w980 height10"></div>
<div class="w980">

  <div class="page_r" style="width:980px;margin-left:0px;">
    <div class="box_r">
      <div class="box_r_m" style="background:rgba(255,255,255,0.7); border-radius:15px;width:945px;height:35px;">
        <div class="box_r_title"><p style="color:rgba(121,190,247,1.00); font-size:18px;"><a href="<?php echo U(MODULE_NAME.'/Index/project');?>">工程案例>>>></a><?php echo $data['name']?></p></div>
      </div>
    </div>

          <div class="box_r">
              <div class="box_r_m" style="width:960px;">
                  <div style="width:720px;margin:0 auto;">
                      <?php foreach($imgs as $v):?>
                           <img src="/ct/Uploads/<?php echo $v['big_images']?>">
                      <?php endforeach;?>
                  </div>
                  <div id="fanye" style="width:900px;height:40px;margin-top:15px;">
                      <?php
 $next = M('project')->where('id>'.$data['id'])->order("id ASC")->limit(1)->select(); $prev = M('project')->where('id<'.$data['id'])->order("id DESC")->limit(1)->select(); ?>
                      <h4 style="float:left;">上一案例: &nbsp;<a href="<?php echo U(MODULE_NAME.'/Index/img',array('id'=>$prev[0]['id']));?>"><?php echo $prev[0]['name']?></a></h4><br />
                      <h4 style="float:left;">下一案例: &nbsp;<a href="<?php echo U(MODULE_NAME.'/Index/img',array('id'=>$next[0]['id']));?>"><?php echo $next[0]['name']?></a></h4>
                  </div>
              </div>
              <div class="box_r_b"></div>
          </div>

      </div>


</div>
</div>
</div>

<div class="w980 height20"></div>
<div id="bgfooter">
    <div id="footer">
        <div class="copyright">
            <div class="copyright1"><a href="" title=""><img src="/ct/Public/Yourphp/Tpl/Home/Default/Public/images/logo.jpg" style="width:230px" alt="" alt="" /></a></div>
            <div class="copyright2">Copyright&copy;2016 <a href="http://www.miit.gov.cn/" rel="nofollow" target="_blank">版权归 创特装饰 所有</a>
                <br />
            </div>
        </div>
        <div class="subnav">
            <div class="subnav2">
                <strong>案例</strong>
                <?php $cat1 = M('category')->limit(4)->select(); foreach($cat1 as $v): ?>
                <span><a href="<?php echo U('Index/cas',array('un'=>$v['id']));?>" title="现代简约"><?php echo $v['name']?></a></span>
                <?php endforeach;?>
            </div>
            <div class="subnav3">
                <strong>工程施工</strong>
                <span><a href="<?php echo U(MODULE_NAME.'/Index/project');?>" title="施工体系">工程案例</a></span>
                <span><a href="<?php echo U(MODULE_NAME.'/Index/build');?>" title="合作材料">施工现场</a></span>
            </div>

            <div class="subnav5">
                <strong>更多链接</strong>
                <span><a href="<?php echo U('Index/about');?>" title="公司介绍">关于我们</a></span>
                <span><a href="<?php echo U('Index/newslst');?>" title="最新活动">资讯中心</a></span>
            </div>
        </div>
    </div>
</div>
<!--底部服务栏-->
<DIV id="bottomDiv1" style="left: 0px;">
    <DIV class="bottom_float">
        <form name="myform" id="myform" action="<?php echo U(MODULE_NAME.'/Index/mail');?>" method="post">
            <DIV class="bottom_float_in">
                <input type="hidden" id="catid" name="catid" value="36" />
                <input type="hidden" id="catid" name="moduleid" value="6" />
                <input type="hidden" name="lang" value="" />
                <DIV class="left"><a href=""><img src="/ct/Public/Yourphp/Tpl/Home/Default/Public/images/fbftlabel.jpg" alt="预约量房" /></a></DIV>
                <DIV class="left ml9">姓名：
                    <input type="text" name="name" id="title" value="" class="fbft2" />
                </DIV>
                <DIV class="left ml9">电话：
                    <input type="text" name="phoneNum" id="telephone" value="" class="fbft2" />
                </DIV>
                <DIV class="left ml9">楼盘：
                    <input type="text" name="loupan" id="fbloupan" value="" class="fbft2" />
                </DIV>
                <DIV class="left ml9">面积：
                    <input type="text" name="mianji" id="fbmianji" value="" class="fbft2" />
                </DIV>
                <DIV class="bottom_float_server">
                    <input onclick="return confirm('确定提交吗？');" type="submit" name="submit" value="" class="send" />
                </DIV>
            </DIV>
        </form>
    </DIV>
</DIV>
<div class="clear"></div>
</body>
</html>