<?php
namespace Student\Model;
use Think\Model;



class StudentHomeworkModel extends Model {
	
	public function give_score($homeworkid,$score,$id)
	{


		$data['mark'] = $score;
		$res = $this->where(array('id' => $homeworkid,'homeworkoid'=>$id))->save($data);
		if ($res) {
			return true;
		} else {
			return false;
		}
		
	}

}