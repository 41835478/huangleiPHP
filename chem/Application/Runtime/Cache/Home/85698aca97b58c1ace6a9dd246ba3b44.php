<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>危险化学品 管理中心 - 修改 </title>
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
    <span class="action-span"><a href="<?php echo U(MODULE_NAME.'/goods/lst');?>">列表</a></span>
    <span class="action-span1"><a href="#">危险化学品 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 修改 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="<?php echo U(MODULE_NAME.'/goods/save');?>">
        <input type="hidden" name="id" value="<?php echo $data['id']?>">
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">品名</td>
                <td>
                    <input type="text" name="ch_name" maxlength="60" value="<?php echo $data['ch_name']?>" />
                </td>
            </tr>
            <tr>
                <td class="label">英文名称</td>
                <td>
                    <input type="text" name="en_name" maxlength="60" value="<?php echo $data['en_name']?>" />
                </td>
            </tr>

            <tr>
                <td class="label">别名</td>
                <td>
                    <input type="text" name="alias" maxlength="60" value="<?php echo $data['alias']?>" />
                </td>
            </tr>
            <tr>
                <td class="label">项目</td>
                <td>
                    <input type="text" name="project" maxlength="60" value="<?php echo $data['project']?>" />
                </td>
            </tr>
            <tr>
                <td class="label">危险货物编号</td>
                <td>
                    <input type="text" name="cas" maxlength="60" size="40" value="<?php echo $data['cas']?>" />
                </td>
            </tr>
            <tr>
                <td class="label">类别</td>
                <td>
                    <select name="status">
                        <option value="" selected="selected"></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">生产厂家</td>
                <td>
                    <input type="text" name="factory" maxlength="60" size="40" value="<?php echo $data['factory']?>" />
                </td>
            </tr>
            <tr>
                <td class="label">出厂日期</td>
                <td>
                    <input type="text" name="datatime" maxlength="60" size="40" value="<?php echo $data['datatime']?>" />
                </td>
            </tr>
            <tr>
                <td class="label">详细信息</td>
                <td>
                    <textarea name="content" id="content"><?php echo $data['content']?></textarea>
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