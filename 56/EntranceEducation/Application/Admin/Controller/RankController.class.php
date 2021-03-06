<?php
namespace Admin\Controller;
use Think\Controller;
class RankController extends Controller {

    public function index(){



    }

    /**
     * 更新 exercise_rank数据表 
     * @author 李俊君<hello_lijj@qq.com>
     * @copyright  2017-11-06 19:48Authors
     * @param $p  ,每次更新 700条记录
     * @return
     * 通过新浪云定时功能，每天凌晨4点 更新 数据库
     */
    public function updateRank($p) {

    	$stuList = M('student_info')->field('id, openId, name, number, academy, class')->limit(70)->page($p)->select();

    	foreach ($stuList as &$value) {
            if (!empty($value)) {
                $value['answer_num'] = M('exercise')->where(array('openid'=>$value['openId']))->count();
                $exercise_rightnum = M('exercise')->where(array('openid'=>$value['openId'], 'result'=>1))->count();
                $rework_rightnum = M('exercise')->where(array('openid'=>$value['openId'], 'result'=>0, 'is_rework'=>1))->count();
                $value['right_num'] = $exercise_rightnum + $rework_rightnum;
                if (M('exercise_rank')->find($value['id'])) {
                    M('exercise_rank')->save($value);   
                } else {
                    M('exercise_rank')->add($value);   
                }
            } else {
                echo "faild";
            } 

    	}
    	

    }
}