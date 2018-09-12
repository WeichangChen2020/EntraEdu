<?php
return array(
	//'配置项'=>'配置值'
	
	
	// 'MODULE_ALLOW_LIST'  => array('Student','Admin'),
    // 'DEFAULT_MODULE'     => 'Student',

	'URL_HTML_SUFFIX' => '',  //伪静态设置为空
	'URL_MODEL' => 1,

	'SESSION_AUTO_START' => true,  //开启缓存

	// 'SHOW_PAGE_TRACE' => false, //开启trace


	// 配置数据库
	'DB_TYPE' => 'mysql', 
	'DB_HOST' => '127.0.0.1',
	'DB_USER' => 'root',
	'DB_PWD' => '',
	'DB_NAME'  => 'app_dataplatform',
	'DB_PORT' => '', 
	'DB_PREFIX' => 'cp_', 

	
	//解决了数据库默认小写问题
	'DB_PARAMS'    =>    array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL),

	'APP_ID' => 'wx8e1ab063e92381dc',// app_id
	'APP_SECRET' => '19db5de1b20d1baad44167298a5ac0f1',// app_secret
	'TOKEN' => 'weixin',// token
	'CRYPT' => 'JrE17gcesko9MSclArbkoBSu7mpN0puEEa3EWwwAuBz', //消息加密KEY（EncodingAESKey）
	'COMMONPATH' => 'http://dataplatform-collegephysics2.stor.sinaapp.com',//storage链接
	'QUESTIONPATH'=> '/collegephysics/questionbank/cp_',//自由练习文件夹
	'HOMEWORKPATH'=> '/collegephysics/image_questionbank/cp_',//课后作业公共部分
	'SUBMITPATH'=> '/collegephysics/homework/',//用户提交作业图片到该地址


);