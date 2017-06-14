<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <title>黄磊个人博客</title>
</head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/blog/Public/Index/css/bootstrap.min.css">

<script src="/blog/Public/Index/js/bootstrap.min.js"></script>

<link rel="shortcut icon" type="image/x-icon" href="/blog/Public/Index/images/icon.ico" media="screen" />
<script src="/blog/Public/Admin/js/jquery-1.9.1.min.js"></script>
<link rel="stylesheet" href="/blog/Public/Index/css/style.css">
<body>
<div class="jumbotron">

    <div class="container header">
        <!-- ===================================header start=============================================== -->
        <div class="col-xs-12">
            <a href="/blog">
                <h1 class="title">黄磊个人博客</h1>
                <p class="title_desc">一个专注于php的小学生</p>
            </a>
        </div>
        <div class="col-xs-12">
            <ul class="nav nav-pills nav-justified">

                <li <?php echo !isset($_GET['category']) || $_GET['category'] == "" ? 'class="active"' : '';?>><a href="/blog" class="category" title="Home">Home</a></li>
                <?php foreach($catData as $k => $v): ?>
                <li <?php echo isset($_GET['category']) && $_GET['category']==$v['id'] ? 'class="active"' : '';?>><a href="<?php echo U('/articles/category/'.$v[id]);?>"  class="category" title="<?php echo $v['cat_name'];?>"><?php echo $v['cat_name'];?></a></li><!--  class="active"-->
                <?php endforeach; ?>

            </ul>
        </div>
        <!-- ===================================header end=============================================== -->
        <div class='col-xs-12 location'>
            <h5><span class="glyphicon glyphicon-home"></span> &nbsp;位置 ：<a href="/blog" id="home">Home </a>
                <?php echo $now_here;?>
            </h5>
        </div>

        <div class="row">
            <!-- ===================================left article start=============================================== -->

            <div class='col-xs-9 articles'>
    <?php if(count($articles) != 0){foreach($articles as $k => $v): ?>
    <div class='col-xs-12'>
        <h4 class="ar_title"><a href="<?php echo U('/articles'.getUrlParameter('ar',$v['id']));?>" title="文章标题：<?php echo $v['ar_title'];?>"><?php echo $v['ar_title'];?></a></h4>
        <ul class="list-inline">
            <li><span class="glyphicon glyphicon-eye-open " title="阅读量"></span> <?php echo $v['ar_click_num']; ?></li>
            <!--<li><span class="glyphicon glyphicon-thumbs-up" title="点赞数"></span> 点赞：<span class="good"><?php echo $v['ar_good_num']; ?></span></li>-->
            <li><span class="glyphicon glyphicon-edit" title="文章作者"></span> <?php echo $v['ar_author']; ?></li>
            <li><span class="glyphicon glyphicon-th-list" title="分类"></span> <a href="<?php echo U('/articles/category/'.$v[cat_id]);?>"><?php echo $v['cat_name']; ?></a></li>
            <li><span class="glyphicon glyphicon-tag" title="标签"></span>
                <?php
 $tags = explode(',',$v['tags']); $arr = array(); $tags_id = explode(',',$v['tags_id']); foreach($tags as $k1 => $v1){ $parameter = U('/articles/tag/'.$tags_id[$k1]); $arr[] = '<a href='."$parameter".'>'."$v1".'</a>'; } echo implode('、',$arr); ?>
            </li>
            <li><span class="glyphicon glyphicon-time" title="时间"></span> <?php echo $v['ar_time']; ?></li>
        </ul>
        <p class="lead"><?php echo mb_substr(strip_tags($v['ar_content'],"<a>"),0,250,'utf-8').'...';?></p>
    </div>

    <div class='col-xs-12 blockquote'>
        <blockquote>
            <a href="<?php echo U('/articles'.getUrlParameter('ar',$v['id']));?>" class="btn btn-success" title="点击阅读全文~"><span class="glyphicon glyphicon-leaf"></span> 阅读全文</a>
            &emsp;
            <a href="javascript:void(0);" <?php echo in_array($v['id'],$like)?"disabled":'';?> onclick="setLike(this,'<?php echo $v[id];?>')" class="btn btn-primary" title="赞一下~"><span class="glyphicon glyphicon-thumbs-up"></span>
                <span class="text1">
                    <?php
 if(in_array($v['id'],$like)){ echo '已赞~'; }else{ echo '赞一下'; } ?>
            </span> (<span class="num2"><?php echo $v['ar_good_num'];?></span>)</a>
        </blockquote><!--  onclick="setGood(this,<?php echo $v['id'];?>,<?php echo $k;?>)" -->

    </div>
    <?php endforeach;}else{echo "<div class='col-xs-12 text-center'><h3>暂无相关文章^_^！</h3></div>";} ?>

    <!-- ====分页===== -->
    <div class='col-xs-12 text-center pages'>
        <?php echo $show;?>
    </div>
