<?php
namespace Admin\Controller;
use Think\Controller;
class RankexerController extends Controller {

    public function index(){



    }

    public function updateRank() {


    	$stuList = M('student_info')->field('id', 'openid', 'name', 'number', 'academy', 'class')->select();

    	p($stuList);
    	
    }
}