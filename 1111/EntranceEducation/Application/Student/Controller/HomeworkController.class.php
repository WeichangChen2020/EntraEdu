<?php
// +----------------------------------------------------------------------
// | 大学物理教学互动平台
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

class HomeworkController extends Controller{

    public function index(){
        //+++++++++++++++++++处理访问界面的openId
        $openId = session("openId");
        if(!$openId){
            $openId = I('openId');
            session('openId',$openId);//将用户的$openid存入session中
        } 
        $STUDENT = M('student_info');
        $stuclass    = $STUDENT->where("openId='$openId'")->find();

        $HOMEWORK = M('homework_zg');

        $where['class'] = array('like','%'.$stuclass['class'].'%');
        $homework = $HOMEWORK->where($where)->order('create_time desc')->select();        

        //+++++++++++++++++++把是否提交和人数也加到数组里
        foreach ($homework as $key => $value) {
            $homework[$key]['isSubmit']  = $this->isSubmit($openId,$homework[$key]['homeworkname'],$homework[$key]['id']);
            $homework[$key]['submit']    = $this->getSubmitNum($homework[$key]['homeworkname'],$homework[$key]['id']);
            $count = 0;
            $count += $STUDENT->where(array('class'=>$value['class']))->count();
            $homework[$key]['count']    = $count;
            //已过提交截止时间status为0
            if (strtotime($homework[$key]['dead_time']) > strtotime(date("Y-m-d H:i:s"))) {
                  $homework[$key]['status'] = 1;
            } else {
                  $homework[$key]['status'] = 0;
            }
        }
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('allnum',$allnum);
        // dump($homework);die();
        $this->assign('homework',$homework)->display();
    }

