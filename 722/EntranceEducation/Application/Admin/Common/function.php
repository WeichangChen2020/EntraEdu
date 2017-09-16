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

 ?>