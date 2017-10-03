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
}

 ?>