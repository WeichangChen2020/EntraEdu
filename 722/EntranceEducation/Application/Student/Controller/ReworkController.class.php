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
		$quesidArray = $HISTORY->field('quesid')->distinct(true)->select();//错误题目编号数组，已合并重复数据

		$ques = $QUESTION->where(array('id' => $quesidArray[$WrongQuesid]['quesid']))->find();
		session('quesid',$ques['id']);
		$this->assign('ques',$ques);
		$this->assign('openId',$openId);


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
			$this->error('你访问的页面不存在');
		}
		$openid       = session('openId');
		$quesid       = session('quesid');
		$option       = I('option');
		$start_time   = ceil(intval(trim(I('time'))) / 1000); //将毫秒转为秒并取整
		$right_answer = D('Questionbank')->getRightAnswer($quesid);
		
		$data = array(	
			'openid' => $openid,
			'quesid' => $quesid,
			'answer' => $option,
			'result' => $option == $right_answer ? 1 : 0,
			'spend'  => time() - $start_time,
			'time'   => date('Y-m-d:H:i:s', time())
		);

		D('Exercise')->add($data);

		$this->ajaxReturn($right_answer, 'json');
	}



}

 ?>