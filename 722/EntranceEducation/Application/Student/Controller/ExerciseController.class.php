<?php 
namespace Student\Controller;
use Think\Controller;

class ExerciseController extends Controller{
	

	public function index() {
		$this->display();
	}

	public function exercise() {
		$Question = new \Student\Model\QuestionbankModel();;
		$quesId = rand(1, 15);
		$quesItem = $Question->getQuestion($quesId);
		$this->assign('quesItem', $quesItem)->display('index');
	}

	public function test(){
		$a = M('questionbank');
		$b = $a->select();
		var_dump($b);
	}

}

 ?>