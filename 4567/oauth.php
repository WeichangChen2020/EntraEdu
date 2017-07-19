<?php
if (isset($_GET['code'])){
    //echo $_GET['code'];
    header("location: http://www.baidu.com?openid=11");
	exit;
}else{
    echo "NO CODE";
}
?>


