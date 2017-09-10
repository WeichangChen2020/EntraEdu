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

		$Chapter = M('question_chapter', 'ee_', $this->database_con);
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

		$right_answer = $this->where(array('id'=>$qs_id))->getField('right_answer');

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
	 * @var 
	 * @return array {id type author num} 题目类型 题目来源 该类型题目
	 */
	public function getQuesAllType() {

		$quesTypeArr = array(
			array('id' => 1, 'type' => '单选题', 'num' => 0),
			array('id' => 2, 'type' => '判断题', 'num' => 0),
			array('id' => 3, 'type' => '多选题', 'num' => 0),
		);

		
		foreach ($quesTypeArr as $key => $value) {

			$quesTypeArr[$key]['num'] = $this->getQuesTypeNum($value['id']);

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
	 * @var 
	 * @return array {id type author num} 题目类型 题目来源 该类型题目
	 */
	public function getQuesAllChapter() {

		$quesChapterArr = D('QuestionChapter')->select();

		foreach ($quesChapterArr as $key => $value) {
			$quesChapterArr[$key]['num'] = $this->getQuesChapterNum($value['id']);
		}

		return $quesChapterArr;
	}

	/**
	 * getQuesAllChapter 获取所有题目的数量
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-10 14:20 Authors
	 * @var 
	 * @return int 题目总数量
	 */
	public function getQuesNum() {

		return  $this->count();

	}

	

}