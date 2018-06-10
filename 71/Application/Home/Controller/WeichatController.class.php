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
namespace Home\Controller;
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
       /* try{*/
            $appid = 'wx035846a807521cd0'; //AppID(应用ID)
            $token = 'qyh'; //微信后台填写的TOKEN
            $crypt = 'yIimR2UShx2uDVbgJq7fofjQnCuAXs0Js0UBJmVpva8'; //消息加密KEY（EncodingAESKey）
            
            /* 加载微信SDK */
            $wechat = new Wechat($token, $appid, $crypt);
            $user   = new UserController();
            $this->user();
        
    }

    /**
     * DEMO
     * @param  Object $wechat Wechat对象
     * @param  array  $data   接受到微信推送的消息，用户
     */
    private function user(){
        $user=new UserController();
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
