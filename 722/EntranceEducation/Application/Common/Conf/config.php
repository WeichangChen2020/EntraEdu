<?php
return array(
	//'配置项'=>'配置值'
	
	
	'MODULE_ALLOW_LIST'  => array('Student','Teacher'),
    'DEFAULT_MODULE'     => 'Student',

	'SESSION_AUTO_START' => false,
	'URL_HTML_SUFFIX'    => '',  //伪静态设置为空

	'SESSION_AUTO_START' => true,  //开启缓存

	// 配置数据库
	'DB_TYPE' => 'mysql', 
	'DB_HOST' => '127.0.0.1',
	'DB_USER' => 'root',
	'DB_PWD' => '',
	'DB_NAME'  => 'newer',
	'DB_PORT' => '', 
	'DB_PREFIX' => 'ee_', 
	
	//解决了数据库默认小写问题
	'DB_PARAMS'    =>    array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL),   

);