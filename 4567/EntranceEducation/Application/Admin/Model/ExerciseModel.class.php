<?php
namespace Admin\Model;
use Think\Model;
class ExerciseModel extends Model {

	/**
	 * getQuestionList 获取题目列表，包括正确率和提交人数
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-10-29 14:40 Authors
	 * @var  
	 * @return  int
	 */
	public function getAnswerNum($id) {
		if (empty($id)) {
			return 0;
		}
		$sql = " SELECT COUNT(*)  FROM ee_exercise WHERE quesid = $id";
		
		$Model = new \Think\Model();
		$res = $Model->query($sql);

		return $res['COUNT(*)'];
	}


}