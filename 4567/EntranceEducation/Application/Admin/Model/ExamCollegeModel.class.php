<?php
namespace Admin\Model;
use Think\Model;
class ExamCollegeModel extends Model {

	/**
	 * init() 初始化exam_college表(创建考试)
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-15 21:18Authors
	 * @var  $exaimid 
	 * @return  
	 */
	public function init() {

		$collegeList = D('StudentList')->getCollegeList();
		foreach ($collegeList as $key => $value) {
			// $value['examid'] = 
			dump($value);
		}
		return $collegeList;
	}


}