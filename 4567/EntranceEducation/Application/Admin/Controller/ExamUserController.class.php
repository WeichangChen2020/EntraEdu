<?php 
namespace Admin\Controller;
use Think\Controller;

/**
 * EXAMUSER 控制器 新生考试 模拟考试
 * @author 陈伟昌<1339849378@qq.com>
 * @copyright  2017-10-29 14:128Authors
 * @var  
 * @return 
 */
class ExamUserController extends CommonController{
	
	/**
	 * index 模拟考试主页面 显示考试列表，提交人数等
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-10-29 14:12Authors
	 * @var  
	 * @return 
	 */

	public function index() {

		$examList = D('ExamSetup')->select();
		// p($examList);
		$this->assign('examList', $examList);
		$this->display();
	}




}