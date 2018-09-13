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
		$d  =  "2015-10-12 00:00:00"; 
		
		$exper=mysql_query("select * from homework_list",$link) or die(mysql_error());
		$exper_num=mysql_num_rows($exper);
		for($i=1;$i<=$exper_num;$i++)
        {
            
            $ex_row=mysql_fetch_array($exper);
            //echo "实验".$i.$ex_row[1];

            echo "<h4><a href='homework_detail_2015.php?id=$id&unit=$i'>实验".$i.$ex_row[1];
            echo "<a/></h4>";
            echo "&nbsp&nbsp<b>作业提交</b>";
            //if($ex_row[2]==0)
                echo "[关闭]";
            //else
                //echo "<a href='homework_up_meu.php?id=$id&unit=$i'><font color='red'>[进入]</font><a>";
            
            echo "&nbsp&nbsp<b>互评任务</b>";
            //if($ex_row[3]==0)
                echo "[关闭]";
            //else
                //echo "<a href='homework_com_menu.php?id=$id&unit=$i'><font color='red'>[进入]</font><a>";
            
            echo "<br />";
        }
        
                
    ?>
</ul> 

</body>
</html>