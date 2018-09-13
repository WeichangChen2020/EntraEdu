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

        <h2>作业提交</h2>
        <hr />
        <li>上传实验报告</li>
              
         
      <ul>
          <li>上传须知</li>
          <ul>
          <li><font color="red">请同学们在当周实验结束后周末前结束之前提交实验报告，本模块分数包括有作业分和互评分两块，请同学们认真对待</font>  
          <li><font color="red">如有疑问请及时和助教联系</font>  
          <li>严禁相互抄袭，否则倒扣分数
          <li>实验报告要按照实验指导书中“实验报告内容”撰写，必须包括程序代码和运行结果的屏幕拷贝
          <li>实验报告上传文件名为：学号_班级_姓名_章名_实验.docx 
          <li><font color="green">请注意文档命名格式例：111150013_网络1102_张三_实验一_顺序结构与输入.docx</font>
          <li><font color="green">提交作业是请选择相应的实验，小心提交错误</font> 
          <li>上传文件大小不得超过500kb
              
              </ul>
          </ul>

  <hr />

<ul>
              <?php
//         $flag=1;
//echo   "    </ul>
//<hr />      
//<h2>

            
                //</h2>
                //<ul>";  
//echo "<br/>";
//echo "<font color=red>注意：请先选择作业的章节";
//echo "</font>";
	
    include '../connect_database.php'; 
	$id = $_GET['id'];
	$unit=$_GET['unit'];
	$unit_select=mysql_query("select * from $_homework_list where id='$unit'",$link) or die(mysql_error());
	$unit_name=mysql_result($unit_select,0,1);
	echo " <form action=\"../student homework/upload_file.php?id=$id&flag=$unit\" method=\"post\" enctype=\"multipart/form-data\">";
	echo "<b>实验".$unit.$unit_name."</b>";
	echo "&nbsp&nbsp";
	echo "<select name=\"flag1\">";
	echo "<option  value=\"1\">不覆盖</option>";
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
  
        
?></ul>
          </body>
     </html>