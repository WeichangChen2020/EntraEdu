?<?php
header("Content-type: text/html; charset=utf-8");
include '../connect_database.php'; 
mysql_query("set names 'utf8'");
$mysql  =   new SaeMysql();
   $id = $_GET['id'];
$savefile = $_GET['savefile'];
   
              
                       $res=mysql_query("select * from `$_homework` where no.=$id",$link);
                       $dowloads=mysql_result($res,0,6);
             $dowloads=$dowloads+1;
                       //  echo $dowloads;
         
               $sql="update `$_homework` set `downloads` = '$dowloads'  where no.=$id";         
                 $mysql->runSql($sql);
                 
              
//echo "<body onunload=\"window.open('http://ieelab.zjgsu.edu.cn/zgb/project/1411050224.zip')\">";//关闭本网页时跳出下载框
//echo "<body onload=\"window.open('http://ieelab.zjgsu.edu.cn/zgb/project/$savefile')\">";//打开本网页时跳出下载框
echo "<body onload=\"window.open('http://cprogramplatform-homework.stor.sinaapp.com/$savefile')\">";

                   
                   
?>
