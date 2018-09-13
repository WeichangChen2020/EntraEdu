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
        <h2>作业详情</h2>
                     
<?php
	
    include '../connect_database.php';  

	$id = $_GET['id'];
	$unit=$_GET['unit'];
	echo "<input type=\"button\"  onclick=\"window.location.href='homework_2015.php?id=$id'\" value=\"返回\"><hr /><ul>";
	$d   =   "2015-10-10 00:00:00";   
	$sqlType = "select type from $_classes where id='$id'";
    $resType = mysql_query($sqlType, $link);
    @$rowType = mysql_fetch_row($resType);
	$sqlTypee = "select username from $_classes where id='$id'";
    $resTypee = mysql_query($sqlTypee, $link);
    @$rowTypee = mysql_result($resTypee,0);
	$unit_select=mysql_query("select * from homework_list where id='$unit'",$link) or die(mysql_error());
	$unit_name=mysql_result($unit_select,0,1);
	echo "<b>实验".$unit.$unit_name."作业详情</b>";
	echo "&nbsp&nbsp";
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo '作业提交状态：';
	$check_homework=mysql_query("select * from homework where flag='$unit' and author in (select username from $_classes where id='$id')",$link) or die(mysql_error());
	if(mysql_num_rows($check_homework)!=0)
	{
    	$row_check=mysql_fetch_array($check_homework);
    	if($row_check['size']=='0.00 Kb')
       		echo '<font color="green">提交内容错误</font>';
    	else
			echo '<font color="blue">已提交</font> ';
    
	}
	else
    	echo '<font color="red">未提交</font> ';


	$check_com=mysql_query("select * from homework_comment where flag='$unit' and id='$id'",$link) or die(mysql_error());
	if(mysql_num_rows($check_com)!=0)
	{
    //$row=mysql_fetch_array($check_homework);
    //if($row['size']=='0.00 Kb')
    //echo '<font color="green">提交内容错误</font>';
    // else
		echo '<font color="blue">已评阅</font> ';
    	echo "<br />";
    	$my_work=mysql_query("select * from homework where flag='$unit' and uploader_id='$id'",$link) or die(mysql_error());
    	$my_w_row=mysql_fetch_array($my_work);
    	echo "$my_w_row[3]($my_w_row[4])";
    	echo "<input type=\"button\"  onclick=\"window.location.href='http://cprogramplatform-homework.stor.sinaapp.com/$my_w_row[3]?num=$my_w_row[0]'\" value=\"下载\"></form>";
    	echo "<br />";
    	$my_res=mysql_query("select * from `homework_comment` where `no.`=$my_w_row[0]",$link);
        @$my_com=mysql_fetch_array($my_res);
   		echo  '评阅者('.$my_com[5].')：'.$my_com[6].'<br />';
    	echo "该作业的分数为：".$my_com[7];
	}
	else
	{
    	echo '<font color="red">未评阅</font> ';
	}

	echo '作业互评任务：';
    $nu=($unit+1)*7;
    $date_w=date("Y-m-d H:i:s",strtotime("$d   +$nu   day")); 
	$check_homework=mysql_query("select * from homework_comment where flag='$unit' and name in (select username from $_classes where id='$id')",$link) or die(mysql_error());
	if(mysql_num_rows($check_homework)!=0)
	{
		echo '<font color="blue">已完成（+1）</font> ';
    
	}
	else
	{
        $time_now=date("Y-m-d H:i:s",time()); 
     	if($time_now>$date_w)
        	echo '<font color="green">未完成或未按时提交（-1）</font> ';
    	else
    		echo '<font color="red">未完成</font> ';
	}

	echo '<br />';
	echo '<br />';
//echo "<a href=''>已批改完成的作业</a>";
	echo '<hr />';
	echo '<br />';
	echo "<a href='right_and_worng_2015.php?id=$id&unit=$unit'>查看题目正确率</a><br />";
	echo "<a href='stu_mean_2015.php?id=$id&unit=$unit'>查看心得汇总</a><br />";

	$se_st_num=mysql_query("select * from homework where flag='$unit' group by author ",$link) or die(mysql_error());
	$up_num=mysql_num_rows($se_st_num);
	echo   "<h2> <li>第".$unit."次实验报告</h2>  <ul>";  
	//echo "<a href='detail.php?unit=$unit'>已批改完成的作业</a><br />";
	//echo "已提交人数：$up_num<a href=\"unupdate_2015.php?flag=$unit\">未提交名单</a><br /><hr/>";  
	$ac_work=mysql_query("select * from `homework` where savename!='' and flag='$unit'",$link);
	$ac_1=mysql_num_rows($ac_work);
	$ac_work=mysql_query("select * from `homework` where flag='$unit'",$link);
	$ac_2=mysql_num_rows($ac_work);
	echo "批改总进度：$ac_1/$ac_2   <br />";

	@$result=mysql_query("select * from `homework` where savename!='' and flag='$unit'",$link);
    $nums=mysql_num_rows($result);

 	for($i=0;$i<$nums;$i++)
    {	
       $row=mysql_fetch_array($result);
       echo "<li>";
       echo "$row[3]($row[4])($row[2])";
       if($rowType[0] == 1)
       { 
     	  echo "<input type=\"button\"  onclick=\"window.location.href='http://cprogramplatform-homework.stor.sinaapp.com/$row[3]?num=$row[0]'\" value=\"下载\"></form>";
     	  echo "<a href='../student homework/ans_2015.php?id=$id&num=$row[0]&flag=$unit'>评价</a>";
     	  $res=mysql_query("select * from `$_homework_comment` where `no.`=$row[0]",$link);
     	  $num=mysql_num_rows($res);
 	  	  for($j=0;$j<$num;$j++)
      	  {	
           	$com=mysql_fetch_array($res);
           	echo  $com[2].'('.$com[5].')：'.$com[6];
       	  }
       }
                        
                        

    }
echo "<br>";
echo "<br>";
echo "<br>";
	
  
        
?></ul>
          </body>
     </html>