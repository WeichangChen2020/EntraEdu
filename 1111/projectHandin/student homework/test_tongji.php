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
           
			测试统计
		</h1>
        <h4 align='center'>本模块分数，最晚交的算1分，未及时交的算2分</h4>
        <hr/>
        
        

<ul>
        <?php
		include '../connect_database.php'; 

		
	 $get_name_if=mysql_query("select * from $_danger_name order by score desc",$link) or die(mysql_error());
	 $d_num=mysql_num_rows($get_name_if);
	 for($i=0;$i<10;++$i)
     {
         if($i>$d_num)
             break;
         $row=mysql_fetch_array($get_name_if);
         echo "<h3 align='center'>".$row['name']."||分数：".$row['score']."</h3>";
     
     }



		?>
    
         
     </ul>
    </body>
     </html>