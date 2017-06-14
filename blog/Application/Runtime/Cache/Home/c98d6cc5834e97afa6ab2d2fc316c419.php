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
    <div class='col-xs-12'>
        <div class='col-xs-12 text-center '>
            <h3><?php echo $data['ar_title']; ?></h3>
            <ul class="list-inline">
                <li><span class="glyphicon glyphicon-edit" title="文章作者"></span> <?php echo $data['ar_author']; ?></li>
                <li><span class="glyphicon glyphicon-th-list" title="分类"></span> <a href="<?php echo U('/articles/category/'.$v[id]);?>"><?php echo $data['cat_name']; ?></a></li>
                <li><span class="glyphicon glyphicon-tag" title="标签"></span>
                    <?php
 $tags = explode(',',$data['tags']); $arr = array(); $tags_id = explode(',',$data['tags_id']); foreach($tags as $k1 => $v1){ $parameter = U('/articles/tag/'.$tags_id[$k1]); $arr[] = '<a href='."$parameter".'>'."$v1".'</a>'; } echo implode('、',$arr); ?>
                </li>
                <li><span class="glyphicon glyphicon-time" title="时间"></span> <?php echo $data['ar_time']; ?></li>
            </ul>
        </div>
        <div class='col-xs-12' style="border: 1px solid #FFB90F;padding:20px;background: #FCFCFC;border-radius: 5px;">
            <?php echo $data['ar_content']; ?>
        </div>
    </div>

</div>
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