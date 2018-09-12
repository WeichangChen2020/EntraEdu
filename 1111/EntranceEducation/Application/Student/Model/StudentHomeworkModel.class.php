<?php
namespace Student\Model;
use Think\Model;



class StudentHomeworkModel extends Model {
	
	public function give_score($homeworkid,$score,$id)
	{


        $openId       = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $myname = M('studentInfo')->where(array('openId'=>$openId))->field('name')->find();
        $data['correcter'] = $myname['name'];
		$data['mark'] = $score;
		$res = $this->where(array('id' => $homeworkid,'homeworkoid'=>$id))->save($data);
		if ($res) {
			return true;
		} else {
			return false;
		}
		
	}

	public function ssgive_score($homeworkid,$score,$id)
	{
		$data['mark'] = $score;
		$data['complain'] = 0;
		$res = $this->where(array('id' => $homeworkid,'homeworkoid'=>$id))->save($data);
		if ($res) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * getComplainState  获取申诉状态
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright 2018-03-04T16:58:48+0800
	 * @var
	 * @param     string                   $openId       
	 * @param     string                   $homeworkname 课后作业名字
	 * @return    string                                 1申诉中 0申诉结束 NULL未申诉 EMPTY未找到提交记录 NO未被批改
	 */
	public function getComplainState($openId,$homeworkname)
	{
		if (empty($openId)||empty($homeworkname)) {
			return '参数错误';
		}
		// 提交--未批改--NO
		// 	 |--已批改
		// 		 |-申诉中--1
		// 		 |-未申诉--NULL
		// 		 |-申诉已处理--0
		$corrected = $this->where(array('openId'=>$openId,'homeworkname'=>$homeworkname,'mark'=>array('NEQ','no')))->find();
		if (empty($corrected)) {	
			return 'NO';
		}
		$inComplain = $this->where(array('openId'=>$openId,'homeworkname'=>$homeworkname,'complain'=>'1'))->find();
		if (!empty($inComplain)) {
			return '1';
		}
		$complainFinished = $this->where(array('openId'=>$openId,'homeworkname'=>$homeworkname,'complain'=>'0'))->find();
		if (!empty($complainFinished)) {
			return '0';
		}
		$submit = $this->where(array('openId'=>$openId,'homeworkname'=>$homeworkname,'complain'=>array('EXP','IS NULL')))->find();
		if (!empty($submit)) {
			return 'NULL';
		}
		return 'EMPTY';
	}
}