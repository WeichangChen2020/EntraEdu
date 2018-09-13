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

        <h2>互评任务</h2>
        <hr />
              
         
      <ul>
          <ul>
  		  <li><font color="blue">未按时提交作业的同学视为放弃互评分，无法参加互评</font> 
          <li><font color="blue">未按时完成批改任务的同学，也无法得到互评分</font>
          <li><font color="red">互评结束时间一般定为开始布置批改任务的一周之后</font>   
          <li>严禁相互抄袭，否则倒扣分数
          <li>每次实验报告每题一分，正确1分错误0分，编程题请在C环境中运行，得到正确结果才算正确
          <li>每位同学在得到通知后，在待批改互评作业里下载其他同学的实验进行批改
          <li>批改完毕后，在评阅里进行打分，并将批改后的报告提交到平台。
          <li>假如待批改显示同学未提交，则请稍后再批改，通知助教
          <li>批改后报告提交格式例：批改者名_原文件名.docx：李四_111150013_网络1102_张三_实验一_顺序结构与输入.docx
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
	$sqlType = "select type from $_classes where id='$id'";
    $resType = mysql_query($sqlType, $link);
    $rowType = mysql_fetch_row($resType);//
	$sqlTypee = "select username from $_classes where id='$id'";
    $resTypee = mysql_query($sqlTypee, $link);
    @$rowTypee = mysql_result($resTypee,0);
	$unit_select=mysql_query("select * from $_homework_list where id='$unit'",$link) or die(mysql_error());
	$unit_name=mysql_result($unit_select,0,1);;
	echo "<b>实验".$unit.$unit_name."互评作业</b>";
	echo "&nbsp&nbsp";
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "<li><a href=\"../kec/参考答案_$unit.docx\">参考答案_$unit(仅供参考)[点我下载]</a></li>";
	echo "<hr />";
	echo "待评作业<br />";
	$task_set=mysql_query("select * from $_mul_task where id='$id'",$link) or die(mysql_error());
	$row_set=mysql_fetch_array($task_set);
	$task_que=1+$unit;
	$task_num=$row_set[$task_que];//分配的实验报告的no.
    $task_con=mysql_query("select * from $_homework where `no.`='$task_num'",$link) or die(mysql_error());
    $check_task_con=mysql_num_rows($task_con);//存在就1，不存在就0
    if($check_task_con==0||$task_num==0)
    {
        echo '<li>暂时无法参与互评</li>';
    }
    else
    {
		$task_arr=mysql_fetch_array($task_con);
		echo "<li>";
        echo "$task_arr[9]($task_arr[4])";
        echo "<input type=\"button\"  onclick=\"window.location.href='http://cprogramplatform-homework.stor.sinaapp.com/$task_arr[9]?num=$task_arr[0]'\" value=\"下载\"></form>";
                  
        $read_ck=mysql_query("select * from $_homework_comment where `name`='$rowTypee' and flag='$unit'",$link) or die(mysql_error());
        $read_ck_f=mysql_num_rows($read_ck);
        if($read_ck_f==0)                 
        echo "<a href='ans.php?id=$id&num=$task_arr[0]&flag=$task_arr[8]'>评价</a></li>";
        else
        {
            echo '<font color="blue">        已评阅</font> ';
        }
     }

	
  
        
?></ul>
          </body>
     </html>