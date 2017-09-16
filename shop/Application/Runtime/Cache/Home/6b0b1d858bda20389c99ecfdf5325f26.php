<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Cache-Control" content="no-siteapp" />
        <link href="/shop/Public/assets/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="/shop/Public/css/style.css"/>       
        <link href="/shop/Public/assets/css/codemirror.css" rel="stylesheet">
        <link rel="stylesheet" href="/shop/Public/assets/css/ace.min.css" />
        <link rel="stylesheet" href="/shop/Public/font/css/font-awesome.min.css" />
        <!--[if lte IE 8]>
		  <link rel="stylesheet" href="/shop/Public/assets/css/ace-ie.min.css" />
		<![endif]-->
		<script src="/shop/Public/js/jquery-1.9.1.min.js"></script>
        <script src="/shop/Public/assets/js/bootstrap.min.js"></script>
		<script src="/shop/Public/assets/js/typeahead-bs2.min.js"></script>           	
		<script src="/shop/Public/assets/js/jquery.dataTables.min.js"></script>
		<script src="/shop/Public/assets/js/jquery.dataTables.bootstrap.js"></script>
        <script src="/shop/Public/assets/layer/layer.js" type="text/javascript" ></script>          
        <script src="/shop/Public/assets/laydate/laydate.js" type="text/javascript"></script>
<title>管理角色</title>
</head>

<body>
 <div class="margin clearfix">
   <div class="border clearfix">
       <span class="l_f">
        <a href="/shop/index.php/Home/Role/add" id="Competence_add" class="btn btn-warning" title="添加角色"><i class="fa fa-plus"></i> 添加角色</a>
        <a href="javascript:ovid()" class="btn btn-danger" id="pl"><i class="fa fa-trash"></i> 批量删除</a>
       </span>
       <span class="r_f">共：<b><?php echo count($data);?></b>个角色</span>
     </div>
     <div class="compete_list">
         <form id="form1">
       <table id="sample-table-1" class="table table-striped table-bordered table-hover">
		 <thead>
			<tr>
			  <th class="center"><label><input type="checkbox" onclick="t()" class="ace" id="chk1"><span class="lbl"></span></label></th>
                <th>id</th>
			  <th>角色名称</th>
			  <th width="600">权限分配</th>
			  <th class="hidden-480" width="300">描述</th>
			  <th class="hidden-480">操作</th>
             </tr>
		    </thead>
             <tbody>
             <?php foreach($data as $k => $v):?>
			  <tr>

				<td class="center">
                    <?php if($v['id'] != 1):?>
                    <label><input type="checkbox" class="ace chk2" name="dels[]" value="<?php echo $v['id'];?>"><span class="lbl"></span></label>
                    <?php endif; ?>
                </td>

                  <td><?php echo $v['id']?></td>

				<td><?php echo $v['role_name']?></td>
				<td><?php
 foreach($priData as $k1 => $v1){ if(strpos(','.$v['role_pri_id'].',',','.$v1['id'].',') !== false){ echo $v1['pri_name'].'，'; }else if($v['role_pri_id'] == '*'){ echo '所有权限'; break; } } ?></td>
                  <td><?php echo $v['content'];?></td>
				<td>
                    <?php if($v['role_pri_id'] != '*'){?>
                    <a title="修改角色" href="/shop/index.php/Home/Role/save/id/<?php echo $v['id']; ?>"  id="Competence_save" class="btn btn-xs btn-info" ><i class="fa fa-edit bigger-120"></i></a>
                    <a title="删除角色" href="javascript:void(0);" onclick="role_del(this,'<?php echo $v[id];?>')" class="btn btn-xs btn-warning" ><i class="fa fa-trash  bigger-120"></i></a>
                    <?php } ?>
                </td>
			   </tr>
                <?php endforeach; ?>
		      </tbody>
	        </table>
             </form>
     </div>
 </div>

</body>
</html>
<script type="text/javascript">
//面包屑返回值
var index = parent.layer.getFrameIndex(window.name);
parent.layer.iframeAuto(index);
$('.Order_form ,#Competence_add,#Competence_save').on('click', function(){
	var cname = $(this).attr("title");
	var cnames = parent.$('.Current_page').html();
	var herf = parent.$("#iframe").attr("src");
    parent.$('#parentIframe span').html(cname);
	parent.$('#parentIframe').css("display","inline-block");
    parent.$('.Current_page').attr("name",herf).css({"color":"#4c8fbd","cursor":"pointer"});
	//parent.$('.Current_page').html("<a href='javascript:void(0)' name="+herf+">" + cnames + "</a>");
    parent.layer.close(index);
	
});
function t(){
    var chk1 = document.getElementById('chk1');
    var chk2 = document.getElementsByClassName('chk2');
    if(chk1.checked == true){
        for(var i = 0; i < chk2.length; i++){
            chk2[i].checked = true;
        }
    }else{
        for(var i = 0; i < chk2.length; i++){
            chk2[i].checked = false;
        }
    }
}

//批量删除
$('#pl').click(function (){
    layer.confirm('确认要批量删除吗？',function(index) {
        var arr = new Array();
        var chked = $("input:checkbox:checked");
        chked.each(function () {
            var id = $(this).val();
            arr.push(id);
        });
        $.ajax({
            type: 'post',
            url: '/shop/index.php/Home/Role/plDel',
            data: {
                dels: arr,
            },
            success: function (data) {
                if (data == 1) {
                    chked.each(function(){
                        $(this).parent().parent().parent('tr').remove();
                    });
                    layer.msg('批量删除成功!', {icon: 1, time: 1000});
                } else {
                    layer.msg('批量删除失败，请重试!', {icon: 2, time: 1000});
                }
            }
        });
    });

});


/*角色-单个删除*/
function role_del(obj,id){
    layer.confirm('确认要删除吗？',function(index){

        $.ajax({
            type : 'post',
            url : '/shop/index.php/Home/Role/delete/id/'+id,
            success : function(data){

                if(data == 1){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }else{
                    layer.alert('删除失败，请重试！',{
                        title: '提示框',
                        icon:2,
                    });
                }

            }
        });

    });
}
</script>