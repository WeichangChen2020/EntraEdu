<?php

namespace Student\Model;
use Think\Model;


class StudentMarkModel extends Model {
    protected $tablePrefix = 'cn_';
    	/**
	 * getRankList($start) 获取做对题数的排名
	 * @author 
	 * @copyright  2017-11-22 15:12 Authors
	 * @var int $start
	 * @return array('openid', 'sum(result)') 从第$start名往后的20位同学的数组
	 */
	public function getRankList($start = 0) { 

		$sql = "SELECT * FROM cn_student_mark GROUP BY openid ORDER BY lastMark desc,openid desc LIMIT $start,20";
		// dump($sql);	
		$Model = new \Think\Model();
		$res = $Model->query($sql);
		if (empty($res)) {
			return false;
		}

		return $res;
	}
}