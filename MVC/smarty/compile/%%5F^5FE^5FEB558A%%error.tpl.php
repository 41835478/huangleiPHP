<?php /* Smarty version 2.6.26, created on 2016-11-08 14:16:54
         compiled from jump/error.tpl */ ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>错误信息</title>
</head>

<body>
<div style="margin-top:50px;">
    <span style="font-size:80px;font-weight: bold;margin-left:20px;">:(</span>
    <p style="font-weight: bold;font-size:30px;margin-left:20px;"><?php echo $this->_tpl_vars['method']; ?>
 方法不存在！<span id="wait">3</span>秒后跳转</p>
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
            history.back();
            clearInterval(interval);
        }
    },1000);
</script>