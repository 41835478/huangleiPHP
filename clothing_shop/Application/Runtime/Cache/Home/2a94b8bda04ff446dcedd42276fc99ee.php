<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <title></title>
</head>
<link rel="stylesheet" href="/huanglei/huangleiPHP/clothing_shop/Public/Index/css/bootstrap.min.css">
<script src="/huanglei/huangleiPHP/clothing_shop/Public/Index/js/bootstrap.min.js"></script>
<script src="/huanglei/huangleiPHP/clothing_shop/Public/Js/jquery.min.js"></script>

<style>
    .bor:hover{
        border:1px solid green;
        cursor: pointer;
    }
</style>
<body style="background:#eeeeee">
<div class="container">

    <div class="container">

        <div class="page-header">
            <h1><a href="/huanglei/huangleiPHP/clothing_shop/index.php/Home/Index/index" style="text-decoration: none;color:black;">Clothing Shop</a><small>服装商城网站</small>&emsp;
                <?php if(isset($_SESSION['u'])){?>
                <span style="font-size:15px;">欢迎您：<?php echo $_SESSION['u'];?></span>&nbsp;<a href="/huanglei/huangleiPHP/clothing_shop/index.php/Home/Index/logout/username/<?php echo $_SESSION['u'];?>" onclick="return confirm('确定要退出吗？');" style="font-size:15px;">退出</a>&nbsp;<a href="/clothing_shop/index.php/Home/Login/login" style="font-size:15px;">后台登录</a>
                <?php }else{?>
                <a href="/huanglei/huangleiPHP/clothing_shop/index.php/Home/Index/login" style="font-size:15px;">登录</a>&nbsp;<a href="/huanglei/huangleiPHP/clothing_shop/index.php/Home/Index/register" style="font-size:15px;">注册</a>&nbsp;<a href="/clothing_shop/index.php/Home/Login/login" style="font-size:15px;">后台登录</a>
                <?php } ?>
            </small></h1>
        </div>

    </div>

    <div class="col-xs-4">
        <form action="/huanglei/huangleiPHP/clothing_shop/index.php/Home/Index/index" method="get" role="form">
            <div class="form-group">
                <label>商品搜索</label>
                <input type="text" name="search" class="form-control" value="<?php echo $_GET['search'];?>" placeholder="请输入商品关键字">
            </div>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> 搜索</button>

        </form>
        <br/>
        <label>服装分类 <a href="/huanglei/huangleiPHP/clothing_shop/index.php/Home/Index/index">清除筛选</a></label></label>
        <?php foreach($catData as $k => $v): ?>
        <div class="panel panel-default">

            <div class="panel-body">
                <a href="/huanglei/huangleiPHP/clothing_shop/index.php/Home/Index/index/cid/<?php echo $v['id'];?>" <?php echo $_GET['cid'] == $v['id'] ? "style='border: 2px solid orange;'" : "";?>><?php echo $v['cat_name'];?></a>
            </div>
            <?php foreach($v['children'] as $k1 => $v1): ?>
            <div class="panel-footer">&emsp;
                <span><a href="/huanglei/huangleiPHP/clothing_shop/index.php/Home/Index/index/cid/<?php echo $v1['id'];?>" <?php echo $_GET['cid'] == $v1['id'] ? "style='border: 2px solid orange;'" : "";?>><?php echo $v1['cat_name'];?></a></span>
                <?php if(count($v1['children'])>0){?>
                    <span> > </span>

                    <span style="font-size:12px;">
                        <?php foreach($v1['children'] as $k2 => $v2): ?>
                            <a href="/huanglei/huangleiPHP/clothing_shop/index.php/Home/Index/index/cid/<?php echo $v2['id'];?>" <?php echo $_GET['cid'] == $v2['id'] ? "style='border: 2px solid orange;'" : "";?>><?php echo $v2['cat_name'];?></a>&nbsp;&nbsp;
                        <?php endforeach;?>
                    </span>

                <?php }?>

            </div>
            <?php endforeach;?>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="col-xs-8">
        <?php
 if(count($goodsData) == 0){ echo "<div class='col-xs-12 bor'>"; echo "<center><h2>暂无相关商品^_^!</h2></center>"; echo "</div>"; }else{ $i=0;foreach($goodsData as $k => $v): $i++;?>
        <div class="col-xs-4 bor" gid="<?php echo $v['id'];?>">

            <br/>
            <p class="text-center">
                <img src="/clothing_shop/Uploads/<?php echo $v['goods_image'];?>" width="210"/>
            </p>
            <p class="text-left">￥ <?php echo $v['goods_price'];?></a>
            <p class="text-left"><a href="/huanglei/huangleiPHP/clothing_shop/index.php/Home/Index/content/gid/<?php echo $v['id'];?>"><?php echo $v['goods_name'];?></a></p>
            <p class="text-left"><a href="/huanglei/huangleiPHP/clothing_shop/index.php/Home/Index/content/gid/<?php echo $v['id'];?>" class="btn btn-success">查看商品</a>&emsp;</p>

        </div>
        <?php
 if($i%3 == 0){ echo "<div class='row'></div>"; } ?>

        <?php endforeach;} ?>
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


    $('.bor').click(function(){
        var gid = $(this).attr('gid');
        window.location.href="/huanglei/huangleiPHP/clothing_shop/index.php/Home/Index/content/gid/"+gid;
    });
</script>