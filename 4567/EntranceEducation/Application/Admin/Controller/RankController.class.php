<?php
namespace Admin\Controller;
use Think\Controller;
class RankController extends Controller {

    public function index(){

       

    }

    public function updateRank($p) {

    	$stuList = M('student_info')->field('id, openId, name, number, academy, class')->limit(700)->page($p)->select();

    	foreach ($stuList as &$value) {
            if (!empty($value)) {
                $value['answer_num'] = M('exercise')->where(array('openid'=>$value['openId']))->count();
                $value['right_num'] = M('exercise')->where(array('openid'=>$value['openId'], 'result'=>1))->count();

                if (M('exercise_rank')->find($value['id'])) {
                    M('exercise_rank')->save($value);   
                } else {
                    M('exercise_rank')->add($value);   
                }
            }
    	}
    	

    }
}