<?php
return array(
    'DB_TYPE' => 'mysql',
	'DB_HOST' => 'localhost',
    'DB_USER' => 'root',
    'DB_PWD' => '1234',
    'DB_NAME' => 'shop',
    'DB_PREFIX' =>'sh_',
	'URL_MODEL' => '2',
//	'DB_HOST' => 'localhost',
//	'DB_TYPE' => 'mysql',
//	'DB_USER' => 'root',
//	'DB_PWD'  => '1234',
//	'DB_NAME' => 'shop',
//	'DB_PREFIX' =>'sh_',
//	'DB_TYPE' => 'mysql',
//	'DB_HOST' => 'sqld.duapp.com:4050',
//	'DB_USER' => '3e1b7b9a6daf4c5babceac749c322b51',
//	'DB_PWD' => '87d43e0bbe2441cc9a2b207d3c475b99',
//	'DB_NAME' => 'IoeJJyhKAwOOtVcNNsUW',
//	'DB_PREFIX' =>'sh_',
    //'LOG_RECORD' => true, // 开启日志记录
    //'LOG_LEVEL'  =>'EMERG,ALERT,CRIT,ERR', // 只记录EMERG ALERT CRIT ERR 错误

	//商品详情页大图 尺寸
    'GOODS_IMG_BIG_WIDTH' => '390',
    'GOODS_IMG_BIG_HEIGHT' => '390',

	//商品详情页小图 尺寸
	'GOODS_IMG_SMALL_WIDTH' => '85',
	'GOODS_IMG_SMALL_HEIGHT' => '85',

	//商品封面图片
	'GOODS_LOGO_IMG_WIDTH' => '210',
	'GOODS_LOGO_IMG_HEIGHT' => '210',

	'BRAND_LOGO_IMG_WIDTH' => '120',
	'BRAND_LOGO_IMG_HEIGHT' => '60',

	// 店铺logo图尺寸
	'STORE_LOGO_IMG_WIDTH' => '150',
	'STORE_LOGO_IMG_HEIGHT' => '100',




    'TOKEN_ON'      =>    true,  // 是否开启令牌验证 默认关闭
    'TOKEN_NAME'    =>    '__hash__',    // 令牌验证的表单隐藏字段名称，默认为__hash__
    'TOKEN_TYPE'    =>    'md5',  //令牌哈希验证规则 默认为MD5
    'TOKEN_RESET'   =>    true,  //令牌验证出错后是否重置令牌 默认为true

);