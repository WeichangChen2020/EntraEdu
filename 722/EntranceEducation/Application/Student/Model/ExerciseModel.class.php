<?php
namespace Student\Model;
use Think\Model;

/**
 *  练习记录模型
 * @author 李俊君<hello_lijj@qq.com>
 * @copyright  2017-9-8 16:34Authors
 *
 */

class ExerciseModel extends Model {
	/**
	 * 获取用户的答题记录
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-8 16:36Authors
	 * @var string openid
	 * @return array(name, count, rig_cot, wrg_cot, sum)姓名,答题总数,正确数，错误数，题库总数
	 */
	public function getExerciseRecord($openid = '') {

		//答题量
		$count        = count($this->where(array('openid'=>$openid))->group('quesid')->select());

		$rig_cot      = count($this->where(array('openid'=>$openid, 'result' => 1))->group('quesid')->select());

		$record       = array(
			'name'    => D('student_info')->getName($openid),
			'count'   => $count, //答题量
			'rig_cot' => $rig_cot,
	        'wrg_cot' => $count - $rig_cot,
			'sum'     => D('questionbank')->count(),
			'next_quesid' => $next_quesid + 1,
		);
		
		return $record;
	}

	/**
	 * getNewestQuesid() 获取用户的最新的答题进度
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-8 18:14Authors
	 * @var string openid
	 * @return int 最新的答题ID
	 */
	public function getNewestQuesid($openid = '', $chapid = 0, $typeid = 0) {


		$Model = new \Think\Model();
		$newest_quesid = 0;


		// 此时用户按章节选择题目
		if($chapid != 0) {

			$sql = "SELECT * FROM ee_questionbank where chapter = '$chapid' AND NOT EXISTS (SELECT * FROM ee_exercise where openid = '$openid' AND ee_exercise.quesid = ee_questionbank.id GROUP BY quesid)";

			$res = $Model->query($sql);

			if (empty($res)) {
				return false;
			}

			$newest_quesid = $res[0]['id'];

			return $newest_quesid;
		}
		 
		// 此时用户按类型选择题目
		if($typeid   != 0) {
			$sql = "SELECT * FROM ee_questionbank where type = '$typeid' AND NOT EXISTS (SELECT * FROM ee_exercise where openid = '$openid' AND ee_exercise.quesid = ee_questionbank.id GROUP BY quesid)";

			$res = $Model->query($sql);

			if (empty($res)) {
				return false;
			}

			$newest_quesid = $res[0]['id'];

			return $newest_quesid;

		}

		// 此时用户按顺序练习选择题目
		$newest_quesid = D('questionbank')->getUnfishRecord($openid);
		return $newest_quesid;

	}


	/**
	 * getCurrentProgress() 获取用户的答题进度
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-11 12:59Authors
	 * @var string array(openid, chapid, typeid)
	 * @return int 已经完成了的题目数量
	 */
	public function getCurrentProgress($openid = '', $chapid = 0, $typeid = 0) {

		$Model = new \Think\Model();
		$finish_num = 0;

		// 此时用户按章节选择题目
		if($chapid != 0) {

			$finish_Arr = $Model->where("exer.openid='$openid' && bank.id = exer.quesid && bank.chapter=$chapid")
					->table(array('ee_exercise'=>'exer','ee_questionbank'=>'bank'))
					->group("exer.quesid") 
					->select();
			
			return count($finish_Arr);
		}

		// 此时用户按类型选择题目
		if($typeid   != 0) {
			$finish_Arr = $Model->where("exer.openid='$openid' && bank.id = exer.quesid && bank.type=$typeid")
					->table(array('ee_exercise'=>'exer','ee_questionbank'=>'bank'))
					->group("exer.quesid") 
					->select();

			return count($finish_Arr);

		}


		$finishArr = $this->where(array('openid' => $openid))
				          ->group('quesid')
						  ->select();
		$finish_num =  count($finishArr);
			
			
		return $finish_num;
		
	}

	
	//获取做对题数的排名
	public function getRankList($openid = '') { 

		// $sql = "SELECT openid,COUNT(result) FROM (SELECT DISTINCT openid,quesid,result FROM ee_exercise) P GROUP BY openid having COUNT(result) ORDER BY COUNT(result) desc";
		$sql = "SELECT openid, sum(result) FROM (SELECT DISTINCT openid,quesid,result FROM ee_exercise) P GROUP BY openid ORDER BY SUM(result) desc";

		// dump($sql);die;	
		$Model = new \Think\Model();
		$res = $Model->query($sql);
		// dump($res);
		if (empty($res)) {
			return false;
		}

		return $res;
	}


}