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
           
			作业详情
		</h1>
        

<ul>
       <?php
		include '../connect_database.php'; 
		$id=$_GET['id'];
		$unit=$_GET['unit'];
		$get_name=mysql_query("select username from classes where id='$id'",$link) or die(mysql_error());
		@$name=mysql_result($get_name,0,0);
		echo "<h4>第".$unit."单元:".$name."</h4>";
		$get_inf=mysql_query("select * from $_home_work_score where chapter='$unit'",$link) or die(a.mysql_error());
       	$row_e=mysql_fetch_array($get_inf);     
		$de_num=$row_e[1]+$row_e[2]+$row_e[3];
		$get_detail=mysql_query("select * from $_home_work_detail where flag='$unit' and id='$id'",$link) or die(b.mysql_error());
		$detail_num=mysql_num_rows($get_detail);
		if($detail_num!=0)
        {
			$row=mysql_fetch_array($get_detail);
			for($i=1;$i<=$de_num;++$i)
      		{	
           		echo "第".$i."题：";
            	// $row=mysql_fetch_array($get_detail);
            	if($row[$i]==1)
            	{
                	echo "&nbsp<font color='red'>正确</font>";
            
            	}
            	else
            	{
            		echo "&nbsp<font color='green'>错误</font>";
           		}
            
            	echo "<br />";
        	
        	}
            //$row=mysql_fetch_array($get_detail);
            echo "心得：&nbsp";
            if($row[$i]==0)
                echo "<font color='black'>未写</font>";
            else if($row[$i]==1)
                echo "<font color='blue'>一般</font>";
            else if($row[$i]==2)
                echo "<font color='orange'>良好</font>";
            else if($row[$i]==3)
                echo "<font color='red'>优秀</font>";
            echo "<br />";
		
        }
		else
        {
        	echo "暂无批改信息";
        }
?>
    
         
     </ul>
    </body>
     </html>