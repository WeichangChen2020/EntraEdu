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
     <h1 align="center">
           
			实验报告
		</h1>
      <h2>
          
              <li>上传实验报告</li>
              
          </h2>
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
        <ul>
          <li>作业互评</li>
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
          <li>作业和实验报告上传区</li>
          
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

              
              
	$ownset=3;
     $flagshow=$_POST['flag_show']; 
     

          




$id = $_GET['id'];
	
	
    echo     " <form action=\"../student homework/upload_file.php?id=$id&\" method=\"post\"
			enctype=\"multipart/form-data\">";
	echo "<br>";
	echo "<select name=\"flag\"  >";
  echo "<option  value=\"1\">实验一  顺序结构与输入</option>";
  echo "<option  value=\"2\">实验二 各种分支结构</option>";
  echo "<option  value=\"3\">实验三 循环结构和转移语句</option>";
  echo "<option  value=\"4\">实验四 数组和字符串</option>";
  echo "<option  value=\"5\">实验五 函数与变量</option>";
  echo "<option  value=\"6\">实验六 定义编译预处理</option>";
  echo "<option  value=\"7\">实验七 指针及其运算</option>";
  echo "<option  value=\"8\">实验八 指针与字符串</option>";
  echo "<option  value=\"9\">实验九 指针与数组</option>";
  echo "<option  value=\"10\">实验十 指针与函数</option>";
  echo "<option  value=\"11\">实验十一 结构体(struct)与共用体(union)</option>";



//echo "<p id=a></p>";
	echo "</select>";
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
  
        

//已上传作业和实验报告的学生
echo "

   </ul><hr /><ul>";


echo '<h4>实验'.$ownset.'待批改互评作业</h4>';
					echo "<li><a href=\"../kec/参考答案_$ownset.docx\">参考答案_$ownset(仅供参考)</a></li>";
					$task_set=mysql_query("select * from $_mul_task where id='$id'",$link) or die(mysql_error());
					$row_set=mysql_fetch_array($task_set);
//$task_que=$flagshow+1;
					$task_que=1+$ownset;
					$task_num=$row_set[$task_que];
					if(1)
                    {
                        //$no=$task_num[];
                        $task_con=mysql_query("select * from $_homework where `no.`='$task_num'",$link) or die(mysql_error());
                        $check_task_con=mysql_num_rows($task_con);
                        if($check_task_con==0||$task_num==0)
                        {
                            echo '<li>您未按时提交作业,无法参与互评</li>';
                        }
                        else
                        {
						$task_arr=mysql_fetch_array($task_con);
						echo "<li>";
                    	echo "$task_arr[9]($task_arr[4])";
                    	echo "<input type=\"button\"  onclick=\"window.location.href='http://cprogramplatform-homework.stor.sinaapp.com/$task_arr[9]?num=$task_arr[0]'\" value=\"下载\"></form>";
                  
                        $read_ck=mysql_query("select * from $_homework_comment where `name`='$rowTypee' and flag='$ownset'",$link) or die(mysql_error());
                        $read_ck_f=mysql_num_rows($read_ck);
                        if($read_ck_f==0)                 
                  			echo "<a href='ans.php?id=$id&num=$task_arr[0]&flag=$task_arr[8]'>评价</a></li>";
                        else
                        {
                        	echo '<font color="blue">        已评阅</font> ';
                        }
                        }
                        // echo '<hr />';
                    }

echo '<hr /> ';
echo "<b>.互评作业↑↑：前两次互评为测试，同学们不用担心，不计入总分。但是请认真对待第3次开始的互评</b><br/>";
echo '<hr /> ';

//$get_num_h=mysql_query("select max(flag) from homework where id='$id'",$link) or die(mysql_error());
//$aaa=mysql_result($get_num_h,0,0);

