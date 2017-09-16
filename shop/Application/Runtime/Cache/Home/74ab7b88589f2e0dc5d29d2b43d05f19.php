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
<title>管理权限</title>
</head>

<body>
 <div class="margin clearfix">
   <div class="border clearfix">
       <form action="/shop/index.php/Home/Privilege/plDel" method="post" id="form">
       <span class="l_f">
        <a href="/shop/index.php/Home/Privilege/add" id="Competence_add" class="btn btn-warning" title="添加权限"><i class="fa fa-plus"></i> 添加权限</a>
       </span>
       <span class="r_f">共：<b><?php echo count($data);?></b>个权限</span>
     </div>
     <div class="compete_list">

       <table id="sample-table-1" class="table table-striped table-bordered table-hover">
		 <thead>
			<tr>
                <th>id</th>
                <th style="text-align: left">权限名称</th>

			  <th>模块名称</th>
			  <th>控制器名称</th>
			  <th>方法名称</th>
                <th class="hidden-480">描述</th>
			  <th>父级id</th>

			  <th class="hidden-480">操作</th>
             </tr>
		    </thead>
             <tbody>
             <?php foreach($data as $k => $v):?>
			  <tr pi="<?php echo $v['parent_id'];?>">
                  <td><?php echo $v['id']?></td>
				<td style="text-align: left"><?php echo str_repeat('-',$v['level']*8).$v['pri_name']?></td>

				<td><?php echo $v['module_name']?></td>
				<td class="hidden-480"><?php echo $v['controller_name']?></td>
				<td><?php echo $v['action_name']?></td>
				<td><?php echo $v['content']?></td>
				<td><?php echo $v['parent_id']?></td>
				<td>
                 <a title="修改权限" href="/shop/index.php/Home/Privilege/save/id/<?php echo $v['id']; ?>"  id="Competence_save" class="btn btn-xs btn-info" ><i class="fa fa-edit bigger-120"></i></a>
                 <a title="删除" href="javascript:void(0);" onclick="pri_del(this,'<?php echo $v[id];?>')" class="btn btn-xs btn-warning" ><i class="fa fa-trash  bigger-120"></i></a>
				</td>
			   </tr>
             <?php endforeach;?>
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
$('.Order_form ,#Competence_add ,#Competence_save').on('click', function(){
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

    function sub(){
        $('#form').submit();
    }

/*角色-单个删除*/
function pri_del(obj,id){

    var tr = $(obj).parent('td').parent('tr');
    var trId = $(obj).parent('td').parent('tr').children('td').first().text();


    layer.confirm('确认要删除吗？',function(index){

        $.ajax({
            type : 'post',
            url : '/shop/index.php/Home/Privilege/delete/',
            data : {
                id : id,
            },
            success : function(data){

                if(data == 1){
                    layer.msg('已删除!',{icon:1,time:1000});
                    $.each(tr.next('tr'),function(k,v){
                        if($(this).attr('pi') == trId){
                            $(this).remove();
                        }
                    });
                    tr.remove();
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