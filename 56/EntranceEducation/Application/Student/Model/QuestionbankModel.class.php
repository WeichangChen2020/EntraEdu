<?php
namespace Student\Model;
use Think\Model;

/**
 * openid 题目模型
 * @author 李俊君<hello_lijj@qq.com>
 * @copyright  2017-9-8 20:03Authors
 *
 */

class QuestionbankModel extends Model{


	/**
	 * getQuesType 获取题目类型
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-8 20:03Authors
	 * @var int 
	 * @return 单选题 多选题 判断题
	 */

	protected function getQuesType($ty = 0) {

		$typeArr = array('单选题', '判断题', '多选题');
		return $typeArr[$ty - 1];

	}

	/**
	 * getQuesChapter 获取题目类型
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-8 13:21 Authors
	 * @var int 
	 * @return  多选题 判断题
	 */
	protected function getQuesChapter($cp_id = 1) {

		$Chapter = M('question_chapter', 'hs_', $this->database_con);
		$chapter = $Chapter->where(array('id' => $cp_id))->getField('chapter');

		return $chapter;
	}

	/**
	 * getQuestion 获取题目
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-8 13:21 Authors
	 * @var int 
	 * @return  多选题 判断题
	 */
	public function getQuestion($qs_id = 0, $chap_id = 0, $tp_id = 0) {
		
		$param = array();
		if($qs_id  != 0) $param['id']      = $qs_id;
		if($chap_id != 0) $param['chapter'] = $chap_id;
		if($tp_id   != 0) $param['type']    = $tp_id;

		$quesArr = $this->where($param)->find();

		// 当用户做完了所有的题目
		if (empty($quesArr)) {
			return false;
		}

		$quesArr['chapter'] = $this->getQuesChapter($quesArr['chapter']);
		$quesArr['type']    = $this->getQuesType($quesArr['type']);
		
		return $quesArr;
	}

	/**
	 * getRightAnswer 获取正确答案
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-8 15:14 Authors
	 * @var int quesid
	 * @return string 正确答案
	 */
	public function getRightAnswer($qs_id = 1) {

		$right_answer = trim($this->where(array('id'=>$qs_id))->getField('right_answer'));

		return $right_answer;
	}

	/**
	 * getQuesTypeNum 获取不同类型的题目数量
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-9 20:14 Authors
	 * @var int tyid
	 * @return int 数量
	 */
	public function getQuesTypeNum($ty_id) {

		$num = $this->where(array('type' => $ty_id))->count();

		return $num;
	}


	/**
	 * getQuesAllType 获取所有题目的类型信息
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-9 20:14 Authors
	 * @var (openid)
	 * @return array {id type author num finsh_num 题目类型 题目来源 该类型题目 完成了的数量
	 */
	public function getQuesAllType($openid = '') {

		$quesTypeArr = array(
			array('id' => 1, 'type' => '单选题', 'num' => 0),
			array('id' => 2, 'type' => '判断题', 'num' => 0),
			array('id' => 3, 'type' => '多选题', 'num' => 0),
		);

		
		foreach ($quesTypeArr as $key => $value) {

			$quesTypeArr[$key]['num'] = $this->getQuesTypeNum($value['id']);
			// 如果攒传了openid参数，则查询该openid的进度 
			if (!empty($openid)) {
				$quesTypeArr[$key]['finish_num'] = D('exercise')->getCurrentProgress($openid, 0, $value['id']);
			}
			

		}

		return $quesTypeArr;
	}

	/**
	 * getQuesChapterNum 获取不同章节的题目数量
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-9 20:14 Authors
	 * @var int cpid
	 * @return string 正确答案
	 */
	public function getQuesChapterNum($cp_id) {
		
		$num = $this->where(array('chapter' => $cp_id))->count();

		return $num;
	}

	/**
	 * getQuesAllChapter 获取所有题目的章节信息
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-9 20:14 Authors
	 * @var openid 
	 * @return array {id type author num finsh_num} 题目类型 题目来源 该类型题目
	 */
	public function getQuesAllChapter($openid = '') {

		$quesChapterArr = D('QuestionChapter')->select();

		foreach ($quesChapterArr as $key => $value) {
			$quesChapterArr[$key]['num'] = $this->getQuesChapterNum($value['id']);

			// 如果攒传了openid参数，则查询该openid的进度 
			if (!empty($openid)) {
				$quesChapterArr[$key]['finish_num'] = D('exercise')->getCurrentProgress($openid, $value['id'], 0);
			}
			
		}

		return $quesChapterArr;
	}

	/**
	 * getQuesAllChapter 获取所有题目的数量
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-10 14:20 Authors
	 * @var openid
	 * @return int 题目总数量
	 */
	public function getQuesNum($openid = '') {

		$quesNum = array();
		$quesNum['num'] = $this->count();

		if(!empty($openid))
			$quesNum['finish_num'] = D('exercise')->getCurrentProgress($openid);

		return  $quesNum;

	}

	/**
	 * getUnfishRecord 获取用用户没有做过的题目的最小的id
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-11 14:24 Authors
	 * @var openid
	 * @return int 题目总数量
	 */
	public function getUnfishRecord($openid) { 

		// 原来写的sql
		// $sql = "SELECT * FROM hs_questionbank where NOT EXISTS (SELECT * FROM hs_exercise where openid = '$openid' AND hs_exercise.quesid = hs_questionbank.id GROUP BY quesid)";


		$sql = "SELECT id FROM hs_questionbank where NOT EXISTS (SELECT quesid FROM hs_exercise where openid = '$openid' AND hs_exercise.quesid = hs_questionbank.id) limit 1" ;

		$Model = new \Think\Model();
		$res = $Model->query($sql);

		$min_id = $res[0]['id'];
		return $min_id;

	}

// SELECT * FROM hs_exercise where openid = 'ohd41t3hENwHiNZTFBlbsUaB-gGw' AND result = '0' AND NOT EXISTS (SELECT * FROM hs_mistake_history where hs_exercise.quesid = hs_mistake_history.id AND hs_mistake_history.result = '1' AND openid = 'ohd41t3hENwHiNZTFBlbsUaB-gGw');


	/**
	 * getQuesList 获取用题目列表
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-114 13:18 Authors
	 * @var openid
	 * @return arrayList( 'quesid', 'result')
	 */
	public function getQuesList($quesid) {

		$EXER = D('exercise');
		$map = array(
			'id' => array('gt', $quesid - 7),
		);
		
		$quesList = $this->where($map)->field('id')->limit(70)->select();
		
		return $quesList;
	}


	public function getProgress($openid) {

		$result = D('exercise')->getExerciseRecord($openid);//总答题量，答对数，答错数，总题量
		$result['reworknum'] = M('exercise')->where(array('openid'=>$openid, 'result'=>0, 'is_rework'=>1))->count();//错题回顾中答对的题数
		$result['sumNum'] = $result['rig_cot']+$result['reworknum'];//总答对题数
		$result['progress'] = $result['sumNum']/$result['sum'];//完成进度
        
        return $result;
	}

	/**
	 * getQuestionByid 获取题目
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2018-1-5 14:05 Authors
	 * @var quesid
	 * @return array
	 */
	public function getQuestionByid($quesid = 0) {
		
		$param = array();
		if(!$quesid)
			$param['id']      = $quesid;

		$quesArr = M('Questionbank')->where(array('id' => $quesid))->find();

		$quesArr['chapter'] = $this->getQuesChapter($quesArr['chapter']);
		$quesArr['type']    = $this->getQuesType($quesArr['type']);
		
		return $quesArr;
	}


	

}