create database blog;


create table blog_user(
id smallint not null auto_increment primary key comment 'id，主键，自增长',
username varchar(20) not null comment '用户名',
password varchar(32) not null comment '密码'
)engine=MyISAM default charset=utf8 comment '管理员';


create table blog_article(
id smallint not null auto_increment primary key comment 'id，主键，自增长',
ar_title varchar(30) not null comment '文章标题',
ar_author varchar(30) not null comment '文章作者',
ar_content text not null comment '文章内容',
ar_category_id SMALLINT not null comment '文章分类id',
ar_click_num SMALLINT not null default "0" comment '文章点击量',
ar_good_num SMALLINT not null default "0" comment '文章点赞数',
ar_time datetime not null comment '文章添加时间',
ar_show_status enum('启用','停用') not null DEFAULT "启用" comment '文章是否开启展示',
index cat_id(ar_category_id)
)engine=MyISAM default charset=utf8 comment '文章';

create table blog_category(
id smallint not null auto_increment primary key comment 'id，主键，自增长',
cat_name varchar(30) not null comment '分类名称',
cat_order SMALLINT not null default "1" comment '分类排序',
cat_show_status enum('启用','停用') not null DEFAULT "启用" comment '分类是否开启展示'
)engine=MyISAM default charset=utf8 comment '文章分类';

create table blog_tag(
id smallint not null auto_increment primary key comment 'id，主键，自增长',
tag_name varchar(30) not null comment '标签名称'
)engine=MyISAM default charset=utf8 comment '标签';

create table article_tag_id(
id smallint not null auto_increment primary key comment 'id，主键，自增长',
tag_id SMALLINT not null comment '标签id',
article_id SMALLINT not null comment '文章id',
index tag_id(tag_id)
)engine=MyISAM default charset=utf8 comment '文章，标签，关联表';
