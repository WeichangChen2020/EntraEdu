<?php 
namespace Student\Controller;
use Think\Controller;

class ExerciseController extends Controller{
	protected $database_con = 'mysql://lzyoo3jx2o:ik221mylmw4h1x0kyi51j32k01150hx0j4jk30xi@w.rdc.sae.sina.com.cn/app_classtest#utf8';

	

	public function index() {
		$this->display();
	}

	public function exercise() {
		$Question = new \Student\Model\QuestionbankModel();;
		p($Question);
		$Question->test();
		$quesId = rand(1, 15);
		$quesItem = $Question->getQuestion($quesId);
		var_dump($quesItem);
		$this->assign('quesItem', $quesItem)->display('index');
	}

}

 ?>