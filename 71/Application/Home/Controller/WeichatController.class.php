<?php
// +----------------------------------------------------------------------
// | 概率论与数理统计教学互动平台
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://23.testet.sinaapp.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: lijj <hello_lijj@qq.com>
// +----------------------------------------------------------------------
// | Time: 2016-07-16  19:33
// +----------------------------------------------------------------------
namespace Student\Controller;
use Think\Controller;
use Com\Wechat;
use Com\WechatAuth;
use Com\Jssdk; 

class WeichatController extends Controller{
    /**
     * 微信消息接口入口
     * 所有发送到微信的消息都会推送到该操作
     * 所以，微信公众平台后台填写的api地址则为该操作的访问地址
     */
    public function index($id = ''){
        //调试
        try{
            $appid = 'wx035846a807521cd0'; //AppID(应用ID)
            $token = 'qyh'; //微信后台填写的TOKEN
            $crypt = 'yIimR2UShx2uDVbgJq7fofjQnCuAXs0Js0UBJmVpva8'; //消息加密KEY（EncodingAESKey）
            
            /* 加载微信SDK */
            $wechat = new Wechat($token, $appid, $crypt);
            $user   = new UserController();

            /*
            if(!empty($data['Content']))  $record['messageContent'] = $data['Content'];
            if(!empty($userInfo['name'])) $record['name'] = $userInfo['name'];
            if(!empty($userInfo['class'])) $record['class'] = $userInfo['class'];
            if(!empty($userInfo['number'])) $record['number'] = $userInfo['number'];

           if($data && is_array($data)){
                file_put_contents('./data.json', json_encode($data));
                //判断是否注册
                if($user->isRegister($data['FromUserName']))
                    $this->user($wechat, $data);
                else 
                    $this->passer($wechat,$data);
            }*/
        } catch(\Exception $e){
            file_put_contents('./error.json', json_encode($e->getMessage()));
        }
        
    }

