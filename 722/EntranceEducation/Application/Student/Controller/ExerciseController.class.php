<?php 
namespace Student\Controller;
use Think\Controller;

class ExerciseController extends Controller{
	protected $database_con = 'mysql://lzyoo3jx2o:ik221mylmw4h1x0kyi51j32k01150hx0j4jk30xi@w.rdc.sae.sina.com.cn/app_classtest#utf8';

	

	public function index() {
		$this->display();
	}

	public function exercise() {
		$Question = M('questionbank', 'ee_', $this->database_con);
		$quesId = rand(1, 20);
		$quesItem = $Question->find($quesId);
		// var_dump($quesItem);
		$this->assign('quesItem', $quesItem)->display('index');
	}

}

 ?>