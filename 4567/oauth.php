<?php
if (isset($_GET['code'])){
    //echo $_GET['code'];
    header("location: http://www.baidu.com?openid=$_GET['code']");
	exit;
}else{
    echo "NO CODE";
}
?>

