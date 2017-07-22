<?php
if (isset($_GET['code'])){
    //echo $_GET['code'];
	$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx4fdbba9a5ca1c058&secret=c82945fc7ce8bfe136c11e8f37740cf9&code=$_GET['code']&grant_type=authorization_code"; 
	$contents = file_get_contents($url); 
	//如果出现中文乱码使用下面代码 
	//$getcontent = iconv("gb2312", "utf-8",$contents); 
	echo $contents;     
}else{
    echo "NO CODE";
}
?>