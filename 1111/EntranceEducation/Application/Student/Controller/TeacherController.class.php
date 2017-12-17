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
// | Time: 2016-07-17  18:03
// +----------------------------------------------------------------------
namespace Student\Controller;
use Think\Controller;
use Think\Model;

/**
 * 教师类
 */

class TeacherController extends Controller{
    
    public function index(){
        $openId = session("openId");
        if(!$openId){
            $openId = getOpenId();
            session('openId',$openId);
        } 

        $correcNumber = $this->getHomeCorrNum();
        $this->assign('correcNumber',$correcNumber);
        $this->assign('openId',$openId)->display();

    }
    //教师端个人信息
    public function user_index(){
        $this->display();
    }

    //教师端发布课后作业
    public function homework_index(){
        session('openId',null);
        $openId = getOpenId();
        session('openId',$openId);

        $correcNumber = $this->getHomeCorrNum();
        $this->assign('correcNumber',$correcNumber)->display();
    }

    //获取教师端作业待批改量
    private function getHomeCorrNum($homeworkId = 'null'){
        if($homeworkId === 'null'){ //如果$homeworkId 什么都没传递
            $CorrNum = M('student_homework')->where(array('correcter'=>'未批改'))->count();
            return $CorrNum;
        }else{
            $CorrNum = M('student_homework')->where(array('correcter'=>'未批改','homeworkId'=>$homeworkId))->count();
            return $CorrNum;
        }
    }
    //布置作业
    public function homework_assign(){
        $homeworkName = date('m月d日课后作业',time());
        session('homeworkName',$homeworkName);
        $this->assign('homeworkName',$homeworkName)->display();
    }
    

       
            //输出所有章节，里面包含此章节的所有题目
            // $chapternumber = M('homework_zg')->field('chapter')->group('chapter')->count();
           
            
           
            // for ($i=1; $i < $chapternumber+1; $i++) { 
            //     $chapterproblem = M('homework_zg')->where('chapter="$i"')->select();
            // $this->assign('chapterproblem',$chapterproblem);

    public function homework_assign_zg(){
        if (IS_POST) {
            //插入数据库
        } else {
            $homeworkName = session('homeworkName');
            $homeworkkg = M('teacher_homework')->where(array('homeworkName'=>$homeworkName,'type'=>1))->find();
            $this->assign('homeworkzg',$homeworkkg);
            $this->display();
        }
    }
            
          
    
            



            // $homeworkName = session('homeworkName');
            // $homeworkzg = M('teacher_homework')->where(array('homeworkName'=>$homeworkName,'type'=>0))->find();
            // $problems = $homeworkzg['content'];
            // $proarr = explode(',', $problems);

   
    public function homework_assign_kg(){
        if (IS_POST) {
            //插入数据库
        } else {
            // $homeworkName = session('homeworkName');//12月8日作业
            // $homeworkkg = M('homework_kg')->select();
            $chapternumber = M('questionbank')->distinct('chapter')->group('chapter')->select();
            $num = count($chapternumber);
            $this->assign('num',$num);
            $this->display();
        }
    }

    //将上传的作业信息写入数据库
    public function homework_handAssign(){
        if(!IS_AJAX)
            $this->error('你访问的界面不存在');
        $openId   =  session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $HOMEWORK = M('teacher_homework');
        $user     = new UserController();
        $userInfo = $user->getTeacherInfo($openId);
        $name     = $userInfo['name']?$userInfo['name']:'null';

        $homework = array(
            'openId' => $openId, 
            'name' => $name,
            'homeworkName' => trim(I('homeworkName')),
            'content' => I('content'),
            'state' => '开启',
            'deadtime' => I('deadtime'),
            'time' => date('Y-m-d H:i:s',time()),
            );
        
        $HOMEWORK->add($homework);
    }

    //批改作业列表
    public function homework_list_correct(){
        $openId   =  session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $homework = M('teacher_homework')->order('time desc')->select();
        foreach ($homework as $key => $value) {
            $homework[$key]['correcNumber'] = $this->getHomeCorrNum($homework[$key]['id']);
        }
        $this->assign('homework',$homework)->display();
    }

