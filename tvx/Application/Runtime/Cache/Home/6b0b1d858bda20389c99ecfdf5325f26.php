<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 列表 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/tvxManage/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/tvxManage/Public/Styles/main.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="/tvxManage/Public/Js/jquery-1.4.2.min.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U(MODULE_NAME.'/Role/add');?>">添加</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 列表 </span>
    <div style="clear:both"></div>
</h1>
<form method="post" action="<?php echo U(MODULE_NAME.'/Role/bdel');?>" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th width="40"><input onclick="t()" id="checkbox" type="checkbox" /></th>
                    <th>id</th>
                    <th>角色名称</th>
                    <th>操作</th>
            </tr>
            <?php foreach($data as $v):?>
            <tr>
                <td align="center">
                    <?php if($v['id']>1):?>
                    <input class="check" type="checkbox" name="dels[]" value="<?php echo $v['id']?>"/>
                    <?php endif;?>
                </td>
                    <td align="center"><?php echo $v['id']?></td>
                    <td align="center"><?php echo $v['role_name']?></td>

                    </td>
                    <td align="center">
                <a href="<?php echo U(MODULE_NAME.'/Role/save',array('id'=>$v['id']));?>" title="编辑">编辑</a>
<?php if($v['id']>1):?>
                <a onclick="return confirm('确定要删除吗？');" href="<?php echo U(MODULE_NAME.'/Role/del',array('id'=>$v['id']));?>" title="编辑">移除</a>
<?php endif;?>
                </td>
            </tr>
            <?php endforeach;?>
            <tr>
            	<td><input type="submit" value="删除所选" /></td>
                <td align="right" nowrap="true" colspan="4">
                    <div id="turn-page">
                        <?php echo $show; ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</form>

<div id="footer">
共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
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