    private function isSubmit($openId,$homeworkname,$id){
        $submitInfo = M('student_homework')->where(array('openId' => $openId,'homeworkname' => $homeworkname,'homeworkoid' => $id))->select();
        if(empty($submitInfo)){
            return '未提交';
        }
        $donumber = sizeof($submitInfo);

        $submitInfo2 = M('homework_zg')->where(array('homeworkname' => $homeworkname,'id' => $id))->find();
        $putnumber =sizeof(explode('_', $submitInfo2['problem_id']))-1;
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
    //你还说！TM写的真乱，看得我头痛死了
    private function getSubmitNum($homeworkname,$id){
        $number = M('student_homework')->group('name')->where(array('homeworkname' => $homeworkname ,'homeworkoid' => $id))->select();
        // dump($number);
        // echo "<pre>";
        // dump(sizeof($number));die();
        return sizeof($number);
    }

    //点击作业后的菜单界面
    public function homeworkMenu(){
        $openId       = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $homeworkname = I('homeworkname')?I('homeworkname'):$this->error('你访问的界面不存在');
        session('homeworkname',$homeworkname);
        
        $SUBMIT = D('studentHomework');
        $status = I('get.status');
        $mark   = I('get.mark');
        $id     = I('get.id');
        session('homeworkoid',$id);
        $id = session('homeworkoid');
        $HOMEWORK = M('homework_zg');
        $hpStop = $HOMEWORK->where(array('id'=>$id))->getField("hpdead_time");
        $submitStop = $HOMEWORK->where(array('id'=>$id))->getField("dead_time");
        $now = time();
        $hpStop = strtotime($hpStop);
        $submitStop = strtotime($submitStop);

        // ---------$submitStop--------$hpStop--------
        //   $hp=2               $hp=1         $hp=0
        if ($now < $submitStop) {
            $hp = 2;
        }else if ($now < $hpStop) {
            $hp = 1;
        }else{
            $hp = 0;
        }

        $cond2 = array('homeworkname' => $homeworkname,'id'=>$id);

        $homework     = $HOMEWORK->where($cond2)->find();
        $whetherSubmit = M('student_homework')->where(array(
            'openId' => $openId,
            'homeworkoid'=> session('homeworkoid')
        ))->find();
        $model = D('StudentInfo');
        $myname = $model->getName($openId);
        $state  = $this->isSubmit($openId,$homeworkname,$id);
        $number = $this->getSubmitNum($homeworkname,$id);
        $complain = $SUBMIT->getComplainState($openId,$homeworkname);
        $homeworkoid = $id;
        $corrected = $SUBMIT->where(array('correcter'=>$myname,'homeworkoid'=>$id))->find();
        // dump($SUBMIT->getLastSql());
        // dump($complain);die;
        $this->assign('whetherSubmit',!empty($whetherSubmit) ? 'true' : 'false');
        $this->assign('corrected',!empty($corrected) ? '1' : '0');
        $this->assign('state',$state);
        $this->assign('status',$status);
        $this->assign('mark',$mark);
        $this->assign('complain',$complain);
        $this->assign('homework',$homework);
        $this->assign('hp',$hp);
        $this->assign('homeworkoid',$homeworkoid);
        $this->assign('openId',$openId);
        $this->assign('homeworkname',$homeworkname);
        $this->assign('number',$number)->display();
    }

    //上传图片页面
    public function homework(){
        $status = I('get.status');
        $mark   = I('get.mark');
        $bj     = I('get.bj');//补交
        if ($status == 0 && $mark == '未提交') {
            $this->error('已过提交时间',U('index'));
        }
        $openId       = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $homeworkname   = session('?homeworkname') ? session('homeworkname') : $this->error('请重新获取改页面');
        $homeworkoid = session('homeworkoid');
        /*======================判断不可重复提交===================================*/
        $cond = array('openId' => $openId,'homeworkoid'=>$homeworkoid);
        if(M('student_homework')->where($cond)->find()){
            M('student_homework')->where($cond)->delete();
        }
        $HOMEWORK     = M('homework_zg');
        $QUESTIONBANK = M('image_questionbank');
        // dump(session('homeworkoid'));die();

        $cond2 = array('homeworkname' => $homeworkname,'id'=>$homeworkoid);

        $homework     = $HOMEWORK->where($cond2)->find();
        // dump($homework);die();
        $quesarr      = explode('_', $homework['problem_id']);
        // dump($quesarr);die();
        $outproblem   = array();
        foreach ($quesarr as $value) {
            if (!empty($value)) {
                $qu = $QUESTIONBANK->find($value);
                array_push($outproblem, C('COMMONPATH').C('HOMEWORKPATH').$qu['chapter'].'_'.$qu['type'].'_1_'.$qu['id'].'.jpg');
                // dump($outproblem);die();
            }
        }
        // dump($outproblem);die();
        $this->assign('outproblem',$outproblem);//输出N和题目的url
        
        session('quesarr',$quesarr);
        if ($status == 0) {
            $this->assign('bj',1);
        }else
        {
            $this->assign('bj',0);
        }
        $this->assign('homework',$homework)->display();
    }

    public function homeworkmark()
    {
        /*======================在别人表中标记是自己批改的===========================*/
        $id = I('get.id');
        session('homeworkoid',null);
        session('homeworkoid',$id);
        $homeworkname             = session('homeworkname');
        $me = M('student_info')->where(array('openId'=>session('openId')))->find();
        $myname = $me['name'];
        $condi['homeworkoid']    = $id;

        $condi['openId']        = array('NEQ',session('openId'));
        $condi['mark']          = "no";
        $strange = M('student_homework')->group('name')->where($condi)->select();
        $others = $strange[rand(0,sizeof($strange)-1)];
        $map['correcter'] = $myname;

        $map['correctTime'] = date('Y-m-d H:i:s',time());
        // M('student_homework')->where(array('openId'=>$others['openId'],'homeworkoid'=>$id))->save($map);
        /*======================查找别人此时的所有作业===========================*/
        $cond2['homeworkoid']    = $id;
        $cond2['openId']        = $others['openId'];
        $cond2['mark']          = "no";
        $problem = M('student_homework')->where($cond2)->select();
        // dump($problem);die();
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

        foreach ($problem as $k => $v) {
            $temp = $image_questionbank->where(array('id'=>$v['problemid']))->find();
            $right_answer = C('COMMONPATH').C('HOMEWORKPATH').$temp['chapter'].'_'.$temp['type'].'_0_'.$temp['id'].'.jpg';
            $problem[$k]['right_answer'] = $right_answer;
        }
            // dump($problem);die;
        $this->assign('problem',$problem);//别人的作业+正确答案url
        $this->assign('size',sizeof($problem));

        $this->assign('me',$me);
        $this->assign('homeworkname',$homeworkname);
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
            'correctTime' => date('Y-m-d H:i:s',time())
        );
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
        $homework_zg = M('homework_zg')->where("id='$id'")->getField('problem_id');
        $submitStop = strtotime(M('homework_zg')->where("id='$id'")->getField('dead_time'));
        $quesarr      = explode('_', $homework_zg);
        $SUBMIT = M('studentHomework');
        $flag = 0;

        if ($submitStop > time()) {
            $end = 0;
        }else{
            $end = 1;
        }

        $QUESTIONBANK = M('image_questionbank');
        $quesInfo = array();
        foreach ($quesarr as $key => $value) {
            if (!empty($value)) {
                array_push($quesInfo, $QUESTIONBANK->where(array('id'=>$value))->field('id,chapter,type')->find());
            }
        }
        foreach ($quesInfo as $key => $value) {
            $submit = $SUBMIT
                ->where(array(
                    'homeworkname' => $homeworkname,
                    'openId' => $openId,
                    'homeworkoid'=>$id,
                    'problemid'=>$value['id']))
                ->field('imgurl,mark')
                ->find();
            if ($submit == NULL) {
                $flag = 1;
            }
            $quesInfo[$key]['right_answer']   = C('COMMONPATH').C('HOMEWORKPATH').$value['chapter'].'_'.$value['type'].'_0_'.$value['id'].'.jpg';
            $quesInfo[$key]['question']   = C('COMMONPATH').C('HOMEWORKPATH').$value['chapter'].'_'.$value['type'].'_1_'.$value['id'].'.jpg';
            $quesInfo[$key]['submit'] = $submit;
        }
        $this->assign('flag',$flag);
        $this->assign('end',$end);
        $this->assign('quesInfo',$quesInfo);
        $this->assign('homeworkname',$homeworkname);
        $this->display();

    }

