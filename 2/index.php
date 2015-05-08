<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <body bgcolor="#AFEEEE">
    
        <h1>教学互动平台列表</h1>
        <hr/>
<style type="text/css">
a:link,a:visited{
 text-decoration:none;  /*超链接无下划线*/
}
a:hover{
 text-decoration:underline;  /*鼠标放上去有下划线*/
}
</style>
<?php 
include 'connect_database.php';

if($_POST){
	$course_name=$_POST['course_name'];
	$course_url=$_POST['course_url'];
	$time=date("Y-m-d H:i:s",time());
	$sql_insert="insert into course values ('$course_name','$course_url','$time')";
	$result=mysql_query($sql_insert);
}

$sql = "select * from course";
$result = mysql_query($sql,$link);
if(!mysql_num_rows($result)){
	echo "还未添加课程";
}else{
	
	for($i=0;$i<mysql_num_rows($result);$i++){
        $course_arr = mysql_fetch_array($result);
		echo "<h2><a href=\"http://$course_arr[1]/manage/manage_student.php?id=admin\">$course_arr[0]</a></h2>";
	}
}


?>

<hr/>
<h3>新增课程名称</h3>
<form method='post' action='' >
<table width='400' border='1'>
<tr>
    <td>课程名称：</td><td><input type="text" name="course_name" size=32 ></td>
</tr>
<tr>
     <td>课程地址：</td><td><input type="text" name="course_url" size=32></td>
</tr>
<tr>
    <td>（如：cprogramplatform.sinaapp.com）</td>
</tr>
<tr>
    <td rowspan="4">课程简介：</td>
    <td><textarea name="course_intorduce "cols="33"rows="4"></textarea> </td>
</tr>
<tr>
     <label for='file'>文件名:</label>
<input type='file' name='file' id='file' />    
</tr>
<tr>
<td  ><input type="submit" value="提交">
</tr>
</table>
</form>   
</body>
</html>