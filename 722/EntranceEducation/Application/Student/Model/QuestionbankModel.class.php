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

	// 链接数据库参数	
	protected $database_con = 'mysql://lzyoo3jx2o:ik221mylmw4h1x0kyi51j32k01150hx0j4jk30xi@w.rdc.sae.sina.com.cn/app_classtest#utf8';
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
	public function getQuestion($qs_id = 1) {
		$Quse =  M('questionbank', 'ee_', $this->database_con);
		$quesArr = $Quse->find($qs_id);
		$quesArr['chapter'] = $this->getQuesChapter($quesArr['chapter']);
		$quesArr['type'] = $this->getQuesType($quesArr['type']);
		return $quesArr;
	}

	

}