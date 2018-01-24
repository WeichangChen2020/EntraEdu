<?php
namespace Admin\Model;
use Think\Model;
class ExerciseModel extends Model {

	/**
	 * getAnswerNum 获取提交人数
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-10-29 14:40 Authors
	 * @var  
	 * @return  String
	 */
	public function getAnswerNum($id) {
		if (empty($id)) {
			return 0;
		}
		$sql = " SELECT COUNT(*)  FROM ee_exercise WHERE quesid = $id";
		
		$Model = new \Think\Model();
		$res = $Model->query($sql);

		return $res['0']['COUNT(*)'];
	}
	/**
	 * getAccuracy 获取正确率
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-10-29 14:53 Authors
	 * @var  
	 * @return  String
	 */
	public function getAccuracy($id) {
		if (empty($id)) {
			return 0;
		}
		$sql = "SELECT ROUND( SUM( result ) / COUNT( * ) , 2 ) FROM  ee_exercise WHERE  quesid = $id ";

		$Model = new \Think\Model();
		$res = $Model->query($sql);
		return $res['0']["ROUND( SUM( result ) / COUNT( * ) , 2 )"];
	}
	/**
	 * getResult 获取某次模拟考得分
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-10-29 16:20 Authors
	 * @var  
	 * @return  string
	 */
	public function getResult($openid) {
		$id = I('id');
		if (empty($openid)) {
			return 0;
		}
		$map['openid']= $openid;
		$map['examid']= $id;
		$submit = M('ExamSubmit')->where($map)->find();
		if (empty($submit)) {
			return '未提交';
		}else{
			$score = M('ExamSelect')->where(array('openid'=>$openid,'examid'=>$id,'result'=>1))->count();
			return $score;
		}

	}
	/**
	 * test1() 获取正确百分比的排名
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-10-17 13:32Authors
	 * @var int $start
	 * @return array('openid', 'ROUND(SUM(result)/COUNT(*),2)') 从第$start名往后的20位同学的数组
	 */
	public function test1() { 
		$academyList = array(
            '管理学院',
            '人文学院',
            '外国语学院',
            '工商学院',
            '管工学院' ,
            '管电学院' ,
            '信息学院' ,
            '统计学院'  ,
            '马克思学院',
            '信电学院'  ,
            '财会学院' ,
            '环境学院' ,
            '食品学院' ,
            '经济学院',
            '东语学院',
            '法学院'   ,
            '旅游学院'  ,
            '公管学院',
            '艺术学院' ,
            '金融学院' ,
            '非新生'  ,
        );
		for ($i=0; $i < count($academyList); $i++) { 
			dump($academyList[$i]);
		}
			die;
		$sql = "SELECT openid, ROUND(SUM(result)/COUNT(*),2) FROM (SELECT DISTINCT openid,quesid,result FROM ee_exercise) P GROUP BY openid ORDER BY ROUND(SUM(result)/COUNT(*),2) DESC LIMIT  $start,20";

		// dump($sql);	
		$Model = new \Think\Model();
		$res = $Model->query($sql);
		if (empty($res)) {
			return false;
		}

		return $res;
	}


}