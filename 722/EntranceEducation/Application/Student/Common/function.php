<?php 
use Think\Model;


// 截止时间
function get_endtime($now, $set_time){
	return date('m月d日', $now + $set_time * 60);
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
function get_exsercise_index_css($quesid) {
	
	$openid = session('openId');
	
	$map = array(
		'openid' => $openid,
		'quesid' => $quesid,
 	);
	
	$result =  M('exercise')->where($map)->getField('result');


	if(!isset($result)) {
		return 'placeholder';
	} else if ($result == 1) {
		return 'placeholder-right';
	} else {
		return 'placeholder-wrong';
	}
}

function get_exercise_url_css($quesid) {
	
	$openid = session('openId');
	
	$map = array(
		'openid' => $openid,
		'quesid' => $quesid,
 	);
	
	$result =  M('exercise')->where($map)->getField('result');


	if(!isset($result)) {
		return U('Exercise/exercise_chap', array('quesid'=>$quesid));
	} else {
		return 'javascript:;' ;		
	}

}

// *******展示题目索引 in  record *****
function get_record_index_css($quesid) {
	
	$openid = session('openId');
	
	$map = array(
		'openid' => $openid,
		'quesid' => $quesid,
 	);
	
	$result =  M('exercise')->where($map)->getField('result');


	if(!isset($result)) {
		return 'placeholder';
	} else if ($result == 1) {
		return 'placeholder-right';
	} else {
		return 'placeholder-wrong';
	}
}

function get_record_url_css($quesid) {
	

	return U('Record/record', array('quesid'=>$quesid));

}

// *******展示题目索引 in  collect *****
function get_collect_index_css($quesid) {
	
	$openid = session('openId');
	
	$map = array(
		'openid' => $openid,
		'quesid' => $quesid,
 	);
	
	$result =  M('exercise')->where($map)->getField('result');


	if(!isset($result)) {
		return 'placeholder';
	} else if ($result == 1) {
		return 'placeholder-right';
	} else {
		return 'placeholder-wrong';
	}
}

function get_collect_url_css($quesid) {
	

	return U('Collect/recordList', array('quesid'=>$quesid));

}

// *******展示题目索引 in  repeat *****
function get_repeat_index_css($quesid) {
	
	$openid = session('openId');
	
	$map = array(
		'openid' => $openid,
		'quesid' => $quesid,
 	);
	
	$result =  M('repeat')->where($map)->getField('result');


	if(!isset($result)) {
		return 'placeholder';
	} else if ($result == 1) {
		return 'placeholder-right';
	} else {
		return 'placeholder-wrong';
	}
}

function get_repeat_url_css($quesid) {
	
	//$openid = session('openId');
	
	//$map = array(
	//	'openid' => $openid,
	//	'quesid' => $quesid,
 	//);
	
	//$result =  M('repeat')->where($map)->getField('result');


	//if(!isset($result)) {
		return U('Repeat/repeat_chap', array('quesid'=>$quesid));
	//} else {
		return 'javascript:;' ;		
	//}

}

// *******处理包含图片的题目
function repleace_question_image($contents) {
	
	$pattern = '/!\[image\]\((\d{1,}.jpg)\)/';

	$r = preg_match_all($pattern, $contents, $m);
	

	if($r){
		foreach ($m[1] as $k => $v) {
			$contents = str_replace($m[0][$k], '<img class="c-pic" src="http://'. $_SERVER['HTTP_HOST'] .'/EntranceEducation/Public/images/questionbank/'.$v.'">', $contents);
		}
	}

	return $contents;
}


 ?>
