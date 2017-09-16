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

<title>广告管理</title>
</head>

<body>
<div class=" clearfix" id="advertising">
    <div id="scrollsidebar" class="left_Treeview">
        <div class="show_btn" id="rightArrow"><span></span></div>
        <div class="widget-box side_content" >
            <div class="side_title"><a title="隐藏" class="close_btn"><span></span></a></div>
            <div class="side_list">
                <div class="widget-header header-color-green2">
                    <h4 class="lighter smaller">广告图分类</h4>
                </div>
                <div class="widget-body">
                    <ul class="b_P_Sort_list">
                        <li><i class="orange  fa fa-user-secret"></i><a href="/shop/index.php/Ad/Ad/lst">全部(235)</a></li>
                        <?php foreach($adPosData as $k => $v): ?>
                        <li><i class="fa fa-image pink "></i> <a href="/shop/index.php/Ad/Ad/lst/api/<?php echo $v['id'];?>" <?php echo $_GET['api'] == $v['id'] ? "style='color:orange'":'';?>><?php echo $v['ad_pos_name'];?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="Ads_list">
        <div class="border clearfix">
            <span class="l_f">
                <a href="javascript:ovid()" id="ads_add" class="btn btn-warning"><i class="fa fa-plus"></i> 添加广告</a>
            </span>
            <span class="r_f">共：<b><?php echo count($adData);?></b>条广告</span>
        </div>
        <div class="Ads_lists">
            <table class="table table-striped table-bordered table-hover" id="sample-table">
                <thead>
                    <tr>
                        <th width="80">ID</th>
                        <th width="30">排序</th>
                        <th width="180">广告位</th>
                        <th>图片</th>
                        <th width="250px">链接地址</th>
                        <th width="180">加入时间</th>
                        <th width="70">状态</th>
                        <th width="250">操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($adData as $k => $v): ?>
                    <tr>
                        <td><?php echo $v['id'];?></td>
                        <td width="50px"><input type="text" onblur="sort(this,'<?php echo $v[id];?>')" sort="<?php echo $v['ad_sort'];?>" class="input-text text-c" value="<?php echo $v['ad_sort']; ?>" style="width:40px"></td>
                        <td class="ad_pos_name"><?php echo $v['ad_pos_name'];?></td>
                        <td><img src="<?php echo IMG_URL.$v['ad_image_url']?>"  width="<?php echo $v['ad_pos_width']/3;?>px" height="<?php echo $v['ad_pos_height']/3;?>px"/></td>
                        <td><a href="<?php echo $v['ad_link_url'];?>" target="_blank"><?php echo $v['ad_link_url'];?></a></td>
                        <td><?php echo $v['ad_insert_time'];?></td>
                        <td class="td-status">
                            <?php if($v['ad_show_status'] == '启用'):?>
                                <span class="label label-success radius">启用</span></td>
                            <?php else:?>
                                <span class="label label-defaunt radius">停用</span>
                            <?php endif;?>
                        </td>
                        <td class="td-manage">
                            <?php if($v['ad_show_status'] == '启用'):?>
                                <a onClick="member_stop(this,'<?php echo $v[id];?>')"  href="javascript:;" title="停用"  class="btn btn-xs btn-success"><i class="fa fa-check  bigger-120"></i></a>
                            <?php else:?>
                                <a style="text-decoration:none" class="btn btn-xs " onClick="member_start(this,'<?php echo $v[id];?>')" href="javascript:;" title="启用"><i class="fa fa-close bigger-120"></i></a>
                            <?php endif;?>

                           <a title="编辑"  href="/shop/index.php/Ad/Ad/save/id/<?php echo $v['id'];?>"  class="btn btn-xs btn-info" ><i class="fa fa-edit bigger-120"></i></a>
                            <a title="删除" href="javascript:;"  onclick="rec_del(this,'<?php echo $v[id];?>')" class="btn btn-xs btn-warning" ><i class="fa fa-trash  bigger-120"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--添加广告样式-->
<div id="add_ads_style"  style="display:none">
    <form id="form1" method="post" enctype="multipart/form-data">
    <div class="add_adverts">
        <ul>
            <li>
                <label class="label_name">所属广告位</label>
                <span class="cont_style">
                    <select class="form-control" id="form-field-select-1" name="ad_pos_id" onchange="ajaxGetAdPos(this);">
                        <option value="0">请选择广告位..</option>
                            <?php foreach($adPosData as $k => $v): ?>
                                <option value="<?php echo $v['id'];?>"><?php echo $v['ad_pos_name'];?></option>
                            <?php endforeach; ?>
                    </select>
                </span>
            </li>
            <li><label class="label_name">链接地址</label><span class="cont_style"><input name="ad_link_url" type="text" id="form-field-1" placeholder="格式：http://xxxxxxxx" class="col-xs-10 col-sm-5" style="width:450px"></span></li>
            <li>
                <label class="label_name">状&nbsp;&nbsp;态</label>
                <span class="cont_style">
                &nbsp;&nbsp;<label><input name="ad_show_status" value="启用" type="radio" checked="checked" class="ace"><span class="lbl">启用</span></label>&nbsp;&nbsp;&nbsp;
                <label><input name="ad_show_status" value="停用" type="radio" class="ace"><span class="lbl">停用</span></label></span><div class="prompt r_f"></div>
            </li>
            <li>
                <label class="label_name">图片</label>
                <span class="cont_style">
                    <div class="demo">
                        <div class="logobox">



                        </div>
                        <div class="logoupload">
                            <div class="btnbox"><input type="file" name="ad_image" id="pic"></div>
                            <div class="prompt"><span>图片小于5MB,尺寸<span id="size">1200px*560px</span><br />支持.jpg;.gif;.png;.jpeg格式的图片</span></div>
                        </div>
                    </div>
                </span>
            </li>

        </ul>
    </div>
    </form>
