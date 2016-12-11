<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "qyh");//改成自己的TOKEN 
define('APP_ID', 'wx035846a807521cd0');//改成自己的APPID 
define('APP_SECRET', 'yIimR2UShx2uDVbgJq7fofjQnCuAXs0Js0UBJmVpva8');//改成自己的APPSECRET 

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



                	if( $keyword == "?" || $keyword == "？")
          			{ 
            			$content = "";
              
              		 // $link=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
           	 		if($link)
           			{	
                        	//mysql_select_db('app_cprogramplatform',$link);
              			$mysql  =   new SaeMysql();
              			$sql="select * from `$_classes` where id ='$postObj->FromUserName'";
             			$result=mysql_query($sql,$link);
              			$name=mysql_result($result,0,1);
              			$number=mysql_result($result,0,2);
              			$class=mysql_result($result,0,3);
                            /*    $content = "欢迎".$name."同学关注C语言教学互动平台!\n班级：".$class."，学号：".$number." \n发送1：注册个人信息 \n发送2：查询课程安排、资料上传下载 \n发送3：做习题 \n发送4：课下提问 \n发送5：进入教学互动平台 \n发送5：查看平时表现成绩  \n发送7：领任务 \n发送8：问卷调查 \n发送9：大作业上传下载 \n发送10：知识点学习\n发送地理位置信息：点名 \n发送？：平台使用菜单 
                 				 \n网页版平台登陆地址：http://cprogramplatform.sinaapp.com/login.php";
               				*/
                            
             			$content = "欢迎".$name."同学关注C语言教学互动平台!\n班级：".$class."，学号：".$number." \n 直接点击链接即可获取相关内容
						发送1：<a href=\"http://71.testroom.applinzi.com/index.php/Home/Index/index\">初始界面</a> 
						发送2：<a href=\"http://".$app_name.".sinaapp.com/communication/documents.php\">资料下载</a>
						发送3：<a href=\"http://".$app_name.".sinaapp.com/test/ceshi.php?id=$postObj->FromUserName\">习题练习</a>
						发送4：<a href=\"http://7.cprogramplatform.sinaapp.com/kec/prepare1.php?id=$postObj->FromUserName\">翻转课堂</a>
						发送5：<a href=\"http://".$app_name.".sinaapp.com/score_ex/grade_personal.php?id=$postObj->FromUserName\">查看成绩</a>
						发送6：<a href=\"http://".$app_name.".sinaapp.com/score_ex/mid_term.php?id=$postObj->FromUserName\">查期中考试成绩</a>
						发送地理位置信息：点名
						发送？：平台使用菜单 
						网页版平台登陆地址：http://".$app_name.".sinaapp.com/Login.php";        
            			$result = $this->transmitText($postObj, $content);
               
        				// $resultstr = sprintf($xmlTpl, $postObj->FromUserName, $postObj->ToUserName, time(), $str);
          		 		//  echo $resultstr;//输出
           
             			echo $result;
            			} 
         			} 

              		if($keyword == '1'){
						$msgType = "text";
						/*$contentStr = "http://71.testroom.applinzi.com/index.php/Home/Index/index";*/
						 $contentStr = "<a href=\"http://71.testroom.applinzi.com/index.php/Home/Index/index\">初始界面</a>";
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
					else echo "欢迎关注qyh的微信公众号";
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


