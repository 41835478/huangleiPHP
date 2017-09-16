<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
    <meta http-equiv="Expires" CONTENT="0">
    <meta http-equiv="Cache-Control" CONTENT="no-cache">
    <meta http-equiv="Pragma" CONTENT="no-cache">

    <meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/shop/Public/js/html5.js"></script>
<script type="text/javascript" src="/shop/Public/js/respond.min.js"></script>
<script type="text/javascript" src="/shop/Public/js/PIE_IE678.js"></script>
<![endif]-->
<link href="/shop/Public/assets/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="/shop/Public/css/style.css"/>       
<link rel="stylesheet" href="/shop/Public/assets/css/ace.min.css" />
<link rel="stylesheet" href="/shop/Public/assets/css/font-awesome.min.css" />

<link rel="stylesheet" type="text/css" href="/shop/Public/Widget/webuploader/css/webuploader.css" />
<link rel="stylesheet" type="text/css" href="/shop/Public/Widget/webuploader/css/style.css" />

<title>新增商品</title>
</head>
<script type="text/javascript">
    window.UEDITOR_HOME_URL = '/shop/Public/Widget/Data/';
    window.onload = function(){
        window.UEDITOR_CONFIG.toolbars= [[

            'bold', 'italic', 'underline', '|', 'forecolor', 'backcolor',  '|', 'fontfamily', 'fontsize', '|',

            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|','insertimage','insertvideo','link'

        ]];
        UE.getEditor('editor');
    }

</script>
<body>
<div class="clearfix" id="add_picture" style="width:100%">

   <div class="page_right_style" style="width:100%;left:0px;">
   <div class="type_title" style="width:100%;">添加商品基本信息</div>
	<form class="form form-horizontal" enctype="multipart/form-data" method="post" id="form-article-add">

        <div class="clearfix cl">
            <label class="form-label col-2">商品封面：</label>
            <div class="formControls col-10">
                <div class="demo l_f">
                <div class="logobox">
                    <div class="resizebox" style="width:100px;height:100px;border:1px solid green;margin-bottom:10px;">
                        <img src="/shop/Public/images/image.png" width="95px" alt="" height="95px"/>
                    </div>
                    <input id="pic" type="file" name="goods_logo" />
                </div>
                <div class="prompt"><p style="font-size: 12px;color:red;">图片大小210px*210px,图片大小小于5MB,支持.jpg;.gif;.png;.jpeg格式的图片</p></div>
                </div>
            </div>
      </div>
		<div class="clearfix cl">
         <label class="form-label col-2">商品标题：</label>
		 <div class="formControls col-10"><input type="text" class="input-text" value="" name="goods_title" placeholder="商品的标题"/></div>
		</div>
		<div class=" clearfix cl">
         <label class="form-label col-2">简略标题：</label>
	     <div class="formControls col-10"><input type="text" class="input-text" name="goods_jl_title" placeholder="商品的简略标题，建议十个字以下"/></div>
		</div>
        <div class=" clearfix cl">
            <label class="form-label col-2">关键词：</label>
            <div class="formControls col-10"><input type="text" class="input-text" name="keywords" placeholder="请输入商品的关键词，多个请用“,”隔开"/></div>
        </div>
        <div class="clearfix cl">
            <label class="form-label col-2">商品品牌：</label>
            <div class="formControls col-10">
                <select name="brand_id">
                    <option value="0">请选择商品品牌</option>
                    <?php foreach($brandData as $k => $v): ?>
                    <option value="<?php echo $v['id'];?>"><?php echo $v['brand_name']; ?></option>
                    <?php endforeach; ?>
                </select>

            </div>
        </div>
        <div class="clearfix cl">
            <label class="form-label col-2">商品分类：</label>
            <div class="formControls col-10">
                <select name="cat_id">
                    <option value="0">请选择商品分类</option>
                    <?php foreach($catData as $k => $v): ?>
                    <option value="<?php echo $v['id'];?>"><?php echo str_repeat('-',$v['level']*8).$v['cat_name']?></option>
                    <?php endforeach; ?>
                </select>

            </div>
        </div>
		<div class=" clearfix cl">
			
			<div class="Add_p_s">
            <label class="form-label col-2">零售价：</label>
			<div class="formControls col-2"><input type="text" class="input-text" name="goods_retail_price">元</div>
            </div>
			<div class="Add_p_s">
             <label class="form-label col-2">本店价：</label>
			 <div class="formControls col-2"><input type="text" class="input-text" name="goods_shop_price">元</div>
			</div>



		</div>


        <div class="clearfix cl">
            <label class="form-label col-2">商品类型：</label>
            <div class="formControls col-10">
                <select name="type_id" onchange="ajaxGetAttr();">
                    <option value="0">无商品类型</option>
                    <?php foreach($typeData as $k => $v): ?>
                        <option value="<?php echo $v['id']; ?>"><?php echo $v['type_name']; ?></option>
                    <?php endforeach; ?>
                </select>

            </div>
        </div>

        <div class="clearfix cl">

            <div class="col-xs-2">
                <label class="form-label" style="padding-right:12px;">类型对应属性：</label>
            </div>
            <div class="col-xs-10" id="type_attr">
                目前暂无。此处的属性会随商品类型变化，若无商品类型，可不选。
            </div>

        </div>
         <div class="clearfix cl">
            <label class="form-label col-2">产品信息：</label>
			<div class="formControls col-10">
                <textarea id="editor" name="goods_infomation" style="width:100%;height:400px;"></textarea>
             </div>
        </div>


		<div class="clearfix' cl">
			<div class="Button_operation">
                <a onClick="goods_add_submit();" class="btn btn-primary radius" id="submit1"><i class="icon-save "></i>提交并下一步</a>
				<!--<button onClick="goods_add_submit();" class="btn btn-primary radius" ><i class="icon-save "></i>提交并下一步</button>-->
			</div>
		</div>
	</form>
    </div>
