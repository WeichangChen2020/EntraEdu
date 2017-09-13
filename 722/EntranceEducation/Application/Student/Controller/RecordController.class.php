<?php


namespace Student\Controller;
use Think\Controller;
use Think\Model;

class RecordController extends Controller {
	public function index(){

        $openId=session('openId');
        session('openId',$openId);
		//echo $openId;

		$this->display('explain');
	}

	/*
	  getNewestQuesid() 获取用户答题记录

	 */

	public function record(){

		$openId = session('openId');
		$RECORD = D('exercise');
		$QUESTION = D('Questionbank');
		$record = $RECORD->getExerciseRecord($openId);
		// var_dump($record);
		//die();
		$num = $record['count'];//总答题数
		//echo $num;
		//die();
		$idArr = array(); 
		for ($i=0; $i < $num; $i++) { 
			$quesArray = $RECORD->where(array('openid'=>$openId))->group('quesid')->select();
			// var_dump($quesArr);//二维数组
			$quesArr = $quesArray[$i];
			$questionId = $quesArr['quesid'];
			$quesIdArr[$i] = $questionId;
		}
		//var_dump($quesIdArr);//所有做过的题目的id

		$nextid = I('nextid');
		if ($nextid) {
			if ($nextid<$num) {
				$quesId = $quesIdArr[$nextid];
				$nextid++;
			}else{
				$this->display('tip');
				die();
			}

		}else{
			$quesId = $quesIdArr[0];
			$nextid = 1;
		}
		//var_dump($quesId);
		//die();
		session('quesId', $quesId);
		session('nextid',$nextid);
		$quesItem  = $QUESTION->getQuestion($quesId);
		//getQuestion方法当$quesId为空时，返回第一题
		
		$rightAns = $QUESTION->getRightAnswer($quesId);
		$recordArr = $RECORD->where(array('openid'=>$openId,'quesid'=>$quesId))->find();
		//var_dump($recordArr);
		//echo "用户答案：".$recordArr['answer']."<br/>";
		//echo "正确答案：".$rightAns."<br/>";
		//echo $recordArr['result'];

		// 判断是否已经做完了最后一道题目
		if ($quesItem) {
			$this->assign('record', $record);
			$this->assign('quesItem', $quesItem);
			$this->assign('rightAns',$rightAns);
			$this->assign('recordArr',$recordArr);

			// 对题目类型判断 不同类型进入不同的页面
			if ($quesItem['type'] == '单选题') {
				$this->display('index');
			} else if ($quesItem['type'] == '判断题') {
				$this->display('judge');
			} else if ($quesItem['type'] == '多选题') {

				$this->display('mutil');
			}
				 
		} else {

			$this->display('tip');
		}
    }




}