for($ff=1;$ff<=$ownset+2;$ff++)
{

echo '第'.$ff.'次作业提交状态：';
$check_homework=mysql_query("select * from $_homework where flag='$ff' and author in (select username from classes where id='$id')",$link) or die(mysql_error());
if(mysql_num_rows($check_homework)!=0)
{
    $row_check=mysql_fetch_array($check_homework);
    if($row_check['size']=='0.00 Kb')
        echo '<font color="green">提交内容错误</font>';
    else
		echo '<font color="blue">已提交</font> ';
    
}
else
    echo '<font color="red">未提交</font> ';


$check_com=mysql_query("select * from $_homework_comment where flag='$ff' and id='$id'",$link) or die(mysql_error());
if(mysql_num_rows($check_com)!=0)
{
    //$row=mysql_fetch_array($check_homework);
    //if($row['size']=='0.00 Kb')
    //echo '<font color="green">提交内容错误</font>';
    // else
		echo '<font color="blue">已评阅</font> ';
    	echo "<br />";
    	$my_work=mysql_query("select * from $_homework where flag='$ff' and uploader_id='$id'",$link) or die(mysql_error());
    	$my_w_row=mysql_fetch_array($my_work);
    	echo "$my_w_row[3]($my_w_row[4])";
    	echo "<input type=\"button\"  onclick=\"window.location.href='http://cprogramplatform-homework.stor.sinaapp.com/$my_w_row[3]?num=$my_w_row[0]'\" value=\"下载\"></form>";
    	echo "<br />";
    	$my_res=mysql_query("select * from `$_homework_comment` where `no.`=$my_w_row[0]",$link);
        @$my_com=mysql_fetch_array($my_res);
   		echo  '评阅者('.$my_com[5].')：'.$my_com[6].'<br />';
    	echo "该作业的分数为：".$my_com[7];
}
else
{
    	echo '<font color="red">未评阅</font> ';
}

echo '<br />';

echo '第'.$ff.'次作业互评任务：';

$check_homework=mysql_query("select * from $_homework_comment where flag='$ff' and name in (select username from classes where id='$id')",$link) or die(mysql_error());
if(mysql_num_rows($check_homework)!=0)
{
		echo '<font color="blue">已完成（+1）</font> ';
    
}
else
{
     if($ff<$ownset)
        echo '<font color="green">未完成或未按时提交（-1）</font> ';
    else
    	echo '<font color="red">未完成</font> ';
}

echo '<br />';
echo '<hr />';
}

echo "
      </ul> <ul>";
echo "<h2><li>单元选择</li></h2>";

$id = $_GET['id'];


				
                       $result=mysql_query("select * from `$_homework` where savename!=''order by time desc",$link);
                     		$nums=mysql_num_rows($result);
				 $sqlType = "select type from classes where id='$id'";
                        $resType = mysql_query($sqlType, $link);
                        $rowType = mysql_fetch_row($resType);
				 $sqlTypee = "select username from classes where id='$id'";
                        $resTypee = mysql_query($sqlTypee, $link);
                        @$rowTypee = mysql_result($resTypee,0);
//$select_value = isset($_GET['select']) ? $_GET['select'] : '';

if(isset($_POST['flag_show'])) {
			$flag = $_POST['flag_show'];
}
?>
    <form id='form2'  action='' method="post"> 
	<select id='select2' name="flag_show">
	<option  value="1"
        <?php
        if($flag == '1')
            echo "selected";
        ?>
        >实验一  顺序结构与输入</option>
	<option  value="2" 
         <?php
        if($flag == '2')
            echo "selected";
        ?>
        >实验二 各种分支结构</option>
        <option  value="3"
          <?php
        if($flag == '3')
            echo "selected";
        ?>
        >实验三 循环结构和转移语句</option>
    <option  value="4"
          <?php
        if($flag == '4')
            echo "selected";
        ?>
        >实验四 数组和字符串</option>
        	<option  value="5"
          <?php
        if($flag == '5')
            echo "selected";
        ?>
        >实验五 函数与变量</option>
	<option  value="6"
          <?php
        if($flag == '6')
            echo "selected";
        ?>
        >实验六 定义编译预处理</option>
	<option  value="7"
          <?php
        if($flag == '7')
            echo "selected";
        ?>
        >实验七 指针及其运算</option>
	<option  value="8"
          <?php
        if($flag == '8')
            echo "selected";
        ?>
        >实验八 指针与字符串</option>
        	<option  value="9"
          <?php
        if($flag == '9')
            echo "selected";
        ?>
        >实验九 指针与数组</option>
	<option  value="10"
          <?php
        if($flag == '10')
            echo "selected";
        ?>
        >实验十 指针与函数</option>
        	<option  value="11"
          <?php
        if($flag == '11')
            echo "selected";
        ?>
        >实验十一 结构体(struct)与共用体(union)</option>
<p id=a></p>;
	<br/>
	</select>
   <input type="submit" name="submit" value="确定" />
	</form>
          
<?
    
 echo   "      <h2>
            <li>已经批改的实验报告
            
		</h2>
      ";  
//if(!isset($_POST['flag_show']))
//$flag_show=1;
//else
   
//echo "*******$flagshow****";
    if($flagshow==null)
        $flagshow=1;
//echo "<br>*******$flagshow****";

					echo '<hr />';
					
