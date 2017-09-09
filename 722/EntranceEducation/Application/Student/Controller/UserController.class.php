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
			
            $this->assign('stu_info',$stu_info)->display('Index/index');//如果已经注册，直接跳转到欢迎界面
		}else{
			$this->assign('openId',$openId)->display('register');//否则就到注册页面填写信息
		}
    }

    //新生注册信息
    public function register(){
    	$STU           = D('StudentInfo');       //实例化
        $STUDENT       = M('student_list'); //实例化新生信息
        $openId        = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        //这些是注册页面传递过来的参数
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
        //var_dump($registerInfo);
        //die();
        $STU->create($registerInfo);
        
		//这些是新生信息表中存有的信息
        
        $student_info = $STUDENT->where(array('number'=>$number))->find();//在新生信息表中找是否存在某学号的记录
        if($student_info){//如果存在，则获取信息，和传递的参数进行核对
            $name_exsit = $student_info['name'];
            $academy_exsit = $student_info['academy'];
            $class_exsit = $student_info['class'];
            //以学号为准，核对姓名学院班级是否一致
            if( $name==$name_exsit && $college==$academy_exsit && $banji==$class_exsit){

                $stu_info = $STU->where(array('openId' => $openId))->find();//能否找到这条数据，找到返回信息数组，找不到返回null
                //var_dump($stu_info);
                if(!$stu_info){ //如果找不到，就插入数据
                    $new = $STU->data($registerInfo)->add();
                    //var_dump($new);
                    //die();
                    if($new)
                        $this->ajaxReturn(array('res' => '注册成功'));
                    else{
                        //$this->ajaxReturn(array('res' => '注册失败'));

                    }
                }else{ //如果找到就传递信息数组并跳转到系统首页
                    //$this->assign('stu_info',$stu_info)->display('Index/index');
                    $this->ajaxReturn(array('res' => '你已注册！'));
                }
            }else{
                $this->ajaxReturn(array('res' =>'姓名班级学号信息不一致！请正确输入您的信息！' ));
                echo "姓名班级学号信息不一致！请正确输入您的信息！";//信息错误提示如何写？
            }
        }else{ //如果该学号不存在,即非新生的注册
            $this->assign('openId',$openId)->display('register2');
        }

    }

	//非新生注册信息
    public function register2(){
    	$STU           = D('StudentInfo');       //实例化
        $openId        = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        //这些是注册页面传递过来的参数
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
        //var_dump($registerInfo);
        //die();
        $STU->create($registerInfo);        

        $stu_info = $STU->where(array('openId' => $openId))->find();//能否找到这条数据，找到返回信息数组，找不到返回null
        //var_dump($stu_info);
        if(!$stu_info){ //如果找不到，就插入数据
            $new = $STU->data($registerInfo)->add();
            //var_dump($new);
            //die();
            if($new)
                $this->ajaxReturn(array('res' => '注册成功'));
            else{
                //$this->ajaxReturn(array('res' => '注册失败'));

            }
        }else{ //如果找到就传递信息数组并跳转到系统首页
            //$this->assign('stu_info',$stu_info)->display('Index/index');
            $this->ajaxReturn(array('res' => '你已注册！'));
        }
              
    }

}