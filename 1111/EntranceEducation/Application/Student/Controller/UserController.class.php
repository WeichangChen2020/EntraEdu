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

    public function isTeacher($openId){
        if(M('teacher_info')->where(array('openId' => $openId))->find())
            return true;
        else
            return false;
    }

    //添加为教师
    public function teacherAdd($openId){
        session('openId',$openId);
        if($this->isTeacher($openId))
            $this->error('您已是教师',U("Teacher/index",array('openId'=>session('openId'))));
        $userInfo = $this->getUserInfo($openId);
        $info     = array(
            'openId' => $openId,
            'name'   => $userInfo['name'],
            'telphoneNum' => $userInfo['number'],
            'time'   => date('Y-m-d H:i:s',time())
        );
        //如果用户姓名存在于adminer里，说明是管理员添加的老师
        if(M('adminer')->where(array('nickname'=>$userInfo['name']))->find()){

            //1.教师《-》班级的对应关系暂时是手动导入，所以这里更新openid
            $data = array();
            if(M('teacher_class')->where(array('name'=>$userInfo['name']))->find()){
                $data['openId'] = $openId;
                M('teacher_class')->where(array('name'=>$userInfo['name']))->save($data);
            }
            else{  //给测试员分配路人班级
                $data = array(
                    'openId' => $openId,
                    'name'   => $userInfo['name'],
                    'class'  => '测试1班、测试2班',
                    'classid'=> 0
                );
                M('teacher_class')->add($data);
            }

            //2.设置默认积分权重。（这个判断条件可以删除）
            $WEIGHT = M('student_mark_weight');
            if(!$WEIGHT->where(array('openId' => $openId))->find()){
                $weight = array(
                    'openId' => $openId,
                    'name'   => $userInfo['name'],
                    'register' => '1',
                    'weixinMessage' => '0.1',
                    'exerciseNum' => '1',
                    'exerciseRightNum' => '2',
                    'doRan' => '1',
                    'doRanRight' => '2',
                    'classTest' => '1',
                    'classTestRight' => '2',
                    'signin' => '1',
                    'homework' => '2',
                    'homeworkMark' => '2',
                    'homeworkhp' => '2',
                    'homeworkComplain' => '-1',
                    'time' => date('Y-m-d H:i:s',time())
                );
                $WEIGHT->add($weight);
            }
            
            //3.增加教师信息
            $result = M('teacher_info')->add($info);
            if($result)
                $this->success('教师认证成功，将跳转到教师端',U("Teacher/index",array('openId'=>session('openId')))); 
                //return "教师认证成功，发送'2'即可使用教师端功能";
            else
                $this->error('认证失败',U('User/index',array('openId'=>session('openId'))));
        }else{
            $this->error('您不是教师，请联系管理员',U('User/index',array('openId'=>session('openId'))));
        }

    }

    //添加为教师, 由社会上认识成为教师
    public function teacherAddFromPasser($openId){
        if($this->isTeacher($openId))
            return '你的账号已是教师账号，不用再添加';
        $info     = array(
            'openId' => $openId,
            'name'   => '体验者',
            'time'   => date('Y-m-d H:i:s',time())
            );
        D('StudentInfo')->add($info);
        if(M('teacher_info')->add($info))
            return "教师账号添加成功，发送'2'尝试教师端功能";
        else
            return "添加失败";
    }

    //取消为老师
    public function teacherDelete($openId){
        if(!$this->isTeacher($openId))
            return '你的账号不是教师账号，取消失败';
        if(M('teacher_info')->where(array('openId' => $openId))->delete())
            return '教师账号添加成功';
        else
            return '取消失败';
    }


    /**
     * index  平台主界面，同时处理注册函数
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright 2018-03-13T10:19:07+0800
     * @var
     * @return  
     */
    public function index(){
        $STU              = D('StudentInfo');
        $WeChat    = new WeichatController();
        $openId = I('openId');
        session('openId',$openId);
        //非AJAX用于正常访问，ajax用于注册
        if(!IS_AJAX) {
            if($this->isRegister($openId)){
                $MARK             = D('StudentMark');

                $con['openId']    = $openId;
                $stu_info         = $STU->where($con)->find();
                $stu_info['lastMark'] = $MARK->getLastMark($openId); //积分
                $signPackage  = $WeChat->getJssdkPackage();

                $Profile = M('Profile');
                $attributes = $Profile->select();;

                $this->assign('signPackage',$signPackage);
                $this->assign('openId',$openId);
                $this->assign('attributes',$attributes);
                $this->assign('stu_info',$stu_info)->display('Index/main');//如果已经注册，直接跳转到欢迎界面
            }else{
                $this->assign('openId',$openId)->display('register_new');//否则就到注册页面填写信息
            }
        } else {
            //注册时接收数据
            $openId    = I('openId');
            if (empty($openId)) {
                $openId    = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
            }
            //注册页面传递过来的参数
            $name      = I('name');
            $number    = I('number');
            $college   = I('college');
            $banji     = I('banji'); 
            $isNewer   = 0;
            // 用户注册的头像
            $headimgurl    = $WeChat->getHeadimgurl($openId);
            if(empty($headimgurl)) $headimgurl = '';

            //已注册：
            //1.openid已存在。
            //2.用户使用其他微信账户注册，以学号判断，或者以list表中的type判断
            // $isRegister = $STU->where(array('number'=>$number))->find();
            // if(true === $STU->isRegister($openId) || $isRegister) {
            //     $this->ajaxReturn('你已注册');
            // }

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

        
    /**
     * 处理用户注册传来的信息
     * 
     * @param string $openid 用户的openid
     * @return string $imgheadurl 用户头像url
     */
    public function register(){
        if(!IS_AJAX) 
            $this->error('你访问的页面不存在');
        // dump(I());die;
    	$STU       = D('StudentInfo');
        // $WeChat    = new WeichatController();
        $openId    = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        //注册页面传递过来的参数
        $name      = I('name');
        $number    = I('number');
        $college   = I('college');
        $banji     = I('banji')?I('banji'):'路人'; 
        $isNewer   = 0;
        // 用户注册的头像
        // $headimgurl    = $WeChat->getHeadimgurl($openId);
        if(empty($headimgurl)) $headimgurl = '';

        //已注册：
        //1.openid已存在。
        //2.用户使用其他微信账户注册，以学号判断，或者以list表中的type判断
        $isRegister = $STU->where(array('number'=>$number))->find();
        if(true === $STU->isRegister($openId) || $isRegister) {
            $this->ajaxReturn('你已注册');
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


    public function getUserInfo($openId){
        $STU           = D('StudentInfo');       //实例化
        return $STU->where(array('openId' => $openId))->find();
    }

    public function getTeacherInfo($openId){
        return M('teacher_info')->where(array('openId' => $openId))->find();
    }
    public function test(){
        dump(M('studentInfo')->select());die;

    }
    //资料下载
        public function download_list(){
        $this->display("Index/download_list");
    }

}