echo "<b>最新批改：</b>";
$flag_num=0;

 			        for($i=0;$i<$nums&&$flag_num<4;$i++)
                 
                 {	
                         $row=mysql_fetch_array($result);
               
                        //    if($row[5]!=null)
                        //      {      
                        if($row[8]==$flagshow){
                            $flag_num++;
                            
                            //echo "<div id=\"demo\">";
                       
                            //echo "<ul>";
                            echo "<li>";
       	           echo "$row[3]($row[4])";
                    //   echo "已下载$row[6]次</h3> ";
                     
                    //    echo "<form name='form1' action=\"/student project/download.php?id=$row[0]&savefile=$row[5]\" method=\"post\">";
                    //   echo "<input type=\"submit\" name=\"sub1\" value=\"下载\"> </form>";
                        //echo "<input type=\"button\"  onclick=\"window.location.href='http://ieelab.zjgsu.edu.cn/zgb/project/$row[5]?num=$row[0]'\" value=\"下载\"></form>";
                       
                        if($rowType[0] == 1) { 
                        	echo "<input type=\"button\"  onclick=\"window.location.href='http://cprogramplatform-homework.stor.sinaapp.com/$row[3]?num=$row[0]'\" value=\"下载\"></form>";

                            //echo "<a href='../student project/ans.php?id=$id&num=$row[0]'>评价</a>";
                        }
                    echo	"<br />";
                     
                            //echo "<h4>";  
                    $res=mysql_query("select * from `$_homework_comment` where `no.`=$row[0]",$link);
                     		$num=mysql_num_rows($res);
 			        for($j=0;$j<$num;$j++)
                 
                 {	 $com=mysql_fetch_array($res);
                  
                  $remark="";
                   $rema=mysql_query("select * from `$_home_work_detail` where `no`=$row[0]",$link);
                  $remark_arr=mysql_fetch_array($rema);
                  if($remark_arr[4]==NULL)
                      $remark_arr[4]="未评价";
                  if($remark_arr[5]==NULL)
                      $remark_arr[5]="未评价";
                  if($remark_arr[6]==NULL)
                      $remark_arr[6]="未评价";
                  $remark='<b>验证题：</b>'.$remark_arr[4].'、<b>填空改错题：</b>'.$remark_arr[5].'、<b>编程题：</b>'.$remark_arr[6];
                  echo  '评阅者('.$com[5].')：'.$com[6].'<br />';
                  
                  
                  
                  echo "<br/>";
                  echo "该作业的分数为：".$com[7];
                  echo	"<br />";  
                    }
                            //echo	"</h4>";
                    echo "</li>";    
                            //echo "</ul>";
                            //echo "</div>";
                        }
                        //     }
                  
                    }
                     echo "<li>"; 
					 echo "<a href=\"detail.php?flagshow=$flagshow\">查看更多</a>";
                     echo "</li>"; 
                    $se_st_num=mysql_query("select * from $_homework where flag='$flagshow' group by author ",$link) or die(mysql_error());
					$up_num=mysql_num_rows($se_st_num);




					
//if($flagshow<=$ownset)
//  {
// 	$ownset=$flagshow;
//   }


                     echo   "</ul> <hr /> <h2> <li>第".$flagshow."次待批改实验报告</h2>  <ul>";  








					echo "已提交人数：$up_num     <a href=\"unupdate.php?flag=$flagshow\">未提交名单</a><br /><hr/>";  





						$ac_work=mysql_query("select * from `$_homework` where savename!='' and flag='$flagshow'",$link);
						$ac_1=mysql_num_rows($ac_work);
						$ac_work=mysql_query("select * from `$_homework` where flag='$flagshow'",$link);
						$ac_2=mysql_num_rows($ac_work);


					echo "批改总进度：$ac_1/$ac_2   <br />";








              
                       $result=mysql_query("select * from `$_homework` where savename='' and flag='$flagshow'",$link);
                     		$nums=mysql_num_rows($result);
 			        for($i=0;$i<$nums;$i++)
                 
                 	{	
                         $row=mysql_fetch_array($result);
               
                        //    if($row[5]!=null)
                        //      {     
                        //echo "<div id=\"demo\">";
                       
                        //echo "<ul>";
                        echo "<li>";
                        echo "$row[3]($row[4])($row[2])";
                        if($rowType[0] == 1) { 
                        echo "<input type=\"button\"  onclick=\"window.location.href='http://cprogramplatform-homework.stor.sinaapp.com/$row[3]?num=$row[0]'\" value=\"下载\"></form>";
                  
                       		echo "<a href='../student homework/ans.php?id=$id&num=$row[0]&flag=$flagshow'>评价</a>";
                            //echo "<br/>";
                            //echo "<h4>";  
                    $res=mysql_query("select * from `$_homework_comment` where `no.`=$row[0]",$link);
                     		$num=mysql_num_rows($res);
 			        for($j=0;$j<$num;$j++)
                 
                 {	 $com=mysql_fetch_array($res);
                  echo  $com[2].'('.$com[5].')：'.$com[6];
                  //echo	"<br />";  
                    }
                            //echo	"</h4>";
               
                            //echo "</li>";    
                            //echo "</ul>";
                            //echo "</div>";
                        //     }
                  
                    }
                        
                        
                         
                        //echo "</li>";    
                        //echo "</ul>";
                        //echo "</div>";
                  }


echo "<br>";
echo "<br>";
echo "<br>";
                           
                
          ?>          
     
          </ul>
    </body>
     
     </html>