    /**
     * DEMO
     * @param  Object $wechat Wechat对象
     * @param  array  $data   接受到微信推送的消息，用户
     */
    private function user($wechat, $data){
        define('URL_ROOT', 'http://23.testet.sinaapp.com/index.php');
        define('PICURL_ROOT', 'http://testet.sinaapp.com/Public/images/weixin/');
        $user             = new UserController();
        $userInfo         = $user->getUserInfo($data['FromUserName']);
        $welcome          = array("欢迎".$userInfo['name']."关注概率论平台",'',URL_ROOT."/Index/help",PICURL_ROOT."/welcome.jpg");
        $myInfo           = array('发送1：我的信息','', URL_ROOT."/User/index/openId/".$data['FromUserName'],PICURL_ROOT.'myInfo.jpg');
        $fileDownload     = array('发送2：资料下载','', "http://pan.baidu.com/s/1sk9GmTn",PICURL_ROOT.'fileDownload.jpg');
        $homework         = array('发送3：课后作业','', URL_ROOT."/Homework/index/openId/".$data['FromUserName'],PICURL_ROOT.'homework.jpg');
        $signin           = array('发送4：在线签到','',URL_ROOT."/Signin/index/openId/".$data['FromUserName'],PICURL_ROOT.'signin.jpg');
        $test             = array('发送5：随堂测试','',URL_ROOT."/Test/testList/openId/".$data['FromUserName'],PICURL_ROOT.'classtest.jpg');
        $random           = array('发送6：自由练习','',"http://testet.sinaapp.com/index.php/Random/index/openId/".$data['FromUserName'],PICURL_ROOT.'random.jpg');
        $interation       = array('发送7：平台互动','', "http://testet.sinaapp.com/index.php/Community/index/openId/".$data['FromUserName'],PICURL_ROOT.'interation.jpg');
        $teacher          = array('教师端入口','',URL_ROOT.'/Teacher/index/openId/'.$data['FromUserName'],'');
       
        switch ($data['MsgType']) {
            case Wechat::MSG_TYPE_EVENT:
                switch ($data['Event']) {
                    case Wechat::MSG_EVENT_SUBSCRIBE:
                        $wechat->replyNews($welcome,$myInfo,$fileDownload,$homework,$signin,$test,$random,$interation);
                        break;
                    case Wechat::MSG_EVENT_UNSUBSCRIBE:
                        //取消关注，记录日志
                        break;
                    default:
                        $wechat->replyText("欢迎访问概率论与数理统计教学在线平台！您的事件类型：{$data['Event']}，EventKey：{$data['EventKey']}");
                        break;
                }
                break;

            case Wechat::MSG_TYPE_TEXT:
                $isTeacher = $user->isTeacher($data['FromUserName']);
                $mark      = M('student_mark')->where(array('openId' => $data['FromUserName']))->getField('lastMark');
                switch ($data['Content']) {
                   
                    case '11':
                        $wechat->replyText($user->teacherAdd($data['FromUserName']));
                        break;
                    case '111':
                        $wechat->replyText($user->teacherDelete($data['FromUserName']));
                        break;
                    case '2':
                       $wechat->replyNewsOnce('发送2：资料下载',"这里有历年浙江工商大学概率论与数理统计期末考试真题、历年数学考研真题资源下载、任课教师上课课件、课后习题答案等海量资源等你预览下载。", "http://pan.baidu.com/s/1sk9GmTn","http://testet.sinaapp.com/Public/images/weixin/fileDownload.jpg"); 
                        break;
                    case '3':
                       $wechat->replyNewsOnce('发送3：课后作业','姓名：'.$userInfo['name']."\n班级：".$userInfo['class']."\n学号：".$userInfo['number']."\n课后作业", URL_ROOT."/Homework/index/openId/".$data['FromUserName'],PICURL_ROOT.'homework.jpg'); 
                        break;
                    case '33':
                        if($isTeacher)
                            $wechat->replyNewsOnce("发送33：教师端_课后作业","教师端_课后作业", URL_ROOT."/Teacher/homework_index/openId/".$data['FromUserName'],PICURL_ROOT."homework.jpg");
                        else
                            $wechat->replyText('你没有使用该功能的权限');
                        break;
                    case '4':
                       $wechat->replyNewsOnce("发送4：在线签到",'', URL_ROOT."/Signin/index/openId/".$data['FromUserName'],PICURL_ROOT."signin.jpg"); 
                        break;
                    case '44':
                        if($isTeacher)
                            $wechat->replyNewsOnce("发送44：教师端_签到","", URL_ROOT."/Teacher/signin_index/openId/".$data['FromUserName'],PICURL_ROOT.'signin.jpg'); 
                        else
                            $wechat->replyText('你没有使用该功能的权限');
                        break;
                    case '5':
                       $wechat->replyNewsOnce("发送5：随堂测试","", URL_ROOT."/Test/testList/openId/".$data['FromUserName'],PICURL_ROOT."classtest.jpg");
                        break;
                    case '55':
                        if($isTeacher)
                            $wechat->replyNewsOnce("发送55：教师端_随堂测试","这是课堂签到功能",URL_ROOT."/Teacher/test_index/openId/".$data['FromUserName'] ,PICURL_ROOT."classtest.jpg"); 
                        else
                            $wechat->replyText('你没有使用该功能的权限');
                        break;
                    case '6':
                        $wechat->replyNewsOnce('发送6：自由练习','', "http://testet.sinaapp.com/index.php/Random/index/openId/".$data['FromUserName'],PICURL_ROOT."/random.jpg"); 
                        break;
                    case '7':
                        $wechat->replyNewsOnce('发送7：平台互动','',"http://testet.sinaapp.com/index.php/Community/index/openId/".$data['FromUserName'], PICURL_ROOT."/interation.jpg"); 
                        break;
                    case '?':
                    case '？':
                        if($isTeacher)
                            $wechat->replyNews($welcome,$teacher,$myInfo,$fileDownload,$homework,$signin,$test,$random,$interation);
                        else
                            $wechat->replyNews($welcome,$myInfo,$fileDownload,$homework,$signin,$test,$random,$interation);
                        break;
                    default:
                        
                }
                break;
            
            default:
                # code...
                break;
        }
    }

