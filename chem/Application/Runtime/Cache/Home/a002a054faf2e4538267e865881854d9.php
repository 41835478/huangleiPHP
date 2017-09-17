<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>危险化学品 管理中心 - 添加 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/chem/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/chem/Public/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span1"><a href="#">危险化学品 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 危险品申领添加 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="<?php echo U(MODULE_NAME.'/apply/add');?>" enctype="multipart/form-data" >
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">申领品名(规格)</td>
                <td>
                    <select name="stock_id">
                        <?php foreach($goods as $v):?>
                        <option value="<?php echo $v['id'];?>"><?php echo $v['goods_name'].'('.$v['size'].')';?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>

            <tr>
                <td class="label">使用单位</td>
                <td>
                    <input type="text" name="sector" maxlength="60" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">用途</td>
                <td>
                    <input type="text" name="use" maxlength="60" value="" />
                </td>
            </tr>

            <tr>
                <td class="label">联系电话</td>
                <td>
                    <input type="text" name="app_phoneNum" maxlength="60" value="" />
                </td>
            </tr>
            <?php if($_SESSION['level'] == 3){?>
            <tr>
                <td class="label">负责老师</td>
                <td>
                    <input type="text" name="teacher" maxlength="60" value="" />
                </td>
            </tr>
            <?php }?>
            <tr>
                <td class="label">申领数量</td>
                <td>
                    <input type="text" name="stock" maxlength="60" value="" />
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