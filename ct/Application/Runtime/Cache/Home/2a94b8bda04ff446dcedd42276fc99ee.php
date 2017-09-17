<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="author" content="" />
<title>创特装饰工程有限公司</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
<link href="/ct/Public/Yourphp/Tpl/Home/Default/Public/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link rel="stylesheet" href="/ct/Public/Yourphp/Tpl/Home/Default/Public/css/common.css" type="text/css" />
<link rel="stylesheet" href="/ct/Public/Yourphp/Tpl/Home/Default/Public/css/style.css" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/ct/Public/Styles/gdt-style.css">
<script type="text/javascript">var jQuery_1_3_2 = $.noConflict(true);
</script>
<script src="/ct/Public/Public/jquery.min.js"></script>
<script type="text/javascript" src="/ct/Public/Public/Js/jquery-2.0.0.js"></script>
<script src="/ct/Public/Public/Js/yourphp.nav.js"></script>
<script src="/ct/Public/Public/Js/yourphp.js"></script>
<script type="text/javascript" src="/ct/Public/Yourphp/Tpl/Home/Default/Public/Js/jquery.artDialog.js?skin=default"></script>
<script type="text/javascript" src="/ct/Public/Public/Js/iframeTools.js"></script>
<script type="text/javascript" src="/ct/Public/Public/Js/swfupload.js"></script>
<script type="text/javascript" src="/ct/Public/Public/Js/jquery.validate.js"></script>
    <script type="text/javascript" src="/ct/Public/Js/meiqia.js"></script>
</head>
<style>
  .aa a:hover{color:red}
  #main_left{
      width:200px;
        height:240px;

      float:left;
  }

    #main_left_top {
        height:180PX;
        width:200px;
        background:url("/ct/Uploads/weixin.jpg");
        background-size:100% 100%;
        float:left;
    }
    .main_nav{
        height:270px;
        width:1px;
        background:#2a6496;
        float:left;
        margin-left:15px;
    }
    #main_right{
        height:284px;
        width:240px;

        float:left;
        margin-left:35px;
    }

    .main_heng_nav{
        height:1px;
        width:200px;
        background:#2a6496;
        margin-top:5px;
        margin-bottom: 5px;
    }
  </style>
<body class="lybg">
<div id="header">
  <div class="logo"><a href="" target="_blank" ><img src="/ct/Public/Uploads/201212/logo.jpg" style="width:260px;" alt="" /></a></div>
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
      <!--效果开始-->
      <div class="column1_left">
        <div class="container" id="idTransformView2">
          <ul class="slider slider2" id="idSlider2">
            <li><a href=""><img src="/ct/Public/Uploads/201402/530c4d1974f6f.jpg"  alt="装修展会" width="944" height="450"></a></li>
            <li><a href=""><img src="/ct/Public/Uploads/201311/528b1c800dddb.jpg"  alt="装修效果" width="944" height="450"></a></li>
            <li><a href=""><img src="/ct/Public/Uploads/201311/528b1d6eb6c8e.jpg"  alt="装修效果" width="944" height="450"></a></li>
            <li><a href=""><img src="/ct/Public/Uploads/201311/528b1e295227a.jpg"  alt="装修效果" width="944" height="450"></a></li>
            <li><a href=""><img src="/ct/Public/Uploads/201307/51ec8edf8b96f.jpg"  alt="案例鉴赏" width="944" height="450"></a></li>
          </ul>
          <ul class="num" id="idNum2">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
          </ul>
        </div>
      </div>
      <script type="text/javascript" src="/ct/Public/Yourphp/Tpl/Home/Default/Public/js/lanrenzhijia.js"></script>
      <!--End-->
      <div class="clear"></div>
    </div>
    <div class="box_b"></div>
  </div>
</div>
<div class="clear"></div>
<div class="w980">
  <div class="index_title_anli"><p>精品案例/<span>Boutique Case</span></p></div>
</div>
<div class="clear"></div>
<div class="w980">
  <?php foreach($cas as $v):?>
    <div class="anli322">
      <div class="anli322_tu"><a href="<?php echo U(MODULE_NAME.'/Index/comCas',array('id'=>$v['id']));?>" target="_self"><img src="/ct/Uploads/<?php foreach($img as $k){ if($k['case_id'] == $v['id']){ echo $k['big_images']; break; } }?>"  title="27.6万打造中式风格"  width="200" height="140" border="0"></a></div>
      <div class="anli322_title"><?php echo $v['name']?></div>
    </div>

  <?php endforeach;?>

</div>

