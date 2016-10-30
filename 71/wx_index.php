<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "weiphp");//改成自己的TOKEN 
define('APP_ID', 'wxf6f0d8764ddf2176');//改成自己的APPID 
define('APP_SECRET', '03d684e2d937a9df9fd0f94df9c901b3');//改成自己的APPSECRET 

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
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
				if(!empty($keyword))
                {
              		if($keyword == '1'){
						$msgType = "text";
						$contentStr = "http://8080.dataplatform.applinzi.com/index.php/Home/team";
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						echo $resultStr;
					}
					if($keyword == '2'){
						$msgType = "text";
						$contentStr = "http://8080.mysunner.sinaapp.com/index.php/Home/random";
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						echo $resultStr;
					}
					if($keyword == '3'){
						$msgType = "text";
						$contentStr = "http://8080.mysunner.sinaapp.com/index.php/Home/collect/index";
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						echo $resultStr;
					}
					if($keyword == '4'){
						$msgType = "text";
						$contentStr = "http://8080.mysunner.sinaapp.com/index.php/Home/collect/wrong";
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						echo $resultStr;
					}
					if($keyword == 'cd'){
						$msgType = "text";

                        //$contentStr = "<a href=\"8080.dataplatform.applinzi.com/index.php/Home/login/chop/openid/$postObj->FromUserName\">充电一下吧</a>";
                        $contentStr = "<a href=\"http://8080.dataplatform.applinzi.com/index.php/Home/login/chop/openid/$postObj->FromUserName\">充电一下吧</a>";
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						echo $resultStr;
					}
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
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


