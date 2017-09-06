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
	public function collect(){

        $openId   = session('?openId') ? session('openId') : $this->error('请重新获取该页面');

        $RECORD = M('collect_record');
        $QUESTION = M('question');
        $collectNum = $RECORD->where('openId="'.$openId.'"')->count();//收藏题数
        $collectArray = $RECORD->where('openId="'.$openId.'"')->select();//收藏的题目数组
        //var_dump($collectArray);
        //$collectId = $collectArray[1]['questionId'];
        //echo $collectId;
        //die();
        for ($i=0; $i < $collectNum; $i++) { 
        	$collectId = $collectArray[$i]['questionId'];
        	//echo $collectId;
        	$answerRecord = $RECORD->where(array('openId' => $openId,'questionId'=>$collectId))->find();
			//$proId = $RECORD->where(array('openId' => $openId , 'testId' => $testId))->getField('proId');
			//var_dump($answerRecord);//答题记录数组
			//echo $proId;
			//die(); 
			$questionId = $answerRecord['questionId'];
			//echo $questionId;     
	        $quesList = $QUESTION->where(array('id' => $questionId))->select();
	 		//var_dump($quesList);//题目信息数组
			//die(); 
			$proId = $i+1;
			$this->assign('proId',$proId);
			$this->assign('answerRecord',$answerRecord);   
	        $this->assign('quesList',$quesList)->display();
        }
    }




}