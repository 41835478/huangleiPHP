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
        <link rel="stylesheet" href="/shop/Public/assets/css/ace.min.css" />
        <link rel="stylesheet" href="/shop/Public/assets/css/font-awesome.min.css" />
        <link href="/shop/Public/Widget/icheck/icheck.css" rel="stylesheet" type="text/css" />
		<!--[if IE 7]>
		  <link rel="stylesheet" href="/shop/Public/assets/css/font-awesome-ie7.min.css" />
		<![endif]-->
        <!--[if lte IE 8]>
		  <link rel="stylesheet" href="/shop/Public/assets/css/ace-ie.min.css" />
		<![endif]-->
	    <script src="/shop/Public/js/jquery-1.9.1.min.js"></script>   
        <script src="/shop/Public/assets/js/bootstrap.min.js"></script>
        <script src="/shop/Public/assets/js/typeahead-bs2.min.js"></script>
		<!-- page specific plugin scripts -->
		<script src="/shop/Public/assets/js/jquery.dataTables.min.js"></script>
		<script src="/shop/Public/assets/js/jquery.dataTables.bootstrap.js"></script>
        <script type="text/javascript" src="/shop/Public/js/H-ui.js"></script> 
        <script type="text/javascript" src="/shop/Public/js/H-ui.admin.js"></script> 
        <script src="/shop/Public/assets/layer/layer.js" type="text/javascript" ></script>
        <script src="/shop/Public/assets/laydate/laydate.js" type="text/javascript"></script>
        <script src="/shop/Public/js/lrtk.js" type="text/javascript" ></script>
