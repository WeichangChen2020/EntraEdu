<?php
// +----------------------------------------------------------------------
// | 计算机网络教学互动平台
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://23.testet.sinaapp.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: lijj <hello_lijj@qq.com>
// +----------------------------------------------------------------------
// | Time: 2016-07-16  19:34
// +----------------------------------------------------------------------
namespace Student\Controller;
use Think\Controller;
use Think\Model;
use Think\Upload;   
use Com\WechatAuth;   



/**
 * 课后作业类
 */

class HomeworkController extends Controller{


    public function index(){
        //+++++++++++++++++++处理访问界面的openId
        $openId = session("openId");
        if(!$openId){
            $openId = I('openId');
            session('openId',$openId);
        } 
        // var_dump($openId);echo "<br>";
        $studentInfo = M('student_info');
        $stuclass    = $studentInfo->where("openId='$openId'")->find();
        // var_dump($stuclass);echo "<br>";

        $HOMEWORK = M('homework_zg');
        $count    = $HOMEWORK->count();

     

        $Page       = new \Think\Page($count,$count);
        $show       = $Page->show();
        $con['class']  =  $stuclass['class'];
        $allnum = M('StudentInfo')->where(array('class'=>$stuclass['class']))->count();
        $homework = $HOMEWORK->where($con)->order('create_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        // var_dump($homework);die();
        

        //+++++++++++++++++++把是否提交和访问人数也加到数组里
        foreach ($homework as $key => $value) {

            $homework[$key]['isSubmit']  = $this->isSubmit($openId,$homework[$key]['homeworkname'],$homework[$key]['id']);
            $homework[$key]['submit']    = $this->getSubmitNum($homework[$key]['homeworkname'],$homework[$key]['id']);
            if (strtotime($homework[$key]['dead_time']) > strtotime(date("Y-m-d H:i:s"))) {
                  $homework[$key]['status'] = 1;
                  // var_dump($homework[$key]);die();
            } else {
                  $homework[$key]['status'] = 0;
                  // var_dump($homework[$key]['status']);die();
            }
            
                 
        }
        // var_dump($homework);die();
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('allnum',$allnum);
        // var_dump($homework);die();
        $this->assign('homework',$homework)->display();
    }

    private function isSubmit($openId,$homeworkname,$id){
        $submitInfo = M('student_homework')->where(array('openId' => $openId,'homeworkname' => $homeworkname,'homeworkoid' => $id))->select();

        // var_dump($openId);
        // var_dump($homeworkname);
        // var_dump($id);
        // var_dump($submitInfo);die();
        if(empty($submitInfo)){
            return '未提交';
        }
        $donumber = sizeof($submitInfo);

        $submitInfo2 = M('homework_zg')->where(array('homeworkname' => $homeworkname,'id' => $id))->find();
        $putnumber =sizeof(explode('_', $submitInfo2['problem_id']))-1;
        // var_dump($homeworkname);
        // var_dump($id);
        // var_dump($donumber);
        // var_dump($putnumber);

        // if($donumber < $putnumber)
        // {
        //     // var_dump('未提交');
        //     // die();
        //     return '未提交';
        // }
        // var_dump('已提交');
        // die();
        $mark = 0;
        foreach ($submitInfo as $key => $value) {
            if($value['correcter'] == '未批改' || $value['mark'] == 'no')
            {
                
                return '未批改';
            }

            $mark += $value['mark'];
        }

            return $mark;
    }
    private function isMark($name,$homeworkname,$id){
        $markInfo = M('student_homework')->where(array('correcter' => $name,'homeworkname' => $homeworkname,'homeworkoid'=>$id))->select();
        // var_dump($submitInfo);die();
        if(empty($markInfo))
        {
            return '未批改';
        }
        
        foreach ($markInfo as $key => $value) {
            if($value['mark'] == 'no')
                return '未批改';
        }
            return '已批改';
    }

    //提交人数,最好写在model里
    private function getSubmitNum($homeworkname,$id){
        $number = M('student_homework')->group('name')->where(array('homeworkname' => $homeworkname ,'homeworkoid' => $id))->select();
        // var_dump($number);
        // echo "<pre>";
        // var_dump(sizeof($number));die();
        return sizeof($number);
    }

    //点击作业后的菜单界面
    public function homeworkMenu(){
        $openId       = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $homeworkname = I('homeworkname')?I('homeworkname'):$this->error('你访问的界面不存在');
        session('homeworkname',null);
        session('homeworkname',$homeworkname);

        
        // var_dump(session('homeworkname'));die();

        $status = I('get.status');
        $mark   = I('get.mark');
        // var_dump($mark);die();
        $id     = I('get.id');
        session('homeworkoid',null);
        session('homeworkoid',$id);
        $id = session('homeworkoid');
        $HOMEWORK = M('homework_zg');
        // var_dump($id);die();
        $time = $HOMEWORK->where(array('id'=>$id))->getField("hpdead_time");
        $now = date();
        $time = strtotime($time);
        if ($time>$now) {
            $hp = 1;
        }else{
            $hp = 0;
        }

        $cond2 = array('homeworkname' => $homeworkname,'id'=>$id);

        $homework     = $HOMEWORK->where($cond2)->find();

        $model = D('StudentInfo');
        $myname = $model->getName($openId);
// var_dump($myname);die();
        $state  = $this->isSubmit($openId,$homeworkname,$id);
        $number = $this->getSubmitNum($homeworkname,$id);
        $state2 = $this->isMark($myname,$homeworkname,$id);
        
        $this->assign('state',$state);
        $this->assign('status',$status);
        $this->assign('mark',$mark);
        $this->assign('state2',$state2);
        $this->assign('homework',$homework);
        $this->assign('hp',$hp);
        $homeworkoid = $id;
        // var_dump($state);
        // var_dump($state2);die();
        // var_dump($homeworkname);
        // var_dump($number);
        // die();
        $this->assign('homeworkoid',$homeworkoid);
        $this->assign('openId',$openId);
        $this->assign('homeworkname',$homeworkname);
        $this->assign('number',$number)->display();
    }

    //上传图片页面
    public function homework(){
        $status = I('get.status');
        $mark   = I('get.mark');
        $bj     = I('get.bj');
        if ($status == 0 && $mark == '未提交') {
            $this->error('已过提交时间，等死吧',U('index'));
        }




        $openId       = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $homeworkname   = session('?homeworkname') ? session('homeworkname') : $this->error('请重新获取改页面');
        $homeworkoid = session('homeworkoid');
        // var_dump($homeworkname);die();
        /*======================判断不可重复提交===================================*/
        $cond = array('homeworkname' => $homeworkname,'openId' => $openId,'homeworkoid'=>$homeworkoid);
        if(M('student_homework')->where($cond)->find())
            $this->error('你已经提交过了，不可重复提交');
        $HOMEWORK     = M('homework_zg');
        $questionbank = M('image_questionbank');
        // var_dump(session('homeworkoid'));die();

        $cond2 = array('homeworkname' => $homeworkname,'id'=>$homeworkoid);

        $homework     = $HOMEWORK->where($cond2)->find();//找到第几次布置的什么日期的作业
        // var_dump($homework);die();
        $quesarr      = explode('_', $homework['problem_id']);
        // var_dump($quesarr);die();
        $outproblem   = array();
        foreach ($quesarr as $value) {
            if (!empty($value)) {
                $qu = $questionbank->find($value);

                array_push($outproblem, $qu['contents']);
                // var_dump($outproblem);die();
            }
        }
        // var_dump($outproblem);die();
        $this->assign('outproblem',$outproblem);//输出N和题目的url
        // var_dump($outproblem);die();
        
        session('quesarr',$quesarr);
        if ($bj == 1) {
            $this->assign('bj',1);
        }else
        {
            $this->assign('bj',0);
        }
        // var_dump($outproblem);die();
        $this->assign('homework',$homework)->display();
    }

    public function homeworkmark()
    {
        /*======================在别人表中标记是自己批改的===========================*/
      
        $id = I('get.id');
        // var_dump($id);die();
        session('homeworkoid',null);
        session('homeworkoid',$id);
        // var_dump($state);die();
        $homeworkname             = session('homeworkname');
        $me = M('student_info')->where(array('openId'=>session('openId')))->find();
        // var_dump($me);
        // die();
        $myname = $me['name'];
        // var_dump(session('openId'));die();
        // var_dump($homeworkname);die();
        $condi['homeworkname']    = $homeworkname;
        $condi['homeworkoid']    = $id;

        $condi['openId']        = array('NEQ',session('openId'));
        // $condi['correcter']     = array('EQ','未批改');
        $condi['mark']          = "no";
        $strange = M('student_homework')->group('name')->where($condi)->select();
        // var_dump($strange);die();
        $others = $strange[rand(0,sizeof($strange)-1)];
        $map['correcter'] = $myname;

        $map['correctTime'] = date('Y-m-d H:i:s',time());
        M('student_homework')->where(array('openId'=>$others['openId'],'homeworkoid'=>$id))->save($map);
        /*======================查找别人此时的所有作业===========================*/
        $cond2['homeworkname']    = $homeworkname;
        $cond2['homeworkoid']    = $id;
        $cond2['openId']        = $others['openId'];
        $cond2['correcter']     = array('EQ',$myname);
        $cond2['mark']          = "no";
        $problem = M('student_homework')->where($cond2)->select();
        // var_dump($problem);die();
        /*======================获取正确答案=====================================*/
        $homework_zg            =          M('homework_zg');
        $image_questionbank     =          M('image_questionbank');
        $problem_id             =          $homework_zg->where(array('homeworkname' => $homeworkname,'id'=>$id))->find();
        $problemarr             =          explode('_',$problem_id['problem_id']);
        $problemarr2            =          array();
        $right_answer           =          array();
        foreach ($problemarr as $key => $value) {
            if ($value == '') {
                continue;
            }else{
                array_push($problemarr2, $value);
            }
        }

        foreach ($problemarr2 as $key => $value) {
            $answer = $image_questionbank->where(array('id' => $value))->find();
            array_push($right_answer,$answer);
        }


        for ($key=0; $key < sizeof($problem); $key++) { 
           $problem[$key]['right_answer'] = $right_answer[$key]['right_answer'];
        }


        // var_dump($problem);s

        $this->assign('problem',$problem);//别人的作业+正确答案url
        $this->assign('size',sizeof($problem));

        $this->assign('me',$me);
        $this->assign('homeworkname',$homeworkname);

        // var_dump($problem);die();
        return $this->display();
    }

    public function homework_mark(){
        $STU_HOMEWORK = M('student_homework');

        $openId       =  session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $id = session('homeworkoid');
        $homeworkname     = I('personWorkId');
        $mark           = I('mark');
        $personId       = I('personId');
        // $person  = $STU_HOMEWORK->where(array('openId' => $personId))->find();

        $correctInfo = array(
            'mark'        => $mark,

            'correctTime' => date('Y-m-d H:i:s',time()));
        $res = $STU_HOMEWORK->where(array('id' => $personWorkId,'openId' => $personId,'homeworkoid'=>$id))->save($correctInfo);

        
    }
    public function mark_score(){
        $data = I('post.');
        $id = session('homeworkoid');
        $homeworkid = $data['homeworkid'];
        $score = $data['score'];
        $model = D('student_homework');
        $res = $model->give_score($homeworkid,$score,$id);
        if ($res) {
            $this->ajaxReturn(true);
        } else {
            $this->ajaxReturn(false);
        }
    
    }
    public function homeworkview()
    {
        $homeworkname = I('get.homework');

        $openId = session('openId');
        $id = session('homeworkoid');
        // var_dump($id);die();
        $homework_zg = M('homework_zg')->where("id='$id'")->getField('problem_id');
        // var_dump($homework_zg);die();
        $quesarr      = explode('_', $homework_zg);
        // var_dump($quesarr);

        $questionbank = M('image_questionbank');
        //应该有的提交url
        $outproblem   = array();
        foreach ($quesarr as $value) {
            if (!empty($value)) {
                $qu = $questionbank->find($value);
                array_push($outproblem, $qu['right_answer']);
                
            }
        }
        // var_dump($outproblem);
        $model = M('student_homework');
        $homework = $model->where(array('homeworkname' => $homeworkname, 'openId' => $openId,'homeworkoid'=>$id))->select();

        $right = M('image_questionbank');
        //同学提交的数目

        $do = array();
        foreach ($homework as $key => $value) {
            $problem = $right->where(array('id'=>$value['problemid']))->find();
            $homework[$key]['right_answer'] = $problem['right_answer'];
            array_push($do, $problem['right_answer']);
        }
        //本次作业应有的数目
        $outproblem  = array_diff($outproblem,$do);

        if (empty($outproblem)) {
            $this->assign('flag',0);
        }else{
            $this->assign('flag',1);
        }
        $this->assign('homework',$homework);
        $this->assign('homeworkname',$homeworkname);
        $this->assign('outproblem',$outproblem);


        return $this->display();







        
        
        
        

        $this->assign('homework',$homework)->display();

    }

    public function complain()
    {
        
        $homeworkoid = I('get.homeworkoid');
        $openId = I('get.openId');
        $model = M('student_homework');
        $homework = $model->where(array('homeworkoid'=>$homeworkoid,'openId'=>$openId))->select();

        foreach ($homework as $key => $value) {
            $data['complain'] = 1;
            $model->where(array('homeworkoid'=>$homeworkoid,'openId'=>$openId))->save($data);
        }

        $this->redirect('index');
    }
}

