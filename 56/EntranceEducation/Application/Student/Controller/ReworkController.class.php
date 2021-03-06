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

		$QUESTION = D('questionbank');
		$EXERCISE = D('exercise');
		$quesid = $EXERCISE->getMistakeData($openId);
		// dump($quesid);
		$num = $EXERCISE->getMistakeNum($openId);
		session('quesid',$quesid);
		$ques = $QUESTION->getQuestionByid($quesid);
		// dump($ques);
		$name = M('StudentInfo')->where('openId="'.$openId.'"')->getField('name');
		// dump($name);die;
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
		// $openId = session('openId');


		// // $HISTORY = M('exercise');
		// $QUESTION= M('questionbank');

		// /**
		// *历史中错误----错题历史中正确->无视
		// *			|--错题历史中错误或不存在->加入数组
		// *错题历史中做错->加入数组
		// *错题历史中正确->无视
		// *
		// */
		// $MISTAKE = D('MistakeHistory');
		// $quesid = $MISTAKE->getMistakeData($openId);
		// // dump($quesid);
		// $num = $MISTAKE->getNumberOfMistake($openId);
		// session('quesid',$quesid);
		// $ques = $MISTAKE->getQuestionByid($quesid);
		// $name = M('StudentInfo')->where('openId="'.$openId.'"')->getField('name');

		// $this->assign('num',$num);
		// $this->assign('name',$name);
		// $this->assign('ques',$ques);
		// $this->assign('openId',$openId);
		// if ($num == 0) {
		// 	$this->display('tip-none');
		// 	return false;
		// }
		// if ($ques) {
		// 	if ($ques['type'] == '单选题') {
		// 		$this->display('chose');
		// 	} else if ($ques['type'] == '判断题') {
		// 		$this->display('judge');
		// 	} else if ($ques['type'] == '多选题') {
		// 		$this->display('mutil');
		// 	}
		// } else {
		// 	$this->display('tip');
		// }

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

		// M('MistakeHistory')->add($data);
		
		//若错题回顾中回答正确，则更新exercise表中的is_rework
		if($option == $right_answer){
			$map = array(
				'openid' => $openid,
				'quesid' => $quesid,
				'result'    => '0',
				'is_rework' => '0',
			);
			$data2['is_rework'] = 1;
			M('exercise')->where($map)->save($data2);
		}
		
		$this->ajaxReturn($right_answer, 'json');
	}

	public function test(){
		$openId = session('openId');

		$QUESTION = D('questionbank');
		$EXERCISE = D('exercise');
		$quesid = $EXERCISE->getMistakeData($openId);
		// dump($quesid);
		$num = $EXERCISE->getMistakeNum($openId);
		session('quesid',$quesid);
		$ques = $QUESTION->getQuestionByid($quesid);
		// dump($ques);
		$name = M('StudentInfo')->where('openId="'.$openId.'"')->getField('name');
		// dump($name);die;
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



}

 ?>