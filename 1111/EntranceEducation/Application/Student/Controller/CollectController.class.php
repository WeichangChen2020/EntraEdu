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
	    //dump($cancelResult);
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
		// dump($record);die;
		$collectNum = $RECORD->getCollectNum($openId);//收藏题数
		// dump($collectNum);
		//$quesIdArr = $RECORD->where(array('openid'=>$openId))->getfield('quesid',$collectNum);
		//dump($quesIdArr);
		$quesList = $RECORD->where(array('openid'=>$openId))->order('quesid asc')->field('quesid')->select();
		// dump($quesList);//所有收藏的题目的id，二维数组
		$quesIdArr = array();  
		$quesIdArr = array_map('array_shift', $quesList);
		//$quesIdArr = array_column($quesList, 'quesid');  //不知道为什么不能用
		// dump($quesIdArr);//所有收藏的题目的id，一维数组
		if (I('nextid')) {
			$nextid = I('nextid');
			if ($nextid<$collectNum) {
				$quesId = $quesList[$nextid]['quesid'];
				$nextid++;
			}else{
				$this->display('tip');
				die();
			}

		}else{
			if(I('quesid')){
				//从索引进入
				$quesId = I('quesid');
				//print_r(array_keys($quesIdArr,$quesId,true)); 
				//die();
				$nowid = array_keys($quesIdArr,$quesId,true); //array_keys返回的是数组
				$nextid = $nowid[0]+1;
			}else{	
				//从首页入口进入显示第一题
				$quesId = $quesList[0]['quesid'];
				$nextid = 1;
			}
		}
		//dump($quesId);
		//die();
		session('quesid', $quesId);
		session('nextid',$nextid);
		if($quesId==''){
			$this->display('none');
			die();
		}else{
			$quesItem  = $QUESTION->getQuestion($quesId);
		}
		//getQuestion方法当$quesId为空时，返回第一题
		$quesList  = $RECORD->getCollectList($openId);
		// dump($quesList);
		$rightAns = trim($QUESTION->getRightAnswer($quesId));
		//如果收藏的题目未做过，则recoedArr为NULL
		$recordArr = $EXERCISE->where(array('openid'=>$openId,'quesid'=>$quesId))->find();

		$this->assign('record', $record);
		$this->assign('quesItem', $quesItem);
		$this->assign('quesList', $quesList);
		$this->assign('rightAns',$rightAns);
		$this->assign('recordArr',$recordArr);
		
		// 对题目类型判断 不同类型进入不同的页面
		if ($quesItem['type'] == '1') {
			$this->display('index');
		} else if ($quesItem['type'] == '2') {
			$this->display('judge');
		} else if ($quesItem['type'] == '3') {

			$this->display('mutil');
		}
				 
	}


	/**
	 * exercise_index 我的收藏的索引
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-8 14:58Authors
	 * @var  
	 * @return json. 正确，还是错误
	 */

	public function collect_index() {

		$openId = session('openId');
		$RECORD = D('CollectRecord');
		$quesList = $RECORD->where(array('openid'=>$openId))->field('quesid')->select();
		$this->assign('quesList', $quesList)->display();

	}
}