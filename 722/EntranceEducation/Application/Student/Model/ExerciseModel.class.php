<?php
namespace Student\Model;
use Think\Model;

/**
 *  练习记录模型
 * @author 李俊君<hello_lijj@qq.com>
 * @copyright  2017-9-8 16:34Authors
 *
 */

class ExercsieModel extends Model {
	/**
	 * 获取用户的答题记录
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-8 16:36Authors
	 * @var string openid
	 * @return array(name, count, rig_cot, wrg_cot, sum)姓名,答题总数,正确数，错误数，题库总数
	 */
	public function getExercseRecord($openid = '') {

		$record = array(
			'name'    => D('student_info')->getName($openid),
			'count'   => $this->where('openid'=>$openid)
		                     ->count(), //答题量
			'rig_cot' => $this->where('openid'=>$openid, 'result' => 1)
		                     ->count(),
	        'wrg_cot' => $count - $rig_cot,
			'sum'     => D('questionbank')->count(),
		);
		
		return $record;
	}
}