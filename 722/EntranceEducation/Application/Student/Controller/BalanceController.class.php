<?php

namespace Student\Controller;
use Think\Controller;
use Think\Model;
  

// 负载均衡
class BalanceController extends Controller{

	public function balance($openid = '') {

		$college = M('student_info')->where(array('openId'=>$openid))->getField('academy');

		/*array(

			'管理学院'    =>
			'人文学院'    =>
			'外国语学院'  =>
			'工商学院'    =>

			'管工学院'
			'管电学院'
			'信息学院'
			'统计学院'

			'马克思学院'
			'信电学院'
			'财会学院'

			'环境学院'
			'食品学院'
			'经济学院'

			'东语学院'
			'法学院'
			'旅游学院'

			'公管学院'
			'艺术学院'
			'金融学院'
			
		);*/

		p($college);
	}    

}