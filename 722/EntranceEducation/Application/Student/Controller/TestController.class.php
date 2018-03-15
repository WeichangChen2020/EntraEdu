<?php

namespace Student\Controller;
use Think\Controller;
use Think\Model;

/**
 * 统计
 */
class TestController extends Controller{
  
    //获取补考名单
    public function getMakeupList(){
        $STUDENT = D('StudentInfo');
        $openidArr = $STUDENT->where(array('is_newer'=>1))->limit(3600,300)->getField('openId',true);

        $SUBMIT = D('ExamSubmit');
        $QUESTIONBANK = D('Questionbank');
        $MAKEUP = M('makeup_list');

        $info = array();
        foreach ($openidArr as $key => $value) {
            $stuInfo = $STUDENT->getInfo($value);
            // p($stuInfo);
            $stuInfo['score'] = $SUBMIT->getGrade($value);
            $stuInfo['score1'] = $SUBMIT->getGrade1($value);
            $progress = $QUESTIONBANK->getProgress($value);
            // p($stuInfo);
            // $info = array_merge($info,$stuInfo);
            // p($info);die;
            $data = array(
                'name'   => $stuInfo['name'],
                'number' => $stuInfo['number'],
                'academy'=> $stuInfo['academy'],
                'class'  => $stuInfo['class'],
                'score'  => $stuInfo['score'],
                'score1' => $stuInfo['score1'],
            );
            // if(M('makeup_list')->add($data)){
            //     echo $stuInfo['name'].'插入成功!<br/>';
            // }
            $data2 = array(
                'right_num' => $progress['sumNum'],
                'answer_num' => $progress['count'],
            );
            if($MAKEUP->where(array('number'=>$stuInfo['number']))->save($data2)){
                echo $stuInfo['name'].'答对题数更新为:'.$progress['sumNum'].'题<br/>';
            }else{
                echo $stuInfo['name'].'答对题数更新失败！<br/>';
            }
        }
        // p($info);
    }

    public function updateAcademy(){
        $STUDENT = D('StudentInfo');
        $exercise_rank = M('exercise_rank');
        $repe = $STUDENT->where(array('academy'=>'重复注册'))->select();
        // p($repe);
        foreach ($repe as $key => $value) {
            $map['openId']  = array('EQ',$value['openId']);
            $map['academy']  = array('NEQ','重复注册');
            if($record = $exercise_rank->where($map)->find()){
                //p($record);
                $data = array(
                    'academy' => '重复注册',
                    'class'   => '',
                );
                if($exercise_rank->where(array('openId'=>$value['openId']))->save($data)){
                    echo $value['name'].'学院更新为重复注册<br/>';
                }else{
                    echo $value['name'].'学院更新失败<br/>';
                }
            }
        }
    }

    public function exerciseTime(){//统计题目的被收藏次数
        $EXERCISE = D('Exercise');
        $STATISTIC = M('statistics');

        for($i=1;$i<=1457;$i++){
            
            $exercise_time = $EXERCISE->where(array('quesid'=>$i))->count();
            $data = array(
                'quesid' => $i,
                'exercise_time' => $exercise_time,
            );
            p($data);die;
        }
    }    
}