    public function complain()
    {
        $homeworkoid = I('get.homeworkoid');
        $openId = I('get.openId');
        $model = M('student_homework');
        $homework = $model->where(array('homeworkoid'=>$homeworkoid,'openId'=>$openId,'mark'=>array('NEQ','no')))->select();

        foreach ($homework as $key => $value) {
            $data['complain'] = 1;
            $model->where($value)->save($data);
        }
        $this->redirect('index');
    }
    public function test(){
        $homeworkname = I('get.homework');

        $openId = session('openId');
        $id = session('homeworkoid');
        $homework_zg = M('homework_zg')->where("id='$id'")->getField('problem_id');
        $submitStop = strtotime(M('homework_zg')->where("id='$id'")->getField('dead_time'));
        $quesarr      = explode('_', $homework_zg);
        $SUBMIT = M('studentHomework');
        $flag = 0;

        if ($submitStop > time()) {
            $end = 0;
        }else{
            $end = 1;
        }

        $QUESTIONBANK = M('image_questionbank');
        $quesInfo = array();
        foreach ($quesarr as $key => $value) {
            if (!empty($value)) {
                array_push($quesInfo, $QUESTIONBANK->where(array('id'=>$value))->field('id,chapter,type')->find());
            }
        }
        foreach ($quesInfo as $key => $value) {
            $submit = $SUBMIT
                ->where(array(
                    'homeworkname' => $homeworkname,
                    'openId' => $openId,
                    'homeworkoid'=>$id,
                    'problemid'=>$value['id']))
                ->field('imgurl,mark')
                ->find();
            if ($submit == NULL) {
                $flag = 1;
            }
            $quesInfo[$key]['right_answer']   = C('COMMONPATH').C('HOMEWORKPATH').$value['chapter'].'_'.$value['type'].'_0_'.$value['id'].'.jpg';
            $quesInfo[$key]['question']   = C('COMMONPATH').C('HOMEWORKPATH').$value['chapter'].'_'.$value['type'].'_1_'.$value['id'].'.jpg';
            $quesInfo[$key]['submit'] = $submit;
        }
        $this->assign('flag',$flag);
        $this->assign('end',$end);
        $this->assign('quesInfo',$quesInfo);
        dump($quesInfo);die;
        $this->assign('homeworkname',$homeworkname);
        $this->display('homeworkview');

    }

    public function correctTime(){
        $INFO = M('student_info');
        $HOMEWORK = M('student_homework');
        // $where['class']  = array('EQ', '环境类1701、1702');
        // $where['class']  = array('EQ', '环境类1703、1704');
        // $where['class']  = array('EQ', '环境类1705、1706');
        // $where['_logic'] = 'or';
        // $map['_complex'] = $where;
        $map['academy'] = array('EQ', '马海珠');
        $student_info = $INFO->where($map)->select();
        // p($student_info);
        foreach ($student_info as $key => $value) {
            $number = $value['number'];
            $name = $value['name'];
            $correct_time = $HOMEWORK->where(array('correcter'=>$name))->count();
            echo $name."：".$number."：".$correct_time."<br/>";
        }
        // $HOMEWORK->
    }
}

