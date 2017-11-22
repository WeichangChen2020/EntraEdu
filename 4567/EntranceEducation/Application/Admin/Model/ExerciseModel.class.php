<?php
namespace Admin\Model;
use Think\Model;
class ExerciseModel extends Model {

	/**
	 * getAnswerNum 获取提交人数
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-10-29 14:40 Authors
	 * @var  
	 * @return  String
	 */
	public function getAnswerNum($id) {
		if (empty($id)) {
			return 0;
		}
		$sql = " SELECT COUNT(*)  FROM ee_exercise WHERE quesid = $id";
		
		$Model = new \Think\Model();
		$res = $Model->query($sql);

		return $res['0']['COUNT(*)'];
	}
	/**
	 * getAccuracy 获取正确率
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-10-29 14:53 Authors
	 * @var  
	 * @return  String
	 */
	public function getAccuracy($id) {
		if (empty($id)) {
			return 0;
		}
		$sql = "SELECT ROUND( SUM( result ) / COUNT( * ) , 2 ) FROM  ee_exercise WHERE  quesid = $id ";

		$Model = new \Think\Model();
		$res = $Model->query($sql);
		return $res['0']["ROUND( SUM( result ) / COUNT( * ) , 2 )"];
	}
	/**
	 * getResult 获取某次模拟考得分
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-10-29 16:20 Authors
	 * @var  
	 * @return  string
	 */
	public function getResult($openid) {
		$id = I('id');
		if (empty($openid)) {
			return 0;
		}else if (M('ExamSubmit')
			->where(array('openid'=>$openid,'examid'=>$id)
				->find() == null)) {
			return '未提交';
		}else{
			$score = M('ExamSelect')->where(array('openid'=>$openid,'examid'=>$id,'result'=>1))->count();
			return $score;
		}

	}



}