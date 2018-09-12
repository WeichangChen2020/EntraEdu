<?php
namespace Student\Model;
use Think\Model;

class TeacherClassModel extends Model {
	public function getTeacherClass($openId){
		$teacherClass = $this->where(array('openId'=>$openId))->select();
		return $teacherClass;
	} 
}