<?php 

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


 ?>