<div class="clear"></div>
<div class="w980">

  <div class="main_r" style="width:940px;background:white;border:2px solid #d3d1d1;border-radius:15px;">
    <div class="index_cg_title"><p>最新资讯/<span>News</span></p></div>
    <div class="line"></div>
      <div id="main_left">
      <div id="main_left_top"></div>
            <div id="main_left_buttom" style="text-align:center">
                <span align="center">关注创特，好礼多多！</span>
                <img src="/ct/Uploads/5-15062FZ937.gif" style="margin-left:20px;margin-top:10px;">
            </div>
      </div>
      <div class="main_nav"></div>
    <div class="index_cg" style="width:400px;margin-left:15px;" >
      <ul>
        <?php foreach($act as $v):?>
        <li class="aa">
            <?php
 if($v['cat'] == '最新活动'){ echo "<span style='color:red;font-size:13px;font-weight: bold;'>[活动]</span>"; }else if($v['cat'] == '新闻中心'){ echo "<span style='color:blue;font-size:13px;font-weight: bold;'>[新闻]</span>"; }else if($v['cat'] == '装修知识'){ echo "<span style='color:green;font-size:13px;font-weight: bold;'>[知识]</span>"; } ?>
            <a href="<?php echo U(MODULE_NAME.'/Index/news',array('id'=>$v['id']));?>" target="_self" title="<?php echo $v['title']?>"><?php echo $v['title']?>
            <?php if($v['mark']==1){ ?>
                <img src="/ct/Public/Images/5-120601154100.gif">
            <?php } ?>
            <span style="float:right"><?php echo date("Y-m-d",$v['time'])?></span>
            </a>
        </li>
        <?php endforeach;?>
        <li class="aa"><a href="<?php echo U(MODULE_NAME.'/Index/newslst');?>" target="_self" title="查看更多" style="margin-left:160px;font-weight: bold">查看更多</a></li>
      </ul>
    </div>
      <div class="main_nav"></div>
      <div id="main_right">
            <div id="main_right_top">
                <span style="font-size:15px;">在线交谈：<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1251966602&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:1251966602:51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a></span>
            </div>
          <br />
          <div class="main_heng_nav"></div>
            <br />
            <div id="main_left_buttom" style="height:130px;width:240px;">
                <p style="font-size:15px;">联系方式:</p>
                <p style="margin-left:20px;"><span style="font-size:14px;"><img src="/ct/Uploads/weixintubiao.png" style="width:25px;height:25px;margin-top:10px;">&nbsp;&nbsp;&nbsp;13074548734</span></p>
                <p style="margin-left:20px;"><span style="font-size:14px;"><img src="/ct/Uploads/qq.png" style="width:25px;height:25px;margin-top:10px;">&nbsp;&nbsp;&nbsp;1251966602</span></p>
                <p style="margin-left:20px;"><span style="font-size:14px;"><img src="/ct/Uploads/phone.png" style="width:25px;height:25px;margin-top:10px;">&nbsp;&nbsp;&nbsp;400-181-1111 </span></p>


            </div>
      </div>
  </div>

</div>
<div class="w980">

  <div class="index_title_360"><p>工程案例/<span>Project Case</span></p></div>
  
</div>
<div class="clear"></div>
<div class="w980" style="height:345px">
  <?php foreach($one as $v):?>
  <div class="main_l_360">
    <div class="design_tu_b"><span><?php echo $v['name']?></span><a href="<?php echo U(MODULE_NAME.'/Index/img',array('id'=>$v['id']));?>" target="_self"><img src="/ct/Uploads/<?php foreach($projectImg as $k){ if($k['pro_id'] == $v['id']){ echo $k['big_images']; break; } }?>" title="厨房实景体验区" width="284" height="284" border="0" /></a></div>
  </div>
  <?php endforeach;?>
  <div class="main_r_360">
    <ul>
      <?php foreach($project as $k=>$v):?>
      <li>
        <div class="design_tu"><span><?php echo $v['name']?></span><a href="<?php echo U(MODULE_NAME.'/Index/img',array('id'=>$v['id']));?>" target="_self"><img src="/ct/Uploads/<?php foreach($projectImg as $k){ if($k['pro_id'] == $v['id']){ echo $k['big_images']; break; } }?>" title="室内门实景体验区" width="174" height="119" border="0" /></a></div>
      </li>
      <?php endforeach;?>
    </ul>
  </div>
</div>


<div class="w980">
    <div class="box_t"></div>
    <div class="box_m">
        <div id="bgcontainer3">
            <div id="container3">

                <div class="link"><span>友链链接：</span><a href="http://www.msfehs.cn" target="_blank" style="color:#E56600;font-weight:bold;">曼莎菲尔高端婚纱礼服定制</a></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="box_b"></div>
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