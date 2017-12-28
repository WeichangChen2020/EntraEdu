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

            $homework[$key]['isSubmit']  = $this->isSubmit($openId,$homework[$key]['homeworkname']);
            $homework[$key]['submit'] = $this->getSubmitNum($homework[$key]['homeworkname']);
        }
        // var_dump($homework);die();
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('homework',$homework)->display();
    }

    private function isSubmit($openId,$homeworkname){
        $submitInfo = M('student_homework')->where(array('openId' => $openId,'homeworkname' => $homeworkname))->select();
        // var_dump($submitInfo);die();
        if(empty($submitInfo))
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

    //提交人数,最好写在model里
    private function getSubmitNum($homeworkname){
        $number = M('student_homework')->group('name')->where(array('homeworkname' => $homeworkname))->select();
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

        $state  = $this->isSubmit($openId,$homeworkname);
        $number = $this->getSubmitNum($homeworkname);


        $this->assign('state',$state);
        $this->assign('homeworkname',$homeworkname);
        $this->assign('number',$number)->display();
    }

    //上传图片页面
    public function homework(){

        $openId       = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $homeworkname   = session('?homeworkname') ? session('homeworkname') : $this->error('请重新获取改页面');
        // var_dump($homeworkname);die();
        /*======================判断不可重复提交===================================*/
        $cond = array('homeworkname' => $homeworkname,'openId' => $openId);
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

    public function upload(){

        /*=====================实例化类============================*/
        $weixin       =  new WeichatController();   //示例化Weichat类，获取token
        $saes         =  new \SaeStorage();        //创建SaeStorage对象
        $STU          = D('StudentInfo');
        $HOMEWORK     = M('student_homework');

        /*=====================定义初始变量====================*/
        $openId       = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $homeworkname   = session('?homeworkname') ? session('homeworkname') : $this->error('请重新获取改页面');
        // $homeworkname   = I('homeworkname');
        $cond         = array('openId' => $openId);
        $stuInfo      = $STU->where($cond)->find();
        $picIdArray   = I('id');
        $ACCESS_TOKEN = $weixin->getAccessToken();
        $domain       = 'public';
        // $dir          = './homework/homework'.session('homeworkname').'/'; 
        $dir          = './homework/homework'.'1'.'/';


        $filenameFix  = mt_rand(10000000,99999999).$homeworkname.'_';//  图片命名前缀：网络1401班李俊君1400150108.jpg;


        /*======================构造数据上传数组===================================*/
        $homeworkInfo = array(
            'openId'  => $openId,
            'name'    => $stuInfo['name'],
            'number'  => $stuInfo['number'],
            'class'   => $stuInfo['class'],
            'homeworkname' => $homeworkname,
            'correcter' => '未批改',
            'time'    => date('Y-m-d H:i:s',time()),
            );

        $picUrl   = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$ACCESS_TOKEN.'&media_id='.$picIdArray[0];
        // p($picUrl);
        $this->ajaxReturn($picUrl);

        /*======================循环写入Storage===================================*/
        foreach ($picIdArray as $key => $value) {
            $picUrl   = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$ACCESS_TOKEN.'&media_id='.$picIdArray[$key];
            
            $filename = $filenameFix.($key+1).'.jpg';//设置保存在domain中的文件名
            $ch       = curl_init($picUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; //curl_exec执行成功则返回执行结果
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; //在启用CURLOPT_RETURNTRANSFER的时候，返回原生的（Raw）输出。
            $output   = curl_exec($ch) ;
            curl_close($ch);
            $url = $saes->write( $domain , $dir.$filename , $output );//将数据写入到Storage domain并返回存储在domain中此文件的url
            $stuInfoArrayKey = 'pic'.($key+1).'Url';
            $homeworkInfo[$stuInfoArrayKey] = $dir.$filename;
        }

        /*======================存入数据库==========================================*/
        $HOMEWORK->add($homeworkInfo);
    }

    public function homeworkmark()
    {
        /*======================在别人表中标记是自己批改的===========================*/
        $homeworkname             = session('homeworkname');
        $me = M('student_info')->where(array('openId'=>session('openId')))->find();
        // var_dump($me);
        // die();
        $myname = $me['name'];
        // var_dump(session('openId'));die();
        // var_dump($homeworkname);die();
        $condi['homeworkname']    = $homeworkname;
        $condi['openId']        = array('NEQ',session('openId'));
        $condi['correcter']     = array('EQ','未批改');
        $condi['mark']          = "no";
        $strange = M('student_homework')->group('name')->where($condi)->select();
        // var_dump($strange);die();
        $others = $strange[rand(0,sizeof($strange)-1)];
        $map['correcter'] = $myname;
        $map['correctTime'] = date('Y-m-d H:i:s',time());
        M('student_homework')->where(array('openId'=>$others['openId']))->save($map);
        /*======================查找别人此时的所有作业===========================*/
        $cond2['homeworkname']    = $homeworkname;
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
        // var_dump($right_answer);die();





        /*======================映射到模板===========================*/
        // echo "<pre>";
        // var_dump($problem);
        // echo "<pre>";
        // var_dump($right_answer);
        // die();
        
        

        for ($key=0; $key < sizeof($problem); $key++) { 
           $problem[$key]['right_answer'] = $right_answer[$key]['right_answer'];
        }


        var_dump($problem);

        $this->assign('problem',$problem);//别人的作业+正确答案url
  



        $this->assign('me',$me);
        $this->assign('homeworkname',$homeworkname);

        return $this->display();
    }

    public function homework_mark(){
        $STU_HOMEWORK = M('student_homework');

        $openId       =  session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        
        $homeworkname     = I('personWorkId');
        $mark           = I('mark');
        $personId       = I('personId');
        // $person  = $STU_HOMEWORK->where(array('openId' => $personId))->find();

        $correctInfo = array(
            'mark'        => $mark,

            'correctTime' => date('Y-m-d H:i:s',time()));
        $res = $STU_HOMEWORK->where(array('id' => $personWorkId,'openId' => $personId))->save($correctInfo);

        
    }
}

