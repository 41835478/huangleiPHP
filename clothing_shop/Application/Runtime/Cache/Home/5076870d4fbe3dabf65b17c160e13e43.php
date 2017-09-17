<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Clothing Shop 管理中心 - 添加 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/clothing_shop/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/clothing_shop/Public/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="/clothing_shop/index.php/Home/Category/lst">列表</a></span>
    <span class="action-span1"><a href="#">Clothing Shop 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">

    <form method="POST" action="/clothing_shop/index.php/Home/Category/add">
        <table cellspacing="1" cellpadding="3" width="100%">
       		 <tr>
                <td class="label">上级分类：</td>
                <td>

                <select name="parent_id">
                	<option value="0">顶级分类</option>
                    <?php foreach($catData as $v): ?>
                    <option value="<?php echo $v['id']?>"><?php echo str_repeat('-',$v['level']*8).$v['cat_name']?></option>
                    <?php endforeach;?>
                </select>
                </td>
            </tr>
            <tr>
            <tr>
                <td class="label">分类名称：</td>
                <td>
                    <input type="text" name="cat_name" maxlength="60" value="" />
                    <span class="require-field">*</span>
                </td>
            </tr>

                <td colspan="2" align="center"><br />
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>

<div id="footer">
    CopyRight &copy; 版权归 Clothing Shop 所有。
</div>
</body>
</html>