</div>
<link rel="stylesheet" href="/blog/Public/Index/dz/css/animate.css" type="text/css" />
<script src="/blog/Public/Index/dz/js/jquery.min.js" type="text/javascript"></script>
<script src="/blog/Public/Index/dz/js/dz.js" type="text/javascript"></script>
<script>
    /*************************未限制ip，包括点击量，待做**********************************/
    /*************************未限制ip，包括点击量，待做**********************************/
    /*************************未限制ip，包括点击量，待做**********************************/
    /*************************未限制ip，包括点击量，待做**********************************/

    function niceIn(obj){
        obj.find('span').first().addClass('niceIn');
        setTimeout(function(){
            obj.find('span').first().removeClass('niceIn');
        },1000);
    }

    function setLike(obj,id){

        var i = 0;
        $(obj).attr("disabled",true);
        $.tipsBox({
            obj: $(obj),
            str: "+1",
            callback: function () {

                if(i>0){
                    return false;
                }

                $.ajax({
                    type : 'post',
                    url : '/blog/Home/Index/ajaxSetGood/id/'+id,
                    async:false,
                    success : function(response){

                        if(response.status){

                            var num = parseInt($(obj).find('.num2').first().text())+1;
                            $(obj).find('.num2').first().html(num);
                            $(obj).find('.text1').first().html('已赞~');
                            i++;
                        }else{
                            $(obj).attr("disabled",false);
                            alert(response.result);
                        }

                    }
                });


            }
        });

        niceIn($(obj));

    }

/*
    //点赞
    $('.btn1').click(function(){
        var o = $(this);
        var id = $(this).attr('aid');
        o.attr('disabled', 'true');
        $.tipsBox({
            obj: $(this),
            str: "+1",
            callback: function () {

                $.ajax({
                    type : 'post',
                    url : '/blog/Home/Index/ajaxSetGood/id/'+id,
                    async:false,
                    success : function(response){

                        if(response.status){
                            var num = parseInt(o.find('.num1').first().text())+1;
                            alert(num);
                            o.find('.num1').first().html(num);
                            o.find('.text1').first().html('已赞~');


                        }else{
                            alert(response.result);
                        }

                    }
                });


            }
        });

        niceIn($(this));
    });
*/




</script>
            <!-- ===================================left article end=============================================== -->


            <!-- ===================================right start=============================================== -->
            <div class='col-xs-3'>

                <div class="col-xs-12">
                    <h2>标签</h2>
                    <ul  class="list-inline">
                        <?php foreach($tagData as $k => $v):?>
                        <li style="display:inline;line-height:18px;">
                            <label class="middle">
                                <a href="<?php echo U('/articles/tag/'.$v[id]);?>" title="<?php echo $v['tag_name']?>" style="cursor: pointer">
                                    <span class="label" style="background:<?php echo $v['tag_background_color']?>;" ><?php echo $v['tag_name']; ?></span>
                                </a>
                            </label>
                        </li>
                        <?php endforeach; ?>
                    </ul>


                </div>
                <div class="col-xs-12">
                    <h2>最近发布</h2>
                    <ul style="font-weight:bold;color:red;">
                        <?php foreach($time_list as $k => $v): ?>
                        <li><a href="<?php echo U('/articles/ar/'.$v[id]);?>" style="font-weight:bold;"><?php echo $v['ar_title']; ?></a></li>
                        <?php endforeach;?>

                    </ul>
                </div>
                <div class="col-xs-12">
                    <h2>阅读排行</h2>
                    <ol style="font-weight:bold;color:green;">
                        <?php foreach($click_list as $k => $v): ?>
                        <li><a href="<?php echo U('/articles/ar/'.$v[id]);?>" style="font-weight:bold;"><?php echo $v['ar_title']; ?></a></li>
                        <?php endforeach;?>
                    </ol>
                </div>
            </div>
            <!-- ===================================right end=============================================== -->
        </div>
    </div>
    <!-- ===================================footer start=============================================== -->
    <br /><br /><br />
    <div class="col-xs-12">
        <ul class="list-inline text-center">
            <li>Copyright &copy; 2017<a href="<?php echo U('Admin/index/index');?>" target="_blank">.</a> 版权归 黄磊 本人所有. 备案号：黑ICP17000276号</li>
        </ul>
    </div>
    <!-- ===================================footer end=============================================== -->
</div>
</body>
</html>