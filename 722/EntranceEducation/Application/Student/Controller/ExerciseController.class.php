<?php 
namespace Student\Controller;
use Think\Controller;

class ExerciseController extends Controller{
	

	public function index() {
		$this->display();
	}

	/**
	 * exercise 用户做题页面
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-8 14:51Authors
	 * @var  
	 * @return 
	 */
	public function exercise() {
		$Question    = D('Questionbank');
		$quesid      = rand(1, 15);
		session('quesid', $quesid);
		$quesItem    = $Question->getQuestion($quesid);
		$this->assign('quesItem', $quesItem)
			 ->display('index');
	}

	/**
	 * submit 处理用户提交结果
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-8 14:58Authors
	 * @var  
	 * @return json. 正确，还是错误
	 */
	public function submit() {
		if (!IS_AJAX) {
			$this->error('你访问的页面不存在');
		}
		$openid       = 'oendi';
		$quesid       = session('quesid');
		$option       = I('option');
		$start_time   = I('time');
		$right_answer = D('Questionbank')->getRightAnswer($quesid);
		
		$data = array(
			'openid' => $openid,
			'quesid' => $quesid,
			'result' => $option == $right_answer ? 1 : 0,
			'times'  => time(),
			'stsdsfa'=> $start_time,
			'spend'  => time() - $start_time,
			'time'   => date('Y-m-d:H:i:s', time())
		);
		

		$this->ajaxReturn($data);

	}



}

 ?>