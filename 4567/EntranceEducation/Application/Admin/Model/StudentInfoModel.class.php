<?php
namespace Admin\Model;
use Think\Model;
class StudentInfoModel extends Model {

	/**
	 * getOpenid 获取$name的openid
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-10-29 16:17 Authors
	 * @var  
	 * @return  String
	 */
	public function getOpenid($name) {

		$sql = "SELECT openId FROM ee_student_info WHERE name = '$name' ";
		
		$Model = new \Think\Model();
		$res = $Model->query($sql);

		if (empty($res)) {
			return false;
		}
		return $res['0']['openId'];
	}


}