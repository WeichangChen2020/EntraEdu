<?php 
namespace Student\Controller;
use Think\Controller;

class ReworkController extends Controller{
	
	public function index() {

		$openid = session('openId');
		// echo $openid;
		$this->assign('openId',$openid);
		$this->display();
	}

	public function chose(){
		$openId = session('openId');


		// $HISTORY = M('exercise');
		$QUESTION= M('questionbank');


		// dump($quesidArray);die;
		/**
		*历史中错误----错题历史中正确->无视
		*			|--错题历史中错误或不存在->加入数组
		*错题历史中做错->加入数组
		*错题历史中正确->无视
		*
		*/
		// $MISTAKE = M('mistake_history');
		$quesid = D('MistakeHistory')->getMistakeData($openId);
		dump($quesid);
		$num = D('MistakeHistory')->getNumberOfMistake($openId);
		session('quesid',$quesid);
		$ques = D('MistakeHistory')->getQuestionByid($quesid);
		$name = M('StudentInfo')->where('openId="'.$openId.'"')->getField('name');


		// $ques = $QUESTION->where(array('id' => $quesid))->find();
		// $chapter=D('MistakeHistory')->getQuesChapter($ques['chapter']);
		// $questype=D('MistakeHistory')->getQuesType($ques['type']);
		// $this->assign('chapter',$chapter);
		// $this->assign('questype',$questype);
		$this->assign('num',$num);
		$this->assign('name',$name);
		$this->assign('ques',$ques);
		$this->assign('openId',$openId);
		// echo $quesidArray[$WrongQuesid]['quesid'];
		// echo $num;
		if ($num == 0) {
			$this->display('tip-none');
			return false;
		}
		if ($ques) {
			if ($ques['type'] == '单选题') {
				$this->display('chose');
			} else if ($ques['type'] == '判断题') {
				$this->display('judge');
			} else if ($ques['type'] == '多选题') {
				$this->display('mutil');
			}
		} else {
			$this->display('tip');
		}

	}
	public function submit() {
		if (!IS_AJAX) {
			$this->error('您访问的页面不存在');
		}
		$openid       = session('openId');
		$quesid       = session('quesid');
		$option       = I('option');
		$time     = I('time');
		$right_answer = D('Questionbank')->getRightAnswer($quesid);

		$data = array(	
			'openid' => $openid,
			'quesid' => $quesid,
			'answer' => $option,
			'result' => $option == $right_answer ? 1 : 0,
			'spend'  => $time,
			'time'   => date('Y-m-d:H:i:s', time())
		);

		M('MistakeHistory')->add($data);

		$this->ajaxReturn($right_answer, 'json');
	}



}

 ?>