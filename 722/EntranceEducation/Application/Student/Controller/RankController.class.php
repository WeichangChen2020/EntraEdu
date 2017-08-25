<?php


namespace Student\Controller;
use Think\Controller;
use Think\Model;

class RankController extends Controller {
	public function index(){

        $openId=session('openId');
        session('openId',$openId);
		//echo $openId;

		$this->display();
	}
	public function rankMenu(){
		$openId=session('openId');
        session('openId',$openId);
		$this -> display();
	}
	// +++++++我的详情+++++++++++++++
    public function rankDetails(){
        $openId   = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        // $grade     = new gradeController();
        // $gradeInfo = $grade->getDetails($openId);
        // $gradeInfo['commu']= $gradeInfo['comCommentNum']+$gradeInfo['comReplyNum']+$gradeInfo['ranCommentNum']+$gradeInfo['ranReplyNum'];
        // $this->assign('gradeInfo',$gradeInfo)->display();
        $USER = M('student_info');
        $RECORD = M('random_answer_record');
        $SIMULATE = M('simulate_answer_record');
        $GRADE = M('simulate_grade_record');
        $student_info = $USER->where('openId="'.$openId.'"')->find();//学生信息数组
        //var_dump($student_info);
        //die();
        $answerNum = $RECORD->where('openId="'.$openId.'"')->count();
		$answerRightNum = $RECORD->where('openId="'.$openId.'" AND answerResult = "RIGHT"' )->count();
        $simulateArray = $SIMULATE->distinct(true)->field('testId')->where('openId="'.$openId.'"')->select();
        //var_dump($simulateNum);
        $simulateNum = count($simulateArray);
        $grade_info = $GRADE->where('openId="'.$openId.'"')->find();
        $this->assign('student_info',$student_info);
        $this->assign('answerNum',$answerNum);
        $this->assign('answerRightNum',$answerRightNum);
        $this->assign('simulateNum',$simulateNum);
        $this->assign('grade_info',$grade_info);        
        $this->display();
    	
    }


    //+++++++++班级排名
    public function rankClass(){
    	$openId   = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
		$USER = M('student_info');
		//$RECORD = M('random_answer_record');
        $SIMULATE = M('simulate_answer_record');
		$student_info = $USER->where('openId="'.$openId.'"')->find();
        $class = $student_info['class'];
        //echo $class;
		//$classArray = array('0'=>"$class");
        $gradeList = array();
            //====循环输出？？====//
            // foreach ($classArray as $value) {
            //     //$bestGrade = M('simulate_result_record')->where('openId="'.$openId.'"')->max('answerRightNum');
            // 	   $grade1 = M('simulate_grade_record')->where(array('class' => $value))->order('answerRightNum desc,answerTime asc')->select();
            //     $gradeList = array_merge($gradeList,$grade1);
            //     // var_dump($gradeList);                
            // }
        $grade1 = M('simulate_grade_record')->where(array('class' => $class))->order('answerRightNum desc,answerTime asc')->select();
        $gradeList = array_merge($gradeList,$grade1);
        //var_dump($gradeList);
        //die();

        $this->assign('gradeList',$gradeList)->display();
		// $openId   = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
		// $USER = M('student_info');
		// $RECORD = M('random_answer_record');
  //       $SIMULATE = M('simulate_answer_record');
		// $student_info = $USER->where('openId="'.$openId.'"')->find();
		// $answerNum = $RECORD->where('openId="'.$openId.'"')->count();
		// $answerRightNum = $RECORD->where('openId="'.$openId.'" AND answerResult = "RIGHT"' )->count();
  //       $simulateArray = $SIMULATE->distinct(true)->field('testId')->where('openId="'.$openId.'"')->select();
  //       //var_dump($simulateNum);
  //       $simulateNum = count($simulateArray);
  //       $this->assign('student_info',$student_info);
  //       $this->assign('answerNum',$answerNum);
  //       $this->assign('answerRightNum',$answerRightNum);
  //       $this->assign('simulateNum',$simulateNum);    	
    }

    public function rankSchool(){

        $gradeList = M('simulate_grade_record')->order('answerRightNum desc,answerTime asc')->select();

        $this->assign('gradeList',$gradeList)->display();
    }

}