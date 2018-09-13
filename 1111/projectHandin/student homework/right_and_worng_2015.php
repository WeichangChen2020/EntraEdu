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
     <h1 align="center">正确率统计</h1>
    <hr/>
           
<ul>
    <?php

		include '../connect_database.php'; 
		$unit=$_GET['unit'];
		
	 $get_unit_num=mysql_query("select * from home_work_score where chapter='$unit'",$link) or die(mysql_error());
	 $ck_num=mysql_num_rows($get_unit_num);
	 if($ck_num!=0)
     {
     	$row=mysql_fetch_array($get_unit_num);
         echo "<h1>第".$row[0]."单元</h1>";
         $sum=$row[1]+$row[2]+$row[3];
         for($i=0;$i<$sum;)
         {
             $i++;
             echo "第".$i."题：";
             $get_all=mysql_query("select * from home_work_detail where flag='$unit' group by id ",$link) or die(mysql_error());
             $all=mysql_num_rows($get_all);
             $get_right=mysql_query("select * from home_work_detail where score_$i='1' and flag='$unit' group by id ",$link) or die(mysql_error());
         	 $right=mysql_num_rows($get_right);
             if($all==0)
             {
                 $acc=0;
             }
             else
             {
                 $acc=$right/$all;
             }
             $acc=$acc*100;
              echo "正确率：".sprintf("%.2f", $acc);
              echo "%[";
              echo $right."|";
              echo $all."]";
             echo "<br />";
                     
         }    
     
    }

	?>
            
     </ul>
    </body>
</html>