<html>
     {background-color:#00FFFF}
     
     <style> 
 
#increase  
{  
   background-color: #fff;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#eee));
    background-image: -webkit-linear-gradient(top, #fff, #eee);
    background-image: -moz-linear-gradient(top, #fff, #eee);
    background-image: -ms-linear-gradient(top, #fff, #eee);
    background-image: -o-linear-gradient(top, #fff, #eee);
    background-image: linear-gradient(top, #fff, #eee);
   width:500px;
   height:450px;
   box-shadow:  
          0 0 2px rgba(0, 0, 0, 0.2),  
          0 1px 30px rgba(0, 0, 0, .2),  
          0 3px 0 #fff,  
          0 4px 0 rgba(0, 0, 0, .2),  
          0 6px 0 #fff,  
          0 7px 0 rgba(0, 0, 0, .2);
} 
</style> 
     
     
     <center>
<h1 >新增课程名称</h1>
<form method='post' action='index.php' enctype='multipart/form-data' id="increase">
<table width='500' height ='400'border='0' >
<tr>
    <td align='right'>课程名称：</td><td><input type="text" name="course_name" size=45 ></td>
</tr>
<tr>
     <td align='right'>课程地址：</td><td><input type="text" name="course_url" size=45></td>
</tr>
<tr>
    <td align='center'colspan="2" height='20'>（如：cprogramplatform.sinaapp.com）</td>
</tr>
<tr>
    <td align='right' rowspan="1">课程简介：</td>
    <td><textarea name="course_introduce" cols="47" rows="4"></textarea> </td>
</tr>
<tr>
    <td align='right'> 课程二维码:</td>
    <td><input type='file' name='file'  /></td>    
</tr>
<tr>
<td colspan="2" align="center" ><input type="submit" value="提交">
</tr>
</table>
</form>  
     </center>
</html>