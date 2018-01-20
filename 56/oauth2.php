<?php
if (isset($_GET['code'])){
    //echo $_GET['code'];
    $code = $_GET['code'];
    echo $code;die;
    $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx4737741c9b818bb2&secret=e0bc7dc95157d34d227f103eed0b6724&code='.$code.'&grant_type=authorization_code';

    //这个url是为了获取access_token
    
	$content =file_get_contents($url);
	//获取json数据
	$de_json = json_decode($content,TRUE);
	$count_json = count($de_json);

	$openid = $de_json['openid'];
	//session_start();
	//$_SESSION['openId']=$openid;
	//setcookie("openId",$openid, time()+3600);
    echo $openid;
    die;
    header("Location: http://55.testtest11.sinaapp.com/EntranceEducation/index.php/User/index?openId=$openid"); 

}else{
    echo "NO CODE";
}
?>