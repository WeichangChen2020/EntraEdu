<?php 
namespace Student\Controller;
use Think\Controller;

class ExerciseController extends Controller{
	
	/**
	 * index 自由练习主页面
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-10 9:39Authors
	 * @var  
	 * @return 
	 */
	public function index() {
		$quesTypeArr = D('Questionbank')->getQuesAllType();
		$quesChapterArr = D('Questionbank')->getQuesAllChapter();

		$this->assign('quesTypeArr', $quesTypeArr);
		$this->assign('quesChapterArr', $quesChapterArr);
		
		$this->display('list');
	}

	/**
	 * exercise 用户做题页面
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-8 14:51Authors
	 * @var  
	 * @return 
	 */
	public function exercise() {
		$openid = session('openId');
		$record = D('exercise')->getExercseRecord($openid);
		$quesid = I('quesid');

		if (empty($quesid)) {
			$quesid = D('exercise')->getNewestQuesid($openid) + 1;
		}

		session('quesid', $quesid);

		$quesItem    = D('Questionbank')->getQuestion($quesid);
		die;

		// 判断是否已经做完了最后一道题目
		if ($quesItem) {
			$this->assign('record', $record);
			$this->assign('quesItem', $quesItem);

			// 对题目类型判断 不同类型进入不同的页面
			if ($quesItem['type'] == '单选题') {
				$this->display('index');
			} else if ($quesItem['type'] == '判断题') {
				$this->display('judge');
			} else if ($quesItem['type'] == '多选题') {
				$this->display('mutil');
			}
				 
		} else {

			$this->display('tip');
		}
	}

	public function exercise_chap() {
		$openid = session('openId');
		$record = D('exercise')->getExercseRecord($openid);

		$quesid = I('quesid');
		$chapid = I('chapid');
		// $chapid = intval(trim($chapid));

		if (empty($quesid)) {
			$quesid = D('exercise')->getNewestQuesid($openid, $chapid) + 1;
		}

		session('chapid', $chapid);

		$quesItem    = D('Questionbank')->getQuestion($quesid, $chapid);
		p($quesItem);die;
		// 判断是否已经做完了最后一道题目
		if ($quesItem) {
			$this->assign('record', $record);
			$this->assign('quesItem', $quesItem);

			// 对题目类型判断 不同类型进入不同的页面
			if ($quesItem['type'] == '单选题') {
				$this->display('index');
			} else if ($quesItem['type'] == '判断题') {
				$this->display('judge');
			} else if ($quesItem['type'] == '多选题') {
				$this->display('mutil');
			}
				 
		} else {

			$this->display('tip');
		}

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