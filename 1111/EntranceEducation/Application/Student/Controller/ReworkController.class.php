<?php 
namespace Student\Controller;
use Think\Controller;

class ReworkController extends Controller{

	public function chose(){

		$openId = session('openId');
		$QUESTION= D('questionbank');
		$EXERCISE= D('Exercise');

		$quesid = $EXERCISE->getMistakeData($openId);
		$num = $EXERCISE->getNumberOfMistake($openId);
		session('quesid',$quesid);
		$ques = $QUESTION->getQuestion($quesid,0,0);
		$name = M('StudentInfo')->where('openId="'.$openId.'"')->getField('name');
		$ques['contents'] = C('COMMONPATH').C('QUESTIONPATH').$ques['chapter'].'_'.$ques['type'].'_'.$ques['right_answer'].'_'.$ques['id'].'.jpg';

		$this->assign('num',$num);
		$this->assign('name',$name);
		$this->assign('ques',$ques);
		$this->assign('openId',$openId);
		if ($num == 0) {
			$this->display('tip-none');
			return false;
		}
		if ($ques) {
			if ($ques['type'] == '1') {
				$this->display('chose');
			} else if ($ques['type'] == '2') {
				$this->display('judge');
			} else if ($ques['type'] == '3') {
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

		//若错题回顾中回答正确，则更新exercise表中的is_rework
		if($option == $right_answer){
			$map = array(
				'openid' => $openid,
				'quesid' => $quesid
			);
			$data2['is_rework'] = 1;
			M('exercise')->where($map)->save($data2);
		}
		
		$this->ajaxReturn($right_answer, 'json');
	}



}

 ?>