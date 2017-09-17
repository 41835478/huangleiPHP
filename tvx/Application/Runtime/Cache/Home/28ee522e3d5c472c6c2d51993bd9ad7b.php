<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>TXV 管理中心 - 列表 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/tvx/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/tvx/Public/Styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/tvx/Public/Js/jquery-1.4.2.min.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U(MODULE_NAME.'/device/add');?>">添加</a></span>
    <span class="action-span1"><a href="#">TXV 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 列表 </span>
    <div style="clear:both"></div>
</h1>

<form method="post" action="<?php echo U(MODULE_NAME.'/device/bdel');?>" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th width="40"><input  onclick="t()" id="checkbox" type="checkbox"/></th>
                <th>ID</th>
                <th>设备序列号</th>
                <th>设备名称</th>
                <th>所在位置</th>
                <th>开始使用时间</th>
                <th>电机状态</th>
                <th>碳刷状态</th>
                <th>清洁面积</th>
                <th>机型</th>
                <th>运行状态</th>
                <th>操作</th>
            </tr>
            <?php foreach($data as $v):?>

            <tr>
                <td align="center">
                    <input class="check" type="checkbox" name="dels[]" value="<?php echo $v['id']?>"/>
                </td>
                <td align="center"><?php echo $v['id'];?></td>
                <td align="center"><?php echo $v['dev_id']?></td>
                <td align="center"><?php echo $v['dev_name'];?></td>
                <td align="center"><?php echo $v['dev_place']?></td>
                <td align="center"><?php echo date("Y-m-d H:i:s",$v['time'])?></td>
                <td align="center"><?php echo $v['dev_dj_status']?></td>
                <td align="center"><?php echo $v['dev_ts_status']?></td>
                <td align="center"><?php echo $v['qjmj']?></td>
                <td align="center"><?php echo $v['dev_num']?></td>
                <td align="center"><?php echo $v['status']?></td>
                <td align="center">
                <a href="<?php echo U(MODULE_NAME.'/device/save',array('id'=>$v['id']));?>" title="编辑">编辑</a>
                |
                <a onclick="return confirm('确定要删除吗？');" href="<?php echo U(MODULE_NAME.'/device/del',array('id'=>$v['id'],'role_id'=>$v['role_id']));?>" title="编辑">移除</a>
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
    TVX 管理中心<br />
    版权所有 &copy; TVX，并保留所有权利。</div>
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