<meta name="viewport"   content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=yes" /> 
<meta http-equiv="content-type" content="text/html;charset=utf-8">

<?php

  include '../connect_database.php';  
  //$mysql  =   new SaeMysql();
  $id = $_GET['id']; 
  $chapter=$_GET['flag']; 
  $num = $_GET['num']; 


	$sql="select * from `homework` where  `no.` = '$num'";
  $result=mysql_query($sql,$link);
  @$filename=mysql_result($result,0,3);
  @$uploader_id=mysql_result($result,0,7);
//echo $uploader_id;
     //$StudentID =  substr("$filename",0,9);//获取学生学号
     @$flag=mysql_result($result,0,8);//获取作业次数
     $sql_1="select * from `classes` where  `id` = '$uploader_id'";
     $result=mysql_query($sql_1,$link);
     @$student_name=mysql_result($result,0,1);
     @$student_class=mysql_result($result,0,3);
     $contentStr=date("Y-m-d H:i:s",time());	
        	 
     $content ="对该同学第".$flag."次作业的评价：<br />";
     echo $content;


if($_POST['number_1']&&($_FILES['file']['name']!=null))
{
    echo"<font color=\"red\">你的点评已提交</font><br />";
    echo "<input type=\"button\"  onclick=\"window.location.href='/student homework/homework_detail_2015.php?id=$id&unit=$chapter'\" value=\"返回上一页\">";
}
echo "<hr />";

$review=mysql_query("select * from homework where flag='$chapter'and uploader_id= '$uploader_id' ",$link) or die(mysql_error());
@$review_row=mysql_fetch_array($review);

echo "<b>该同学心得体会：</b><br />";
if($review_row[12]==NULL)
    echo "空，请在word中查看是否有心得体会<br />";
else
    echo "$review_row[12]<br />";

echo '<hr />';
$que_ana=mysql_query("select * from home_work_score where chapter='$chapter'",$link) or die(mysql_error());
@$que_row=mysql_fetch_array($que_ana);

echo "<form name='form1' action=\"\" method=\"post\" enctype=\"multipart/form-data\">";
echo "<label for=\"file\">批改后的作业:</label>"; 
echo		"<input type=\"file\" name=\"file\" id=\"file\" />";
echo "<br>";





$nua=1;


echo "<br>";
echo "输入你的评价：";
echo "<br>";
echo "程序验证题目（共$que_row[1]题）：";
echo "<br>";
for($i=1;$i<=$que_row[1];$i++)
{
    echo "$nua .";
	echo "<input type='radio' name='number_$nua' value='1'/> 对"; 
    echo "<input type='radio' name='number_$nua' value='0'/> 错"; 
    $nua++;
    echo "<br>";
    echo "<br>";
}

echo "<br>";
echo "填空改错题目（共$que_row[2]题）：";
echo "<br>";
for($i=1;$i<=$que_row[2];$i++)
{
    echo "$nua .";
	echo "<input type='radio' name='number_$nua' value='1'/> 对"; 
    echo "<input type='radio' name='number_$nua' value='0'/> 错"; 
    $nua++;
    echo "<br>";
    echo "<br>";
}



echo "<br>";
echo "编程题（共$que_row[3]题）：";
echo "<br>";
for($i=1;$i<=$que_row[3];$i++)
{
    echo "$nua .";
	echo "<input type='radio' name='number_$nua' value='1'/> 对"; 
    echo "<input type='radio' name='number_$nua' value='0'/> 错"; 
    $nua++;
    echo "<br>";
    echo "<br>";
}

echo "<br>";
echo "<br>";
echo "心得：";
	echo "<input type='radio' name='number_$nua' value='3'/> 优秀"; 
	echo "<input type='radio' name='number_$nua' value='2'/> 良好"; 
	echo "<input type='radio' name='number_$nua' value='1'/> 一般"; 
    echo "<input type='radio' name='number_$nua' value='0'/> 未写"; 						
echo "<br>";
echo "<br>";
echo "评语：<br />";

//echo "<input name=\"answer\" type=\"text\"  value=\"".$_POST['answer']."\"size=\"50\"><br>";
echo "<textarea name=\"answer\" type=\"text\"  value=\"".$_POST['answer']."\"rows=\"8\" cols=\"45\"></textarea>";
echo "<br/>";
echo "<br>";
echo "<input name='num' type='hidden' value='".$_GET['num']."'>";
echo "<input type=\"submit\" name=\"sub1\" value=\"提交\"> </form>";
echo "<br>";



