<?php
namespace Admin\Model;
use Think\Model;
class ExamCollegeModel extends Model {

	/**
	 * init($id) 初始化exam_college表(创建考试)
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-10-26 14:59 Authors
	 * @var  $id 
	 * @return  boolen
	 */
	public function init($id) {
		if (empty($id)) {
			return false;
		}
		$collegeList = D('StudentList')->getCollegeList();
		foreach ($collegeList as $key => $value) {
			$value['examid'] = $id;
			$this->add($value);
		}
		return true;
	}

	/**
	 * getInfo($id) 获取$id号考试的学院信息(是否允许)
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-10-26 15:09 Authors
	 * @var  $id 
	 * @return  array('academy','state')
	 */
	public function getInfo($id) {
		if (empty($id)) {
			return false;
		}
		$sql = "SELECT * FROM  ee_exam_college WHERE examid = '$id'";
		
		$Model = new \Think\Model();
		$res = $Model->query($sql);

		if (empty($res)) {
			return false;
		}
		dump($res);die;
		return $res;
	}


}