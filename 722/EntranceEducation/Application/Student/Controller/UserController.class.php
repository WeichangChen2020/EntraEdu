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
			
            $this->assign('stu_info',$stu_info)->display('Index/index');//如果已经注册，直接跳转到欢迎界面
		}else{
			$this->display('register');//否则就到注册页面填写信息
		}
    }

    //注册信息
    public function register(){
    	$STU           = D('StudentInfo');       //实例化
        $openId        = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $name          = I('name')?I('name'):$this->error('你访问的界面不存在');
        $number        = I('number')?I('number'):$this->error('你访问的界面不存在');
        $college       = I('college')?I('college'):$this->error('你访问的界面不存在');
        $banji         = I('banji')?I('banji'):$this->error('你访问的界面不存在');

        $registerInfo  = array(
            'openId'   => $openId,
            'name'     => $name,
            'number'   => $number,
            'academy'  => $college,//学院
            'class'    => $banji,//班级
            'time'     => date('Y-m-d H:i:s')
            );
        $STU->create($registerInfo);
        $stu_info = $STU->where(array('openId' => $openId))->find();//能否找到这条数据，找到返回信息数组，找不到返回null
        if(!$stu_info){ //如果找不到，就插入数据
        	$new = $STU->data($registerInfo)->add();
            if($new)
            	$this->ajaxReturn(array('res' => '注册成功'));
        	else
             	$this->ajaxReturn(array('res' => '注册失败'));
        }else{ //如果找到就传递信息数组并跳转到系统首页
        	//$this->assign('stu_info',$stu_info)->display('Index/index');
            $this->ajaxReturn(array('res' => '你已注册！'));
        }    

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