<?php
namespace Admin\Model;
use Think\Model;
class ExerciseModel extends Model {

	/**
	 * getQuestionList 获取题目列表，包括正确率和提交人数
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-10-29 14:40 Authors
	 * @var  
	 * @return  String
	 */
	public function getAnswerNum($id) {
		if (empty($id)) {
			return 0;
		}
		$sql = " SELECT COUNT(*)  FROM ee_exercise WHERE quesid = $id";
		
		$Model = new \Think\Model();
		$res = $Model->query($sql);

		return $res['0']['COUNT(*)'];
	}
	/**
	 * getAccuracy 获取题目列表，包括正确率和提交人数
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-10-29 14:53 Authors
	 * @var  
	 * @return  String
	 */
	public function getAccuracy($id) {
		if (empty($id)) {
			return 0;
		}
		$sql = "SELECT ROUND( SUM( result ) / COUNT( * ) , 2 ) FROM  ee_exercise WHERE  quesid = $id ";

		$Model = new \Think\Model();
		$res = $Model->query($sql);
dump($res);
		return $res['0']['ROUND(SUM(result)/COUNT(*),2)'];
	}


}