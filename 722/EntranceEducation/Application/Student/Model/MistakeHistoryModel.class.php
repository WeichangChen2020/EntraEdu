<?php
namespace Student\Model;
use Think\Model;
class MistakeHistoryModel extends Model {
	public function getMistakeData($openid = '') { 

		$sql = "SELECT DISTINCT quesid FROM ee_exercise
		where openid = '$openid' AND result = '0'
		AND NOT EXISTS (
			SELECT * FROM ee_mistake_history
			WHERE ee_exercise.quesid = ee_mistake_history.quesid AND ee_mistake_history.result = '1' AND openid = '$openid');";

		$Model = new \Think\Model();
		$res = $Model->query($sql);
		// dump($res);
		if (empty($res)) {
			return false;
		}
		// SELECT DISTINCT quesid FROM ee_exercise
		// where openid = 'ohd41t3hENwHiNZTFBlbsUaB-gGw' AND result = '0'
		// AND NOT EXISTS (
		// 	SELECT * FROM ee_mistake_history
		// 	WHERE ee_exercise.quesid = ee_mistake_history.quesid AND ee_mistake_history.result = '1' AND openid = 'ohd41t3hENwHiNZTFBlbsUaB-gGw')
		return $res[0]['quesid'];
	}

}