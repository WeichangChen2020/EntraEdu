<?php @session_start();
	ini_set("display_errors","Off");
static 	$DB_HOST="r.rdc.sae.sina.com.cn:3307";
static 	$DB_NAME="app_testtest11";
static 	$DB_USER=SAE_MYSQL_USER;
static 	$DB_PASS=SAE_MYSQL_PASS;
	// connect db 
static 	$OJ_NAME="浙江工商大学程序设计平台";
static 	$OJ_HOME="./";
static 	$OJ_ADMIN="root@localhost";
static 	$OJ_DATA="/home/judge/data";
static 	$OJ_BBS="discuss";//"bbs" for phpBB3 bridge or "discuss" for mini-forum
static  $OJ_ONLINE=false;
static  $OJ_LANG="en";
static  $OJ_SIM=true; 
static  $OJ_DICT=true;
static  $OJ_LANGMASK=1008; //1mC 2mCPP 4mPascal 8mJava 16mRuby 32mBash 1008 for security reason to mask all other language
static  $OJ_EDITE_AREA=true;//true: syntax highlighting is active
static  $OJ_AUTO_SHARE=true;//true: One can view all AC submit if he/she has ACed it onece.
static  $OJ_CSS="hoj.css";
static  $OJ_SAE=true; //using sina application engine
static  $OJ_VCODE=true;
static  $OJ_APPENDCODE=false;
static  $OJ_MEMCACHE=true;
static  $OJ_MEMSERVER="127.0.0.1";
static  $OJ_MEMPORT=11211;
static  $SAE_STORAGE_ROOT="http://hustoj-web.stor.sinaapp.com/";
if($OJ_SAE) $OJ_DATA="saestor://data/";
//if(date('H')<5||date('H')>22||isset($_GET['dark'])) $OJ_CSS="dark.css";
if (isset($_SESSION['OJ_LANG'])) $OJ_LANG=$_SESSION['OJ_LANG'];

	if($OJ_SAE)	{
	// for sae.sina.com.cn
		mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
		$DB_NAME=SAE_MYSQL_DB;
	}else{
		//for normal install
		if(!mysql_pconnect($DB_HOST,$DB_USER,$DB_PASS)) 
			die('Could not connect: ' . mysql_error());
	}
	// use db
	mysql_query("set names utf8");
	if(!$OJ_SAE)mysql_set_charset("utf8");
	
	if(mysql_select_db($DB_NAME));
	else die('Can\'t use foo : ' . mysql_error());
	//sychronize php and mysql server
	date_default_timezone_set("PRC");
	mysql_query("SET time_zone ='+8:00'");
	
?>
