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
		$d   =   "2015-10-12 00:00:00"; 
		$get_num_h=mysql_query("select max(id) from $_homework_list where value='1'",$link) or die(mysql_error());
		@$aaa=mysql_result($get_num_h,0,0);
		$bbb=$aaa+1;
		if($aaa<=2)
		{
   			$aaa=2;
    		$bbb=2;
		}
		$aaa=$aaa-2;
		for($ff=$aaa;$ff<$bbb;$ff++)
		{

			echo '第'.$ff.'次作业提交状态：';
			$check_homework=mysql_query("select * from $_homework where flag='$ff' and author in (select username from classes where id='$id')",$link) or die(mysql_error());
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
    	$my_res=mysql_query("select * from `$_homework_comment` where `no.`=$my_w_row[0]",$link);
        @$my_com=mysql_fetch_array($my_res);
   		echo  '评阅者('.$my_com[5].')：'.$my_com[6].'<br />';
    	echo "该作业的分数为：".$my_com[7];
		}
		else
		{
    	echo '<font color="red">未评阅</font> ';
		}
        echo '第'.$ff.'次作业互评任务：';

        $nu=($ff+1)*7;
    	$date_w=date("Y-m-d H:i:s",strtotime("$d   +$nu   day")); 
		$check_homework=mysql_query("select * from $_homework_comment where flag='$ff' and name in (select username from classes where id='$id')",$link) or die(mysql_error());
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
    }

	echo "<br />";
	echo "<a href='homework_con.php?id=$id'>查看所有</a>";

	echo '<hr />';




		
		$exper=mysql_query("select * from $_homework_list",$link) or die(mysql_error());
		$exper_num=mysql_num_rows($exper);
		for($i=1;$i<=$exper_num;$i++)
        {
            
            $ex_row=mysql_fetch_array($exper);
            //echo "实验".$i.$ex_row[1];

            echo "<h4><a href='homework_detail.php?id=$id&unit=$i'>实验".$i.$ex_row[1];
            echo "<a/></h4>";
            echo "&nbsp&nbsp<b>作业提交</b>";
            if($ex_row[2]==0)
                echo "[关闭]";
            else
                echo "<a href='homework_up_meu.php?id=$id&unit=$i'><font color='red'>[进入]</font><a>";
            
            echo "&nbsp&nbsp<b>互评任务</b>";
            if($ex_row[3]==0)
                echo "[关闭]";
            else
                echo "<a href='homework_com_menu.php?id=$id&unit=$i'><font color='red'>[进入]</font><a>";
            
            echo "<br />";
        }
        
        
 
       
        
        
        ?>
    </ul> 

          </body>
     </html>