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


// *******处理包含图片的题目
function get_question_with_img($contents) {
	
	// 下列图中哪个是正确的校学生会logo（   ）. A.![image](logo_1.jpg) B.![image](logo_2.jpg) C.![image](logo_3.jpg) D.![image](logo_4.jpg)
	// $pattern = '/href="(show.asp\?cid=26\d\d)\"  title=\"(.*)\" target/';
	
	p($contents);

	$pattern = '/![image]((*))/';

	preg_match_all($pattern, $contents, $m);
	p($m);

}


 ?>
