<?php

namespace Student\Controller;
use Think\Controller;
use Think\Model;

class CollectController extends Controller {

	public function index(){

        $openId=session('openId');
        session('openId',$openId);
		//echo $openId;
		$this->display();
	}

	//收藏
	public function collect(){
	    $openId   = session('?openId') ? session('openId') : $this->error('请重新获取该页面');
	    $quesId   = session('quesid');
	    $COLLECT = D('CollectRecord');
	    $collectResult = $COLLECT->collect($openId,$quesId);
	    if($collectResult){
	    	$this->ajaxReturn('success');
	    }
	
	}

	//取消收藏
	public function cancel(){
	    $openId   = session('?openId') ? session('openId') : $this->error('请重新获取该页面');
	    $quesId = session('quesid');
	    $COLLECT = D('CollectRecord');
	    $cancelResult = $COLLECT->cancel($openId,$quesId);
	    // die();
	    //var_dump($cancelResult);
	    if($cancelResult){	    	
	    	$this->ajaxReturn('success');
		}
	}

	//展示我的收藏
	public function recordList(){
		$openId = session('openId');
		$RECORD = D('CollectRecord');
		$QUESTION = D('Questionbank');
		$EXERCISE = D('Exercise');
		$record = $EXERCISE->getExerciseRecord($openId);
		//var_dump($record);
		$collectNum = $RECORD->getCollectNum($openId);
		$quesIdArr = $RECORD->where(array('openid'=>$openId))->getfield('quesid',$collectNum);
		//var_dump($quesIdArr);
		//var_dump($collectNum);
		//die();	
		$nextid = I('nextid');
		if ($nextid) {
			if ($nextid<$collectNum) {
				$quesId = $quesIdArr[$nextid];
				$nextid++;
			}else{
				$this->display('tip');
				die();
			}

		}else{
			if(I('quesid')){
				$quesId = I('quesid');
			}else{
				$quesId = $quesIdArr[0];
				$nextid = 1;
			}
		}
		//var_dump($quesId);
		//die();
		session('quesid', $quesId);
		session('nextid',$nextid);
		$quesItem  = $QUESTION->getQuestion($quesId);
		//getQuestion方法当$quesId为空时，返回第一题
		$quesList  = $RECORD->getCollectList($openId);
		// var_dump($quesList);
		$rightAns = trim($QUESTION->getRightAnswer($quesId));
		$recordArr = $EXERCISE->where(array('openid'=>$openId,'quesid'=>$quesId))->find();

		$this->assign('record', $record);
		$this->assign('quesItem', $quesItem);
		$this->assign('quesList', $quesList);
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
				 
	}

}