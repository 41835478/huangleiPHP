<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>化学物品 管理中心 - 修改 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/chem/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/chem/Public/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U(MODULE_NAME.'/stock/lst');?>">列表</a></span>
    <span class="action-span1"><a href="#">化学物品 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 库存修改 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="<?php echo U(MODULE_NAME.'/stock/save');?>">
        <input type="hidden" name="id" value="<?php echo $data['id']?>">
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">品名</td>
                <td>
                    <input type="text" name="goods_name" maxlength="60" value="<?php echo $data['goods_name']?>" />
                </td>
            </tr>
            <tr>
                <td class="label">危险化学品代码</td>
                <td>
                    <input type="text" name="goods_code" maxlength="60" value="<?php echo $data['goods_code']?>" />
                </td>
            </tr>
            <tr>
                <td class="label">类别</td>
                <td>
                    <?php
 if($data['style'] == '否'){ $check = "checked=checked"; }else{ $check = ""; } if($data['style'] == '是'){ $check1 = "checked=checked"; }else{ $check1 = ""; } ?>
                    <input type="radio" name="style" value="否" <?php echo $check;?> />否
                    <input type="radio" name="style" value="是" <?php echo $check1;?> />是
                </td>
            </tr>
            <tr>
                <td class="label">规格</td>
                <td>
                    <input type="text" name="size" maxlength="60" value="<?php echo $data['size']?>" />
                </td>
            </tr>
            <tr>
                <td class="label">单价</td>
                <td>
                    <input type="text" name="price" maxlength="60" value="<?php echo $data['price']?>" />元
                </td>
            </tr>
            <tr>
                <td class="label">存放单位</td>
                <td>
                    <input type="text" name="place" maxlength="60" value="<?php echo $data['place']?>" />
                </td>
            </tr>
            <tr>
                <td class="label">库存</td>
                <td>
                    <input type="text" name="stock" maxlength="60" value="<?php echo $data['stock']?>" />
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