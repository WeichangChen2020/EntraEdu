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
		$quesid      = rand(1,15);
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
		$openid       = session('quesid');
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
		$this->ajaxReturn($right_answer);
	}

}

 ?>