<?php
header("Content-type: text/html; charset=utf-8");

$id = $_GET['id'];
$flag=$_GET['flag'];
$flag1=$_POST['flag1'];
$review=$_POST['review'];
$late=$_GET['late'];
if($late==1)
{
    $flag=$_POST['flag'];

}

    include '../connect_database.php';  
	$contentStr=date("Y-m-d H:i:s",time());		   
    $result=mysql_query("select * from `$_classes` where id ='$id'",$link);
    @$author=mysql_result($result,0,1);  
		   
    $result=mysql_query("select * from $_homework where flag='$flag' and uploader_id='$id'");
    @$row=mysql_result($result,0,1);
    @$row1=mysql_result($result,0,5);
	if($row1)
	{
		echo "作业已经批改，不能更新";
	 }
	else if($review==NULL)
    {
    	
    	echo "请加入心得体会";
    }
	else if($_FILES['file']['name']==NULL)
    {
    	
    	echo "请添加文件";
    }
	else
	{
        
        if($flag1==1&&$row)
        {
            echo "你已经提交过同一次作业，如要更新请选择覆盖选项";
        }
        else
        {
            $s2 = new SaeStorage();
            $name =$_FILES['file']['name'];
            $_FILES["file"]["size"]= number_format( $_FILES["file"]["size"] / 1024, 2);		
            $size =$_FILES["file"]["size"] . " Kb";
            echo "谢谢".$author."同学！，你上传的文件信息如下："; 
            echo "<br/>";
            echo "第".$flag."次作业<br />";
            echo "Upload: " . $_FILES["file"]["name"] . "<br />";
            echo "Type: " . $_FILES["file"]["type"] . "<br />";
            echo "Size: " . $_FILES["file"]["size"] . " Kb<br />";
            $a=$_FILES["file"]["size"]*1;
            $dox=substr($name,strrpos($name,'.'));
            //echo "22222".$dox."22222";
            /*
             $chars = array( 
     			"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",  
        		"l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",  
        		"w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",  
       			 "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",  
       			 "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",  
       			 "3", "4", "5", "6", "7", "8", "9" 
    			); 
   			 $charsLen = count($chars) - 1; 
   			 shuffle($chars);   
   			 $output = "1"; 
   			 for ($i=0; $i<8; $i++) 
   			 { 
      			  $output .= $chars[mt_rand(0, $charsLen)]; 
   			 }  
             $ran=mysql_query("select new_name from homework where new_name='$output' ",$link);
             $tag_ran=mysql_num_rows($ran);
           	 if($tag_ran!=0)
             {
             	 $repe=substr( $output, 0, 1 );
                 $repe++;
                 $output=$repe.$output;
             }
             */
            $new_name=$contentStr.".".$dox;
           // echo $new_name;
            //if($a<1024)
            
            //echo "**************************************************************";
            //echo gettype($a);
            //echo "**************************************************************";
            
            //$b=1024.00;
            if($a>500) 
            {
                echo "文件大小超过500k，不能上传";
            }
            else
            {
                        if($flag1==2&&$row)
                        {
                            //echo "$id******$flag";
                            //echo "*******111222222222222222***************************";
                            echo $s2->upload('homework',$name,$_FILES['file']['tmp_name']);
                            $s2->upload('homework',$new_name,$_FILES['file']['tmp_name']);
                            //echo "**************************";
                            //$name='马迪';
                            $con2="UPDATE $_homework set flag='0' where uploader_id='$id' and flag='$flag'";
                            // $con1="UPDATE `project` set `time`=`$contentStr`,`filename`=`$name`,`size`=`$size` where `uploader_id`=`$id` and `flag`=`$flag` ";
                            mysql_query($con2,$link) or die(mysql_error());
                             $con3= "INSERT INTO $_homework (`author`,`time`,`filename`,`size`,`uploader_id`,`flag`,`new_name`,`review`) VALUES ('$author','$contentStr','$name','$size','$id','$flag','$new_name','$review')";
                            mysql_query($con3,$link) or die(mysql_error());
                        }
                        else if(!$row)
                        {
                            
                            //echo "1111111111111111111111";
                            echo $s2->upload('homework',$name,$_FILES['file']['tmp_name']);
                            $s2->upload('homework',$new_name,$_FILES['file']['tmp_name']);		   
                            $con= "INSERT INTO `$_homework` (`author`,`time`,`filename`,`size`,`uploader_id`,`flag`,`new_name`,`review`) VALUES ('$author','$contentStr','$name','$size','$id','$flag','$new_name','$review')";
                            mysql_query($con,$link) or die(mysql_error());
                        }
            }	
            
        }
		
	}
				   
 

?>
