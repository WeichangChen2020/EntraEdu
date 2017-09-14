<?php 
namespace Student\Controller;
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

	}

	public function exam() {


		$openid = session('openId');
		$record = D('exercise')->getExercseRecord($openid);

		$chapid = I('chapid'); if(empty($chapid)) {$chapid = 0; }
		$typeid = I('typeid'); if(empty($typeid)) {$typeid = 0; }

		session('chapid', $chapid);
		session('typeid', $typeid);
		// 首次金进入，否则点击下一题进入
		
		$quesid = D('exercise')->getNewestQuesid($openid, $chapid, $typeid);

		if (false == $quesid) {
			$this->display('tip'); die;
		}

		session('quesid', $quesid);
		$quesItem  = D('Questionbank')->getQuestion($quesid, $chapid,$typeid);


		// 判断是否已经做完了最后一道题目
		if ($quesItem) {
			$this->assign('record', $record);
			$this->assign('quesItem', $quesItem);

			// 对题目类型判断 不同类型进入不同的页面
			$this->display();
				 
		} else {

			$this->display('tip');
		}
	}

}