    //批改作业
    public function homework_correct(){
        $STU_HOMEWORK = M('student_homework');
        $weixin       = new WeichatController();
        $signPackage  = $weixin->getJssdkPackage(); 
        $this->assign('signPackage',$signPackage);

        $homeworkId   = I('homeworkId') ? I('homeworkId') : $this->error('你访问的界面不存在');

        $cond         = array('homeworkId' => $homeworkId,'correcter' => '未批改');
        $homeworkList = $STU_HOMEWORK->where($cond)->order('time desc')->select();
        $this->assign('homeworkList',$homeworkList)->display();
    }

    //把教师打的分数添加到数据库
    public function homework_mark(){
        $STU_HOMEWORK = M('student_homework');
        $TEA = M('teacher_info');
        $openId       =  session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $name = $TEA->where(array('openId' => $openId))->getField('name');
        $personWorkId = I('personWorkId');
        $mark = I('mark');

        $correctInfo = array(
            'mark'        => $mark,
            'correcter'   => $name,
            'correctTime' => date('Y-m-d H:i:s',time()));
        $STU_HOMEWORK->where(array('id' => $personWorkId))->save($correctInfo);
    }

    //浏览已批改作业列表
    public function homework_list_view(){
        $openId   =  session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $homework = M('teacher_homework')->order('time desc')->select();

        foreach ($homework as $key => $value) {
            $homework[$key]['ViewNum'] = $this->getHomeViewNum($homework[$key]['id']);
        }
        $this->assign('homework',$homework)->display();
    }

    //获取教师端作业浏览量
    private function getHomeViewNum($homeworkId){
        $cond              = array('homeworkId' => $homeworkId);
        return M('student_homework')->where($cond)->count();
    }

    //批改作业
    public function homework_view(){
        $STU_HOMEWORK = M('student_homework');
        $weixin       = new WeichatController();
        // $signPackage  = $weixin->getJssdkPackage(); 
        // $this->assign('signPackage',$signPackage);

        $homeworkId   = I('homeworkId') ? I('homeworkId') : $this->error('你访问的界面不存在');
        $cond         = array('homeworkId' => $homeworkId);
        // $map['correcter']  = array('NEQ','未批改');  //已批改查询条件
        $homeworkList = $STU_HOMEWORK->where($cond)->select();
        $this->assign('homeworkList',$homeworkList)->display();
    }


    //教师端签到主页面
    public function signin_index(){
        session('openId',null);
        $openId = getOpenId();
        session('openId',$openId);

        $this->display();
    }

    //教师端发布签到页面
    public function signin_assign(){
        $weixin       = new WeichatController();
        $signPackage  = $weixin->getJssdkPackage(); 
        $this->assign('signPackage',$signPackage);
        $this->assign('time',date('m月d日签到',time()))->display();
    }

    // public function test(){
    //     $signin        = array(
    //         'openId'    => 'qyhtesttest',
    //         'name'      => 'qyh',
    //         'signinName'=> '232sdf23sf',
    //         'latitude'  => 'ddd',
    //         'longitude' => 'ddd',
    //         'accuracy'  => 'ddd',
    //         'deadtime'  => date('Y-m-d H:i:s',time()),
    //         'state'     => '开启',
    //         'time'      => date('Y-m-d H:i:s',time())
    //             );
    //         M('teacher_signin')->add($signin);
    //         $this->ajaxReturn('success');
    // }

    //教师端将签到信息存入数据库
    public function signin_add(){
        if(!IS_AJAX)
            $this->error('你访问的界面不存在');
        $openId        =  session('openId') ? session('openId') : $this->error('请重新获取改页面');
        $name          = M('teacher_info')->where(array('openId' => $openId))->getField('name');
        $signin        = array(
            'openId'    => $openId,
            'name'      => $name,
            'signinName'=> trim(I('signinName')),
            'latitude'  => I('latitude'),
            'longitude' => I('longitude'),
            'accuracy'  => I('accuracy'),
            'deadtime'  => I('deadtime'),
            'state'     => '开启',
            'time'      => date('Y-m-d H:i:s',time())
                );
        if(M('teacher_signin')->add($signin))
            $this->ajaxReturn('success');
        else
            $this->ajaxReturn('failure');
    }

