<?php 

namespace Admin\Model;
use Think\Model;
class AdminerModel extends Model {


	// 返回管理员的学院 校级管理员则返回 ''
	public function getCollege () {

		$username = session('username');
		$college  = $this->where('username = "%s", $username')->getField('college');
		

		return $college;
	}

	
}
 ?>