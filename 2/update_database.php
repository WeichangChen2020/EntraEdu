<?php
include 'connect_database.php';
$word = "app_";
$link = array();
$sql = "select * from app_database";
$result = mysql_query($sql,$link);
if(!mysql_num_rows($result)){
}else{
    for($i=0;$i<mysql_num_rows($result);$i++){
        $app = mysql_fetch_array($result);
        $application = 'app_'.$app['app'];
        $link[$i]=mysql_connect('w.rdc.sae.sina.com.cn.'.':'.'3307',$app['user'],$app['password']); 
        mysql_select_db($mysql_database1,$link[$i]);//选择其他应用数据库
    
    }


}
?>