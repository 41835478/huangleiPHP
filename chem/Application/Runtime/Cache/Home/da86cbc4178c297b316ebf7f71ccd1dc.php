<?php if (!defined('THINK_PATH')) exit();?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>危险化学品 管理中心 - 列表 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/chem/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/chem/Public/Styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/chem/Public/Js/jquery-1.4.2.min.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U(MODULE_NAME.'/putStock/add');?>">添加</a></span>
    <span class="action-span1"><a href="#">危险化学品 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 入库列表 </span>
    <div style="clear:both"></div>
</h1>

<form method="post" action="<?php echo U(MODULE_NAME.'/putStock/bdel');?>" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>序号</th>
                <th style="width:180px;">品名(规格)</th>
                <th>采购员</th>
                <th>验收人</th>
                <th>入库时间</th>
                <th>入库数量</th>
                <th>入库摘要</th>
                <th>操作</th>
            </tr>
            <?php foreach($data as $v):?>
            <tr>
                <td align="center"><?php echo $v['id']?></td>

                <td align="center">
                <?php
 foreach($goods as $k){ if($v['stock_id'] == $k['id']){ echo $k['goods_name'].'('.$k['size'].')'; } } ?>
                </td>
                <td align="center"><?php echo $v['buyer']?></td>
                <td align="center"><?php echo $v['acceptor']?></td>
                <td align="center"><?php echo date('Y-m-d H:i:s',$v['time'])?></td>
                <td align="center"><?php echo $v['stock']?></td>
                <td align="center"><?php echo $v['summary']?></td>
                <td align="center">
                    <a href="<?php echo U(MODULE_NAME.'/putStock/save',array('id'=>$v['id']));?>" title="编辑">编辑</a>
                    |
                    <a onclick="return confirm('确定要删除吗？');" href="<?php echo U(MODULE_NAME.'/putStock/del',array('id'=>$v['id']));?>" title="删除">删除</a>

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