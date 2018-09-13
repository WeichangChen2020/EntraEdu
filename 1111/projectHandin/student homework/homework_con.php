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
     <h1 align="center">
           
			实验报告
		</h1>
        

<ul>
        <?php
		include '../connect_database.php'; 
		$id=$_GET['id'];
		echo '<hr /> ';
		$d   =   "2017-10-12 00:00:00"; 
		for($ff=1;$ff<14;$ff++)
		{

			echo '第'.$ff.'次作业提交状态：';
			$check_homework=mysql_query("select * from $_homework where flag='$ff' and author in (select username from $_classes where id='$id')",$link) or die(mysql_error());
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


			$check_com=mysql_query("select * from $_homework_comment where flag='$ff' and id='$id'",$link) or die(mysql_error());
		if(mysql_num_rows($check_com)!=0)
		{
    //$row=mysql_fetch_array($check_homework);
    //if($row['size']=='0.00 Kb')
    //echo '<font color="green">提交内容错误</font>';
    // else
		echo '<font color="blue">已评阅</font> ';
    	echo "<br />";
    	$my_work=mysql_query("select * from $_homework where flag='$ff' and uploader_id='$id'",$link) or die(mysql_error());
    	$my_w_row=mysql_fetch_array($my_work);
    	echo "$my_w_row[3]($my_w_row[4])";
    	echo "<input type=\"button\"  onclick=\"window.location.href='http://cprogramplatform-homework.stor.sinaapp.com/$my_w_row[3]?num=$my_w_row[0]'\" value=\"下载\"></form>";
    	echo "<br />";
            
       $res_m=mysql_query("select max(Homeworkscores) from `$_homework_comment` where `flag`=$ff",$link);
       $max_r=mysql_result($res_m,0,0);    
            
    	$my_res=mysql_query("select * from `$_homework_comment` where `no.`=$my_w_row[0]",$link);
        @$my_com=mysql_fetch_array($my_res);
   		echo  '评阅者('.$my_com[5].')：'.$my_com[6].'<br />';
    	echo "该作业的分数为：".$my_com[7]."&nbsp最高分：(".$max_r.")";
        if($ff>1)
        {
            $re=mysql_query("select flag from $_homework_recom where id='$id' and unit='$ff' order by unit desc",$link) or die(mysql_error());
            $re_num=mysql_num_rows($re);
            if($re_num!=0)
            {
                $re_flag=mysql_result($re,0,0);
                if( $re_flag==0)
                	echo "&nbsp申述等待处理<br />";
                else
                    echo "&nbsp<a href='recom.php?id=$id&unit=$ff'>申诉</a><br />";
                    
            }
            else
            	echo "&nbsp<a href='recom.php?id=$id&unit=$ff'>申诉</a><br />";
            
            
            echo "<a href='work_detail.php?id=$id&unit=$ff'>查看详情</a><br />";
        }
            
		}
		else
		{
    	echo '<font color="red">未评阅</font> ';
		}
        echo '&nbsp第'.$ff.'次作业互评任务：';

        $nu=($ff+1)*7;
    	$date_w=date("Y-m-d H:i:s",strtotime("$d   +$nu   day")); 
		$check_homework=mysql_query("select * from $_homework_comment where flag='$ff' and name in (select username from $_classes where id='$id')",$link) or die(mysql_error());
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
		
		echo '<hr />';
    }

	echo "<br />";
	
	echo '<hr />';
?>
    
         
     </ul>
    </body>
     </html>