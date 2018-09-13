<?php
header("Content-type: text/html; charset=utf-8");
include '../connect_database.php'; 
	$result=mysql_query("select * from homework_comment",$link);
    $num=1;
	while($row=mysql_fetch_row($result))
	{
		echo "*********************<br>";
        echo "学生id:$row[1]<br>";
		echo "作业分数：$row[7]<br>";
		echo "第$row[8]次作业<br>";
        echo "第.$num.条记录<br>";
  
        $result_info=mysql_query("select * from $_classes where id='$row[1]'",$link);
        $row_info=mysql_fetch_row($result_info);
        if($row_info[3]=='网络1502')
        {
            
        	echo "我是1402班的第$row[8]次作业<br>";
            
            $result_net1402=mysql_query("select * from net1502_homework where id='$row[1]'  ",$link);
            $row_net1402=mysql_fetch_row($result_net1402);
            if($row_net1402==null)
            {
                //如果表中没有记录，则直接插入数据
                $con= "INSERT INTO net1502_homework (`id`,`username`,`class`)VALUES('$row[1]','$row_info[1]','$row_info[3]')";
 				$mysql->runSql($con);
               
                if($row[8]==1)
                {
                	$con_1= "UPDATE net1502_homework SET `1`='$row[7]' where id ='$row[1]'";
 					$mysql->runSql($con_1); 
                }
                else if($row[8]==2)
                {
                	$con_2= "UPDATE net1502_homework SET `2`='$row[7]' where id ='$row[1]'";
 					$mysql->runSql($con_2); 
                }
                else if($row[8]==3)
                {
                	$con_3= "UPDATE net1502_homework SET `3`='$row[7]' where id ='$row[1]'";
 					$mysql->runSql($con_3); 
                }
            
            }
            else
            {
                
            	 if($row[8]==1)
                {
                	$con_1= "UPDATE net1502_homework SET `1`='$row[7]' where id ='$row[1]'";
 					$mysql->runSql($con_1); 
                }
                else if($row[8]==2)
                {
                	$con_2= "UPDATE net1502_homework SET `2`='$row[7]' where id ='$row[1]'";
 					$mysql->runSql($con_2); 
                }
                else if($row[8]==3)
                {
                	$con_3= "UPDATE net1502_homework SET `3`='$row[7]' where id ='$row[1]'";
 					$mysql->runSql($con_3); 
                }
            
            }
            
        }
        
        $num++; 
        
        
        
        echo "*********************<br>";
        
        
	}

?>