</div>
</body>
</html>
<script>
//初始化宽度、高度  
 $(".widget-box").height($(window).height()); 
 $(".Ads_list").width($(window).width()-220);
  //当文档窗口发生改变时 触发  
    $(window).resize(function(){
	$(".widget-box").height($(window).height());
	 $(".Ads_list").width($(window).width()-220);
	});
	$(function() { 
	$("#advertising").fix({
		float : 'left',
		//minStatue : true,
		skin : 'green',	
		durationTime :false,
		stylewidth:'220',
		spacingw:30,//设置隐藏时的距离
	    spacingh:250,//设置显示时间距
		set_scrollsidebar:'.Ads_style',
		table_menu:'.Ads_list'
	});
});

    //上传图片时，生成url，显示在页面中
$("#pic").change(function(){

    var pic = this.files[0];
    var picUrl = window.URL.createObjectURL(pic);

    $('.logobox').html('<img src="'+picUrl+'" width="100%" height="100%"/>');

});

//排序
function sort(obj,id){
    var num = $(obj).val();
    var old_num = $(obj).attr('sort');
    if(num == 0 || isNaN(num)){
        $(obj).val(old_num);
        layer.msg('更改失败！',{icon:2,time:1000});

        return false;
    }

    $.ajax({
        type : 'post',
        url : '/shop/index.php/Ad/Ad/sort',
        data : {
            num:num,id:id
        },
        success : function (data){
            if(data == 1){
                layer.msg('已更改！',{icon:1,time:1000});
            }else{
                layer.msg('更改失败！',{icon:2,time:1000});
            }
        }
    });
}

    //ajax获取广告位的信息
function ajaxGetAdPos(obj){
    var id = $(obj).val();
    $.ajax({
        type : 'post',
        url : '/shop/index.php/Ad/Ad/ajaxGetAdPos/id/'+id,
        dataType : 'json',
        success : function(response){
            if(response == 1){
                $('#form-field-select-1').find("option[value='0']").removeAttr("selected").attr("selected","selected");
                layer.alert('当前广告位数量已满，您可以停用或删除，以增加数量！',{icon: 2});
            }else{
                $('.logobox').css('width',response.ad_pos_width/2+'px').css('height',response.ad_pos_height/2+'px');
                $('#size').html(response.ad_pos_width+'px*'+response.ad_pos_height+'px');
            }

        }
    });
}

/*停用*/
function member_stop(obj,id){
    layer.confirm('确认要停用吗？',function(index){
        $.ajax({
            type : 'post',
            url : '/shop/index.php/Ad/Ad/setStatus',
            data : {
                id : id,
                status : 0,
            },
            success : function(data){
                if(data == 1){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs " onClick="member_start(this,'+id+')" href="javascript:;" title="启用"><i class="fa fa-close bigger-120"></i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">停用</span>');
                    $(obj).remove();
                    layer.msg('已停用!',{icon: 5,time:1000});
                }else{
                    layer.msg('停用失败，请刷新重试!',{icon: 5,time:1000});
                }
            }
        });
    });
}

/*启用*/
function member_start(obj,id){

    layer.confirm('确认要启用吗？',function(index){
        $.ajax({
            type : 'post',
            url : '/shop/index.php/Ad/Ad/setStatus',
            data : {
                id : id,
                status : 1,
            },
            success : function(data){
                if(data == 1){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs btn-success" onClick="member_stop(this,'+id+')" href="javascript:;" title="停用"><i class="fa fa-check bigger-120"></i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">启用</span>');
                    $(obj).remove();
                    layer.msg('已启用!',{icon: 6,time:1000});
                }else if(data = 3){
                    layer.alert('“'+$(obj).parents('tr').find('.ad_pos_name').text()+'”广告位数量已满，停用或删除，以增加数量！',{icon: 2});
                }else{
                    layer.msg('启用失败，请刷新重试!',{icon: 5,time:1000});
                }
            }
        });

    });
}

/*单个删除*/
function rec_del(obj,id){
    layer.confirm('确认要删除吗？',function(index){
        $.ajax({
            type : 'post',
            url : '/shop/index.php/Ad/Ad/delete/id/'+id,
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


/*******添加广告*********/
 $('#ads_add').on('click', function(){
	  layer.open({
        type: 1,
        title: '添加广告',
		maxmin: true,
		shadeClose: false, //点击遮罩关闭层
        area : ['800px' , ''],
        content:$('#add_ads_style'),
		btn:['提交','取消'],
		yes:function(index,layero){
            var form = new FormData($('#form1')[0]);
            $.ajax({
                type : 'post',
                url : '/shop/index.php/Ad/Ad/add',
                data : form,
                /*********后两行是关键，使用formdata传值，必须加这两行*********/
                processData: false,  // 告诉jQuery不要去处理发送的数据
                contentType: false,   // 告诉jQuery不要去设置Content-Type请求
                dataType : 'json',
                success : function(response){


                    if(response.status){
                        layer.msg(response.result,{icon:1,time:1000},function(){
                            location.reload();
                        });
                    }else{
                        layer.alert(response.result,{icon: 2});
                    }



                }
            });
		}
    });
})
</script>

<script>
jQuery(function($) {
				var oTable1 = $('#sample-table').dataTable( {
				"aaSorting": [[ 0, "desc" ]],//默认第几个排序
		"bStateSave": true,//状态保存
		"aoColumnDefs": [
		  //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
		  {"orderable":false,"aTargets":[1,2,3,4,6,7]}// 制定列不参与排序
		] } );
				

			})
</script>