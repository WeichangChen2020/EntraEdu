<?php 
namespace Admin\Controller;
use Think\Controller;

/**
 * EXAM 控制器 新生考试 模拟考试
 * @author 李俊君<hello_lijj@qq.com>
 * @copyright  2017-9-12 15:08Authors
 * @var  
 * @return 
 */
class ExamController extends Controller{
	
	/**
	 * index 自由练习主页面 能显示当前进度，答题了多少道
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-10 9:39Authors
	 * @var  
	 * @return 
	 */

	public function index() {
		$this->display();
	}

	public function add() {
		if (IS_POST) {
			p(I());
		} else {
			$this->show();
		}
	}


	public function addQues() {
		$this->display();
	}



}