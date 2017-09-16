<?php /* Smarty version 2.6.26, created on 2016-11-08 14:29:45
         compiled from jump/success.tpl */ ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>错误信息</title>
</head>

<body>
<div style="margin-top:50px;">
    <span style="font-size:80px;font-weight: bold;margin-left:20px;">:)</span>
    <p style="font-weight: bold;font-size:30px;margin-left:20px;">操作成功！<span id="wait">3</span>秒后跳转</p>
</div>

</body>
</html>
<script>

    var time = 3;
    var wait = document.getElementById('wait');
    var interval = setInterval(function(){
        time--;
        wait.innerHTML = time;

        if(time <= 0){
            location.href='<?php echo $this->_tpl_vars['url']; ?>
';
            clearInterval(interval);
        }
    },1000);
</script>