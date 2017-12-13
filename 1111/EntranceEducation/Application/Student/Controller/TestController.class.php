<?php
// +----------------------------------------------------------------------
// | 计算机网络教学互动平台
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://23.testet.sinaapp.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: lijj <hello_lijj@qq.com>
// +----------------------------------------------------------------------
// | Time: 2016-07-24  13:24
// +----------------------------------------------------------------------
namespace Student\Controller;
use Think\Controller;
use Think\Model;

/**
 * 随堂测试类
 */
class TestController extends Controller{
  

    public function index(){
        //echo "默认页面";
        $openId=session('openId');
        session('openId',$openId);
        $this->display();
    }
    public function testList(){
        //session('openId',null);
        //$openId = getOpenId();
        $openId=session('openId');
        session('openId',$openId);

        $map['state'] = array('neq','');
        $testList = M('teacher_quiz')->where($map)->order('time desc')->select();

        //+++++++++++++++++++把是否提交和访问人数也加到数组里
        foreach ($testList as $key => $value) {
            $testList[$key]['isSubmit']  = $this->isSubmit($openId,$testList[$key]['id']);
            $testList[$key]['submitNum'] = $this->getSubmitNum($testList[$key]['id']);
        }

        // p($testList);
        $this->assign('testList',$testList)->display();
    }


    private function isSubmit($openId,$quizId){
        if(M('student_classtest_record')->where(array('openId' => $openId,'quizId' => $quizId))->find())
            return true;
        else
            return false;
    }

    //提交人数,最好写在model里
    public function getSubmitNum($quizId){
        $testList = M('student_classtest_record')->where(array('quizId' => $quizId))->select();
        $tea      = new TeacherController();
        $testStu  = $tea->array_unset($testList,'openId');
        return count($testStu);
    }

    public function testMenu(){
        $quizId = I('quizId')?I('quizId'):$this->error('你访问的页面不存在');
        session('quizId',null);
        session('quizId',$quizId);

        $openId   = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $this->assign('state',$this->isSubmit($openId,$quizId));
        $this->assign('quizId',$quizId);
        $this->assign('number',$this->getSubmitNum($quizId))->display();
    }

    // 在线测试
    public function test(){
        $quizId   = session('?quizId') ? session('quizId') : $this->error('请重新获取改页面');
        $openId   = session('?openId') ? session('openId') : $this->error('请重新获取改页面');

        if(M('student_classtest_record')->where(array('openId' => $openId , 'quizId' => $quizId))->find())
            $this->error('你已经提交过了，不得重复提交');
        if(M('teacher_quiz')->where(array('quizId' => $quizId))->getField('state') == '关闭')
            $this->error('测试时间已经结束！');
        $quesList = M('teacher_quiz_questionbank')->where(array('quizId' => $quizId))->order('time desc')->select();
        $this->assign('quesList',$quesList)->display();
    }

    public function testSubmit(){
        if(!IS_AJAX)
            $this->error('你访问的页面不存在');
        $quizId  = session('?quizId') ? session('quizId') : $this->error('请重新获取改页面');
        $openId  = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        
        $answerStr   = I('answer');
        $answerArray = explode('_',substr($answerStr, 0,strlen($answerStr)-1));
        $quesIdStr   = I('quesId');
        $quesIdArray = explode('_',substr($quesIdStr, 0,strlen($quesIdStr)-1));
        $user        = new UserController();
        $stuInfo     = $user->getUserInfo($openId);
        $quizName    = M('teacher_quiz')->where(array('id'=>$quizId))->getField('quizName');
        $QUIZ        = M('teacher_quiz_questionbank');
        $result      = array();
        $rightNum    = 0;
        
        foreach ($answerArray as $key => $value) {
            $rightAnswer = $QUIZ->where(array('id' => $quesIdArray[$key]))->getField('rightAnswer');
            $answerInfo = array(
               'openId' => $openId,
               'quizId' => $quizId,
               'questionId' => $quesIdArray[$key],
               'quizName' => $quizName,
               'answer' => $value,
               'rightAnswer' => $rightAnswer,
               'answerResult' => $value == $rightAnswer ? 'RIGHT' : 'WRONG',
               'time' => date('Y-m-d H:i:s')
               );
            if(!empty($stuInfo)){
                $answerInfo['name']   = $stuInfo['name'];
                $answerInfo['class']  = $stuInfo['class'];
            }else{
                $answerInfo['name']   = 'null';
                $answerInfo['class']  = 'null';
            }
            if($value == $rightAnswer){
                $result[] = 'RIGHT';
                $rightNum ++;
            }else{
                $result[] = 'WRONG';
            }
            if(!M('student_classtest_record')->add($answerInfo))
                $this->ajaxReturn('failure');
        }
        $resultStr = '正确数量：'.$rightNum.'错误数量:'.(count($result)-$rightNum) ;
        $this->ajaxReturn($resultStr);
    }


    //提交后的结果
    public function testResult(){
        $testResult = I('result');
        $quizId  = session('?quizId') ? session('quizId') : $this->error('请重新获取改页面');
        $this->assign('quizId',$quizId);
        $this->assign('testResult',$testResult)->display();
    }

    //题目解析
    public function testAnalyze(){
        $quizId   = session('?quizId') ? session('quizId') : $this->error('请重新获取改页面');
        $openId   = session('?openId') ? session('openId') : $this->error('请重新获取改页面');

        if(!M('student_classtest_record')->where(array('openId' => $openId , 'quizId' => $quizId))->find())
            $this->error('请先完成题目在查看解析');
        $quesList = M('teacher_quiz_questionbank')->where(array('quizId' => $quizId))->select();
        $this->assign('quesList',$quesList)->display();
    }

    //测试详情
    public function testDetails(){
        $quizId   = session('?quizId') ? session('quizId') : $this->error('请重新获取改页面');
        $openId   = session('?openId') ? session('openId') : $this->error('请重新获取改页面');

        $STU_ClA_REC = M('student_classtest_record');
        $quesList = M('teacher_quiz_questionbank')->where(array('quizId' => $quizId))->select();
        foreach ($quesList as $key => $value) {
            $primaryId = $quesList[$key]['id'];
            $quesList[$key]['optionA'] = $STU_ClA_REC->where(array('quizId' => $quizId,'questionId' => $primaryId,'answer' => 'A'))->count();
            $quesList[$key]['optionB'] = $STU_ClA_REC->where(array('quizId' => $quizId,'questionId' => $primaryId,'answer' => 'B'))->count();
            $quesList[$key]['optionC'] = $STU_ClA_REC->where(array('quizId' => $quizId,'questionId' => $primaryId,'answer' => 'C'))->count();
            $quesList[$key]['optionD'] = $STU_ClA_REC->where(array('quizId' => $quizId,'questionId' => $primaryId,'answer' => 'D'))->count();
        }
        $this->assign('quesList',$quesList)->display();
    }
}