<?php
namespace Home\Controller;
use Think\Controller;
class CommunicationplatController extends Controller {
    public function index(){	
		$Record=M('record');    /*评论在record表里*/ 
		$nums=$Record->count();   /*评论条数*/
		$table=$Record->order('time desc')->select();
		$pagesize=10;
		$pages=ceil($nums/$pagesize);
		$page=1;
		$this->assign('table',$table);

		$this->display();
    }
    public function replay(){
        $number=I('get.num');
        /*var_dump($number);
        die();*/
       $this->assign('number',$number);
    	$this->display();
    }

    public function addcomment(){
    	
    	$numbe=I('get.numr');
    	
    	
    	$this->display();

    }
}