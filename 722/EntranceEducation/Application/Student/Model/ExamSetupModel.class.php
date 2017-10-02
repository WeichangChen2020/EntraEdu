<?php 
namespace Student\Model;
use Think\Model;

/**
 * 创建考试模型
 * @author 李俊君<hello_lijj@qq.com>
 * @copyright  2017-10-2 17:15Authors
 *
 */

class ExamSetupModel extends Model {

	/**
	 * 展示所有的模拟考试列表
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-10-2 17:15Authors
	 * @return $listArray{examinfo}
	 */
	public function listExam() {
		$examList = $this->select();
		return $examList;
	}


	/**
	 * 获取详细的模拟考试信息
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-10-2 20:52Authors
	 * @return $examInfo{int examtime, int exam_ques_count, }
	 */

	public function getExamInfo($examid){
		$examInfo = $this->find($examid);
		$examInfo['count'] = D('ExamQuestionbank')->count($examid);
		return $examInfo;
	}
	
}

 ?>