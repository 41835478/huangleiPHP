<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>危险化学品 管理中心</title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/chem/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/chem/Public/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span1"><a href="#">危险化学品 详细信息</a> </span>
    <span id="search_id" class="action-span1"></span>
    <div style="clear:both"></div>
</h1>

<div class="list-div">
    <table cellspacing='1' cellpadding='3'>
        <tr>
            <th align="left" style="font-weight: bold;font-size: 15px;"><?php echo $data['ch_name'];?></th>
        </tr>
        <tr>
        <td><?php echo html_entity_decode($data['content']);?></td>
    </tr>

    </table>
</div>
<div id="footer">
危险化学品 管理中心<br />
版权所有 &copy; 2016 广西大学实验室，并保留所有权利。</div>
</body>
</html>