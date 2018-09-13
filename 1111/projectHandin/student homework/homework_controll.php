<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=yes" />   
<meta http-equiv="content-type" content="text/html;charset=utf-8">
 <style type="text/css">
#demo{width:900px; padding:5px;border:1px solid #ddd;background-color:#eee;}

</style>
     
 
     
<style type="text/css">
a {text-decoration: none;}
</style>
</head>
 <body>
     <h1>实验管理</h1>
     
<?php
	include '../connect_database.php'; 


	if(isset($_GET['x']))
    {
        $x=$_GET['x'];
        $flag=$_GET['flag'];
        mysql_query("update $_homework_list set value='$x' where id='$flag'",$link) or die(mysql_error());
    
    }

	if(isset($_GET['y']))
    {
        $y=$_GET['y'];
        $flag=$_GET['flag'];
        mysql_query("update $_homework_list set comment='$y' where id='$flag'",$link) or die(mysql_error());
    
    }






	$exp_name_get=mysql_query("select * from $_homework_list",$link) or die(mysql_error());
	$exp_name_get_num=mysql_num_rows($exp_name_get);
	for($i=0;$i<$exp_name_get_num;)
    {
    	$row_1=mysql_fetch_array($exp_name_get);
        echo "<h4>实验".++$i."    ".$row_1['ex_name'];
        echo "</h4>";
        echo "<font ";
        if($row_1['value']==1)
        {
            echo " color=red>提交作业(开启中)：</font>";
            echo "<a href='?x=0&flag=$i'>关闭</a>";
        }
        else
        {
            echo " >提交作业(未开启)：</font>";
            echo "<a href='?x=1&flag=$i'>开启</a>";
        }
        echo "&nbsp&nbsp<font ";
        if($row_1['comment']==1)
        {
            echo " color=red>互评任务(开启中)：</font>";
            echo "<a href='?y=0&flag=$i'>关闭</a>";
        }
        else
        {
            echo " >互评任务(未开启)：</font>";
            echo "<a href='?y=1&flag=$i'>开启</a>";
        }




        $ck_0=mysql_query("select count(id) from $_mul_task where task_$i='0'",$link) or die(mysql_errno());
        $ck_num=mysql_result($ck_0, 0);
        $ck_1=mysql_query("select count(id) from $_mul_task",$link) or die(mysql_errno());
        $ck_num1=mysql_result($ck_1,0,0);
        if($ck_num>20||$ck_num1==0)
            echo "&nbsp&nbsp<a href='../mul_e/ran_2.php?flag=$i'>分配互评任务</a>";
        else
            echo "&nbsp&nbsp已分配";
    
    }
	

     ?>     
     
     
    </body>
     
     </html>