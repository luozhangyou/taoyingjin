<?php
return array(
	//'配置项'=>'配置值'
	'TMPL_TEMPLATE_SUFFIX'  =>  '.htm',// 默认模板文件后缀
	'URL_CASE_INSENSITIVE' => true,//忽略大小写
    'SHOW_PAGE_TRACE' =>true,
    'DB_FIELD_CACHE'=>false,
    'HTML_CACHE_ON'=>false,
    'MULTI_MODULE' =>  true,
    'MODULE_ALLOW_LIST' =>  array('Home','Admin'),
    'DEFAULT_MODULE' => 'Home',
	'DB_PARAMS'    =>    array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL),//取消数据库返回大小写转换
	'LOAD_EXT_CONFIG' => 'conn,rabc,taobao'//自动加载其他配置文件
);