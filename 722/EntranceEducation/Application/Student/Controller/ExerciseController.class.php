<?php 
namespace Student\Controller;
use Think\Controller;

class ExerciseController extends Controller{
	public function index() {
		$this->display();
	}

	public function exercise() {
		$QUESTION = M('questionbank', 'ee_', $this->database_con);
		$quesArr = $QUESTION->select();
		p($quesArr);
		$this->display('index');
	}

}

 ?>