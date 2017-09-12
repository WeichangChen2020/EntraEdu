<?php
namespace Student\Model;
use Think\Model;
class MistakeHistoryModel extends Model {

	//获取错题信息
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

	//获取题目种类
	protected function getQuesType($ty = 0) {

		$typeArr = array('单选题', '判断题', '多选题');
		return $typeArr[$ty - 1];

	}

	//获取题目章节
	protected function getQuesChapter($cp_id = 1) {

		$Chapter = M('question_chapter', 'ee_', $this->database_con);
		$chapter = $Chapter->where(array('id' => $cp_id))->getField('chapter');

		return $chapter;
	}

}