<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "weixin");//改成自己的TOKEN 
define('APP_ID', 'wx913b2486f97088cb');//改成自己的APPID 
define('APP_SECRET', '635f5e327e4c8c2f70744690d9a1e02a');//改成自己的APPSECRET 

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
        $appid     = 'wx913b2486f97088cb';
        $appsecret = '635f5e327e4c8c2f70744690d9a1e02a';
        $crypt = 'IFw7tLUcSrbyksiIJUUGEkyL2snSaiXL2arnGzGhXQj'; //消息加密KEY（EncodingAESKey）
        $token = 'weixin';
        
        /* 加载微信SDK */
        $wechat = new Wechat($token, $appid, $crypt);		
		$user = new UserController();
		$data = $wechat->request();
	    $userInfo = $user->getUserInfo($data['FromUserName']);
	    $isTeacher = $user->isTeacher($data['FromUserName']);
        $record = array(
            'openId' => $data['FromUserName'],
            'messageType' => 'formUser',
            'time'  => date('Y-m-d H:i:s',time()),
            );
        if(!empty($data['Content']))  $record['messageContent'] = $data['Content'];
        if(!empty($userInfo['name'])) $record['name'] = $userInfo['name'];
        if(!empty($userInfo['class'])) $record['class'] = $userInfo['class'];
        if(!empty($userInfo['number'])) $record['number'] = $userInfo['number'];
        M('weixin_message_record')->add($record);
		
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

				if ($ev == "subscribe")
				{
					  $msgType = "text";
					  $contentStr = "欢迎关注计算机网络在线教学平台！";
					  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
					  echo $resultStr;
				}



				if(!empty($keyword))
                {

                	if( $keyword == "?" || $keyword == "？")
          			{ 
            		    $msgType = "text";
            		    if($isTeacher){
            		    	$contentStr = "
								发送1：<a href=\"http://1111.testroom.applinzi.com/EntranceEducation/index.php/User/index/openId/$postObj->FromUserName\">计算机网络</a> 
								发送2：<a href=\"http://1111.testroom.applinzi.com/EntranceEducation/index.php/Teacher/index/openId/$postObj->FromUserName\">教师入口</a>			
								发送地理位置信息：签到";
            		    }else{
            		    	$contentStr = "
								发送1：<a href=\"http://1111.testroom.applinzi.com/EntranceEducation/index.php/User/index/openId/$postObj->FromUserName\">计算机网络</a> 			
								发送地理位置信息：签到";
            		    }

            			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
               
        				// $resultstr = sprintf($xmlTpl, $postObj->FromUserName, $postObj->ToUserName, time(), $str);
          		 		//  echo $resultstr;//输出          
             			echo $resultStr;
            			
         			} 

              		if($keyword == '1'){
						$msgType = "text";
						/*$contentStr = "http://71.testroom.applinzi.com/index.php/Home/Index/index";*/
						$contentStr = "<a href=\"http://1111.testroom.applinzi.com/EntranceEducation/index.php/User/index/openId/$postObj->FromUserName\">计算机网络</a>";
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						echo $resultStr;
						
					}
					//http://1111.testroom.applinzi.com/EntranceEducation/index.php/Teacher/index/openId/oIpKjs78eKv_q18h5oNTSS4vL-64
					
					if($keyword == '2' && $isTeacher){
						$msgType = "text";
						/*$contentStr = "http://71.testroom.applinzi.com/index.php/Home/Index/index";*/
						$contentStr = "<a href=\"http://1111.testroom.applinzi.com/EntranceEducation/index.php/Teacher/index/openId/$postObj->FromUserName\">教师入口</a>";
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						echo $resultStr;						
					}

                }else{
                	echo "Input something...";
                }

        }else {
        	echo "发送？查看平台菜单";
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


