<?php
namespace Student\Model;
use Think\Model;
class TeacherInfoModel extends Model {
	/**
	 * [函数名]  [函数描述]
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright 2018-02-10T13:51:43+0800
	 * @var
	 * @param     string                   $openid [description]
	 * @return    boolean                           是教师则true
	 */
	public function checkTeacher($openid){
		$info = $this->where(array('openId'=>$openid))->find();
		$class= M('TeacherClass')->where(array('openId'=>$openid))->find();
		if (!empty($info) || !empty($class)) {
			return true;
		}else{
			return false;
		}
	}
}