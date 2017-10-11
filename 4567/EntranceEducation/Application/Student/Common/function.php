<?php 
use Think\Model;


// 截止时间
function get_endtime($now, $set_time){
	return date('m月d日 h时i分', $now + $set_time * 60);
}


// *******展示题目索引****************

function get_exam_index_css($result) {
	
	if ($result == -1) {
		return 'placeholder';
	} else {
		return 'placeholder-right';
	}
}

// *******展示题目索引 in  exercise *****
function get_exsercise_index_css($id) {
	
	$openid = session('openId');
	$quesid = session('quesid');
	echo $openid;
	echo $quesid;
	
	$map = array(
		'openid' => $openid,
		'quesid' => $quesid,
 	)
	
	$result =  M('exercise')->where($map)->getField('result');

	if(empty($result)) {
		return 'placeholder';
	} else if ($result == 0) {
		return 'placeholder-wrong';
	} else if ($result == 1){
		return 'placeholder-right';
	}

	return 'placeholder'; 
}

function get_exercise_url_css($result) {
	if (!$result) {
		
	}
}


 ?>
