<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <body bgcolor="#AFEEEE">
    
        <h1 align='center'>教学互动平台列表</h1>
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
include 'update_database.php';

$folder_name='upload';
$application='testroom';
$app = array();
$application='testroom-upload.stor.sinaapp.com';
//$word = 'app_';


if($_POST){
	$course_name=$_POST['course_name'];
	$course_url=$_POST['course_url'];
    $course_introduce=$_POST['course_introduce'];
    if(!empty($_FILES))
    {
	  if($_FILES["file"]["error"] == 0)
        {          
            $file = new SaeStorage();
			$filename=$_FILES['file']['name'];
            $file->upload($folder_name,$filename,$_FILES['file']['tmp_name']);//把用户传到SAE的文件转存到名为test的storage
         
		}
	}
        
	$time=date("Y-m-d H:i:s",time());
    //$app = explode('.',$course_url);     
    //echo $app[0];
    // $app = $word.$app[0];
    //$sql="select * from $app.`classes`";
    //$result=mysql_query($sql,$link1);
    //$row=mysql_fetch_array($result);
    //$stu_count=mysql_num_rows($result); //计算平台的人数
    //$sql_insert="insert into course(coures_name,course_url,course_introduce,picture_url,time) values ('$course_name','$course_url','$course_introduce','$filename','$time')";
    $sql_insert = "INSERT INTO `course` (`course_name`, `course_url`, `course_introduce`, `picture_url`, `time`) VALUES ('$course_name','$course_url','$course_introduce','$filename','$time')";
    $result=mysql_query($sql_insert,$link);
      echo"<script type='text/javascript'>alert('提交成功，等待管理员的审核');location='../index.php';</script>";  
    
}

$sql = "select * from course where course_participants != 0";
$result = mysql_query($sql,$link);
if(!mysql_num_rows($result)){
	echo "还未添加课程";
}else{
	
	
?>
        
<table border='1' cellpadding="20">   
<tr>
    <th > 平台名称</th>
    <th> 平台简介</th>
    <th> 关注人数</th>
    <th> 二维码</th>
<?
        for($i=0;$i<mysql_num_rows($result);$i++){
            $course_arr = mysql_fetch_array($result);
            echo "<tr>";
            echo "<td align='center' style='width:300px;'><h2><a href=\"http://$course_arr[2]/manage/manage_student.php?id=admin\">$course_arr[1]</a></h2></td>";
            echo "<td align='center'style='width:350px;'><h3> $course_arr[4]</h3></td>";
            echo "<td align='center'style='width:100px;'><h3> $course_arr[3]</h3></td>";
            echo "<td> <img style='width:150px;' src='http://$application/$course_arr[5]' />  </td>";
            echo "</tr>";
	}
}


?>
         
      
        </table>
<hr/>
<h3 >新增课程名称</h3>
<form method='post' action='' enctype='multipart/form-data'>
<table width='400' border='1'>
<tr>
    <td>课程名称：</td><td><input type="text" name="course_name" size=32 ></td>
</tr>
<tr>
     <td>课程地址：</td><td><input type="text" name="course_url" size=32></td>
</tr>
<tr>
    <td colspan="2">（如：cprogramplatform.sinaapp.com）</td>
</tr>
<tr>
    <td rowspan="1">课程简介：</td>
    <td><textarea name="course_introduce" cols="33" rows="4"></textarea> </td>
</tr>
<tr>
    <td> 文件名:</td>
    <td><input type='file' name='file'  /></td>    
</tr>
<tr>
<td colspan="2" align="center" ><input type="submit" value="提交">
</tr>
</table>
</form>   
</body>
</html>