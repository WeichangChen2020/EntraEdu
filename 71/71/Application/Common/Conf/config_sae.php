<?php
return array(			
//==========SAE跨应用========
	


	//'配置项'=>'配置值'
	// 添加数据库配置信息
	'DB_TYPE'=>'mysql',// 数据库类型
	'DB_HOST'=>'w.rdc.sae.sina.com.cn'.','.'r.rdc.sae.sina.com.cn',// 服务器地址
	'DB_NAME'=>'app_cprogramplatform',// 数据库名
	'DB_USER'=>'ylm2jlwxmm',// 用户名
	'DB_PWD'=>'2y5jjyhxwj13xm2i5kwxz3ykwlj4542i022lwlhy',// 密码
	//'DB_PWD'=>'111222',// 密码
	'DB_PORT'=>3307,// 端口
	/*'DB_PREFIX'=>'gt_',*/// 数据库表前缀
	'DB_CHARSET'=>'utf8',// 数据库字符集
	/*'DB_SUPPREFIX'=>'cplatV2_',*/ //为了和上一版本数据库共存的问题，修改了系统类Model.class.php，增加了DB_SUPPREFIX字段作为第一表前缀	
    //'DB_SUPPREFIX2'=>'2016_', //为了和上一版本数据库共存的问题，修改了系统类Model.class.php和convention.php，增加了DB_SUPPREFIX字段作为第二表前缀	
	//默认错误跳转对应的模板文件
	//'TMPL_ACTION_ERROR' => 'Public:error',
	//默认成功跳转对应的模板文件
	//'TMPL_ACTION_SUCCESS' => 'Public:success',
	
	//'TOKEN_ON'      =>    true,  // 是否开启令牌验证 默认关闭
	'TOKEN_NAME'    =>    '__hash__',    // 令牌验证的表单隐藏字段名称，默认为__hash__
	'TOKEN_TYPE'    =>    'md5',  //令牌哈希验证规则 默认为MD5
	'TOKEN_RESET'   =>    true,  //令牌验证出错后是否重置令牌 默认为true
    
    /*
    header("Content-type:text/html;charset=utf-8");
echo "用户名   :".SAE_MYSQL_USER;
echo "密码     :".SAE_MYSQL_PASS;
echo "主库域名:".SAE_MYSQL_HOST_M;
echo "从库域名:".SAE_MYSQL_HOST_S;
echo "端口     :".SAE_MYSQL_PORT;
echo "数据库名:".SAE_MYSQL_DB;
    */
    
	
);