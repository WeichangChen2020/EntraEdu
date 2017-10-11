<?php
namespace Admin\Model;
use Think\Model;
class ExamSetupModel extends Model {

	/**
	 * showList 删除 考试记录
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-15 21:18Authors
	 * @var  $exaimid 
	 * @return  
	 */
	public function showList() {

		$list = $this->select();
		foreach ($list as $key => $value) {
			// $list[$key]['start_time']
		}
		$this->delete($id);
	}


}