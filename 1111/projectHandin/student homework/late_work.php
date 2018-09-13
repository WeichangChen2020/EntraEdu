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
           
			作业补交
		</h1>
        

<ul>
<?php

	
    include '../connect_database.php';  
	$id = $_GET['id'];
    echo     " <form action=\"../student homework/upload_file.php?id=$id&late=1\" method=\"post\"	enctype=\"multipart/form-data\">";
	echo "<br>";
	echo "<select name=\"flag\"  >";
	$get_class=mysql_query("select * from $_homework_list",$link) or die(a.mysql_error());
	for($i=1;$i<14;++$i)
    {
        $row=mysql_fetch_array($get_class);
        echo "<option  value=\"".$i."\">第".$i."章&nbsp".$row['ex_name']."</option>";
    
    }




//echo "<p id=a></p>";
	echo "</select>";
	echo "&nbsp&nbsp";
	echo "<select name=\"flag1\">";
	//echo "<option  value=\"1\">不覆盖</option>";
	echo "<option  value=\"2\">覆盖</option>";
	echo "<br>";
	echo "</select>";
	echo "<br>";
    echo "<br>";
    echo "<label for=\"file\">文件名:</label>"; 
	
	

	echo		"<input type=\"file\" name=\"file\" id=\"file\" />";



echo "<br/>";
echo "心得体会：<br />";
	echo		" <textarea name='review'cols='40' rows='5'></textarea>";
echo "<br/>";
	echo "<br>";
	echo "<br>";
	echo		"<input type=\"submit\" name=\"submit\" value=\"提交\" />";
	echo	"</form>";
  
        

//已上传作业和实验报告的学生
echo "

   </ul><hr /><ul>";
?>
        </body>
    </html>