<?php

namespace Student\Controller;
use Think\Controller;
use Think\Model;

/**
 * 我的信息类
 */


class UserController extends Controller {

    //判断是否在微信端
    // public function _before_index(){
    //     if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false){
    //         $this->error("请在微信端打开");
    //         exit;
    //     }
    // }
    //判断是否注册
	public function isRegister($openId){
		$STU                 = D('StudentInfo');       //实例化
		$condition['openId'] = $openId;                //查询条件

		if($STU->where($condition)->find())                    
			return true;
		else
			return false;
	}


    public function index(){
    	//++++++++++++++++++++++++++++++++++++++++++设定openId session
        //session('openId',null);
        $openId = getOpenId(); //
        //echo $openId;
        //die();
        session('openId',$openId);
        //$openId = 'o_88Bj6aebK2XYfoh7cU9cV0dzx0';//session('openId')
        //echo session('openId');
        // echo "<br>";
        // echo $openId;
        //echo $_COOKIE["openId"];
        // die();

		if($this->isRegister($openId)){

            //++++++++++++++++++++++++++++++++++++++++++模型实例化
            $STU              = D('StudentInfo');
            //$MARK             = D('StudentMark');
            $con['openId']    = $openId;
            $stu_info         = $STU->where($con)->find();
           // $stu_info['mark'] = $MARK->where($con)->getField('lastMark');  //把成绩也并入stu_info数组中

            $this->assign('stu_info',$stu_info)->display('Index/main');//如果已经注册，直接跳转到欢迎界面
		}else{
			$this->assign('openId',$openId)->display('register_new');//否则就到注册页面填写信息
		}
    }

    
    
    /**
     * 处理用户注册传来的信息
     * 
     * @param string $openid 用户的openid
     * @return string $imgheadurl 用户头像url
     */
    public function register(){
        if(!IS_AJAX) $this->error('你访问的页面不存在');
    	$STU           = D('StudentInfo');       //实例化
        $WeChat        = new WeichatController();
        $openId        = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        //这些是注册页面传递过来的参数
        $name          = I('name');
        $number        = I('number');
        $college       = I('college');
        $banji         = I('banji'); 
        $isNewer       = 0;

        // 用户注册的头像
        $headimgurl    = $WeChat->getHeadimgurl($openId);
        dump($headimgurl);
        if(empty($headimgurl)) $headimgurl = '';

        // 新手的信息
        if (!empty($college) && !empty($banji)) {
            
            $isNewer = 1;

            $newerInfo = $STU->newerInfo($number);
            if(false === $newerInfo) {
                $this->ajaxReturn('请检查您的信息或从非新生入口注册');
            }

            if(!($newerInfo['name'] == $name && $newerInfo['academy'] == $college && $newerInfo['class'] == $banji)) {
                $this->ajaxReturn('姓名班级学号信息不一致！请正确输入您的信息！');
            }

        } 

        if(true === $STU->isRegister($openId)) {

            $this->ajaxReturn('你已经注册过了');
        }

        $registerInfo   = array(
            'openId'     => $openId,
            'name'       => $name,
            'number'     => $number,
            'academy'    => $college,//学院
            'class'      => $banji,//班级
            'is_newer'   => $isNewer,
            'headimgurl' => $headimgurl,
            'time'       => date('Y-m-d H:i:s'),
        );

        if ($STU->add($registerInfo)) {
            $this->ajaxReturn('success');
        } 
       
    }
	

}