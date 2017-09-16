<?php
return array(
//	'DB_HOST' => 'localhost',
//    'DB_TYPE' => 'mysql',
//    'DB_USER' => 'root',
//    'DB_PWD'  => '',
//    'DB_NAME' => 'shop',
//    'DB_PREFIX' =>'sh_',
	'DB_HOST' => 'localhost',
	'DB_TYPE' => 'mysql',
	'DB_USER' => 'root',
	'DB_PWD'  => '1234',
	'DB_NAME' => 'shop',
	'DB_PREFIX' =>'sh_',
//	'DB_TYPE' => 'mysql',
//	'DB_HOST' => 'sqld.duapp.com:4050',
//	'DB_USER' => '3e1b7b9a6daf4c5babceac749c322b51',
//	'DB_PWD' => '87d43e0bbe2441cc9a2b207d3c475b99',
//	'DB_NAME' => 'IoeJJyhKAwOOtVcNNsUW',
//	'DB_PREFIX' =>'sh_',
	'DES_KEY' => 'eater_shop',
	'URL_HTML_SUFFIX'       => '',  // URL伪静态后缀设置

	'EXPRESS_PRICE' => '15.00',		// 快递费用

	'MAIL_HOST' =>'smtp.163.com',//smtp服务器的名称
    'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    'MAIL_USERNAME' =>'13074548734@163.com',//发件人的邮箱名
    'MAIL_PASSWORD' =>'Aa123456',//163邮箱发件人授权密码
    'MAIL_FROM' =>'13074548734@163.com',//发件人邮箱地址
    'MAIL_FROMNAME'=>'eater商城',//发件人姓名
    'MAIL_CHARSET' =>'utf-8',//设置邮件编码
    'MAIL_ISHT' =>TRUE, // 是否HTML格式邮件


	'TOKEN_ON'      =>    true,  // 是否开启令牌验证 默认关闭
	'TOKEN_NAME'    =>    '__hash__',    // 令牌验证的表单隐藏字段名称，默认为__hash__
	'TOKEN_TYPE'    =>    'md5',  //令牌哈希验证规则 默认为MD5
	'TOKEN_RESET'   =>    true,  //令牌验证出错后是否重置令牌 默认为true
);