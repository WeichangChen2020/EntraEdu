<?php
header("Content-type: text/html; charset=utf-8");
include '../connect_database.php';  
$flag=$_GET['flag'];
$unup=mysql_query("select * from $_classes where (class='$_class1' or class='$_class2') and  username not in (select author from homework where flag='$flag')",$link) or die(mysql_error());
$un_num=mysql_num_rows($unup);
if($un_num==0)
    echo "本次作业全部提交";
else
{
    echo "<h2>未提交名单：<h2/>";
    for($i=0;$i<$un_num;$i++)
    {
   		$row=mysql_fetch_array($unup);
        echo $row['username'];
        echo '、';
        if($i%7==0&&$i!=0)
            echo '<br />';
        
    }
    echo '<br/>请以上同学及时提交作业，如有错漏或疑问请和助教联系';
}