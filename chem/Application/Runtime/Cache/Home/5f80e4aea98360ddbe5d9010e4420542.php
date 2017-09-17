<?php if (!defined('THINK_PATH')) exit();?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>化学物品 管理中心 - 列表 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/chem/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/chem/Public/Styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/chem/Public/Js/jquery-1.4.2.min.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U(MODULE_NAME.'/stock/add');?>">添加</a></span>
    <span class="action-span1"><a href="#">化学物品 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 清单列表 </span>
    <div style="clear:both"></div>
</h1>

<form method="post" action="<?php echo U(MODULE_NAME.'/stock/bdel');?>" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th style="width:100px;">序号</th>
                <th style="width:200px;">品名</th>
                <th style="width:200px;">危险化学品代码</th>
                <th style="width:200px;color:red;font-weight:bold">是否剧毒</th>
                <th style="width:300px;">规格</th>
                <th style="width:300px;">单价</th>
                <th style="width:300px;">存放单位</th>
                <th style="width:300px;color:red;font-weight:bold">库存量</th>
                <th style="width:100px;">操作</th>
            </tr>
            <?php foreach($data as $v):?>
            <tr>
                <td align="center"><?php echo $v['id'];?></td>
                <td align="center"><?php echo $v['goods_name']?></td>
                <td align="center"><?php echo $v['goods_code'];?></td>
                <td align="center" style="color:red;font-weight:bold"><?php echo $v['style'];?></td>
                <td align="center"><?php echo $v['size'];?></td>
                <td align="center"><?php echo $v['price'];?></td>
                <td align="center"><?php echo $v['place'];?></td>
                <td align="center" style="color:red;font-weight:bold"><?php echo $v['stock'];?></td>
                <td align="center">
                    <a href="<?php echo U(MODULE_NAME.'/stock/save',array('id'=>$v['id']));?>" title="编辑">编辑</a>
                    |
                    <a onclick="return confirm('确定要删除吗？');" href="<?php echo U(MODULE_NAME.'/stock/del',array('id'=>$v['id'],'role_id'=>$v['role_id']));?>" title="编辑">移除</a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>
</form>

<div id="footer">
    危险化学品 管理中心<br />
    版权所有 &copy; 2016 广西大学实验室，并保留所有权利。</div>
</body>
</html>