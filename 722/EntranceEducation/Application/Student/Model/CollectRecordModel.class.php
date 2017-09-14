<?php
namespace Student\Model;
use Think\Model;

/**
 * 收藏记录模型
 * @author 李俊君<hello_lijj@qq.com>
 * @copyright  2017-9-8 16:34Authors
 *
 */

class CollectRecordModel extends Model {
	/**
	 * 收藏
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-8 16:36Authors
	 * @var string openid
	 * @return array(openid, quesid, time, )
	 */
	public function collect($openid = '',$quesid = '') {

		$result = $this->where(array('openid'=>$openid,'quesid'=>$quesid))->find();

		if (!$result) {//未收藏则add
			$record       = array(
				'openid'  => $openid,
				'quesid'  => $quesid, 
				'time'    => date('Y-m-d:H:i:s', time()),
			);
			return $this->add($record);
		}else{
			return false;//已收藏
		}		
		
	}
	/**
	 * 取消收藏
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-8 18:14Authors
	 * @var string openid
	 * @return 删除成功与否
	 */
	public function cancel($openid = '',$quesid = '') {

		$exsit = $this->where(array('openid'=>$openid,'quesid'=>$quesid))->find();
		if ($exsit) {//已收藏则delete
			$result = $this->where(array('openid'=>$openid,'quesid'=>$quesid))->delete();
			return $result;
		}else{
			return false;//未收藏
		}				
	}
}