    /**
     * DEMO
     * 未注册处理函数,路人
     */
    private function passer($wechat, $data){
        $welcome      = array("欢迎关注概率论与数理统计教学互动平台","概率论与数理统计教学互动平台是一款便利于师生教学概率论与数理统计科目的产品。提供：课后作业、课堂签到、自由练习等功能。带有：历年浙江工商大学概率论与数理统计期末考试真题、历年数学考研真题资源下载、任课教师上课课件、课后习题答案等海量资源。", "http://23.testet.sinaapp.com/index.php/index/help","http://testet.sinaapp.com/Public/images/weixin/welcome.jpg");
        $myInfo       = array("发送1：请先注册","你还没有注册，请点击注册你的信息", "http://23.testet.sinaapp.com/index.php/User/index/openId/".$data['FromUserName'],"http://testet.sinaapp.com/Public/images/weixin/register.jpg");
        $fileDownload = array('发送2：资料下载',"", "http://pan.baidu.com/s/1sk9GmTn","http://testet.sinaapp.com/Public/images/weixin/fileDownload.jpg");
        $help         = array("发送?：使用帮助","发送？查看平台使用帮助", "http://23.testet.sinaapp.com/index.php/index/help","http://testet.sinaapp.com/Public/images/weixin/help.jpg");
        switch ($data['MsgType']) {
            case Wechat::MSG_TYPE_EVENT:
                switch ($data['Event']) {
                    case Wechat::MSG_EVENT_SUBSCRIBE:
                        $wechat->replyNews($welcome,$myInfo,$fileDownload,$help);
                        break;
                    case Wechat::MSG_EVENT_UNSUBSCRIBE:
                        //取消关注，记录日志
                        break;

                    default:
                        $wechat->replyText("欢迎访问概率论与数理统计教学互动平台！您的事件类型：{$data['Event']}，EventKey：{$data['EventKey']}");
                        break;
                }
                break;

            case Wechat::MSG_TYPE_TEXT:
                switch ($data['Content']) {
                    case '1':
                       $wechat->replyNewsOnce("发送1：请先注册","你还没有注册，请点击注册你的信息", "http://23.testet.sinaapp.com/index.php/User/index/openId/".$data['FromUserName'],"http://testet.sinaapp.com/Public/images/weixin/register.jpg"); 
                        break;
                    case '2':
                       $wechat->replyNewsOnce("发送2：资料下载","这里有历年浙江工商大学概率论与数理统计期末考试真题、历年数学考研真题资源下载、任课教师上课课件、课后习题答案等海量资源等你预览下载。", "http://pan.baidu.com/s/1sk9GmTn","http://testet.sinaapp.com/Public/images/weixin/fileDownload.jpg");
                        break;
                    case '?':
                    default:       
                        $wechat->replyNews($help,$myInfo,$fileDownload);
                        break;
                }
                break;
            
            default:
                # code...
                break;
        }
    }




    /**
     * 资源文件上传方法
     * @param  string $type 上传的资源类型
     * @return string       媒体资源ID
     */
    private function upload($type){
        $appid     = '';
        $appsecret = '';

        $token = session("token");

        if($token){
            $auth = new WechatAuth($appid, $appsecret, $token);
        } else {
            $auth  = new WechatAuth($appid, $appsecret);
            $token = $auth->getAccessToken();

            session(array('expire' => $token['expires_in']));
            session("token", $token['access_token']);
        }

        switch ($type) {
            case 'image':
                $filename = './Public/image.jpg';
                $media    = $auth->materialAddMaterial($filename, $type);
                break;

            case 'voice':
                $filename = './Public/voice.mp3';
                $media    = $auth->materialAddMaterial($filename, $type);
                break;

            case 'video':
                $filename    = './Public/video.mp4';
                $discription = array('title' => '视频标题', 'introduction' => '视频描述');
                $media       = $auth->materialAddMaterial($filename, $type, $discription);
                break;

            case 'thumb':
                $filename = './Public/music.jpg';
                $media    = $auth->materialAddMaterial($filename, $type);
                break;
            
            default:
                return '';
        }

        if($media["errcode"] == 42001){ //access_token expired
            session("token", null);
            $this->upload($type);
        }

        return $media['media_id'];
    }


    public function getAccessToken(){
        $appid     = '';
        $appsecret = '';

        $token = session("token");

        if($token){
            $auth = new WechatAuth($appid, $appsecret, $token);
        } else {
            $auth  = new WechatAuth($appid, $appsecret);
            $tokenArray = $auth->getAccessToken();
            $token = $tokenArray['access_token'];
        }

        return $token;
    }

    public function getJssdkPackage(){
        $appid     = '';
        $appsecret = '';

        $jssdk = new Jssdk($appid, $appsecret);
        return $jssdk->GetSignPackage();
    }
}
