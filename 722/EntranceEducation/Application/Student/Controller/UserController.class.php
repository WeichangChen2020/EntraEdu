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
            $progress = D('Questionbank')->getProgress($openId);  //做题统计
            //p($progress);
            $this->assign('progress',$progress);
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

            // 将StudentList里的type置1
            M('StudentList')-> where(array('number'=>$number))->setField('type', 1);
            $this->ajaxReturn('success');
        } 
       
    }

    public function modify(){
        $info = M('student_info');
        $list = M('student_list');
        //p($number);
        // $numArr = array('1701510121','1702177311','1703080107','1703080513','1706030717','1706070107','1709070227','1709070303','1711060118','1711060437','1711060438','1719130101','1719130105','1719130106','1719130112','1719130120'
        //     ,'1719130121','1719130124','1719130212','1720100411','1735010105','1735010113','1735010128','1735010131','1735010209','1735010226','1735020101','1735020105','1735020323','1735020324','1735020434','1735028128'
        // );
        // for ($i=0; $i < count($numArr); $i++) { 
        //     $stulist = $list->where(array('number'=>$numArr[$i]))->select();
        //     $stuinfo = $info->where(array('number'=>$numArr[$i]))->select();
        //     p($stulist);

        //     if($stulist&&$stuinfo){       //两张表里都存在，说明是新生且已注册
        //         $data['academy'] = $stulist[0]['academy'];
        //         $data['is_newer'] = 1;                
        //         $result1 = $info->where(array('number'=>$numArr[$i]))->save($data);
        //         $type = $list->where(array('number'=>$numArr[$i]))->getField('type');
        //         if($type==0){  //是新生且已注册，但list表中是未注册
        //             $data2['type'] = 1;
        //             $result2 = $list->where(array('number'=>$numArr[$i]))->save($data2);
        //         }
                
        //     }
            
        //     if($result1){
        //         p("更新info中的学院和是否新生成功！");
        //     }

        //     if($result2){
        //         p("更新list中的是否注册成功！");
        //     }
        // }
        $noregister = $list->where(array('type'=>0))->select();//list表中显示未注册
        for ($i=0; $i < count($noregister); $i++) { 
            $isregister = $info->where(array('name'=>$noregister[$i]['name']))->find();
            $is_newer = $isregister['is_newer'];
            if ($is_newer==1) {  //info里是新生
                p($noregister);
                p($isregister);
            }
        }
    }
}