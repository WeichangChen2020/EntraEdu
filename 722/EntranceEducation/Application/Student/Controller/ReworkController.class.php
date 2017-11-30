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
		$QUESTION= M('questionbank');
		$MISTAKE = D('MistakeHistory');
		$quesid = $MISTAKE->getMistakeRand($openId);
		$ques = $QUESTION->where(array('id'=>$quesid))->find();
		$num = $MISTAKE->getMistakeNum($openId);
		$quesid = $MISTAKE->getMistakeData($openId);
		session('quesid',$quesid);
		$name = M('StudentInfo')->where('openId="'.$openId.'"')->getField('name');
		$ques['chapter'] = getChapterName($ques['chapter']);
		$ques['type'] = get_ques_type($ques['type']);
		
		$this->assign('num',$num);
		$this->assign('name',$name);
		$this->assign('ques',$ques);
		$this->assign('openId',$openId);
		if ($num == 0) {
			$this->display('tip');
			return false;
		}
		if ($ques) {
			if ($ques['type'] == '单选题') {
				$this->display('chose');
			} else if ($ques['type'] == '判断题') {
				$this->display('judge');
			} else if ($ques['type'] == '多选题') {
				$this->display('mutil');
			} else {
				dump('该题题目有错，请联系管理员');
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
		// $data         = M('MistakeHistory')->where(array('openid'=>$openid,'quesid'=>$quesid));
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

		M('MistakeHistory')->where(array('openid'=>$openid,'quesid' => $quesid))->save($data);

		$this->ajaxReturn($right_answer, 'json');
	}
	public function test(){

	// 	$openId = session('openId');
	// 	$QUESTION= M('questionbank');
	// 	$MISTAKE = D('MistakeHistory');
	// 	$quesid = $MISTAKE->getMistakeRand($openId);
	// 	$ques = $QUESTION->where(array('id'=>$quesid))->find();
	// 	$num = $MISTAKE->getMistakeNum($openId);
	// 	$quesid = $MISTAKE->getMistakeData($openId);
	// 	session('quesid',$quesid);
	// 	$name = M('StudentInfo')->where('openId="'.$openId.'"')->getField('name');
	// 	$ques['chapter'] = getChapterName($ques['chapter']);
	// 	$ques['type'] = get_ques_type($ques['type']);
		
	// 	$this->assign('num',$num);
	// 	$this->assign('name',$name);
	// 	$this->assign('ques',$ques);
	// 	$this->assign('openId',$openId);
	// 	if ($num == 0) {
	// 		$this->display('tip');
	// 		return false;
	// 	}
	// 	if ($ques) {
	// 		if ($ques['type'] == '单选题') {
	// 			$this->display('chose');
	// 		} else if ($ques['type'] == '判断题') {
	// 			$this->display('judge');
	// 		} else if ($ques['type'] == '多选题') {
	// 			$this->display('mutil');
	// 		} else {
	// 			dump('该题题目有错，请联系管理员');
	// 		}
	// 	} else {
	// 		$this->display('tip');
	// 	}

	// }


}

 ?>