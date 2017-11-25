<?php
namespace Admin\Controller;
use Think\Controller;
class RankController extends Controller {

    public function index(){



    }

    public function updateRank() {


    	$stuList = M('student_info')->field('id', 'openId', 'name', 'number', 'academy', 'class')->select();

    	p($stuList);
    	
    }
}