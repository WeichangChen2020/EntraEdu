<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "weixin");//改成自己的TOKEN 
define('APP_ID', 'wx8e1ab063e92381dc');//改成自己的APPID 
define('APP_SECRET', '19db5de1b20d1baad44167298a5ac0f1');//改成自己的APPSECRET 
define('APP_URL','http://18.dataplatform.applinzi.com');//
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
        //include_once './EntranceEducation/Application/Common/Conf/config_sae.php';
        $APP_URL = "http://18.dataplatform.applinzi.com/";
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)){
                
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);

            $ev = $postObj->Event;

            $mysql_database = "app_".$_SERVER['HTTP_APPNAME'];
            $link=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS); //连接数据库
            mysql_select_db("$mysql_database",$link);//选择数据库
            mysql_query("set names 'utf-8'");
            date_default_timezone_set("Asia/Shanghai");

            $sql = "SELECT * FROM `cp_teacher_info` WHERE `openId` = '$fromUsername'";
            $result = mysql_query($sql,$link);
            $exsit = mysql_num_rows($result);
            if($exsit){
                $teacher = 1;
            }else{
                $teacher = 0;
            }

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
                  $contentStr = "欢迎关注大学物理在线教学平台！\n发送“？”获取菜单";
                  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                  echo $resultStr;
            }

            if(!empty($keyword))
            {

                if( $keyword == "?" || $keyword == "？")
                { 
                    $msgType = "text";
                    $contentStr = "发送1：<a href=\"http://18.dataplatform.applinzi.com/EntranceEducation/index.php/User/index/openId/$postObj->FromUserName\">大学物理</a> \n发送rz：<a href=\"http://18.dataplatform.applinzi.com/EntranceEducation/index.php/User/teacherAdd/openId/$postObj->FromUserName\"> 教师认证</a>\n发送？：平台使用菜单";        
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);          
                    echo $resultStr;                    
                } 

                if($keyword == '1'){
                    $msgType = "text";
                    /*$contentStr = "http://71.dataplatform.applinzi.com/index.php/Home/Index/index";*/
                    $contentStr = "<a href=\"http://18.dataplatform.applinzi.com/EntranceEducation/index.php/User/index/openId/$postObj->FromUserName\">大学物理</a>";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }

                if($keyword == 'rz'){
                    $msgType = "text";
                    /*$contentStr = "http://71.testroom.applinzi.com/index.php/Home/Index/index";*/
                    $contentStr = "<a href=\"http://18.dataplatform.applinzi.com/EntranceEducation/index.php/User/teacherAdd/openId/$postObj->FromUserName\">教师认证</a>";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
                
                if($keyword == '2'){
                    $msgType = "text";
                    $contentStr = "<a href=\"http://18.dataplatform.applinzi.com/EntranceEducation/index.php/Teacher/index/openId/$postObj->FromUserName\">教师端</a>";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
                else {
                    $msgType = "text";
                    /*$contentStr = "http://71.dataplatform.applinzi.com/index.php/Home/Index/index";*/
                    $contentStr = "请发送'？'试试";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
            }else{
                // echo "Input something...";
            }

        }else {
            // echo "";
            // exit;
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


