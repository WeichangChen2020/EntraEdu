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

	/**
	 * getOpenid 获取$openid的info
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-11-7 15:32 Authors
	 * @var  
	 * @return  Array
	 */
	public function getInfo($openid) {

		$sql = "SELECT * FROM ee_student_info WHERE openid = '$openid' ";
		
		$Model = new \Think\Model();
		$res = $Model->query($sql);

		if (empty($res)) {
			return false;
		}
		return $res;
	}
	/**
	 * getOpenidBynumber 获取$number的openid
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-11-21 14:55 Authors
	 * @var  
	 * @return  String
	 */
	public function getOpenidBynumber($number) {
		$openid = M('StudentInfo')->where(array('is_newer'=>1))->select();
		
		dump($openid);die;
	}

}