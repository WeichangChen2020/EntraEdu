<?php
include 'connect_database.php';
$word = "app_";
$links = array();
$sql = "select * from app_database";
$result = mysql_query($sql,$link);
if(!mysql_num_rows($result)){
}else{
    for($i=1;$i<=mysql_num_rows($result);$i++){
        $app = mysql_fetch_array($result);
        $application = 'app_'.$app['app'];
        $id = $app['id'];
        $links[$i]=mysql_connect('w.rdc.sae.sina.com.cn.'.':'.'3307',$app['user'],$app['password']); 
        mysql_select_db($mysql_database1,$links[$i]);//选择其他应用数据库
        
        if($links[$i]){
        echo "hello";
          }
        
       
        $sql_count="select * from $application.`classes`";
        $result_count=mysql_query($sql_count,$links[$i]);
        //$row=mysql_fetch_array($result_count);
        $stu_count=mysql_num_rows($result_count); //计算平台的人数
         echo $stu_count;
        $sql_update = "update course set course_participants = '$stu_count' where id=$id";
        $result_up = mysql_query($sql_update);
    
    }


}
?>