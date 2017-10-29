<?php
namespace Admin\Model;
use Think\Model;
class ExamSubmitModel extends Model {

	/**
	 * getSubmitNum 获取提交人数
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-10-29 14:28 Authors
	 * @var  
	 * @return  int
	 */
	public function getSubmitNum($id) {

		$sql = "SELECT COUNT(*) FROM ee_exam_submit WHERE examid = '$id' ";

		$Model = new \Think\Model();
		$res = $Model->query($sql);

		if (empty($res)) {
			return 0;
		}
		return $res['0']['COUNT(*)'];
	}


}