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
        $homework = $HOMEWORK->where($con)->order('create_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        // var_dump($homework);die();
        

        //+++++++++++++++++++把是否提交和访问人数也加到数组里
        foreach ($homework as $key => $value) {

            $homework[$key]['isSubmit']  = $this->isSubmit($openId,$homework[$key]['homeworkname'],$homework[$key]['id']);
            $homework[$key]['submit']    = $this->getSubmitNum($homework[$key]['homeworkname']);
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

        // var_dump($homework);die();
        $this->assign('homework',$homework)->display();



    }

    private function isSubmit($openId,$homeworkname,$id){
        $submitInfo = M('student_homework')->where(array('openId' => $openId,'homeworkname' => $homeworkname,'homeworkoid' => $id))->select();
        // var_dump($openId);
        // var_dump($homeworkname);
        // var_dump($id);
        // var_dump($submitInfo);die();
        $donumber = sizeof($submitInfo);
        
        $submitInfo2 = M('homework_zg')->where(array('homeworkname' => $homeworkname,'id' => $id))->find();
        $putnumber =sizeof(explode('_', $submitInfo2['problem_id']))-1;

        if($donumber < $putnumber)
        {
            return '未提交';
        }
        $mark = 0;
        foreach ($submitInfo as $key => $value) {
            if($value['correcter'] == '未批改')
                return '未批改';
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
        $id     = I('get.id');
        if ($status == 0 && $mark == '未提交') {
            $this->error('已过提交时间，等死吧',U('index'));
        }
        $model = D('StudentInfo');
        $myname = $model->getName($openId);
// var_dump($myname);die();
        $state  = $this->isSubmit($openId,$homeworkname,$id);
        $number = $this->getSubmitNum($homeworkname,$id);
        $state2 = $this->isMark($myname,$homeworkname,$id);

        session('homeworkoid',$id);
        $this->assign('state',$state);
        $this->assign('state2',$state2);
        $homeworkoid = $id;
        // var_dump($state);
        // var_dump($state2);
        // var_dump($homeworkname);
        // var_dump($number);
        // die();
        $this->assign('homeworkoid',$homeworkoid);
        $this->assign('homeworkname',$homeworkname);
        $this->assign('number',$number)->display();
    }

    //上传图片页面
    public function homework(){

        $openId       = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $homeworkname   = session('?homeworkname') ? session('homeworkname') : $this->error('请重新获取改页面');
        // var_dump($homeworkname);die();
        /*======================判断不可重复提交===================================*/
        $cond = array('homeworkname' => $homeworkname,'openId' => $openId,'homeworkoid'=>session('homeworkoid'));
        if(M('student_homework')->where($cond)->find())
            $this->error('你已经提交过了，不可重复提交');
        $HOMEWORK     = M('homework_zg');
        $questionbank = M('image_questionbank');
        $homework     = $HOMEWORK->where("homeworkname='$homeworkname'")->find();
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
        -
        session('quesarr',$quesarr);

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
        $map['homeworkoid'] = $id;
        $map['correctTime'] = date('Y-m-d H:i:s',time());
        M('student_homework')->where(array('openId'=>$others['openId']))->save($map);
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
        $problem_id             =          $homework_zg->where(array('homeworkname' => $homeworkname))->find();
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
        // var_dump($homeworkname);
        // echo "<pre>";
        // var_dump($openId);
        // die();
        $model = M('student_homework');
        $homework = $model->where(array('homeworkname' => $homeworkname, 'openId' => $openId,'homeworkoid'=>$id))->select();
        $this->assign('homework',$homework);
        $this->assign('homeworkname',$homeworkname);


        return $this->display();

    }
}