    //签到列表
    public function signin_list(){
        $cond['accuracy']  = array('NEQ','');  //精度accurcy，是v3.0版本特加的变量，依次区别是新的版本
        $signinList        = M('teacher_signin')->where($cond)->order('time desc')->select();
        foreach ($signinList as $key => $value) {
            $signinList[$key]['signinNum'] = $this->getSigninNum($signinList[$key]['id']);
        }
        $this->assign('signinList',$signinList)->display();
    }

    private function getSigninNum($signinId){
        return M('student_signin')->where(array('signinId' => $signinId))->count();
    }

    //设置状态关闭，代签
    public function signin_list_set(){
        $signinId = I('signinId') ? I('signinId') : $this->error('你访问的界面不存在');
        session('signinId',null);
        session('signinId',$signinId);
        $state = M('teacher_signin')->where(array('id' => $signinId))->getField('state');
        $signinNum = $this->getSigninNum($signinId);
        $this->assign('signinNum',$signinNum);
        $this->assign('state',$state)->display();
    }

    //已签到名单
    public function signin_view(){
        $signinId      =  session('?signinId') ? session('signinId') : $this->error('请重新获取该页面');
        $signinList    =  M('student_signin')->where(array('signinId' => $signinId))->select();
        $this->assign('signinList',$signinList)->display();
    }

    //未签到列表,未签到名单感觉没有必要做
    public function signin_allograph(){
        $this->display();
    }

    //关闭签到
    public function signin_close(){
        if(!IS_AJAX)
            $this->error('你访问的界面不存在');
        $signinId      =  session('?signinId') ? session('signinId') : $this->error('请重新获取该页面'); 
        if(M('teacher_signin')->where(array('id' => $signinId))->save(array('state' => '关闭')))
            $this->ajaxReturn('success');
        else
            $this->ajaxReturn('failure');
    }


    //教师端随堂测试首页面
    public function test_index(){
        session('openId',null);
        $openId = getOpenId();
        session('openId',$openId);
 
        $this->display();
    }

    //发布测试
    public function test_assign(){
        $quesId = I('quesId');
        if(empty($quesId))
            $this->error('你访问的界面不存在');
        $assignArray['quesId']     = substr($quesId, 1);
        $assignArray['testName']   = date('m月d日随堂测试',time());
        $assignArray['testNumber'] = count(explode('_', substr($quesId, 1)));

        $this->assign('assignArray',$assignArray)->display();
    }

    public function test_add(){
        if(!IS_AJAX)
            $this->error('你访问的界面不存在');
        $openId      =  session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        $quesIdArray = explode('_', I('testQuesId'));
        $user        = new UserController();
        $teaInfo     = $user->getTeacherInfo($openId);
        $QUESBANK = M('questionbank');
        $QUIZBANK = M('teacher_quiz_questionbank');

        // /*===============添加测试记录========================*/
        $quiz = array(
            'openId'   => $openId,
            'name'     => $teaInfo['name']?$teaInfo['name']:'default',
            'quizName' => trim(I('testName')),
            'state'    => '开启',
            'deadtime' => I('deadtime'),
            'time'     => date('Y-m-d H:i:s',time()),
            );
        $quizId = M('teacher_quiz')->add($quiz);
        if(!$quizId)
            $this->ajaxReturn('failure');

        

        /*===============添加测试题目========================*/
        foreach ($quesIdArray as $value) {
            $quesInfo      = $QUESBANK->where(array('id' => $value))->find();
            $quesInfoArray = array(
                'quizId'           => $quizId,
                'primaryId'        => $value,
                'openId'           => $openId,
                'name'             => $teaInfo['name']?$teaInfo['name']:'default',
                'quizName'         => trim(I('testName')),
                'questionPicPath'  => $quesInfo['questionPicPath'],
                'questionPicName'  => $quesInfo['questionPicName'],
                'rightAnswer'      => $quesInfo['rightAnswer'],
                'analysisPicPath'  => $quesInfo['analysisPicPath'],
                'analysisPicName'  => $quesInfo['analysisPicName'],
                'time' => date('Y-m-d H:i:s') 
                );
            if(!$QUIZBANK->add($quesInfoArray))
                $this->ajaxReturn('failure');
        }

        $this->ajaxReturn('success');
    }

