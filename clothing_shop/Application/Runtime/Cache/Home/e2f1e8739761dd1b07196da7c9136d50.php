<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<title></title>
</head>
<link rel="stylesheet" href="/clothing_shop/Public/Index/css/bootstrap.min.css">
<script src="/clothing_shop/Public/Index/js/bootstrap.min.js"></script>
<script src="/clothing_shop/Public/Js/jquery.min.js"></script>

<body style="background:#eeeeee">
<div class="container">
	
	<div class="container">
	
	<div class="page-header">
		<h1><a href="/clothing_shop/index.php/Home/Index/index" style="text-decoration: none;color:black;">Clothing Shop</a><small>服装商城网站</small></h1>
    </h1>
	</div>
		<h3>注册</h3>
        <p>已有账号，点击<a href="login.html">登录</a></p>
        
    </div>
	<form action="/clothing_shop/index.php/Home/Index/register" method="post">
        <div class="col-xs-12">
             <div class="form-group">
                <label>用户名</label>
                <input type="text" class="form-control" name="username" placeholder="请输入用户名">
            </div>
            <div class="form-group">
                <label>密码</label>
                <input type="password" class="form-control" name="password" placeholder="请输入密码">
            </div>
            <button type="submit" class="btn btn-warning">注册</button>
        </div>
    </form>
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
</script>