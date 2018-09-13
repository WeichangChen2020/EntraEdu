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
           
			作业申诉
		</h1>
        


        <?php
		include '../connect_database.php'; 
		$id=$_GET['id'];
		$unit=$_GET['unit'];


		$get_home=mysql_query("select * from $_homework where uploader_id='$id' and flag='$unit'",$link) or die(mysql_error());
		@$home_id=mysql_result($get_home,0,0);
		if($home_id)
			$a=mysql_query("insert $_homework_recom(`id`,`task`,`unit`)values('$id','$home_id','$unit')",$link) or die(mysql_error());
		if($a)
			echo "申诉成功";
		else
            echo "出现问题了，请联系助教";
		?>
    </body>
</html>