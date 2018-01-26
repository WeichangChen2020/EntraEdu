<?php
// +----------------------------------------------------------------------
// | 大学物理教学互动平台
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://23.testet.sinaapp.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: lijj <hello_lijj@qq.com>
// +----------------------------------------------------------------------
// | Time: 2016-07-20  14:14
// +----------------------------------------------------------------------
namespace Student\Controller;
use Think\Controller;
use Think\Model;

/**
 * 签到
 */

class SigninController extends Controller{
    
    //学生端入口主页面
    public function index(){
        session('openId',null);
        $openId = I('openId');
        session('openId',$openId);
        $SINGIN = D('studentSignin');
        $studentInfo = M('StudentInfo')->where(array('openId'=>$openId))->find();
        $signinList = D('teacherSignin')->getSigninList($openId);
        foreach ($signinList as $key => $value) {
            $signinList[$key]['isSignin']  = $SINGIN->isSignin($openId,$signinList[$key]['id']);
            $signinList[$key]['signinNum'] = $SINGIN->getSigninNum($signinList[$key]['id']);
            $signinList[$key]['signinName'] = $studentInfo['class'].":".$signinList[$key]['signinName'];
        }

        $this->assign('signinList',$signinList)->display();
    }

    //签到菜单
    public function signinMenu(){
        $openId       =  session('openId') ? session('openId') : $this->error('请你重新获取该页面');
        $signinId     = I('signinId') ? I('signinId') : $this->error('你访问的界面不存在');
        session('signinId',null);
        session('signinId',$signinId);

        $weixin       = new WeichatController();
        $signPackage  = $weixin->getJssdkPackage(); 
        $SINGIN = D('studentSignin');

        $this->assign('state',$SINGIN->isSignin($openId,$signinId));
        $this->assign('signinNum',$SINGIN->getSigninNum($signinId));
        $this->assign('signPackage',$signPackage)->display();

    }

    //在线签到
    public function signinOnline(){
        if(!IS_AJAX)
            $this->error('你访问的界面不存在');

        $openId        =  session('?openId') ? session('openId') : $this->error('请重新获取该页面');
        $signinId      =  session('?signinId') ? session('signinId') : $this->error('请重新获取该页面');
        $SIGNIN = M('teacher_signin');
        $signInfo = $SIGNIN->where(array('id' => $signinId))->find();
        //已截止
        $deadtime = $signInfo['deadtime'];
        $now = time();
        if($now > strtotime($deadtime))
            $this->ajaxReturn('close');
        
        //已关闭
        if($signInfo['state'] != '开启')
            $this->ajaxReturn('close');

        //已签到
        if(M('student_signin')->where(array('openId' => $openId,'signinId' => $signinId))->find())
            $this->ajaxReturn('signined');

        $STU           = D('StudentInfo');
        $signin        = array(
            'openId'   => $openId,
            'name'     => $STU->getName($openId),
            'class'    => $STU->getClass($openId),
            'number'   => $STU->getNumber($openId),
            'signinId' => $signinId,
            'latitude' => I('latitude'),
            'longitude'=> I('longitude'),
            'accuracy' => I('accuracy'),
            'time'     => date('Y-m-d H:i:s',time()),
            );
        if(M('student_signin')->add($signin))
            $this->ajaxReturn('success');
        else
            $this->ajaxReturn('fail');
    }

    //查看签到
    public function signinView(){
        // 序号，姓名，签到时间，签到地点，
        $weixin       = new WeichatController();
        $signPackage  = $weixin->getJssdkPackage(); 
        $this->assign('signPackage',$signPackage);

        $signinId      =  session('?signinId') ? session('signinId') : $this->error('请重新获取该页面');
        $signinList = M('student_signin')->where(array('signinId' => $signinId))->select();

        $signinInfo = M('teacher_signin')->find($signinId);
        $this->assign('signinInfo',$signinInfo);
        $this->assign('signinList',$signinList)->display();
    }
}

