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


	/**
	 * 获取用户参与考试的基本条件
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-10-3 14:15Authors
	 * @param $openid, $examid
	 * @return 
	 */
	public function beforeInitExam ($openid, $examid){

        $examInfo = $this->getExamInfo($examid);
        $now      = time();
        
        $info         = array(
	      'is_on'     => 1,
	      'is_end'    => 0,
	      'is_submit' => 0,
	      'is_init'   => 0,
        );

        // 考试还未开启
        if ($now < $examInfo['start_time'] && $examInfo['is_on'] == 0) {
        	$info['is_on'] = 0;
        } 

        // 考试已经截止
        if ($now > $examInfo['start_time'] + $examInfo['set_time'] * 60 ) {
        	$info['is_end'] = 1;
        }

        // 已经提交过了
        if (D('ExamSubmit')->isSubmit($openid, $examid)) {
        	$info['is_submit'] = 1;
        }

        // 已经初始化过了
        if (D('ExamSelect')->isInit($openid, $examid)) {
        	$info['is_init'] = 1;
        }

        return $info;

	} 
	
}

 ?>