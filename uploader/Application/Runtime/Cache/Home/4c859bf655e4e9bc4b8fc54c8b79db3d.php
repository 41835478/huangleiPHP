<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>thinkphp整合系列之webuploader异步预览上传</title>
    <webuploadercss />
</head>
<body>

<form action="<?php echo U('Home/Index/webuploader');?>" method="post">
    <webuploader name="image" url="<?php echo U('Home/Index/ajax_upload');?>" word="或将照片拖到这里，单次最多可选300张" />
    自定义附加字段：<input type="text" name="extend" value="上传的文件描述">
    <input type="submit" value="提交">
</form>


<webuploaderjs />
</body>
</html>