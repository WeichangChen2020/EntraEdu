<?php

namespace Student\Model;
use Think\Model;


class StudentMarkModel extends Model {
    protected $tablePrefix = 'cn_';
    /**
	 * getLastMark($openid) 获取积分
	 * @author 
	 * @copyright  2018-01-19 15:57 Authors
	 * @var 
	 * @return 
	 */
    public function getLastMark($openid){
    	$map = array('openid'=>$openid);
    	$mark = $this->where($map)->getfield('lastMark');
    	// p($mark);die;
    	return $mark;
    }

    public function getRank($openid){
    	$map = array('openid',$openid);
    	$class = D('StudentInfo')->getClass($openid);
    	// p($class);
    	$rankList = $this->order('lastMark desc')->where(array('class'=>$class))->group('openid')->select();
    	// p($rankList);
    	foreach ($rankList as $key => $value) {
    		// p($rankList);
    		// p($value);
    		if(in_array($openid, $value)){
    			// p('匹配');
    			$rankMark=array_keys($rankList,$value);
    		}
    	}
    	return $rankMark[0];
    }

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