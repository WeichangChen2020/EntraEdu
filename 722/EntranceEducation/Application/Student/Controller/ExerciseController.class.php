<?php 
namespace Student\Controller;
use Think\Controller;

class ExerciseController extends Controller{
	protected $database_con = 'mysql://lzyoo3jx2o:ik221mylmw4h1x0kyi51j32k01150hx0j4jk30xi@w.rdc.sae.sina.com.cn/app_classtest#utf8';
	
	protected $cplat_con = 'mysql://ylm2jlwxmm:2y5jjyhxwj13xm2i5kwxz3ykwlj4542i022lwlhy@w.rdc.sae.sina.com.cn/app_cprogramplatform#utf8';

	public function index() {
		$this->display();
	}

	public function exercise() {
		$quesArr = M('es', 'class', $this->database_con)->select();

		$cplat_openid = M('es', 'class', $this->cplat_con)->select();
	
		var_dump($quesArr);
		var_dump($cplat_openid);die;
		
		$this->display('index');
	}

}

 ?>