if($_POST)
{
    $s=trim($_POST['answer']);
	$number=array();
    $sum=0;
    //echo $nua;
    for($j=1;$j<=$nua;$j++)
    {
    	$number[$j]=$_POST["number_$j"];
        //echo "a".$number[$j];
        if($number[$j]==NULL)
            break;
        $sum+=$number[$j];
    
    }
    if($j<=$nua)
    {
        echo "<script>alert(\"信息输入不完整,请重新输入\")</script>";
        echo "信息输入不完整,请重新输入（按游览器的回退键）<br/>";
        echo "<input type=\"button\"  onclick=\"window.location.href='/student homework/homework_detail_2015.php?id=$id&unit=$chapter'\" value=\"返回上一页\">";
        exit();
    
    }
    if($_FILES['file']['name']==null)
    {
        echo "<script>alert(\"未提交文件\")</script>";
    	echo "未提交文件<br/>";
        echo "<input type=\"button\"  onclick=\"window.location.href='/student homework/homework_detail_2015.php?id=$id&unit=$chapter'\" value=\"返回上一页\">";
        exit();
    
    }
    
    
    
    
    
    
    
     $s2 = new SaeStorage();
     $name =$_FILES['file']['name'];
     $_FILES["file"]["size"]= number_format( $_FILES["file"]["size"] / 1024, 2);		
     $size =$_FILES["file"]["size"] . " Kb";
     $a=$_FILES["file"]["size"]*1;
     $name="[已批改]".$name;

     if($a>500) 
     {
        echo "文件大小超过500k，不能上传<br />";
        echo "<input type=\"button\"  onclick=\"window.location.href='/student homework/homework_detail_2015.php?id=$id&unit=$chapter'\" value=\"返回上一页\">";
        exit();
      }
      else
      {
          echo $s2->upload('homework/modified2',$name,$_FILES['file']['tmp_name']);
                            		   
              $con= "INSERT INTO `homework_mark` (`author`,`time`,`filename`,`size`,`uploader_id`,`flag`) VALUES ('$student_name','$contentStr','$name','$size','$id','$chapter')";
              mysql_query($con,$link) or die(mysql_error());
            
       }	
    

    
    $detail=mysql_query("insert into home_work_detail(id,score_1,score_2,score_4,score_3,score_5,score_6,score_7,score_8,score_9,
    score_10,score_11,score_12,score_13,score_14,score_15,no,flag) values('$uploader_id','$number[1]','$number[2]','$number[3]','$number[4]','$number[5]','$number[6]','$number[7]'
    ,'$number[8]','$number[9]','$number[10]','$number[11]','$number[12]','$number[13]','$number[14]','$number[15]','$num','$chapter')",$link) or die(mysql_error());
    
    
    $Homeworkscores = $sum;//获取到此题的分数
    
 	
    $num = $_POST['num'];
    $correctSql = "update homework set savename='$id' where `no.`='$num'";
    if(!mysql_query($correctSql, $link))
        echo mysql_error();

                       $contentStr = date("Y-m-d H:i:s",time());
                       
                     $sql="select * from `classes` where id='$id'";
                        	$result=mysql_query($sql,$link);
                       		$name=mysql_result($result,0,1);
                       $number=mysql_result($result,0,2);
                       $class=mysql_result($result,0,3);
                    
                     
                    
                       
                                 $con    =   "INSERT INTO `homework_comment`(`no.`,`id`,`name`,`number`,`class`,`time`,`comment`,`Homeworkscores`,`flag`) VALUES ('$num','$uploader_id','$name','$number','$class','$contentStr','$s','$Homeworkscores','$chapter')";
                      
                             	mysql_query($con,$link) or die(mysql_error());
                      
                      
                       
                       
                       $content = "你的点评：<br />".$name."(".$contentStr."）：".$s;
                   
                     	
                			echo $content;
                   
       
   

}

echo "<br>";
echo "<input type=\"button\"  onclick=\"window.location.href='/student homework/homework_detail_2015.php?id=$id&unit=$chapter'\" value=\"返回上一页\">";



//****************************************将平时分插入net140X中*********************************************














//**************************************END*****************************************************************
?>

