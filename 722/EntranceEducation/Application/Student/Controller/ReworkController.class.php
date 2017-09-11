<?php 
namespace Student\Controller;
use Think\Controller;

class ReworkController extends Controller{
	
	public function index() {

		$openid = session('openId');
		echo $openid;
		$this->assign('openId',$openid);
		$this->display();
	}

	public function chose(){
		$openId = session('openId');

		$WrongQuesid = I('WrongQuesid');
		if(empty($WrongQuesid))
			$WrongQuesid=0;
		session('WrongQuesid',$WrongQuesid);

		$HISTORY = M('exercise');
		$QUESTION= M('questionbank');

		$wrongNum  = $HISTORY->where('openId="'.$openId.'" AND result = "0"' )->count();//错误题目数量
		$quesidArray = $HISTORY->where('openId="'.$openId.'" AND result = "0"' )->field('quesid')->distinct(true)->select();//错误题目编号数组，已合并重复数据

		// dump($quesidArray);die;
		/**
		*历史中错误----错题历史中正确->无视
		*			|--错题历史中错误或不存在->加入数组
		*错题历史中做错->加入数组
		*错题历史中正确->无视
		*
		*/
		$MISTAKE = M('mistake_history');




		// dump($quesidArray);
		$ques = $QUESTION->where(array('id' => $quesidArray[$WrongQuesid]['quesid']))->find();
		session('quesid',$ques['id']);
		$this->assign('ques',$ques);
		$this->assign('openId',$openId);
		// echo $quesidArray[$WrongQuesid]['quesid'];
		if ($wrongNum == 0) {
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

	public function getMistakeData($openid = '') { 

		$openid = 'ohd41t3hENwHiNZTFBlbsUaB-gGw';
		$sql = "SELECT * FROM ee_exercise where NOT EXISTS (SELECT * FROM ee_mistake_history where openid = '$openid' AND ee_exercise.quesid = ee_mistake_history.quesid)";

		$Model = new \Think\Model();
		$res = $Model->query($sql);

		dump($res);
		// $min_id = $res[0]['id'];
		// return $minid;
		// SELECT * FROM ee_exercise where openid = 'ohd41t3hENwHiNZTFBlbsUaB-gGw' AND result='0' AND NOT EXISTS (SELECT * FROM ee_mistake_history where ee_exercise.quesid = ee_mistake_history.quesid);

	}


}

 ?>