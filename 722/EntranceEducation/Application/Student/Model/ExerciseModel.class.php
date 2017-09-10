<?php
namespace Student\Model;
use Think\Model;

/**
 *  练习记录模型
 * @author 李俊君<hello_lijj@qq.com>
 * @copyright  2017-9-8 16:34Authors
 *
 */

class ExerciseModel extends Model {
	/**
	 * 获取用户的答题记录
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-8 16:36Authors
	 * @var string openid
	 * @return array(name, count, rig_cot, wrg_cot, sum)姓名,答题总数,正确数，错误数，题库总数
	 */
	public function getExercseRecord($openid = '') {

		$count        = $this->where(array('openid'=>$openid))
			                 ->count(); //答题量
		$rig_cot      = $this->where(array('openid'=>$openid, 'result' => 1))
		                     ->count();
		$record       = array(
			'name'    => D('student_info')->getName($openid),
			'count'   => $count, //答题量
			'rig_cot' => $rig_cot,
	        'wrg_cot' => $count - $rig_cot,
			'sum'     => D('questionbank')->count(),
			'next_quesid' => $next_quesid + 1,
		);
		
		return $record;
	}

	/**
	 * getNewestQuesid() 获取用户的最新的答题进度
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-8 18:14Authors
	 * @var string openid
	 * @return int 最新的答题ID
	 */
	public function getNewestQuesid($openid = '', $chap_id = 0, $tp_id = 0) {


		$Model = new \Think\Model();
		$newest_quesid = 0;

		// 此时用户按章节选择题目
		if($chap_id != 0) {
			// p($openid);
			$newest_quesid = $Model->where("exer.openid='$openid' && bank.id = exer.quesid && bank.chapter=$chap_id")
					->table(array('ee_exercise'=>'exer','ee_questionbank'=>'bank'))
					-> max("exer.quesid");
			// 如果没有查到结果
			if (empty($newest_quesid)) {
				$newest_quesid = D('Questionbank')->where(array('chapter'=>$chap_id))->min('quesid');
			}
			p($newest_quesid);
			return $newest_quesid;
		}
		 
		// 此时用户按类型选择题目
		if($tp_id   != 0) {

		}


		// 此时用户按顺序练习选择题目
		$newest_id = $this->where(array('openid'=>$openid))->max('quesid');
		return $newest_quesid;

	}
}