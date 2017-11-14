<?php
/*
    方倍工作室
    http://www.fangbei.org/
    CopyRight 2011-2017 All Rights Reserved
*/ 

header('Content-type:text');
define("TOKEN", "weixin");

define('APP_ID', 'wx913b2486f97088cb');//改成自己的APPID 
define('APP_SECRET', '635f5e327e4c8c2f70744690d9a1e02a');//改成自己的APPSECRET 


$wechatObj = new wechatCallbackapiTest();
if (!isset($_GET['echostr'])) {
	$wechatObj->responseMsg();
}else{
    $wechatObj->valid();
}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
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
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if($tmpStr == $signature){
            return true;
        }else{
            return false;
        }
    }


    public function test()
    {
      return "c";
    }
    
    //响应消息
    public function responseMsg()
    {
        include_once 'connect_database.php';

        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $this->logger("R ".$postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

            $fromUsername = $postObj->FromUserName;
            
            $RX_TYPE = trim($postObj->MsgType);

            $keyword = trim($postObj->Content);
            $time = time();

            switch ($RX_TYPE)
            {
                case "event":
                if($link)
                { 
                //mysql_select_db('app_cprogramplatform',$link);
                  $mysql  =   new SaeMysql();
                  $sql="select * from `user` where id ='$postObj->FromUserName'";
                  $result=mysql_query($sql,$link);
                  $exsit=mysql_affected_rows();
                  $name=mysql_result($result,0,1);
                  $number=mysql_result($result,0,2);
                  $sex=mysql_result($result,0,3);
                  if (!$exsit) {
                      $name="小可爱";
                      $sex="你猜";
                      $number="";
                  }
                  $content = "欢迎".$name."欢迎关注计算机爱网络!\n性别：".$sex."，帐号：".$number." \n 
                  直接点击链接即可获取相关内容
                  发送1：<a href=\"http://1111.testroom.applinzi.com/EntranceEducation/index.php/User/index?openId=$postObj->FromUserName\">进入课程</a> 

";     
              $content .= (!empty($object->EventKey))?("\n来自二维码场景 ".str_replace("qrscene_","",$object->EventKey)):"";                 
                    $result = $this->receiveEvent($postObj, $content);
                    echo $result;                    
                }
                break;

            }

            $this->logger("T ".$result);
            echo $result;

            if( $keyword == "?" || $keyword == "？")
            { 
              //$content = $this->test();              
                if($link)
                { 
                //mysql_select_db('app_cprogramplatform',$link);
                  $mysql  =   new SaeMysql();
                  $sql="select * from `user` where id ='$postObj->FromUserName'";
                  $result=mysql_query($sql,$link);
                  $exsit=mysql_affected_rows();
                  $name=mysql_result($result,0,1);
                  $number=mysql_result($result,0,2);
                  $class=mysql_result($result,0,3);
                  if (!$exsit) {
                      $name="小可爱";
                      $sex="你猜";
                      $number="";
                  }

                  $content = "欢迎".$name."关注计算机爱网络!\n性别：".$sex."，帐号：".$number." \n 直接点击链接即可获取相关内容
发送1：<a href=\"http://".$app_name.".applinzi.com/register/register.php?id=$postObj->FromUserName\">注册信息</a> 
发送2：<a href=\"http://".$app_name.".applinzi.com/reserve/reserve.php?userid=$postObj->FromUserName\">课程预约</a>
发送？：平台使用菜单 
";     
                  $content .= (!empty($object->EventKey))?("\n来自二维码场景 ".str_replace("qrscene_","",$object->EventKey)):"";  
                  $result = $this->transmitText($postObj, $content);
                  echo $result;
                }
              //$result = $this->transmitText($postObj, $content);          
              //echo $result;
            }

            if( $keyword  == "1")
            {   
                $content = "";
                $content="<a href=\"http://".$app_name.".applinzi.com/register/register.php?id=$postObj->FromUserName\">注册个人信息2333</a>";
                $result = $this->transmitText($postObj,$content);
                echo $result;
              
            }

            if( $keyword  == "2")
            { 
                $content = "";
                $content = "<a href=\"http://".$app_name.".applinzi.com/reserve/reserve.php?userid=$postObj->FromUserName\">课程预约</a>";
                $result = $this->transmitText($postObj,$content);
                echo $result;              
            }

        }else{
            //echo "sorry,I can't understand";
            $content = "sorry,I can't understand";
            $result = $this->transmitText($postObj,$content);
            echo $result; 
            exit;
        }
        
    }
     



    private function receiveEvent($object)
    {
        $content = "";
        switch ($object->Event)
        {
            case "subscribe":
                $content = "欢迎关注计算机爱网络";
                break;
            case "unsubscribe":
                $content = "取消关注";
                break;
        }
        $result = $this->transmitText($object, $content);
        return $result;
    }
    
    //接收文本消息
    private function receiveText($object)
    {
        $keyword = trim($object->Content);
        $content = date("Y-m-d H:i:s",time());
        
        if(is_array($content)){
            if (isset($content[0]['PicUrl'])){
                $result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
            $result = $this->transmitText($object, $content);
        }

        return $result;
    }

    
    private function transmitText($object, $content)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }

    private function transmitNews($object, $arr_item)
    {
        if(!is_array($arr_item))
            return;

        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
    </item>
";
        $item_str = "";
        foreach ($arr_item as $item)
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);

        $newsTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<Content><![CDATA[]]></Content>
<ArticleCount>%s</ArticleCount>
<Articles>
$item_str</Articles>
</xml>";

        $result = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item));
        return $result;
    }

    private function transmitMusic($object, $musicArray)
    {
        $itemTpl = "<Music>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
    <MusicUrl><![CDATA[%s]]></MusicUrl>
    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
</Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
$item_str
</xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }
    
    private function logger($log_content)
    {
        if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        }else if($_SERVER['REMOTE_ADDR'] != "127.0.0.1"){ //LOCAL
            $max_size = 10000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('H:i:s')." ".$log_content."\r\n", FILE_APPEND);
        }
    }
}


?>