    public function test_ques_list(){
        $unit   = intval(I('unit'));//章节
        $number = intval(I('number'));//题数
        if($unit === 0)
            $this->error('你选择的章节出错了');
        $unitArray = str_split($unit);
         
        $result    = array();
        foreach ($unitArray as $value) {
           //$value  = 'unit'.$value ;
           $cond   = array('chapter' => $value);
           $result = array_merge($result,M('questionbank')->where($cond)->select());
        }
        if($number !== 0){   //说明用户自定义选择了数量
            $numberResult = array(); 
            $rand = array_rand($result,$number);
            foreach ($rand as $key => $value) {
                $numberResult[] = $result[$value];
            }
            $this->assign('result',$numberResult)->display();
        }else{
            $this->assign('result',$result)->display();
        }
    }

    // 教师端测试列表，点击测试管理后进入界面
    public function test_list(){
        $map['state'] = array('neq','');
        $testList     = M('teacher_quiz')->where($map)->order('time desc')->select();
        $TEST = new TestController();
        foreach ($testList as $key => $value) {
            $testList[$key]['submitNum'] = $TEST->getSubmitNum($testList[$key]['id']);
        }
        $this->assign('testList',$testList)->display();
    }


    //教师端测试管理页面
    public function test_list_set(){
        $quizId = I('quizId') ? I('quizId') : $this->error('你访问的界面不存在');
        session('quizId',null);
        session('quizId',$quizId);
        $state     = M('teacher_quiz')->where(array('id' => $quizId))->getField('state');
        $TEST      = new TestController();
        $submitNum = $TEST->getSubmitNum($quizId);
        $this->assign('submitNum',$submitNum);
        $this->assign('state',$state)->display();
    }   

    //关闭测试
    public function test_close(){
        if(!IS_AJAX)
            $this->error('你访问的界面不存在');
        $quizId      =  session('?quizId') ? session('quizId') : $this->error('请重新获取该页面'); 
        if(M('teacher_quiz')->where(array('id' => $quizId))->save(array('state' => '关闭')))
            $this->ajaxReturn('success');
        else
            $this->ajaxReturn('failure');
    }

    // 测试提交列表
    public function test_view(){
        $quizId = I('quizId');
        if(empty($quizId))
            $quizId  =  session('?quizId') ? session('quizId') : $this->error('请重新获取该页面');
        $STU_CLA_REC =  M('student_classtest_record');
        $testList    =  $STU_CLA_REC->where(array('quizId' => $quizId))->select();
        $stuTestList =  $this->array_unset($testList,'openId');
        foreach ($stuTestList as $key => $value) {
            $stuTestList[$key]['rightNum'] = $STU_CLA_REC->where(array('quizId' => $quizId,'openId' => $stuTestList[$key]['openId'],'answerResult'=>'RIGHT'))->count();
        }
        $this->assign('stuTestList',$stuTestList)->display();
    }
    
    // 去除二维数组里的重复的值 
    public function array_unset($arr,$key){   //$arr->传入数组   $key->判断的key值
        $res = array();      //建立一个目标数组
        foreach ($arr as $value){         
           if(isset($res[$value[$key]])){ //查看有没有重复项
                 unset($value[$key]);//有：销毁
           }else{
                $res[$value[$key]] = $value;
           }
        }
        return $res;
    }


    public function test_analyze(){
        $quizId   = session('?quizId') ? session('quizId') : $this->error('请重新获取改页面');
        $openId   = session('?openId') ? session('openId') : $this->error('请重新获取改页面');

        $quesList = M('teacher_quiz_questionbank')->where(array('quizId' => $quizId))->select();
        $this->assign('quesList',$quesList)->display('Test/testAnalyze');
    }
}
