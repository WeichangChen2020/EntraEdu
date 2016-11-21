<!--*****************************************************************************
    ZheJiang Gongshang University.
    Author       :zhuhua,pengdan
    Version      :V1.0
    Time         :2015-1-30
******************************************************************************-->
<?php 
//$mysql_server_name = "localhost";
//$mysql_username = "root";
//$mysql_password ="";
$mysql_database = "app_testroom";
$mysql_database1 = "app_cprogramplatform";
$mysql_database2 = "app_dstructureplatform";
$link=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS); //连接数据库
mysql_select_db("$mysql_database",$link);//选择数据库
//$link1=mysql_connect('w.rdc.sae.sina.com.cn.'.':'.'3307','ylm2jlwxmm','2y5jjyhxwj13xm2i5kwxz3ykwlj4542i022lwlhy'); //连接数据库
//mysql_select_db($mysql_database1,$link1);//选择数据库
//$link2=mysql_connect('w.rdc.sae.sina.com.cn.'.':'.'3307','z54ynonl2w','y5l5w140jiil55jj2i5ik1k4ili522535w4lyz3w'); //连接数据库
//mysql_select_db($mysql_database2,$link2);//选择数据库


//if($linkk){
//echo "hello";
//}
$mysql  =   new SaeMysql();
mysql_query("set names 'utf-8'");
date_default_timezone_set("Asia/Shanghai");
?>

