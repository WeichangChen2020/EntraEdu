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
}