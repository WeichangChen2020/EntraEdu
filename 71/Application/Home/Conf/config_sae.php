<?php
//define('APPID', 'wx234ccba5ec69a5cf');
//define('APPSECRET', 'd4624c36b6795d1d99dcf0547af5443d');
//define('APPID', 'wxc8a7584bdc331e27');
//define('APPSECRET', '6b6715a0d969ac505eaa5304e7b60dd6');

//define("TOKEN", "weiphp");
//define("APPNAME",'gshqwechat');
//define('UPLOADSDOMAIN','Uploads');

$st =   new SaeStorage();
return array( 
	'URL_MODEL'          => '1', //URL模式    
	'SESSION_AUTO_START' => true, //是否开启session
	'TMPL_PARSE_STRING'  =>array(
		'__LOGPUB__'     => __ROOT__.'/Public/Login/',    
		'__PUBLIC__'     => '71/Public/Home/', // 增加新的images类库路径替换规则    
		'__UPLOAD__'  	 => '/Public/Upload', //上传路径
		'__TEST__'       => '/Public/Test/',
		'/Public/Upload' => $st->getUrl('public','Upload'),
	),
	'LAYOUT_ON'=>true,
	'LAYOUT_NAME'=>'Layout/layout',	
		
);