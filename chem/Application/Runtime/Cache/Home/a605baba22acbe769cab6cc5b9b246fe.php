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
    <span class="action-span"><a href="<?php echo U(MODULE_NAME.'/rules/add');?>">添加</a></span>
    <span class="action-span1"><a href="#">危险化学品 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 规章制度列表 </span>
    <div style="clear:both"></div>
</h1>

<form method="post" action="<?php echo U(MODULE_NAME.'/rules/bdel');?>" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th style="width:100px;"><input  onclick="t()" id="checkbox" type="checkbox"/></th>
                <th style="width:100px;">序号</th>
                <th style="width:300px;">标题</th>
                <th style="width:100px;">时间</th>
                <th>内容</th>
                <th style="width:100px;">操作</th>
            </tr>
            <?php foreach($data as $v):?>
            <tr>
                <td align="center">
                    <input class="check" type="checkbox" name="dels[]" value="<?php echo $v['id']?>"/>
                </td>
                <td align="center"><?php echo $v['id'];?></td>
                <td align="center"><?php echo $v['title']?></td>
                <td align="center"><?php echo date("Y-m-d H:i:s",$v['time']);?></td>
                <td align="center"><?php echo $v['content']?></td>
                <td align="center">
                <a href="<?php echo U(MODULE_NAME.'/rules/save',array('id'=>$v['id']));?>" title="编辑">编辑</a>
                |
                <a onclick="return confirm('确定要删除吗？');" href="<?php echo U(MODULE_NAME.'/rules/del',array('id'=>$v['id'],'role_id'=>$v['role_id']));?>" title="编辑">移除</a>
                </td>
            </tr>
            <?php endforeach;?>
            <tr>
                <td><input onclick="return confirm('确定要删除吗？');" type="submit" value="删除所选" /></td>
            </tr>
        </table>
    </div>
</form>

<div id="footer">
    危险化学品 管理中心<br />
    版权所有 &copy; 2016 广西大学实验室，并保留所有权利。</div>
</body>
</html>
<script>
    function t(){
        var a = document.getElementsByClassName('check');
        var b = document.getElementById('checkbox');
        if(b.checked==true){
            for(var i=0;i<a.length;i++){
                a[i].checked = true;
            }
        }else{
            for(var i=0;i<a.length;i++){
                a[i].checked = false;
            }
        }

    }

</script>