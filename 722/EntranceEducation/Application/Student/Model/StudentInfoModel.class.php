<?php
namespace Student\Model;
use Think\Model;
class StudentInfoModel extends Model {
	// protected $tablePrefix = 'db_';

	public function getName($openid){
		return  $this->where('openId="'.$openid.'"')->getField('name');
	}
	public function getClass($openid){
		return  $this->where('openId="'.$openid.'"')->getField('class');
	}
	public function getNumber($openid){
		return  $this->where('openId="'.$openid.'"')->getField('number');
	}

	public function getStuInfo($openid){
		return  $this->where('openId="'.$openid.'"')->find();
	}

	//判断是否注册
	public function isRegister($openId){
		$condition['openId'] = $openId;                //查询条件
		if($this->where($condition)->find())                    
			return true;
		else
			return false;
	}

	//返回新手列表里的信息
	public function newerInfo($number) {
		$info = D('student_list')->where(array('number'=>$number))->find();
		
		if (empty($info)) {
			return false;
		}

		return $info;
	}

	/**
	 * 判断用户是否为新生
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-10-3 14:25Authors
	 * @param $openid
	 * @return true or false
	 */
	public function isNewer ($openid){

		$newer = $this->where(array('openid'=>$openid))->getField('is_newer');
		if ($newer)
			return true;
		else
			return false;
		
	}
	/**
	 * getInfo 获取$openid的info
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-11-26 19:20 Authors
	 * @var  
	 * @return  Array
	 */
	public function getInfo($openid) {

		$res = $this->where(array('openId'=>$openid))->find();
		if (empty($res)) {
			return false;
		}
		return $res;
	}
}