<?php 
namespace Student\Model;
use Think\Model;

/**
 * 学生选择题目模型
 * @author 李俊君<hello_lijj@qq.com>
 * @copyright  2017-10-2 17:09Authors
 *
 */

class ExamSelectModel extends Model {
	
	/**
	 * 判断学生用户的这次题目是否初始化
	 * 学生选择题目的记录
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-10-2 17:09Authors
	 * @param $openid, $examid
	 * @return true, false
	 */

	public function isInit($openid, $examid) {
		$is_init = $this->where(array('openid'=>$openid, 'examid'=>$examid))->find();

		if($is_init)
			return true;
		else
			return false;
	}

	/**
	 * initExam 初始化考试题目
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-10-3 14:15Authors
	 * @param $openid, $examid
	 * @return true 初始化成功 false 初始化失败
	 */

	public function initExam($openid, $examid) {

		$quesUnits = D('ExamQuestionbank')->where(array('examid'=>$examid))->select();
		$result = false;

		foreach ($quesUnits as $key => $value) {
			
			$queUnit = $this->getRandQues($value['chapid'], $value['chap_num']);
			foreach ($queUnit as $k => $v) {
				
				$ques = array(
					'openid' => $openid,
					'examid' => $examid,
					'quesid' => $v,
					'time'   => date('Y-m-d H:i:s'),
 				);

				$result = $this->add($ques);
			}
		}
		
		return $result;
	}

	/**
	 * getRandQues 获取随机题目
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-10-3 16:08Authors
	 * @param $chapid, $rand_num
	 * @return array(quesid)
	 */

	public function getRandQues($chapid, $rand_num) {

		$quesArray     = D('Questionbank')->where(array('chapter'=>$chapid))->getField('id', true);

		$quesUnitArray = array_rand($quesArray, $rand_num);
		$return        = array();

		foreach ($quesUnitArray as $key => $value) {
			$return[] = $quesArray[$value];

		}
		return $return;
	}

	/**
	 * getExamItems 获取题目信息
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-10-3 15:52Authors
	 * @param $openid, $examid
	 * @return 
	 */

	public function getExamItems($openid, $examid) {

		$examQues = $this->where(array('openid'=>$openid, 'examid'=>$examid))->select();

		return $examQues;
	}
}

 ?>