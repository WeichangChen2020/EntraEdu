<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <body bgcolor="#AFEEEE">
    
        <h1>各课程列表</h1>
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
新增课程名称
        <hr/>
<form method='post' action=''>
<table width='400' border='0'>
<tr>
<td>课程名称：<input type="text" name="course_name" size=32 ></td>
</tr>
<tr>
<td>课程地址：<input type="text" name="course_url" size=32></td>
</tr>
    <tr><td>（如：cprogramplatform.sinaapp.com）</td></tr>
<tr>
<td  ><input type="submit" value="提交">
</tr>
</table>
</form>   
</body>
</html>