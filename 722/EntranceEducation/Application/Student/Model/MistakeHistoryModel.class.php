<?php
namespace Student\Model;
use Think\Model;
class MistakeHistoryModel extends Model {

	//获取错题信息
	public function getMistakeData($openid = '') { 

		$sql = "SELECT quesid FROM ee_exercise
		where openid = '$openid' AND result = '0'
		AND NOT EXISTS (
			SELECT * FROM ee_mistake_history
			WHERE ee_exercise.quesid = ee_mistake_history.quesid AND ee_mistake_history.result = '1' AND openid = '$openid') LIMIT 1;";

		// dump($sql);die;	
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

	//获取错题数量
	public function getNumberOfMistake($openid = ''){
		$sql = "SELECT DISTINCT COUNT(quesid) FROM ee_exercise
		where openid = '$openid' AND result = '0'
		AND NOT EXISTS (
			SELECT * FROM ee_mistake_history
			WHERE ee_exercise.quesid = ee_mistake_history.quesid AND ee_mistake_history.result = '1' AND openid = '$openid');";

		$Model = new \Think\Model();
		$num = $Model->query($sql);
		// dump($num);
		if (empty($num)) {
			return false;
		}
		// echo $num[0]['COUNT(quesid)'];
		return $num[0]['COUNT(quesid)'];
	}

	//获取答对的错题数量
	public function getNumberOfRight($openid = ''){
		$sql = "SELECT DISTINCT COUNT(quesid) FROM ee_mistake_history WHERE result = '1' AND openid = '$openid'";

		$Model = new \Think\Model();
		$num = $Model->query($sql);
		// dump($num);
		if (empty($num)) {
			return false;
		}
		// echo $num[0]['COUNT(quesid)'];
		return $num[0]['COUNT(quesid)'];
	}	

	//获取题目信息
	public function getQuestionByid($quesid = 0) {
		
		$param = array();
		if(!$quesid)
			$param['id']      = $quesid;

		$quesArr = M('Questionbank')->where(array('id' => $quesid))->find();

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

    /**
     * getMistakeRand($openid) 随机获取错题的id号
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright  2017-11-30 14:31 Authors
     * @return   int  false
     */
    public function getMistakeRand($openid) {
        
        if (empty($openid)) {
            return false;
        }
        $quesid = $this->where(array('openid'=>$openid,'result'=>0))->order('rand()')->limit(1)->select();
        return $quesid['0']['quesid'];
    }
    /**
     * getMistakeNum($openid) 随机获取错题总数
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright  2017-11-30 14:31 Authors
     * @return   int  false
     */
    public function getMistakeNum($openid) {
        
        if (empty($openid)) {
            return false;
        }
        $quesNum = $this->where(array('openid'=>$openid,'result'=>0))->count('quesid');
        return $quesNum;
    }
    

}