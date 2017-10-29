<?php 


/**
 * is_on 解析是否开启
 * @author 李俊君<hello_lijj@qq.com>
 * @copyright  2017-9-16 11:13Authors
 * @var string $on 1 or 0
 * @return string 开启 关闭
 */
function is_on($on) {
	$state = array('关闭', '开启');
	return $state[$on];
}

/**
 * get_ques_type 获取题目类型
 * @author 李俊君<hello_lijj@qq.com>
 * @copyright  2017-10-15 21:08Authors
 * @var string $on 1 or 0
 * @return string 开启 关闭
 */
function get_ques_type($type) {
	switch ($type) {
		case 1:
			return '单选题';
			break;
		case 2:
			return '判读题';
			break;
		case 3:
			return '多选题';
		default:
			return 'ss';
			break;
	}
}
/**
 * getAnswerNum 获取答题人数
 * @author 陈伟昌<1339849378@qq.com>
 * @copyright  2017-10-29 14:36Authors
 * @var $id  题目id
 * @return int 答题人数
 */
function getAnswerNum($id) {
	$num = D('Exercise')->getAnswerNum($id);
	return $num;
}
/**
 * getAccuracy 获取答题人数
 * @author 陈伟昌<1339849378@qq.com>
 * @copyright  2017-10-29 14:36Authors
 * @var $id  题目id
 * @return int 答题人数
 */
function getAccuracy($id) {
	$accuracy = D('Exercise')->getAccuracy($id);
	return $accuracy;
}

 ?>