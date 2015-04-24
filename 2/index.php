<html>
<?php 
include 'conect_database.php';

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
	$course_arr = mysql_fetch_array($result);
	for($i=0;$i<mysql_num_rows($result);$i++){
		echo "<h2><a href=\"http://$course_arr[0]/manage/manage_student.php?id='admin'\">$course_arr[1]</a></h2>";
	}
}


?>

<form method='post' action=''>
<table width='500' border='0'>
<tr>
<td>课程名称：<input type="text" name="course_name"></td>
<td>课程地址：<input type="text" name="course_url"></td>
</tr>
</table>
</form>



</html>>