</div>
</div>
<script src="/shop/Public/js/jquery-1.9.1.min.js"></script>


<script src="/shop/Public/assets/js/bootstrap.min.js"></script>
<script src="/shop/Public/assets/layer/layer.js" type="text/javascript" ></script>
<script src="/shop/Public/assets/laydate/laydate.js" type="text/javascript"></script>


<!------   ueditor  ----------->
<script type="text/javascript" src="/shop/Public/Widget/Data/ueditor.config.js"></script>
<script type="text/javascript" src="/shop/Public/Widget/Data/ueditor.all.min.js"> </script>

<script>
    $("#pic").change(function(){

        var pic = this.files[0];
        //console.log(pic);		//调试js代码，可以显示出object中的信息
        var picUrl = window.URL.createObjectURL(pic);

        $('.resizebox').html('<img src="'+picUrl+'" width="98px" height="98px" />');

    });

    function goods_add_submit(){
        layer.confirm('提交后，将不再更改，确定吗？', {
            btn: ['是的，我已决定','还没想好'] //按钮
        }, function(){
            $('#submit1').attr('disabled',true);
            var form = new FormData($('#form-article-add')[0]);
            $.ajax({
                type : 'post',
                url : "/shop/index.php/Goods/Goods/add",
                data : form,
                dataType : 'json',
                /*********后两行是关键，使用formdata传值，必须加这两行*********/
                processData: false,  // 告诉jQuery不要去处理发送的数据
                contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
                success : function(response){

                    if(response.status){
                            //删除掉最后一条访问记录，会消除掉后退按钮，不过仍然存在bug
                        location.replace("/shop/index.php/Goods/Goods/addImage");
                        $('#submit1').attr('disabled',false);
                    }else{
                        layer.alert(response.result, {icon: 2});
                        $('#submit1').attr('disabled',false);
                    }


                }
            });
        }, function(){
            layer.msg('您可以继续修改', {icon: 6});
        });


    }


        /*********************点击 加号， 添加新属性****************************/
    function addNewAttr(obj){

        if($(obj).attr('class') == 'icon-plus'){
            var newAttr = $(obj).parent().parent().first().clone();
            newAttr.find('i').removeClass('icon-plus').addClass('icon-minus');
            $(obj).parent().parent().first().after(newAttr);
        }else{
            $(obj).parent().parent().first().remove();
        }
    }

    /**
     *
     *
     * 添加属性这里，必须写成函数的形式，如果写成click点击事件，新增后的内容的点击事件是不可用的
     */
    //$('.add_attribute').click(function(){
    //    var className = $(this).attr('class');
    //    if(className == 'icon-plus add_attribute'){
    //        var thisParent = $(this).parent().parent().first();
    //        var cloneThisAttr = thisParent.clone();
    //        thisParent.after(cloneThisAttr);
    //    }else{
    //        alert('456');
    //    }
    //});

    function ajaxGetAttr(){

        var type_id = $("select[name='type_id']").val();

        if(type_id == 0){
            $('#type_attr').html('');
            return false;
        }


        $.ajax({
            type : 'post',
            url : '/shop/index.php/Goods/Goods/ajaxGetAttr/tid/'+type_id,
            dataType : 'json',
            success : function(response){

                if(response.status){
                    var str = "";
                    $.each(response.result,function(k,v){
                        if(v.attr_type == "单选"){
                            str += "<div class='form-group' style='width:100%;'>";
                            str += "<label class='form-label col-2'>"+v.attr_name+"：</label>";
                            str += "<div class='formControls col-2'>";
                            str += "<select name='goods_attr["+v.id+"][]'>";

                                    //将属性可选值，以逗号形式拆分
                            var arr = v.attr_values.split(',');
                            for(var i = 0; i < arr.length; i++){
                                str += "<option>"+arr[i]+"</option>";
                            }
                            str += "</select>";
                            str += "&nbsp;<i class='icon-plus' onclick='addNewAttr(this)' style='cursor: pointer'></i>&nbsp;";
                            str += "<input type='text' class='input-text' placeholder='额外加价，默认为0' value='0' name='attr_price[]' style='width:150px;display: inline'>元(额外加价，默认为0，不加价)";

                            str += "</div>";
                            str += "</div>";
                        }else{
                            if(v.attr_values == ""){
                                str += "<div class='form-group' style='width:100%;'>";
                                str += "<label class='form-label col-2'>"+v.attr_name+"：</label>";
                                str += "<div class='formControls col-2'>";
                                str += "<input type='text' class='input-text' placeholder='输入文字' name='goods_attr["+v.id+"]' style='width:150px;display: inline'>&emsp;";
                                str += "<input type='text' class='input-text' placeholder='额外加价，默认为0' value='0' name='attr_price[]' style='width:150px;display: inline'>元(额外加价，默认为0，不加价)";
                                str += "</div>";
                                str += "</div>";
                            }else{
                                str += "<div class='form-group' style='width:100%;'>";
                                str += "<label class='form-label col-2'>"+v.attr_name+"：</label>";
                                str += "<div class='formControls col-2'>";
                                str += "<select name='goods_attr["+v.id+"]'>";

                                //将属性可选值，以逗号形式拆分
                                var arr = v.attr_values.split(',');
                                for(var i = 0; i < arr.length; i++){
                                    str += "<option>"+arr[i]+"</option>";
                                }
                                str += "</select>&emsp;";
                                str += "<input type='text' class='input-text' placeholder='额外加价，默认为0' value='0' name='attr_price[]' style='width:150px;display: inline'>元(额外加价，默认为0，不加价)";

                                str += "</div>";
                                str += "</div>";
                            }



                        }

                    });

                    $('#type_attr').html(str);

                }else{
                    layer.alert(response.result,{
                        title: '提示框',
                        icon:2,
                    });
                }
            }
        });

    }
</script>


<script>

$( document).ready(function(){
//初始化宽度、高度
  
   $(".widget-box").height($(window).height()); 
   $(".page_right_style").height($(window).height()); 
   //$(".page_right_style").width($(window).width()-220);
  //当文档窗口发生改变时 触发  
    $(window).resize(function(){

	 $(".widget-box").height($(window).height()); 
	 $(".page_right_style").height($(window).height()); 
	 //$(".page_right_style").width($(window).width()-220);
	});	
});

</script>
</body>
</html>