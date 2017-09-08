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

		/*$openid = session('openId');
		$quesid = session('quesid');
		$right_answer = D('Questionbank')->getRightAnswer('quesid');
		$result = 判断一下;*/
		$spend = I('time');
		$option = I('option');
		// $time = 

		$this->ajaxReturn('A'.$spend.$option);
		
		
	}



}

 ?>