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
        $openId = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $USER = M('student_info');
        $RECORD = M('random_answer_record');
        //$SIMULATE = M('simulate_answer_record');
        $RESULT = M('simulate_result_record');
        $GRADE = M('simulate_grade_record');
        $student_info = $USER->where('openId="'.$openId.'"')->find();//学生信息数组

        $answerNum = $RECORD->where('openId="'.$openId.'"')->count();//自由练习答题数
		$answerRightNum = $RECORD->where('openId="'.$openId.'" AND answerResult = "RIGHT"' )->count();
        
        //$simulateArray = $SIMULATE->distinct(true)->field('testId')->where('openId="'.$openId.'"')->select();
        //var_dump($simulateArray);
        //$simulateNum = count($simulateArray);
        $simulateNum = $RESULT->where('openId="'.$openId.'"')->count();

        $grade_info = $GRADE->where('openId="'.$openId.'"')->find();
        //var_dump($grade_info);
        $this->assign('student_info',$student_info);
        $this->assign('answerNum',$answerNum);
        $this->assign('answerRightNum',$answerRightNum);
        $this->assign('simulateNum',$simulateNum);
        $this->assign('grade_info',$grade_info);        
        $this->display();
    	
    }


    //+++++++++班级排名
    public function rankClass(){
    	$openId = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
		$USER = M('student_info');
		//$RECORD = M('random_answer_record');
        $SIMULATE = M('simulate_answer_record');
        $GRADE = M('simulate_grade_record');
		$student_info = $USER->where('openId="'.$openId.'"')->find();
        $class = $student_info['class'];
        $answerRightNum = $GRADE->where('openId="'.$openId.'"')->getfield('answerRightNum');
        //echo $class;
		//$classArray = array('0'=>"$class");
        //$gradeList = array();
            //====循环输出？？====//
            // foreach ($classArray as $value) {               
            // 	$grade1 = M('simulate_grade_record')->where(array('class' => $value))->order('answerRightNum desc,answerTime asc')->select();
            //     $gradeList = array_merge($gradeList,$grade1);
            //     var_dump($gradeList);                
            // }
        $gradeList = $GRADE->where(array('class' => $class))->order('answerRightNum desc,answerTime asc')->select();
        //$gradeList = array_merge($gradeList,$grade1);
        //var_dump($gradeList);//这™是个二维数组！

        $this->assign('answerRightNum',$answerRightNum);
        $this->assign('gradeList',$gradeList)->display();
  	
    }

    public function rankSchool(){
        $openId = session('?openId') ? session('openId') : $this->error('请重新获取改页面');       
        $GRADE = M('simulate_grade_record');

        $answerRightNum = $GRADE->where('openId="'.$openId.'"')->getfield('answerRightNum');
        $gradeList = $GRADE->order('answerRightNum desc,answerTime asc')->select();

        $this->assign('answerRightNum',$answerRightNum);
        $this->assign('gradeList',$gradeList)->display();
    }

}