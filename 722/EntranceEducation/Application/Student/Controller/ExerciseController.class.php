<?php 
namespace Student\Controller;
use Think\Controller;

class ExerciseController extends Controller{
	
	/**
	 * index 自由练习主页面 能显示当前进度，答题了多少道
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-10 9:39Authors
	 * @var  
	 * @return 
	 */
	public function index() {

		$openid         = session('openId');
		$QUES           = D('Questionbank');
		$quesTypeArr    = $QUES->getQuesAllType($openid);
		$quesChapterArr = $QUES->getQuesAllChapter($openid);

		$icon = array('bodygood', 'notebook', 'shenghuo', 'sate_edu', 'notebook', 'heartword', 'consciousness');


		$this->assign('quesTypeArr', $quesTypeArr);
		$this->assign('quesChapterArr', $quesChapterArr);
		$this->assign('quesNum', $QUES->getQuesNum($openid));
		$this->assign('icon', $icon);


	
		$this->display('list');
	}

	/**
	 * exercise 用户做题页面
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-8 14:51Authors
	 * @var  
	 * @return 
	 */

	public function exercise_chap() {
		$openid = session('openId');
		$record = D('exercise')->getExerciseRecord($openid);

		$chapid = I('chapid'); if(empty($chapid)) {$chapid = 0; }
		$typeid = I('typeid'); if(empty($typeid)) {$typeid = 0; }
		$quesid = I('quesid'); 

		session('chapid', $chapid);
		session('typeid', $typeid);
		// 首次金进入，否则点击下一题进入
		
		if (empty($quesid)) {
			$quesid = D('exercise')->getNewestQuesid($openid, $chapid, $typeid);
		}		
		

		if (false == $quesid) {
			$this->display('tip'); die;
		}

		session('quesid', $quesid);
		$quesItem  = D('Questionbank')->getQuestion($quesid, $chapid,$typeid);
		$quesList  = D('Questionbank')->getQuesList($openid);
		// p($quesList);

		// 判断是否已经做完了最后一道题目
		if ($quesItem) {
			$this->assign('record', $record);
			$this->assign('quesItem', $quesItem);
			$this->assign('quesList', $quesList);

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
		$quesid       = I('quesid');
		$option       = I('option');
		$time         = intval(trim(I('time'))); //将毫秒转为秒并取整
		$right_answer = D('Questionbank')->getRightAnswer($quesid);
		$done = D('Exercise')->where(array('openid'=>$openid,'quesid'=>$quesid))->find();
        if(!$done){  //如果不存在
        	$data = array(
                'openid' => $openid,
                'quesid' => $quesid,
                'answer' => $option,
                'result' => $option == $right_answer ? 1 : 0,
                'spend'  => $time,
                'time'   => date('Y-m-d:H:i:s', time())
            );

            D('Exercise')->add($data);

            $this->ajaxReturn($right_answer, 'json');
        }else{ //如果已存在
        	$this->ajaxReturn('fail');
        }
	}

	public function test() {
		D('Questionbank')->getQuesList('ohd41t0Bx0TshKrf18RvG9PuH8DI');
	}


}

 ?>