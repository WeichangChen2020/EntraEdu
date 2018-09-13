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
           
			作业报告
		</h1>
        

<ul>
        <?php
		include '../connect_database.php'; 

		
		$danger_flag=mysql_query("select max(unit) from $_danger_name",$link) or die(mysql_error());
		$danger_unit=mysql_result($danger_flag,0,0);
		$danger_t=mysql_query("select max(time) from $_danger_name",$link) or die(mysql_error());
		$danger_time=mysql_result($danger_t,0,0);

		$now_time=date("Y-m-d H:i:s",time());
//echo $danger_time.$now_time;
		$danger_time=date("Y-m-d H:i:s",strtotime("$danger_time   +7   day"));
        
        if($now_time>$danger_time)
        {
            echo "<font color='red'>信息已更新，请刷新</font><br />";
        }

		for($i=0;$i<13;)
        { 	
            
            ++$i;
            echo "第".$i."作业<br/>";
            $unup=mysql_query("select * from $_classes where (class='$_class1' or class='$_class2') and id not in (select uploader_id from $_homework where flag='$i')",$link) or die(mysql_error());
			$un_num=mysql_num_rows($unup);
			if($un_num==0)
                echo "本次作业全部提交<br />";
			else
			{
                if($un_num<10)
                {
    				echo "<font color='green'>未提交名单：$nbsp";
    				for($j=0;$j<$un_num;$j++)
    				{
   						$row=mysql_fetch_array($unup);
        				echo $row['username'];
                        
        				echo '、';
                        if($now_time>$danger_time&&$i>$danger_unit)
        				{
                            $d_name=$row['username'];
            				$sure_name=mysql_query("select * from $_danger_name where name='$d_name'",$link) or die(mysql_error());
                            $sure_num=mysql_num_rows($sure_name);
                            $score=2;
                            if($sure_num==0)
                            {
                                mysql_query("insert into $_danger_name(`name`,`unit`,`score`,`time`)values('$d_name','$i','$score','$now_time')",$link) or die(mysql_error());
                            
                            }
                            else
                            {
                                $old_score=mysql_result($sure_name,0,2);
                                $new_score=$old_score+$score;
                  
                                mysql_query("update $_danger_name set score='$new_score',unit='$i',time='$now_time' where name='$d_name'",$link) or die(mysql_error());
                            
                            }
        				}
        
    				}
                }
                echo '</font><br/>';
			}
            if($un_num<10)
            {
				$get_num_h=mysql_query("select * from $_homework where flag='$i' order by time desc",$link) or die(mysql_error());
            	$num=mysql_num_rows($get_num_h);
                echo "最后".(10-$un_num)."名：<br/>";
            	for($j=0;$j<10-$un_num;++$j)
            	{
                	if($j>=$num)
                    	break;
                	$row=mysql_fetch_array($get_num_h);
					$name=$row['author'];
                	echo $name."||";
                    if($now_time>$danger_time&&$i>$danger_unit)
        			{
                        //$d_name=$row['username'];
            				$sure_name=mysql_query("select * from $_danger_name where name='$name'",$link) or die(mysql_error());
                            $sure_num=mysql_num_rows($sure_name);
                            $score=1;
                            if($sure_num==0)
                            {
                                mysql_query("insert into $_danger_name(`name`,`unit`,`score`,`time`)values('$name','$i','$score','$now_time')",$link) or die(mysql_error());
                            
                            }
                            else
                            {
                                $old_score=mysql_result($sure_name,0,2);
                                $new_score=$old_score+$score;
                  
                                mysql_query("update $_danger_name set score='$new_score',unit='$i',time='$now_time' where name='$name'",$link) or die(mysql_error());
                            
                            }
        			}
        

           		 }	
            }
            
            echo "<br />";
            echo "<hr />";
            
        }
		
	



		?>
    
         
     </ul>
    </body>
     </html>