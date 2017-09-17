<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <title></title>
</head>
<link rel="stylesheet" href="/clothing_shop/Public/Index/css/bootstrap.min.css">
<script src="/clothing_shop/Public/Index/js/bootstrap.min.js"></script>
<script src="/clothing_shop/Public/Js/jquery.min.js"></script>

<style>
.nav{
    width:100%;
    height:2px;
    background: green;
    float:left;
    margin-top:10px;
    margin-bottom: 10px;
}
</style>
<body style="background:#eeeeee">
<div class="container">

    <div class="container">

        <div class="page-header">
            <h1><a href="/clothing_shop/index.php/Home/Index/index" style="text-decoration: none;color:black;">Clothing Shop</a><small>服装商城网站</small>&emsp;
                <?php if(isset($_SESSION['u'])){?>
                <span style="font-size:15px;">欢迎您：<?php echo $_SESSION['u'];?></span>&nbsp;<a href="/clothing_shop/index.php/Home/Index/logout" onclick="return confirm('确定要退出吗？');" style="font-size:15px;">退出</a>
                <?php }else{?>
                <a href="/clothing_shop/index.php/Home/Index/login" style="font-size:15px;">登录</a>&nbsp;<a href="/clothing_shop/index.php/Home/Index/register" style="font-size:15px;">注册</a>
                <?php } ?>
                </small></h1>        </div>

    </div>

    <div class="col-xs-4">
        <form action="/clothing_shop/index.php/Home/Index/index" method="get" role="form">
            <div class="form-group">
                <label>商品搜索</label>
                <input type="text" name="search" class="form-control" value="<?php echo $_GET['search'];?>" placeholder="请输入商品关键字">
            </div>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> 搜索</button>

        </form>
        <br/>
        <label>服装分类 <a href="/clothing_shop/index.php/Home/Index/index">清除筛选</a></label></label>
        <?php foreach($catData as $k => $v): ?>
        <div class="panel panel-default">

            <div class="panel-body">
                <a href="/clothing_shop/index.php/Home/Index/index/cid/<?php echo $v['id'];?>" <?php echo $_GET['cid'] == $v['id'] ? "style='border: 2px solid orange;'" : "";?>><?php echo $v['cat_name'];?></a>
            </div>
            <?php foreach($v['children'] as $k1 => $v1): ?>
            <div class="panel-footer">&emsp;
                <span><a href="/clothing_shop/index.php/Home/Index/index/cid/<?php echo $v1['id'];?>" <?php echo $_GET['cid'] == $v1['id'] ? "style='border: 2px solid orange;'" : "";?>><?php echo $v1['cat_name'];?></a></span>
                <?php if(count($v1['children'])>0){?>
                    <span> > </span>

                    <span style="font-size:12px;">
                        <?php foreach($v1['children'] as $k2 => $v2): ?>
                            <a href="/clothing_shop/index.php/Home/Index/index/cid/<?php echo $v2['id'];?>" <?php echo $_GET['cid'] == $v2['id'] ? "style='border: 2px solid orange;'" : "";?>><?php echo $v2['cat_name'];?></a>&nbsp;&nbsp;
                        <?php endforeach;?>
                    </span>

                <?php }?>

            </div>
            <?php endforeach;?>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="col-xs-8">

        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <h3><?php echo $data['goods_name'];?></h3>
                </div>
            </div>
            <div class="nav"></div>
            <div class="col-xs-6">
                <center>
                    <img src="/clothing_shop/Uploads/<?php echo $data['goods_image'];?>" width="280" />
                </center>
            </div>
            <div class="col-xs-6">
                <br /><br />
                <p class="text-left">本店价：￥ <?php echo $data['goods_price'];?></p>
                <form action="/clothing_shop/index.php/Home/Index/buy" method="post">
                <p class="text-left">尺寸：
                    <input type="hidden" name="gid" value="<?php echo $data['id'];?>">
                <?php $arr = explode(',',$data['goods_size']);foreach($arr as $k => $v):?>
                        <label>
                            <input type="radio" name="goods_size" value="<?php echo $v;?>" id="optionsRadios1" value="option1" checked><?php echo $v;?>
                        </label>
                        &nbsp;
                <?php endforeach; ?>
                    <p class="text-left">数量：<input type="number" name="number" value="1" style="width:50px;"/></p>
                </p>
                <p class="text-left">分类：<?php echo $data['cat_name'];?></p>
                <p class="text-left"><button class="btn btn-success">点击购买</button>&emsp;</p>
                </form>
            </div>
        </div>
        <div class="nav" style="margin-top:100px;"></div>
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <h4>
                        <a class="aa" style="cursor: pointer;text-decoration: none;font-weight: bold">商品详情</a>
                        |
                        <a class="aa" style="cursor: pointer;text-decoration: none;">商品评论</a>
                    </h4>
                </div>
            </div>
            <br /><br />
            <div class="col-xs-12" id="sp">
                <p class="text-center"><center><?php echo html_entity_decode($data['goods_info']);?></center></p>
            </div>

            <div class="col-xs-12" id="pl" style="display: none">
                <div class="col-xs-12">
                    <?php if(count($message) == 0){?>
                    <center><h1>该商品暂无评论！</h1></center>
                    <?php }else{?>
                    <?php foreach($message as $k => $v): ?>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">用户：<?php echo $v['username'];?>&emsp;&emsp;评论时间：<?php echo $v['time'];?></h3>
                        </div>
                        <div class="panel-body">
                            <?php echo $v['message'];?>
                        </div>
                    </div>
                    <?php endforeach;} ?>

                </div>
                <div class="col-xs-12">
                    <form action="/clothing_shop/index.php/Home/Index/comment" method="post" role="form">
                        <div class="form-group">
                            <input type="hidden" name="gid" value="<?php echo $data['id'];?>">
                            <label>发表评论</label>
                            <textarea class="form-control" name="message" rows="3"></textarea><br />
                            <button type="submit" class="btn btn-default"> 发布</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>




</div>
</body>
</html>
<script>

    //当用户关闭浏览器时
    $(window).bind('beforeunload',function(){

        $.ajax({
            type: "post",
            url: "<?php echo U('Home/Index/aaa');?>",
        });

    });


    $('.aa').click(function(){

        var css = $(this).text();

        if(css == "商品详情"){
            $(this).css('font-weight','bold');
            $(this).siblings('a').css('font-weight','');
            $('#sp').css('display','block');
            $('#pl').css('display','none');
        }else{
            $(this).css('font-weight','bold');
            $(this).siblings('a').css('font-weight','');
            $('#sp').css('display','none');
            $('#pl').css('display','block');
        }


    });
</script>