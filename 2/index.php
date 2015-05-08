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
$folder_name='upload';
$application='testroom';
$app = array();
$storage = 'testroom-upload.stor.sinaapp.com';
$word = 'app_';


/*$t=$word.'cprogramplatform';
 $sql="select * from $t.`classes`";
	$result=mysql_query($sql,$linkk);
	$row=mysql_fetch_array($result);
    $stu_count=mysql_num_rows($result); //计算平台的人数
    echo $stu_count;*/    


    

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
    $app = explode('.',$course_url);     
    //echo $app[0];
    $app = $word.$app[0];
    $sql="select * from $app.`classes`";
	$result=mysql_query($sql,$linkk);
	$row=mysql_fetch_array($result);
    $stu_count=mysql_num_rows($result); //计算平台的人数
    $sql_insert="insert into course values ('$course_name','$course_url','$stu_count','$course_introduce','$filename','$time')";
    $result=mysql_query($sql_insert,$link);
    
}

$sql = "select * from course";
$result = mysql_query($sql,$link);
if(!mysql_num_rows($result)){
	echo "还未添加课程";
}else{
	
	
?>
        
<table border='1'>   
<tr>
    <th> 平台名称</th>
    <th> 平台简介</th>
    <th> 关注人数</th>
    <th> 二维码</th>
</tr>
    <tr><td><img src='../c.jpg' />  </td></tr>
<?
        for($i=0;$i<mysql_num_rows($result);$i++){
            $course_arr = mysql_fetch_array($result);
            echo "<tr>";
            echo "<td><h2><a href=\"http://$course_arr[1]/manage/manage_student.php?id=admin\">$course_arr[0]</a></h2></td>";
            echo "<td> $course_arr[3]</td>";
            echo "<td> $course_arr[2]</td>";
            
            //header('content-type:$storage/$course_arr[4];');
            //$content=file_get_contents('test.jpg');
            // echo $content;
            
            echo "<td> <img src='$storage/$course_arr[4]' />  </td>";
            echo "</tr>";
	}
}


?>
        
    <img src='../c.jpg' />    
        
        </table>
<hr/>
<h3>新增课程名称</h3>
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