<?php
/*
方倍工作室 http://www.cnblogs.com/txw1958/
CopyRight 2013 www.doucube.com  All Rights Reserved
*/

//define your token
define("TOKEN", "weixin");//改成自己的TOKEN 
define('APP_ID', 'wx4737741c9b818bb2');//改成自己的APPID 
define('APP_SECRET', 'e0bc7dc95157d34d227f103eed0b6724');//改成自己的APPSECRET 

//$wechatObj = new wechatCallbackapiTest();
$wechatObj = new wechatCallbackapiTest(APP_ID,APP_SECRET); 

if (isset($_GET['echostr'])) 
{
    $wechatObj->valid();
}
else{
    $wechatObj->responseMsg();
}

header("location:nav.php");
class wechatCallbackapiTest
{
    public function valid()
    {
    $echoStr = $_GET["echostr"];
    //valid signature , option
    if($this->checkSignature()){
        echo $echoStr;      
        exit;
    }
}
public function responseMsg()
{
    //get post data, May be due to the different environments
    $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
    //extract post data
    if (!empty($postStr)){
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);

        $ev = $postObj->Event;

        $time = time();
        $textTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>0</FuncFlag>
            </xml>";

        if ($ev == "subscribe") {
            $msgType = "text";
            $contentStr = "欢迎关注必修课在线练习平台！\n发送?以获取菜单";
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            echo $resultStr;
        }

        if(!empty($keyword)) {
            if( $keyword == "?" || $keyword == "？" || $keyword == "帮助" || $keyword == "菜单") { 
                $msgType = "text";
                $contentStr = "发送1：<a href=\"http://55.testtest11.sinaapp.com/EntranceEducation/index.php/Balance/balance/openid/".$fromUsername."\">毛概在线练习</a>\n发送?：平台使用菜单";        
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                //  echo $resultstr;//输出
                echo $resultStr;
            } else if($keyword == '1') {
                $msgType = "text";
                $contentStr = "<a href=\"http://55.testtest11.sinaapp.com/EntranceEducation/index.php/Balance/balance/openid/".$fromUsername."\">毛概在线练习</a>";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            } else if($keyword == 'test') {
                $msgType = "text";
                $contentStr = "http://55.testtest11.sinaapp.com/EntranceEducation/index.php/Balance/balance/openid/".$fromUsername;
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }
        }else{
        }
    } else {
    }
} 

private function checkSignature()
{
    $signature = $_GET["signature"];
    $timestamp = $_GET["timestamp"];
    $nonce = $_GET["nonce"];  

    $token = TOKEN;
    $tmpArr = array($token, $timestamp, $nonce);
    sort($tmpArr);
    $tmpStr = implode( $tmpArr );
    $tmpStr = sha1( $tmpStr );
    
    if( $tmpStr == $signature ){
      return true;
  }else{
      return false;
  }
}
}



?> 