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
	    $quesId   = session('quesid');
	    $COLLECT = D('CollectRecord');
	    $collectResult = $COLLECT->collect($openId,$quesId);
	    if($collectResult){
	    	$this->ajaxReturn('success');
	    }
	
	}

	public function cancel(){
	    $openId   = session('?openId') ? session('openId') : $this->error('请重新获取该页面');
	    $quesId = session('quesid');
	    $COLLECT = D('CollectRecord');
	    $cancelResult = $COLLECT->cancel($openId,$quesId);
	    // var_dump($result);
	    // die();
	    if($cancelResult){	    	
	    	$this->ajaxReturn('success');
		}
	}		

}