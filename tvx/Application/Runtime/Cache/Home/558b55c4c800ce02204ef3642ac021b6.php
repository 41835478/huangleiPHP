<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/tvxManage/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/tvxManage/Public/Styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/tvxManage/Public/Js/jquery-1.4.2.min.js"></script>
<style>
ul li{list-style-type:none;margin:5px;}
</style>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U(MODULE_NAME.'/Role/lst');?>">列表</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">

    <form method="POST" action="<?php echo U(MODULE_NAME.'/Role/add');?>">
        <table cellspacing="1" cellpadding="3" width="100%">
			<tr>
                <td class="label">角色名称：</td>
                <td>
					<input type="text" name="role_name" maxlength="60" value="" />
					<span class="require-field">*</span>
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
<script>

    $(':checkbox').click(function(){
        //获取到点击的checkbox的value值
        var cur_li = $(this).attr('level');
        var checked = $(this).attr('check');

        $(this).prevAll('input:checkbox').each(function () {
            if ($(this).attr("level") < cur_li) {
                $(this).attr("checked", "checked");

                if ($(this).attr('level') == 0)
                    return false;

            }
        });

        if(!checked) {
            $(this).nextAll('input:checkbox').each(function () {
                if ($(this).attr("level") > cur_li) {
                    $(this).removeAttr("checked");
                }
            });
        }

 });


</script>