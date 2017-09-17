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

    <span class="action-span1"><a href="#">危险化学品 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 列表 </span>
    <div style="clear:both"></div>
</h1>

    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>序号</th>
                <th>品名</th>
                <th>类别</th>
                <th>项目</th>
                <th>危险货物编号</th>
                <th>英文名称</th>
                <th>别名</th>
                <th>生产厂家</th>
                <th>出厂日期</th>


            </tr>
            <?php foreach($row as $v):?>

            <tr>

                <td align="center"><?php echo $v['id'];?></td>
                <td align="center"><a href="<?php echo U(MODULE_NAME.'/Goods/message',array('id'=>$v['id']));?>"><?php echo $v['ch_name']?></a></td>
                <td align="center"><?php echo $v['status']?></td>
                <td align="center"><?php echo $v['project']?></td>
                <td align="center"><?php echo $v['cas']?></td>
                <td align="center"><?php echo $v['en_name'];?></td>
                <td align="center"><?php echo $v['alias']?></td>

                <td align="center"><?php echo $v['factory']?></td>
                <td align="center"><?php echo $v['datatime']?></td>

            </tr>

        </table>
    </div>

<div id="footer">
    危险化学品 管理中心<br />
    版权所有 &copy; 2016 广西大学实验室，并保留所有权利。</div>
</body>
</html>