<html>
     <center>
<h3 >新增课程名称</h3>
<form method='post' action='index.php' enctype='multipart/form-data'>
<table width='400' border='1' '>
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
     </center>
</html>