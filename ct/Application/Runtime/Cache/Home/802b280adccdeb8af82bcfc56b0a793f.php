<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>创特 管理中心 - 修改 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/ct/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/ct/Public/Styles/main.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
        window.UEDITOR_HOME_URL = '/ct/Application/Data/ueditor/';
        window.onload = function(){
            window.UEDITOR_CONFIG.initialFrameWidth =800;
            window.UEDITOR_CONFIG.initialFrameHeight =300;
            window.UEDITOR_CONFIG.savePath= ['upload','upload1'];
            window.UEDITOR_CONFIG.imageUrl = "<?php echo U(MODULE_NAME.'/Company/upload');?>";
            window.UEDITOR_CONFIG.imagePath = '/ct/Uploads/';
            UE.getEditor('content');
        }
    </script>
    <script type="text/javascript" src="/ct/Application/Data/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/ct/Application/Data/ueditor/ueditor.all.min.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U(MODULE_NAME.'/Active/lst');?>">列表</a></span>
    <span class="action-span1"><a href="#">创特 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 修改资讯 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="<?php echo U(MODULE_NAME.'/Active/save');?>" enctype="multipart/form-data" >
        <input type="hidden" name="id" value="<?php echo $data['id']?>" />
        <input type="hidden" name="oldlogo" value="<?php echo $data['images'];?>" />
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">类别</td>
                <td>
                    <select name="cat">
                        <?php
 if($data['cat'] == '最新活动'){ $select = "selected = selected"; }else{ $select = ''; } if($data['cat'] == '新闻中心'){ $select1 = "selected = selected"; }else{ $select1 = ''; } if($data['cat'] == '装修知识'){ $select2 = "selected = selected"; }else{ $select2 = ''; } ?>
                        <option value="最新活动" <?php echo $select;?>>最新活动</option>
                        <option value="新闻中心" <?php echo $select1;?>>新闻中心</option>
                        <option value="装修知识" <?php echo $select2;?>>装修知识</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">封面图片</td>
                <td>
                    <img src="/ct/Uploads/<?php echo $data['images']?>">
                    <input type="file" name="active" maxlength="60" value="" />
                    <span>* 不上传则不修改图片</span>
                </td>
            </tr>
            <tr>
                <td class="label">标题</td>
                <td>
                    <input type="text" name="title" maxlength="60" value="<?php echo $data['title'];?>" />
                </td>
            </tr>
            <tr>
                <td class="label">摘要</td>
                <td>
                    <input type="text" name="summary" maxlength="60" value="<?php echo $data['summary'];?>" />
                </td>
            </tr>

            <tr>
                <td class="label">是否启用‘hot’标记</td>
                <td>
                    <?php
 if($data['mark'] == 1){ $checked = "checked=checked"; }else{ $checked1 = "checked=checked"; } ?>
                    <input type="radio" name="mark" value="1" <?php echo $checked;?> />启用
                    <input type="radio" name="mark" value="0" <?php echo $checked1;?> />不启用
                </td>
            </tr>
            <tr>
                <td class="label">是否置顶</td>
                <td>
                    <?php
 if($data['top'] == 1){ $checked2 = "checked=checked"; }else{ $checked3 = "checked=checked"; } ?>
                    <input type="radio" name="top" value="1" <?php echo $checked2;?>/>置顶
                    <input type="radio" name="top" value="0" <?php echo $checked3;?>/>不置顶
                </td>
            </tr>
            <tr>
                <td class="label">描述</td>
                <td>
                    <textarea name="content" id="content"><?php echo $data['content'];?></textarea>
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
共执行 1 个查询，用时 0.018952 秒，Gzip 已禁用，内存占用 2.197 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>