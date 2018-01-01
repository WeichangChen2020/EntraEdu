<?php
namespace Student\Model;
use Think\Model;



class StudentHomeworkModel extends Model {
	
	public function give_score($homeworkid,$score)
	{
		$data['mark'] = $score;
		$res = $this->where("id='$homeworkid'")->save($data);
		if ($res) {
			return true;
		} else {
			return false;
		}
		
	}

}