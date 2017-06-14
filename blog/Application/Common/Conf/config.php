<?php
return array(

    'URL_ROUTER_ON'   => true,    //开启路由
    'URL_MODEL'=>1, //去掉 index.php
    'URL_HTML_SUFFIX' => '',    //设置伪静态
    'URL_ROUTE_RULES'=>array(
        'articles/category/:category$'=>'Home/Index/index',
        'articles/page/:page$' => 'Home/Index/index',
        'articles/category/:category/page/:page$' => 'Home/Index/index',
        'articles/tag/:tag/page/:page$' => 'Home/Index/index',
        'articles/category/:category/ar/:ar$'=>'Home/Index/content',
        'articles/ar/:ar$'=>'Home/Index/content',
        'articles/tag/:tag$'=>'Home/Index/index',
        'articles/tag/:tag/ar/:ar$'=>'Home/Index/content',
        //'articles/page/:page/ar/:ar$'=>'Home/Index/content',
    ),

    
     
);