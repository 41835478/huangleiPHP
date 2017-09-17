<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>危险化学品 管理中心 - 添加 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/chem/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/chem/Public/Styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    window.UEDITOR_HOME_URL = '/chem/Application/Data/ueditor/';
    window.onload = function(){
        window.UEDITOR_CONFIG.initialFrameWidth =800;
        window.UEDITOR_CONFIG.initialFrameHeight =300;
        window.UEDITOR_CONFIG.savePath= ['upload','upload1'];
        window.UEDITOR_CONFIG.imageUrl = "<?php echo U(MODULE_NAME.'/Blog/upload');?>";
        window.UEDITOR_CONFIG.imagePath = '/chem/Uploads/';
        UE.getEditor('content');
    }
</script>
<script type="text/javascript" src="/chem/Application/Data/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/chem/Application/Data/ueditor/ueditor.all.min.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U(MODULE_NAME.'/rules/lst');?>">列表</a></span>
    <span class="action-span1"><a href="#">危险化学品 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 公告添加 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="<?php echo U(MODULE_NAME.'/notice/add');?>" enctype="multipart/form-data" >
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">标题</td>
                <td>
                    <input type="text" name="title" maxlength="60" value="" />
                </td>
            </tr>

            <tr>
                <td class="label">内容</td>
                <td>
                    <textarea name="content" id="content"></textarea>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center"><br />
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>

<div id="footer">
    危险化学品 管理中心<br />
    版权所有 &copy; 2016 广西大学实验室，并保留所有权利。</div>
</body>
</html>