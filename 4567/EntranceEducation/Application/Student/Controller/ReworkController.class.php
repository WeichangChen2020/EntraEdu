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

		/**
		*历史中错误----错题历史中正确->无视
		*			|--错题历史中错误或不存在->加入数组
		*错题历史中做错->加入数组
		*错题历史中正确->无视
		*
		*/
		$MISTAKE = D('MistakeHistory');
		$quesid = $MISTAKE->getMistakeData($openId);
		// dump($quesid);
		$num = $MISTAKE->getNumberOfMistake($openId);
		session('quesid',$quesid);
		$ques = $MISTAKE->getQuestionByid($quesid);
		$name = M('StudentInfo')->where('openId="'.$openId.'"')->getField('name');

		$this->assign('num',$num);
		$this->assign('name',$name);
		$this->assign('ques',$ques);
		$this->assign('openId',$openId);
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
		$option       = trim(I('option'));
		$time     = I('time');
		$right_answer = trim(D('Questionbank')->getRightAnswer($quesid));
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
	public function test(){
		$MISTAKE = M('mistakeHistory');
		$list = $MISTAKE->where('result=1')->limit('2000')->select();
		dump($list);
		dump($MISTAKE->where('result=1')->count());
		die;
	}



}

 ?>