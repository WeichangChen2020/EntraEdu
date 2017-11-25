<?php
namespace Admin\Controller;
use Think\Controller;
class RankController extends Controller {

    public function index(){



    }

    public function updateRank() {


    	$stuList = M('student_info')->field('id, openId, name, number, academy, class')->limit(600)->select();

    	p($stuList);

    	// foreach ($stuList as &$value) {

    	// 	$value['answer_num'] = M('exercise')->where(array('openid'=>$value['openId']))->count();
    	// 	$value['right_num'] = M('exercise')->where(array('openid'=>$value['openId'], 'result'=>1))->count();

    	// 	p($value);
    	// }
    	

    }
}