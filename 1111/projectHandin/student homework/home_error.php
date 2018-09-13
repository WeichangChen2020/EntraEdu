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
        <?php
			include '../connect_database.php'; 
			if(isset($_GET['mx']))
            {
            	$np=$_GET['mx'];
                // echo $np;
                mysql_query("update $_homework_recom set flag='1' where task='$np'",$link) or die(mysql_error()."pppp");
            
            }

			$get_a=mysql_query("select * from $_homework_recom where flag!='1'",$link) or die(mysql_error());
			$a_num=mysql_num_rows($get_a);
			for($i=0;$i<$a_num;++$i)
            {
                $ta=mysql_fetch_array($get_a);
                $task_id=$ta[1];
                
                $get_w=mysql_query("select * from $_homework where `no.`='$task_id'",$link) or die(mysql_error());
                $row=mysql_fetch_array($get_w);
                echo "<li>";
      			echo "$row[3]($row[4])($row[2])";
                $unit=$row['flag'];

     	  		echo "<input type=\"button\"  onclick=\"window.location.href='http://cprogramplatform-homework.stor.sinaapp.com/$row[3]?num=$row[0]'\" value=\"下载\"></form>";
     	  		echo "<a href='../student homework/reans.php?id=$id&num=$row[0]&flag=$unit'>修正</a>";
                
                echo "&nbsp<a href='?mx=$task_id'>忽略</a>";
                echo "<br />";
                $res=mysql_query("select max(Homeworkscores) from `$_homework_comment` where `flag`=$unit",$link);
                $max=mysql_result($res,0,0);
                
     	  		$res=mysql_query("select * from `$_homework_comment` where `no.`=$row[0]",$link);
     	  		$num=mysql_num_rows($res);
 	  	  		for($j=0;$j<$num;$j++)
      	  		{	
           			$com=mysql_fetch_array($res);
                    echo  $com[2].'('.$com[5].')：'.$com[6]."&nbsp".$com['Homeworkscores']."分/最高分".$max;
                    
                     echo "&nbsp<a href='work_detail.php?id=$ta[0]&unit=$unit'>查看详情</a><br />";
       	  		}

                
            	
            }




		?>
        
 			

    </body>
     </html>