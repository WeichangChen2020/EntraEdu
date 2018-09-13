<?php

header("Content-type:text/html;charset=utf-8");
include '../connect_database.php';  

$flagshow=$_GET['unit'];
//$flagshow=1;
$result=mysql_query("select * from `$_homework` where savename!='' and `flag`='$flagshow'",$link) or die(mysql_error());
$nums=mysql_num_rows($result);
if($nums==0)
{
	echo "还未有批改完成作业";
    exit();
}
      for($i=0;$i<$nums;$i++)
                 
                 {	
                         $row=mysql_fetch_array($result);
               
                        //    if($row[5]!=null)
                        //      {      
                        if($row[8]==$flagshow){
                            //echo "<div id=\"demo\">";
                       
                            //echo "<ul>";
                            echo "<li>";
       	           echo "$row[3]($row[4])";
                    //   echo "已下载$row[6]次</h3> ";
                     
                    //    echo "<form name='form1' action=\"/student project/download.php?id=$row[0]&savefile=$row[5]\" method=\"post\">";
                    //   echo "<input type=\"submit\" name=\"sub1\" value=\"下载\"> </form>";
                        //echo "<input type=\"button\"  onclick=\"window.location.href='http://ieelab.zjgsu.edu.cn/zgb/project/$row[5]?num=$row[0]'\" value=\"下载\"></form>";
                       
                            // if($rowType[0] == 1) { 
                        	echo "<input type=\"button\"  onclick=\"window.location.href='http://cprogramplatform-homework.stor.sinaapp.com/$row[3]?num=$row[0]'\" value=\"下载\"></form>";

                            //echo "<a href='../student project/ans.php?id=$id&num=$row[0]'>评价</a>";
                            //  }
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
                  
                  if($flagshow>1)
                  {
                  		echo "<br /><a href='work_detail.php?id=$row[7]&unit=$flagshow'>查看详情</a><br />";
                  }
                  
                    }
                            //echo	"</h4>";
                    echo "</li>";  
                     echo "<hr/>";       
                            //echo "</ul>";
                            //echo "</div>";
                        }
                        //     }
                  
                    }
                       
?>