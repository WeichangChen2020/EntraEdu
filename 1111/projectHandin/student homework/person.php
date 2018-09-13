<html>


<?php 
	include "../connect_database.php";
	if($link){
		$sql = "select author,uploader_id from $_homework where author='' ";
		$result = mysql_query($sql,$link);
		$num = mysql_num_rows($result);
		//echo $num;97
		for($i=0;$i<$num;$i++){
			$row = mysql_fetch_array($result);
			var_dump($row);
			$id = $row['uploader_id'];
			echo $id;
			echo "<br/>";
			$sql2 = "select username from $_classes where id = '$id'";
			$result2 = mysql_query($sql2,$link);
			$row2 = mysql_fetch_array($result2);
			var_dump($row2);
			$name = $row2['username'];
			echo $name;
			if($row['author']==''){
				$sql3 = "UPDATE `$_homework` SET `author`='$name' where uploader_id='$id'";
				$result3 = mysql_query($sql3,$link);
				if($result3){
					echo "success<br/>";
				}
			}			
		}
	}

?>


</html>