<title>产品列表</title>
</head>
<body>
<div class=" page-content clearfix">
 <div id="products_style">
    <div class="search_style">
      <div class="title_names">搜索查询</div>
        <form action="/shop/index.php/Goods/Goods/lst" method="get">
              <ul class="search_content clearfix">
               <li><label class="l_f">产品名称</label><input name="goods_name" type="text"  class="text_add" placeholder="输入关键字"  value="<?php echo $_GET['goods_name'];?>" style=" width:250px"/></li>
               <li><label class="l_f">分类</label><input name="cat" type="text"  class="text_add" placeholder="输入分类名称"  value="<?php echo $_GET['cat'];?>" style=" width:100px"/></li>
               <li><label class="l_f">品牌</label><input name="brand" type="text"  class="text_add" placeholder="输入品牌名称"  value="<?php echo $_GET['brand'];?>" style=" width:100px"/></li>
               <li style="width:90px;"><button type="subimt" class="btn_search"><i class="icon-search"></i>查询</button></li>
              </ul>
        </form>

    </div>

     <div class="border clearfix">
       <span class="l_f">
           <!-- 店铺 -->
        <i class="icon-home"  style="font-size: 20px;"></i>
        <span style="display:inline-block;font-size: 20px;">店铺：</span>
        <span style="display:inline-block;font-size: 15px;color:blue;">
            <?php if($store['store_name'] != ""){echo $store['store_name'].'('.$store['store_status'].')';}else{echo "无店铺信息";}?>
        </span>
           <?php if($store['store_name'] != ""){?>
               <?php if($store['business_status'] == '营业中'){ ?>
                    <a onClick="store_stop(this,'<?php echo $store[id]?>')"  href="javascript:;" title="打烊"  class="btn btn-xs btn-success">营业中</a>
               <?php }else{?>
                    <a style="text-decoration:none" class="btn btn-xs" onClick="store_start(this,'<?php echo $store[id]?>')" href="javascript:;" title="营业">已打烊</a>
               <?php }?>
           <?php }?>
        <a href="/shop/index.php/Goods/Goods/add" title="添加商品" class="btn btn-warning Order_form"><i class="icon-plus"></i>添加商品</a>
        <a href="<?php echo U('recommend/pending_rec');?>" title="推荐申请" class="btn btn-danger Order_form"><i class="icon-plus"></i>推荐申请</a>
        <a href="<?php echo U('Store/Store/save',array('id'=>$store[id]));?>" title="店铺修改" class="btn btn-info Order_form"><i class="icon-edit"></i>店铺修改</a>



       </span>
       <span class="r_f">共：<b><?php echo count($goodsData);?></b>件商品</span>
     </div>
     <!--产品列表展示-->
     <div class="h_products_list clearfix" id="products_list">
         <div id="scrollsidebar" class="left_Treeview">

            <div class="show_btn" id="rightArrow"><span></span></div>

            <div class="widget-box side_content" >

                <div class="side_title"><a title="隐藏" class="close_btn"><span></span></a></div>

                <div class="side_list"><div class="widget-header header-color-green2"><h4 class="lighter smaller">产品类型列表</h4></div>

                    <div class="widget-body">

                            <ul class="b_P_Sort_list">
                                <li><i class="orange icon-folder-close"></i></i><a href="/shop/index.php/Goods/Goods/lst">全部</a></li>
                                <?php foreach($typeData as $k => $v): ?>
                                    <li><i class="icon-file-text grey"></i> <a href="/shop/index.php/Goods/Goods/lst/tid/<?php echo $v['id']; ?>" <?php echo $_GET['tid'] == $v['id'] ? "style='color:orange'":'';?>><?php echo $v['type_name']; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                     </div>

                </div>
            </div>
         </div>
         <div class="table_menu_list" id="testIframe">
       <table class="table table-striped table-bordered table-hover" id="sample-table">
		<thead>


		 <tr>

				<th width="120px">产品编号</th>
				<th width="250px">产品名称</th>
				<th width="100px">零售价</th>
				<th width="100px">本店价</th>
                <th width="90px">商品分类</th>
                <th width="90px">商品类型</th>
				<th width="100px">审核状态</th>
				<th width="70px">状态</th>
				<th width="200px">操作</th>
			</tr>
		</thead>
	<tbody>
    <?php foreach($goodsData as $k => $v): ?>
     <tr>

        <td width="80px"><?php echo $v['goods_number'];?></td>
        <td width="250px"><u style="cursor:pointer" class="text-primary"><a href="/shop/index.php/Goods/Goods/goods_detailed/id/<?php echo $v['id'];?>"  class="Order_form" title="<?php echo $v['goods_title'];?>"><?php echo $v['goods_title'];?></a></u></td>
        <td width="100px"><?php echo $v['goods_retail_price'];?></td>
        <td width="100px"><?php echo $v['goods_shop_price'];?></td>
        <td width="90px"><?php echo $v['cat_name'];?></td>
        <td width="90px"><?php echo $v['type_name'] !="" ? $v['type_name'] : '无';?></td>
        <td width="70px"><?php echo $v['pending_status'];?></td>
        <td class="td-status">
            <?php if($v['is_sell'] == '是'){ ?>
                <span class="label label-success radius">上架中</span>
            <?php }else{ ?>
                <span class="label label-defaunt radius">已下架</span>
            <?php }?>
        </td>
        <td class="td-manage">
            <?php if($v['pending_status'] == '通过审核'){?>
                <?php if($v['is_sell'] == '是'){ ?>
                    <a onClick="member_stop(this,'<?php echo $v[id]?>')"  href="javascript:;" title="下架"  class="btn btn-xs btn-success"><i class="icon-ok bigger-120"></i></a>
                <?php }else{?>
                    <a style="text-decoration:none" class="btn btn-xs" onClick="member_start(this,'<?php echo $v[id]?>')" href="javascript:;" title="上架"><i class="icon-remove bigger-120"></i></a>
                <?php }?>

        <a title="库存" href="/shop/index.php/Goods/Goods/stock/id/<?php echo $v['id'];?>"   class="btn btn-xs btn-warning"><i class="icon-shopping-cart bigger-120"></i></a>
            <?php }?>
        <a title="编辑"  href="/shop/index.php/Goods/Goods/save/id/<?php echo $v['id']?>" class="btn btn-xs btn-info" ><i class="icon-edit bigger-120"></i></a>
        <a title="删除" href="javascript:;"  onclick="member_del(this,'<?php echo $v[id];?>')" class="btn btn-xs btn-danger" ><i class="icon-trash  bigger-120"></i></a>
       </td>
	  </tr>
    <?php endforeach; ?>


    </tbody>
    </table>
    </div>     
  </div>
 </div>
</div>
</body>
</html>
<script>
jQuery(function($) {
		var oTable1 = $('#sample-table').dataTable( {
		"aaSorting": [[ 0, "desc" ]],//默认第几个排序
		"bStateSave": true,//状态保存
		"aoColumnDefs": [
        {"orderable":false,"aTargets":[1,4,5,6,7,8]}// 制定列不参与排序
		] } );
});

$(function() { 
	$("#products_style").fix({
		float : 'left',
		//minStatue : true,
		skin : 'green',	
		durationTime :false,
		spacingw:30,//设置隐藏时的距离
	    spacingh:260,//设置显示时间距
	});
});
</script>
<script type="text/javascript">
//初始化宽度、高度  
 $(".widget-box").height($(window).height()-215); 
