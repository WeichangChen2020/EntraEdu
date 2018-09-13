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
           
			学生心得汇总
		</h1>
        

<ul>
       <?php
		include '../connect_database.php'; 
		$id=$_GET['id'];
		$unit=$_GET['unit'];
		echo "<input type=\"button\"  onclick=\"window.location.href='homework_detail.php?id=$id&unit=$unit'\" value=\"返回\">";
		echo "<h4>第".$unit."单元</h4>";
		echo "<hr />";
		$get_type=mysql_query("select type from $_classes where id='$id'",$link) or die(a.mysql_error());
        @$type=mysql_result($get_type,0,0);
		if($type==1&&!(isset($_GET['x'])))
        {
            echo "<a href='?x=1&id=$id&unit=$unit'>查看姓名</a><br /><hr />";
        }
		else if($type==1&&isset($_GET['x']))
        {
            echo "<a href='?id=$id&unit=$unit'>隐藏姓名</a><br /><hr />";
        }

		$get_inf=mysql_query("select * from $_homework where flag='$unit' and review!=''",$link) or die(a.mysql_error());
		$get_inf_num=mysql_num_rows($get_inf);
		for($i=0;$i<$get_inf_num;++$i)
        {
        	$row=mysql_fetch_array($get_inf);
            $up_id=$row['uploader_id'];
            
            if(isset($_GET['x']))
            {
                $get_name=mysql_query("select username from $_classes where id='$up_id'",$link) or die(a.mysql_error());
            	@$name=mysql_result($get_name,0,0);
                echo $name.":".$row['review'];
                
            }
            else
                echo "同学心得:".$row['review'];
            echo "<br />";
            
            
            
            $get_com=mysql_query("select * from $_homework_comment where flag='$unit' and id='$up_id'",$link) or die(a.mysql_error());
            @$c_name=mysql_result($get_com,0,2);
            @$comment=mysql_result($get_com,0,6);
            echo "&nbsp评价：".$comment;
            echo "<br />";
            
            echo "<hr />";
        
        }

?>
    
         
     </ul>
    </body>
     </html>