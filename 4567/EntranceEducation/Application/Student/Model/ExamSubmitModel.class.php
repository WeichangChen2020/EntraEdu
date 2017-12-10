<?php 
namespace Student\Model;
use Think\Model;

/**
 * 学生考试提交 模型
 * @author 李俊君<hello_lijj@qq.com>
 * @copyright  2017-10-2 17:11Authors
 *
 */

class ExamSubmitModel extends Model {

	/**
	 * is_submit() 判断考试是否提交
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-10-2 17:11Authors
	 * @param $openid, $examid
	 * @return true： 提交 false：未提交
	 */
	public function isSubmit($openid, $examid) {

		$is_submit = $this->where(array('openid'=>$openid, 'examid'=>$examid))->find();

		if($is_submit)
			return true;
		else
			return false;
	}

	/**
	 * getGrade() 获得正式考试成绩
	 * @author 蔡佳琪
	 * @copyright  2017-12-7 10:22Authors
	 * @param $openid, $examid  //User控制器里如何获得$examid？后需改善！ 
	 * @return array() submit
	 */
	public function getGrade($openid){
		$info = D('StudentInfo')->getInfo($openid);
		$examidList = D('Admin/ExamSubmit')->formal_examid;
		$examid = $examidList[$info['academy']];
		if (empty($openid)) {
			return 'getGrade($openid)传参错误';
		}

		$score = $this->where(array('openid'=>$openid,'examid'=>$examid))->getField('score');
		if($score){
			return $score;
		}else{
			$score = M('ExamSelect')->where(array('examid'=>$examid,'openid'=>$openid,'result'=>1))->count();
		}
	}

}

 ?>