$(".table_menu_list").width($(window).width()-260);
 $(".table_menu_list").height($(window).height()-215);
  //当文档窗口发生改变时 触发  
    $(window).resize(function(){
	$(".widget-box").height($(window).height()-215);
	 $(".table_menu_list").width($(window).width()-260);
	  $(".table_menu_list").height($(window).height()-215);
	})
 

/*产品-停用*/
function member_stop(obj,id) {


    layer.confirm('确认要下架吗？', function (index) {
        $.ajax({
            type: 'post',
            url: '/shop/index.php/Goods/Goods/setStatus',
            data: {
                id: id,
                status: 0,
            },
            success: function (data) {
                if (data == 1) {
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs " onClick="member_start(this,'+id+')" href="javascript:;" title="上架"><i class="icon-remove bigger-120"></i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已下架</span>');
                    $(obj).remove();
                    layer.msg('已下架', {icon: 5, time: 1000});
                } else {
                    layer.msg('下架失败，请刷新重试!', {icon: 5, time: 1000});
                }
            }
        });
    });
}

/*产品-启用*/
function member_start(obj,id){

    layer.confirm('确认要上架吗？',function(index){
        $.ajax({
            type : 'post',
            url : '/shop/index.php/Goods/Goods/setStatus',
            data : {
                id : id,
                status : 1,
            },
            success : function(data){
                if(data == 1){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs btn-success" onClick="member_stop(this,'+id+')" href="javascript:;" title="下架"><i class="icon-ok bigger-120"></i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">上架中</span>');
                    $(obj).remove();
                    layer.msg('已上架',{icon: 6,time:1000});
                }else{
                    layer.msg('上架失败，请刷新重试!',{icon: 5,time:1000});
                }
            }
        });

    });


}

/*店铺-打烊*/
function store_stop(obj,id) {


    layer.confirm('确认要打烊吗？', function (index) {
        $.ajax({
            type: 'post',
            url: '/shop/index.php/Goods/Goods/setStoreStatus',
            data: {
                id: id,
                status: 0,
            },
            success: function (data) {
                if (data == 1) {
                    $(obj).attr('onclick',"store_start(this,"+id+")").attr('title','营业').removeClass('btn-success').text('已打烊');
                    layer.msg('已打烊', {icon: 5, time: 1000});
                } else {
                    layer.msg('打烊失败，请刷新重试!', {icon: 5, time: 1000});
                }
            }
        });
    });
}

/*店铺- 营业*/
function store_start(obj,id){

    layer.confirm('确认要营业吗？',function(index){
        $.ajax({
            type : 'post',
            url : '/shop/index.php/Goods/Goods/setStoreStatus',
            data : {
                id : id,
                status : 1,
            },
            success : function(data){
                if(data == 1){
                    $(obj).attr('onclick',"store_stop(this,"+id+")").attr('title','打烊').addClass('btn-success').text('营业中');
                    layer.msg('已营业',{icon: 6,time:1000});
                }else{
                    layer.msg('营业失败，请刷新重试!',{icon: 5,time:1000});
                }
            }
        });

    });


}

function member_del(obj,id){
    layer.confirm('确认要删除吗？',function(index){
        $.ajax({
            url : '/shop/index.php/Goods/Goods/delete/id/'+id,
            success : function(data){
                if(data == 1){
                    $(obj).parents("tr").remove();
                    layer.msg('删除成功！',{icon:1,time:1000});
                }else{
                    layer.msg('删除失败，刷新重试！',{icon:2,time:1000});
                }
            }
        });


    });
}
//面包屑返回值
var index = parent.layer.getFrameIndex(window.name);
parent.layer.iframeAuto(index);
$('.Order_form').on('click', function(){
	var cname = $(this).attr("title");
	var chref = $(this).attr("href");
	var cnames = parent.$('.Current_page').html();
	var herf = parent.$("#iframe").attr("src");
    parent.$('#parentIframe').html(cname);
    parent.$('#iframe').attr("src",chref).ready();;
	parent.$('#parentIframe').css("display","inline-block");
	parent.$('.Current_page').attr({"name":herf,"href":"javascript:void(0)"}).css({"color":"#4c8fbd","cursor":"pointer"});
	//parent.$('.Current_page').html("<a href='javascript:void(0)' name="+herf+" class='iframeurl'>" + cnames + "</a>");
    parent.layer.close(index);
	
});
</script>