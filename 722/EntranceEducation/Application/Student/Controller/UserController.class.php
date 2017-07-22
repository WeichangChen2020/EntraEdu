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

    //判断是否为教师
    public function isTeacher($openId){
        if(M('teacher_info')->where(array('openId' => $openId))->find())
            return true;
        else
            return false;
    }

    //添加为教师
    public function teacherAdd($openId){
        if($this->isTeacher($openId))
            return '你的账号已是教师账号，不用再添加';
        $userInfo = $this->getUserInfo($openId);
        $info     = array(
            'openId' => $openId,
            'name'   => $userInfo['name'],
            'time'   => date('Y-m-d H:i:s',time())
            );
        if(M('teacher_info')->add($info))
            return '教师账号添加成功，发送？尝试教师端端功能';
        else
            return '添加失败';
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
            return '教师账号添加成功，发送？尝试教师端端功能';
        else
            return '添加失败';
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

    public function index(){
    	//++++++++++++++++++++++++++++++++++++++++++设定openId session
        session('openId',null);
        $openId = 'o_88Bj6aebK2XYfoh7cU9cV0dzx0'; //getOpenId()
        session('openId',$openId);

		if($this->isRegister($openId)){

            //++++++++++++++++++++++++++++++++++++++++++模型实例化
            $STU              = D('StudentInfo');
            //$MARK             = D('StudentMark');
            $con['openId']    = $openId;
            $stu_info         = $STU->where($con)->find();
           // $stu_info['mark'] = $MARK->where($con)->getField('lastMark');  //把成绩也并入stu_info数组中
			
            $this->assign('stu_info',$stu_info)->display('Index/index');
		}else{
			$this->display('register');
		}
    }

    //注册信息
    public function register(){
    	$STU           = D('StudentInfo');       //实例化
        $openId        = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $name          = I('name')?I('name'):$this->error('你访问的界面不存在');
        $number        = I('number')?I('number'):$this->error('你访问的界面不存在');
        $banji         = I('banji')?I('banji'):$this->error('你访问的界面不存在');

        $registerInfo  = array(
            'openId'   => $openId,
            'name'     => $name,
            'number'   => $number,
            'class'    => $banji,
            'time'     => date('Y-m-d H:i:s')
            );
        $STU->create($registerInfo);
        if($STU->data($registerInfo)->add())
            $this->ajaxReturn(array('res' => '注册成功'));
        else
            $this->ajaxReturn(array('res' => '注册失败'));
    }

    //获取用户信息
    public function getUserInfo($openId){
        $STU           = D('StudentInfo');       //实例化
        return $STU->where(array('openId' => $openId))->find();
    }

    public function getTeacherInfo($openId){
        return M('teacher_info')->where(array('openId' => $openId))->find();
    }

    // +++++++++++作为展示性页面+++++++++++++++
    public function markDetails(){
        $openId   = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $mark     = new MarkController();
        $markInfo = $mark->getDetails($openId);
        $markInfo['commu']= $markInfo['comCommentNum']+$markInfo['comReplyNum']+$markInfo['ranCommentNum']+$markInfo['ranReplyNum'];
        $this->assign('markInfo',$markInfo)->display();
    }


    //++++++++++++++++++++++++查看其他同学成绩
    public function markClass(){
        $classStr = I('class');
        $classArray = explode('_', substr($classStr, 0,strlen($classStr)-1));
        $markList = array();
        if($classArray[0] == 'all'){
            $markList = M('student_mark')->order('lastMark desc')->select();
        }else{
            foreach ($classArray as $value) {
                $markList = array_merge($markList,M('student_mark')->where(array('class' => $value))->select());
            }
        }
        $this->assign('markList',$markList)->display();
    }

}