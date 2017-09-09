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
	public function getNewestQuesid($openid = '', $chap_id = '') {

		p($chap_id);
		if (empty($chap_id)) {
			$newest_id = $this->where(array('openid'=>$openid))->max('id');
			$newest_quesid  = $this->where(array('id'=>$newest_id))->getField('quesid');
		} else {

			$cod = array('id'=>$newest_id, 'chapter'=> $chap_id);
			$newest_id = $this->where($cod)->max('id');
			$newest_quesid  = $this->where($cod)->getField('quesid');

			p($newest_quesid);
		}
		

		return $newest_quesid;

	}
}