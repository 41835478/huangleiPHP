<?php
return array(
//    'DB_HOST'   => 'sqld.duapp.com:4050', //服务器地址
//    'DB_TYPE'   => 'mysql',     //数据库类型
//    'DB_NAME'   => 'YrBdBiWOObyektGziXcY',      //数据库名称
//    'DB_USER'   => '3e1b7b9a6daf4c5babceac749c322b51',      //数据库用户名
//    'DB_PWD'    => '87d43e0bbe2441cc9a2b207d3c475b99',          //数据库密码
//    'DB_PREFIX' => 'blog_',     //数据表前缀

    'DB_HOST'   => 'localhost', //服务器地址
    'DB_TYPE'   => 'mysql',     //数据库类型
    'DB_NAME'   => 'blog',      //数据库名称
    'DB_USER'   => 'root',      //数据库用户名
    'DB_PWD'    => '',      //数据库密码
    'DB_PREFIX' => 'blog_',     //数据表前缀
    'URL_MODEL' => '2',

    //开启模板布局
    'LAYOUT_ON'=>true,
    'LAYOUT_NAME'=>'layout',

    'HTML_CACHE_ON'     =>    true, // 开启静态缓存
    'HTML_CACHE_TIME'   =>    3600,   // 全局静态缓存有效期（秒）
    'HTML_FILE_SUFFIX'  =>    '.html', // 设置静态缓存文件后缀
    'HTML_CACHE_RULES'  =>     array(  // 定义静态缓存规则

        'Index:index'   => 'CategoryID_TagID_Page/{category|def_cat}_{tag|def_tag}_{page|def_page}',
        'Index:content' => 'ContentID/{ar}'

    ),




);

function def_page(){
    if(!(isset($_GET['page']) && $_GET['page'])){
        return 1;
    }else{
        return $_GET['page'];
    }

}
function def_tag(){
    if(!(isset($_GET['tag']) && $_GET['tag'])){
        return 0;
    }else{
        return $_GET['tag'];
    }

}
/* 生成的缓存文件，如果不存在category参数默认为0 */
function def_cat(){
    if(!(isset($_GET['category']) && $_GET['category'])){
        return 0;
    }else{
        return $_GET['category'];
    }

}
