<?php
namespace Student\Model;
use Think\Model;
class MistakeHistoryModel extends Model {

	//获取错题信息
	public function getMistake($openid = '') { 

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
		return $res;
	}
	public function getMistakeData($openid = ''){
		$res = $this->getMistake($openid);
		return $res[0]['quesid'];
	}

	//获取错题数量
	public function getNumberOfMistake($openid = ''){
		$num = count($this->getMistake($openid));
		return $num;		
	}

	//获取题目信息
	public function getQuestionByid($qs_id = 0) {
		
		$param = array();
		if(!$qs_id)
			$param['id']      = $qs_id;

		$quesArr = M('Questionbank')->where(array('id' => $qs_id))->find();

		$quesArr['chapter'] = $this->getQuesChapter($quesArr['chapter']);
		$quesArr['type']    = $this->getQuesType($quesArr['type']);
		
		return $quesArr;
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