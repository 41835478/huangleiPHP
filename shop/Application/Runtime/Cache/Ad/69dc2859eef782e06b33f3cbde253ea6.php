<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
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
<script src="/shop/Public/assets/js/typeahead-bs2.min.js"></script>
<script src="/shop/Public/js/lrtk.js" type="text/javascript" ></script>
<script src="/shop/Public/assets/js/jquery.dataTables.min.js"></script>
<script src="/shop/Public/assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="/shop/Public/assets/layer/layer.js" type="text/javascript" ></script>
<title>广告位管理</title>
</head>

<body>
<div class="page-content clearfix">
    <div class="sort_style">
        <div class="border clearfix">
            <span class="l_f">
                <a href="javascript:ovid()" id="sort_add" class="btn btn-warning"><i class="fa fa-plus"></i> 添加广告位</a>
                <a href="javascript:ovid()" class="btn btn-danger" id="pl"><i class="fa fa-trash"></i> 批量删除</a>
            </span>
            <span class="r_f">共：<b><?php echo count($recData);?></b>类</span>
        </div>
        <div class="sort_list">
            <table class="table table-striped table-bordered table-hover" id="sample-table">
                <thead>
                    <tr>
                        <th width="50px"><label><input type="checkbox" onclick="t()" class="ace" id="chk1"><span class="lbl"></span></label></th>
                        <th width="50px">ID</th>
                        <th width="200px">广告位名称</th>
                        <th width="100px">广告位宽度</th>
                        <th width="100px">广告位高度</th>
                        <th width="80px">广告位限制个数</th>
                        <th width="100px">操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($adData as $k => $v): ?>
                    <tr>
                        <td class="center">
                            <label><input type="checkbox" class="ace chk2" name="dels[]" value="<?php echo $v['id'];?>"><span class="lbl"></span></label>
                        </td>
                        <td><?php echo $v['id'];?></td>
                        <td><?php echo $v['ad_pos_name'];?></td>
                        <td><?php echo $v['ad_pos_width'];?>px</td>
                        <td><?php echo $v['ad_pos_height'];?>px</td>
                        <td><?php echo $v['ad_pos_limit'];?></td>
                        <td class="td-manage">
                            <a title="编辑" href="/shop/index.php/Ad/AdPos/save/id/<?php echo $v['id'];?>"  class="btn btn-xs btn-info" ><i class="fa fa-edit bigger-120"></i></a>
                            <a title="删除" href="javascript:;"  onclick="rec_del(this,'<?php echo $v[id];?>')" class="btn btn-xs btn-warning" ><i class="fa fa-trash  bigger-120"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--添加推荐-->
<div class="sort_style_add margin" id="sort_style_add" style="display:none">
    <form id="form1">
  <div class="">
     <ul>
      <li><label class="label_name">广告位名称</label><div class="col-sm-8"><input name="ad_pos_name" type="text" id="form-field-1" placeholder="输入广告位名称" class="col-xs-10 col-sm-5"></div></li>
      <li><label class="label_name">广告位宽度</label><div class="col-sm-8"><input name="ad_pos_width" type="text" id="form-field-1" placeholder="输入广告位宽度" class="col-xs-10 col-sm-5"></div></li>
      <li><label class="label_name">广告位高度</label><div class="col-sm-8"><input name="ad_pos_height" type="text" id="form-field-1" placeholder="输入广告位高度" class="col-xs-10 col-sm-5"></div></li>
      <li><label class="label_name">广告位限制个数</label><div class="col-sm-8"><input name="ad_pos_limit" type="text" id="form-field-1" placeholder="输入广告位限制个数" class="col-xs-10 col-sm-5"></div></li>

     </ul>
  </div>
    </form>
</div>
</body>
</html>
<script type="text/javascript">
$('#sort_add').on('click', function(){
    layer.open({
        type: 1,
        title: '添加广告位',
        maxmin: true,
        shadeClose: false, //点击遮罩关闭层
        area : ['750px' , ''],
        content:$('#sort_style_add'),
        btn:['提交','取消'],
        yes:function(index,layero){

            var r = /^[0-9]*[1-9][0-9]*$/;

            var v = $("input[name='ad_pos_limit']").val();
            if(!r.test(v)){
                layer.alert("限制个数必须为正整数！",{icon:2});
                return false;
            }


            $.ajax({
                type : 'post',
                url : '/shop/index.php/Ad/AdPos/add',
                data : $('#form1').serialize(),
                success : function(response){
                    if(response.status){
                        layer.msg(response.result,{icon:1,time:1000},function(){
                            location.href="/shop/index.php/Ad/AdPos/lst";
                        });
                    }else{
                        layer.alert(response.result,{icon:2,time:1000});
                    }
                }
            });
        }
    });
})

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
            url: '/shop/index.php/Ad/AdPos/plDel',
            data: {
                dels: arr,
            },
            success: function (response) {
                if (response.status) {
                    chked.each(function(){
                        $(this).parent().parent().parent('tr').remove();
                    });
                    layer.msg(response.result, {icon: 1, time: 1000});
                } else {
                    layer.msg(response.result, {icon: 2, time: 1000});
                }
            }
        });
    });

});


/*角色-单个删除*/
function rec_del(obj,id){
    layer.confirm('确认要删除吗？',function(index){
        $.ajax({
            type : 'post',
            url : '/shop/index.php/Ad/AdPos/delete/id/'+id,
            success : function(response){

                if(response.status){
                    $(obj).parents("tr").remove();
                    layer.msg(response.result,{icon:1,time:1000});
                }else{
                    layer.alert(response.result,{
                        title: '提示框',
                        icon:2,
                    });
                }

            }
        });

    });
}


//面包屑返回值
var index = parent.layer.getFrameIndex(window.name);
parent.layer.iframeAuto(index);
$('.Order_form ,.ads_link').on('click', function(){
	var cname = $(this).attr("title");
	var cnames = parent.$('.Current_page').html();
	var herf = parent.$("#iframe").attr("src");
    parent.$('#parentIframe span').html(cname);
	parent.$('#parentIframe').css("display","inline-block");
    parent.$('.Current_page').attr("name",herf).css({"color":"#4c8fbd","cursor":"pointer"});
	//parent.$('.Current_page').html("<a href='javascript:void(0)' name="+herf+">" + cnames + "</a>");
    parent.layer.close(index);
	
});

</script>
<script type="text/javascript">
jQuery(function($) {
				var oTable1 = $('#sample-table').dataTable( {
				"aaSorting": [[ 1, "desc" ]],//默认第几个排序
		"bStateSave": false,//状态保存
		"aoColumnDefs": [
		  //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
		  {"orderable":false,"aTargets":[0,2,3,4,5,6]}// 制定列不参与排序
		] } );

			})
</script>