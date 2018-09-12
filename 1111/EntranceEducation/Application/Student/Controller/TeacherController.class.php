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
        $openId = getOpenId();
        session('openId',$openId);
        if(!$openId){
            $openId = session("openId");
        } 

        // $correcNumber = $this->getHomeCorrNum();
        // $this->assign('correcNumber',$correcNumber);
        $user = new UserController;
        $teaInfo = $user->getTeacherInfo($openId);
        $this->assign('teaInfo',$teaInfo);
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

        $openId =  session('openId');
        $teacherClass = D('TeacherClass')->getTeacherClass($openId);//某位老师带的班级
        $this->assign('teacherClass',$teacherClass)->display();

        // $correcNumber = $this->getHomeCorrNum();
        // var_dump($correcNumber);die();
        // $this->assign('correcNumber',$correcNumber)->display();
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
    


    public function homework_assign_zg(){
        if(IS_AJAX){
            $unit = I('unit');
            $count= 0;
            $unitArray = str_split($unit);
            foreach ($unitArray as $key => $value) {
                $count += M('imageQuestionbank')->where(array('chapter'=>$value['id']))->count();
            }
            $this->ajaxReturn($count);
        }
        $chapterList = M('questionChapter')->select();
        // foreach ($chapterList as $key => $value) {
        //     $chapterList[$key]['count'] = M('imageQuestionbank')->where(array('chapter'=>$value['id']))->count();
        // }
        $this->assign('chapterList',$chapterList);
        $this->display();    

    }

    public function homework_assign_zg2(){
        $unit   = I('unit');//章节
        session('unit',$unit);
        $number = intval(I('number'));//题数
        if($unit === 0)
            $this->error('你选择的章节出错了');
        $unitArray = explode('_',substr($unit, 0,strlen($unit)-1));

        $result    = array();
        foreach ($unitArray as $value) {
            $cond   = array('chapter' => $value);
            $result = array_merge($result,M('image_questionbank')->where($cond)->select());
        }
        foreach ($result as $key => $value) {
            $result[$key]['contents'] = C('COMMONPATH').C('HOMEWORKPATH').$value['chapter'].'_'.$value['type'].'_1_'.$value['id'].'.jpg';
        }
        if($number != ''){   //说明用户自定义选择了数量
            $numberResult = array(); 
            $rand = array_rand($result,$number);
            foreach ($rand as $key => $value) {
                $numberResult[] = $result[$value];
            }
            $this->assign('random',1);
            $this->assign('quesItem',$numberResult);
            $this->display();
        }else{
            $this->assign('random',0);
            $this->assign('quesItem',$result);
            $this->display();
        }


    }

    public function homework_class_list(){
        $openId =  session('openId');
        $banji = I('get.banji');
        $banji = explode('_', $banji);
        // var_dump($banji);die();
        $quesId = I('get.quesId');
        session('quesId',null);
        session('quesId',$quesId);

        $teacherClass = D('TeacherClass')->getTeacherClass($openId);//某位老师带的班级
        // var_dump($teacherClass);die();
        $word = date("m月d日",time());
        $map['homeworkname'] = array('like',$word.'%');
        $map['class'] = $data['teacherClass'];
        $homeworkzg = M('homework_zg')->where($map)->count();
        // var_dump($homeworkzg+2);die();
        if ($homeworkzg == 0) {
            $name = date("m月d日",time());
        }else
        {
            $homeworkzg++;
            $name = date("m月d日第".$homeworkzg."次作业",time());
        }
        $banji = json_encode($banji);
        // var_dump($banji);die();
        $this->assign('homeworkName',$name);
        $this->assign('banji',$banji);
        $this->assign('teacherClass',$teacherClass)->display();


    }

    public function chooseclass(){

        $openId =  session('openId');
        // echo $openId;
        $quesId = I('get.quesId');
        session('quesId',$quesId);
        $teacherClass = D('TeacherClass')->getTeacherClass($openId);//某位老师带的班级
        // dump($teacherClass);die;
        $this->assign('teacherClass',$teacherClass);
        $this->assign('quesId',$quesId);

        $this->assign('quesId',$quesId)->display();


    }
    
    public function homework_insert(){
        $data = I('post.');
        $model = M('homework_zg');
        
        $class = $data['teacherClass'];
        // var_dump($data);die();
        $word = date("m月d日",time());
        foreach ($class as $key => $value) {
         if (!empty($value)) {
            $map['homeworkname'] = array('like',$word.'%');
            $map['class'] = $value;
            $homeworkzg = M('homework_zg')->where($map)->count();
                // var_dump($homeworkzg+2);die();
            if ($homeworkzg == 0) {
                $name = date("m月d日",time());
            }else
            {
                $homeworkzg++;
                $name = date("m月d日第".$homeworkzg."次作业",time());
                    // var_dump($name);die();
            }
            $map['homeworkname'] = $name;
            $map['class'] = $value;
            $map['dead_time'] = $data['deadtime'];
            $map['hpdead_time'] = $data['hpdeadtime'];
            $map['problem_id'] = session('quesId');
            $map['bj'] = $data['bj'];
            $res = $model->add($map);
        }
    }
    $this->ajaxReturn();

}








            // $homeworkName = session('homeworkName');
            // $homeworkzg = M('teacher_homework')->where(array('homeworkName'=>$homeworkName,'type'=>0))->find();
            // $problems = $homeworkzg['content'];
            // $proarr = explode(',', $problems);


    // public function homework_assign_kg(){
    //     var_dump(3444);
    //         $chapternumber = M('questionbank')->distinct('chapter')->group('chapter')->select();
    //         $num = count($chapternumber);
    //         $this->assign('num',$num);
    //         $this->display();

    // }

    //将上传的作业信息写入数据库
public function homework_handAssign(){
    if(!IS_AJAX)
        $this->error('你访问的界面不存在');
    $openId   =  session('?openId') ? session('openId') : $this->error('请重新获取该页面');
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

    //批改申诉作业列表
public function homework_list_correct(){
    $SUBMIT = M('student_homework');
    $QUESTION = M('imageQuestionbank');
    $list = $SUBMIT->where(array('openId'=>I('openId'),'homeworkoid'=>I('homeworkoid')))->select();
    foreach ($list as $key => $value) {
        $question = $QUESTION->where(array('id'=>$value['problemid']))->find();
        $list[$key]['right_answer'] = C('COMMONPATH').C('HOMEWORKPATH').$question['chapter'].'_'.$question['type'].'_0_'.$question['id'].'.jpg';
    }
    $this->assign('homework',$list)->display();
}

    //批改未批改作业列表
public function homework_list_correct2(){

    $SUBMIT = M('student_homework');
    $QUES   = M('imageQuestionbank');
    $homework = $SUBMIT->where(array('mark'=>'no'))->order('time desc')->limit(10)->select();
    foreach ($homework as $key => $value) {
        $question = $QUES->where(array('id'=>$value['problemid']))->find();
        $homework[$key]['right_answer'] = C('COMMONPATH').C('HOMEWORKPATH').$question['chapter'].'_'.$question['type'].'_0_'.$question['id'].'.jpg';
    }
    $this->assign('homework',$homework)->display();
}

public function mark_score(){
    if (!IS_AJAX) {
        $this->error('你访问的界面不存在');
    }
    $score = I('score');
    if (empty($score)) {
        $this->ajaxReturn(false);
    }
    $model = D('student_homework');
    $data = array(
        'correcter'   => '老师批改',
        'mark'   =>  $score,
        'complain'   =>  '0',
        'correctTime' => date('Y-m-d H:i:s',time())
    );
    $res = $model->where(array('id'=>I('homeworkid')))->save($data);
    // dump($model->getLastSql());die;
    if ($res) {
        $this->ajaxReturn(true);
    } else {
        $this->ajaxReturn(false);
    }
    
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
    $openId       =  session('?openId') ? session('openId') : $this->error('请重新获取该页面');
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
        $class = I('get.class');
        $now = date("Y-m-d H:i:s",time());
        $homework = M('homework_zg')->where(array('class'=>$class))->order("create_time desc")->select();
        $SUBMIT =  M('student_homework');
        $STINFO = M('student_info');
        foreach ($homework as $key => $value) {
            $submit = $SUBMIT->where(array('homeworkoid' => $value['id']))->field('openId')->group('openId')->select();
            $homework[$key]['submit'] = count($submit);
            //总人数
            $homework[$key]['sum'] = $STINFO->where(array('class'=>$value['class']))->count();
            //flag为1指还没截止作业提交
            if ($value['dead_time'] > $now) {
                $homework[$key]['flag'] = 1;
            }else{
                $homework[$key]['flag'] = 0;
                $homework[$key]['bjnum'] = count($SUBMIT->where(array('homeworkoid' => $value['id'],'bj'=>1))->field('openId','bj')->group('openId')->select());
            }
        }
        $this->assign('bjnum',$bjnum);
        $this->assign('homework',$homework);
        $this->assign('now',$now);
        // var_dump($homework);die();
        $this->display();
}

    //获取教师端作业浏览量
private function getHomeViewNum($homeworkId){
    $cond              = array('homeworkId' => $homeworkId);
    return M('student_homework')->where($cond)->count();
}

    //批改作业
public function homework_view(){
    $homeworkoid = I('get.id');
    $class = M('homework_zg')->where(array('id'=>$homeworkoid))->getField("class");
    $classmate = M('student_info')->where("class='$class'")->order('number')->select();
    $SUBMIT = M('student_homework');
        // var_dump($classmate);die();
    foreach ($classmate as $key => $value) {
        $doc = $SUBMIT->where(array('homeworkoid'=>$homeworkoid,'openId'=>$value['openId']))->find();
        $submitList = $SUBMIT->where(array('homeworkoid'=>$homeworkoid,'openId'=>$value['openId']))->group('problemid')->select();
        $huping = $SUBMIT->where(array('homeworkoid'=>$homeworkoid,'correcter'=>$value['name']))->find();
        $complain = $SUBMIT->where(array('homeworkoid'=>$homeworkoid,'openId'=>$value['openId'],'complain'=>'1'))->find();
        if (!empty($complain)) {
            $classmate[$key]['complain'] = 'complain';
        }
        $classmate[$key]['score'] = 0;
        foreach ($submitList as $k => $v) {
            if ($v['mark'] == 'no') {
                $classmate[$key]['score'] = '未批改';
                break;
            }
            $classmate[$key]['score'] = $v['mark'] + $classmate[$key]['score'];
        }
        if (!empty($huping)) {
            $classmate[$key]['hpflag'] = 1;
        }
        if (empty($doc)) {
            $classmate[$key]['flag'] = 0;
        }else if ($doc['bj'] == 1) {
            $classmate[$key]['flag'] = 2;
        }else{
            $classmate[$key]['flag'] = 1;
        }
    }

    $this->assign('classmate',$classmate);
    $this->assign('homeworkoid',$homeworkoid);
    $this->display();
}
public function homework_viewdetail()
{
    $homeworkoid = I('get.homeworkoid');
    $name = I('get.name');
        // var_dump($homeworkoid.'/'.$name);die();
    $data = M('student_homework')->where(array('homeworkoid'=>$homeworkoid,'name'=>$name))->select();
    $this->assign('homeworkoid',$homeworkoid);
    $this->assign('homeworkList',$data);
    $this->display();
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
    $name    = D('TeacherSignin')->setSigninName(session('openId'));
    $this->assign('signPackage',$signPackage);
    $this->assign('time',$name);
    $this->display();
}

    /**
     * signin_chose_class  选择班级
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright 2018-01-25
     * @var
     * @return    
     */
    public function signin_chose_class(){
        $data = I();
        $openId =  session('openId');
        $teacherClass = D('TeacherClass')->getTeacherClass($openId);//某位老师带的班级
        $name    = D('TeacherSignin')->setSigninName(session('openId'));

        $this->assign('teacherClass',$teacherClass);
        $this->assign('data',$data);
        $this->assign('signPackage',$signPackage);
        $this->assign('time',$name);
        $this->display();
    }

    /**
     * signin_add  添加签到记录
     * @author    陈伟昌<1339849378@qq.com>
     * @copyright 2018-01-25
     * @var
     * @return    string
     */
    public function signin_add(){
        if(!IS_AJAX){
            $this->error('你访问的界面不存在');
        }
        $openId        =  session('openId') ? session('openId') : $this->error('请重新获取该页面');
        $name          = M('teacherInfo')->where(array('openId' => $openId))->getField('name');
        $signin        = array(
            'openId'    => $openId,
            'name'      => $name,
            'class'     => I('class'),
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
        $openId    = session('openId') ? session('openId') : $this->error('请重新获取该页面');
        $list      = M('teacherSignin')->where(array('openId' => $openId))->order('time desc')->select();
        $SIGNIN    = D('TeacherSignin');
        $STUDENT   = D('StudentInfo');
        foreach ($list as $key => $value) {
            $list[$key]['signinNum'] = $this->getSigninNum($value['id']);
            $count = 0;
            $signinInfo = $SIGNIN->getDetail($value['id']);
            foreach ($signinInfo["class"] as $k => $v) {
                $count += count($STUDENT->getClassmate($v));
            }
            $list[$key]['count']     = $count;
        }
        $this->assign('signinList',$list)->display();
    }

    private function getSigninNum($signinId){
        return M('studentSignin')->where(array('signinId' => $signinId))->count();
    }

    //设置状态关闭，代签
    public function signin_list_set(){
        $signinId = I('signinId') ? I('signinId') : $this->error('你访问的界面不存在');
        session('signinId',$signinId);
        $state = M('teacher_signin')->where(array('id' => $signinId))->getField('state');
        $signinNum = $this->getSigninNum($signinId);
        $this->assign('signinNum',$signinNum);
        $this->assign('state',$state)->display();
    }

    //已签到名单
    public function signin_view(){
        $signinId      =  session('?signinId') ? session('signinId') : $this->error('请重新获取该页面');
        $SIGNIN        =  D('TeacherSignin');
        $signinInfo    =  $SIGNIN->getDetail($signinId);
        $location      =  $SIGNIN->where(array('id'=>$signinId))->find();
        $STUDENT       =  D('StudentInfo');
        $SIGNIN        =  D('StudentSignin');
        $signinList    =  array();
        foreach ($signinInfo["class"] as $key => $value) {
            if (empty($signinList)) {
                $signinList = $STUDENT->getClassmate($value);
            }else{
                $temp = $STUDENT->getClassmate($value);
                foreach ($temp as $key => $value) {
                    array_push($signinList, $value);
                }
            }
        }

        foreach ($signinList as $key => $value) {
            //计算距离
            // $signinList[$key]['distance'] = $SIGNIN->getdistance($location['longitude'],$location['latitude'],$value['longitude'],$value['latitude']);
            // dump($value);
            // dump($signinList[$key]['distance']);die;
            //默认缺席
            $signinList[$key]['flag'] = 0;
            //判断代签
            $map['location'] = array('like','%代%');
            $map['openId']= $value['openId'];
            $map['signinId']= $signinId;
            if (NULL != $SIGNIN->where($map)->find()) {
                $signinList[$key]['flag'] = 2;
                continue;
            }
            //请假
            $map['location'] = array('like','%假%');
            if (NULL != $SIGNIN->where($map)->find()) {
                $signinList[$key]['flag'] = 3;
                continue;
            }
            //判断到席
            if ($SIGNIN->isSignin($value['openId'],$signinId) ) {
                $signinList[$key]['flag'] = 1;
                continue;
            }
        }
        $this->assign('signinId',$signinId);
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
    /**
     * daiqian  老师帮学生代签
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright 2018-01-25T19:04:47+0800
     * @var
     * @return    string                   [description]
     */
    public function daiqian(){
        if(IS_AJAX){
            /*====获取该学生信息==*/
            $openId = I('openId');
            $func   = I('func');
            $signinId = I('signinId');

            $res    = D('StudentSignin')->changeSignin($openId,$signinId,$func);
            $this->ajaxReturn($res);   
        }else 
            //非ajax访问
        $this->ajaxReturn('非法的请求方式');   
    }

    //教师端随堂测试首页面,1.发布测试，2.测试管理
    public function test_index(){
        // session('openId',null);
        $openId = getOpenId();
        session('openId',$openId);
        //p($openId);
        $this->display();
    }

    //发布测试->章节列表
    public function test_unit_list(){
        // $chapArr = M('question_chapter')->select();
        // // p($chapArr);
        // foreach ($chapArr as $key => $value) {
        //     $queNum[$key]['num'] = D('Questionbank')->getQuesChapterNum($chapArr[$key]['id']);
        // }
        // $this->assign('queNum',$queNum);
        if(IS_AJAX){
            $unit = I('unit');
            $count= 0;
            $unitArray = str_split($unit);
            foreach ($unitArray as $key => $value) {
                $count += M('questionbank')->where(array('chapter'=>$value['id']))->count();
            }
            $this->ajaxReturn($count);
        }
        $chapterList = M('question_chapter')->select();
        foreach ($chapterList as $key => $value) {
            $chapterList[$key]['num'] = D('Questionbank')->getQuesChapterNum($chapterList[$key]['id']);
        }
        // $this->assign('queNum',$queNum);
        // p($chapterList);die;
        $this->assign('chapterList',$chapterList);
        $this->display();
    }

    //发布测试->章节列表->题目列表
    public function test_ques_list(){
        $unit   = intval(I('unit'));//章节
        $number = intval(I('number'));//题数
        if($unit === 0)
            $this->error('你选择的章节出错了');
        $unitArray = str_split($unit);

        $result    = array();
        foreach ($unitArray as $value) {
            $cond   = array('chapter' => $value);
            $result = array_merge($result,M('questionbank')->where($cond)->select());
        }
        // p($result);//某几章节的所有题目二维数组
        foreach ($result as $key => $value) {
            $result[$key]['contents'] = C('COMMONPATH').C('QUESTIONPATH').$value['chapter'].'_'.$value['type'].'_'.$value['right_answer'].'_'.$value['id'].'.jpg';
        }
        // var_dump($result);
        // die;
        if($number != 0){   //用户自定义题目数量
            $numberResult = array(); 
            $rand = array_rand($result,$number);//当number=1的时候，$rand是个数字不是数组.(？)
            // var_dump($rand);die;
            foreach ($rand as $key => $value) {
                $numberResult[] = $result[$value];
            }
            //var_dump($numberResult);die;
            $this->assign('random',1);
            $this->assign('quesItem',$numberResult)->display();
        }else{
            $this->assign('random',0);
            $this->assign('quesItem',$result)->display();
        }

    }



    //发布测试->章节列表->题目列表->班级列表
    public function test_class_list(){
        $openId =  session('openId');
        // echo $openId;
        $quesId = I('quesId'); 
        session('quesId',$quesId);
        $teacherClass = D('TeacherClass')->getTeacherClass($openId);//某位老师带的班级
        // var_dump($teacherClass);
        $this->assign('teacherClass',$teacherClass)->display();

    }

    //发布测试
    public function test_assign(){
        $openId =  session('openId');
        $quesId = session('quesId');//_2_3
        $banji = I('banji');//_班级1_班级2
        //echo $quesId;
        //echo $banji;
        //die;
        if(empty($quesId))
            $this->error('你访问的界面不存在');

        $assignArray['quesId']     = substr($quesId, 1);//从第2个开始截取
        $assignArray['banji']      = substr($banji, 1);
        //echo $assignArray['quesId'];
        $assignArray['testName']   = date('m月d日H:i:s',time());
        $assignArray['quesNumber'] = count(explode('_', substr($quesId, 1)));
        //var_dump($assignArray);
        
        $this->assign('assignArray',$assignArray)->display();
    }

    //添加测试，套了三层循环，紧张
    public function test_add(){
        if(!IS_AJAX)
            $this->error('你访问的界面不存在');
        $openId      = session('?openId') ? session('openId') : $this->error('请重新获取该页面');
        $classArray  = explode('_', I('testBanji'));//以_为分割,打成数组
        $quesIdArray = explode('_', I('testQuesId'));//题目id数组
        // var_dump($quesIdArray);die;
        $user        = new UserController();
        $teaInfo     = $user->getTeacherInfo($openId);
        $QUESBANK    = M('questionbank');
        $TESTSET     = M('test_set');
        $TESTBANK    = M('test_questionbank');
        $TESTSELECT  = M('test_select');

        /*===============添加测试，设置=================*/
        foreach ($classArray as $key => $value) {
            $quiz = array(
                'openid'   => $openId,
                'name'     => $teaInfo['name']?$teaInfo['name']:'佚名',
                'testName' => $value.'：'.trim(I('testName')),
                // 'quizName' => trim(I('testName')),
                'class'    => $value,
                'state'    => '开启',
                'deadtime' => I('deadtime'),
                'time'     => date('Y-m-d H:i:s',time()),
            );
            //var_dump($quiz);die;
            $testid = $TESTSET->add($quiz);
            // var_dump($testid);die;//居然是返回自增id握草，666
            //$quiz['testid'] = $testid;
            //M('test_set')->save($quiz);

            if(!$testid)
                $this->ajaxReturn('failure');

            /*===============插入测试信息========================*/
            foreach ($quesIdArray as $v) {
                $quesInfo      = $QUESBANK->where(array('id' => $v))->find();
                //var_dump($quesInfo);die;
                $quesInfoArray = array(
                    'openid'           => $openId,                
                    'name'             => $teaInfo['name']?$teaInfo['name']:'default',
                    'class'            => $value,
                    'testid'           => $testid,
                    'quesid'           => $v,
                    'rightAnswer'      => $quesInfo['right_answer'],
                    'time' => date('Y-m-d H:i:s') 
                );
                if(!$TESTBANK->add($quesInfoArray))
                    $this->ajaxReturn('failure');

                /*===============在学生答题记录表插入题目========================*/
                $openidArr = M('student_info')->where(array('class'=>$value))->field('openId')->select();//某班级的所有学生openid
                //p($openidArr);
                foreach ($openidArr as $kk => $vv) {
                    //p($vv);
                    $openid = $vv['openId'];
                    $stuInfo     = $user->getUserInfo($openid);
                    $que = array(
                        'openid' => $openid,
                        'name'   => $stuInfo['name']?$stuInfo['name']:'default',
                        'testid' => $testid,
                        'quesid' => $v,
                        'time'   => date('Y-m-d H:i:s'),
                    );
                    //p($que);
                    // die;
                    $init = $TESTSELECT->add($que);

                }
            }

        }

        $this->ajaxReturn('success');
    }



    // 教师端 测试管理->随堂测试列表
    public function test_list(){
        $openId = session('openId');
        session('openId',$openId);
        $map['state'] = array('neq','');
        $map['openid'] = $openId;
        // p($map);
        $testList = M('test_set')->where($map)->order('time desc')->select();
        //$TEST = new TestController();
        $TEST = D('TestSubmit');
        $STUINFO = D('StudentInfo');
        foreach ($testList as $key => $value) {
            $testList[$key]['submitNum'] = $TEST->getSubmitNum($testList[$key]['id']);
            $testList[$key]['stuNum'] = $STUINFO->getStuNumByClass($value['class']);
        }
        // p($testList);
        $this->assign('testList',$testList)->display();
    }


    //教师端 测试管理->随堂测试列表->测试管理（停止测试，提交列表，题目解析，测试统计）
    public function test_list_set(){
        $testid = I('testid') ? I('testid') : $this->error('你访问的界面不存在');
        session('testid',null);
        session('testid',$testid);
        $state     = M('test_set')->where(array('id' => $testid))->getField('state');
        //$TEST      = new TestController();
        $TEST = D('TestSubmit');
        $submitNum = $TEST->getSubmitNum($testid);
        $this->assign('submitNum',$submitNum);
        $this->assign('state',$state)->display();
    }   

    //关闭测试
    public function test_close(){
        if(!IS_AJAX)
            $this->error('你访问的界面不存在');
        $testid      =  session('?testid') ? session('testid') : $this->error('请重新获取该页面'); 
        if(M('test_set')->where(array('id' => $testid))->save(array('state' => '关闭')))
            $this->ajaxReturn('success');
        else
            $this->ajaxReturn('failure');
    }

    // 测试管理->随堂测试列表->测试管理->提交列表
    public function test_view(){
        $testid = I('testid');
        if(empty($testid))
            $testid  =  session('?testid') ? session('testid') : $this->error('请重新获取该页面');
        $SUBMIT =  M('test_submit');
        $testList    =  $SUBMIT->where(array('testid' => $testid))->select();
        // var_dump($testList);
        // $stuTestList =  $this->array_unset($testList,'openid');
        // var_dump($stuTestList);
        // foreach ($stuTestList as $key => $value) {
        //     $stuTestList[$key]['rightNum'] = $SUBMIT->where(array('testid' => $testid,'openid' => $stuTestList[$key]['openid'],'result'=>'1'))->count();
        // }
        // var_dump($stuTestList);
        //$this->assign('stuTestList',$stuTestList)->display();
        $this->assign('stuTestList',$testList)->display();
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

    // 测试管理->随堂测试列表->测试管理->题目解析
    public function test_analyze(){
        $testid   = session('?testid') ? session('testid') : $this->error('请重新获取该页面');
        $openId   = session('?openId') ? session('openId') : $this->error('请重新获取该页面');
        $TESTSELECT = D('TestSelect');
        // $unitArray = str_split($unit);
        $quesList = $TESTSELECT->getTestItems($openId, $testid);//某测试所有题目
        $quesidList = array();
        foreach ($quesList as $key => $value) {
            $quesidList[$key] = $value['quesid'];
        }
        // p($quesidList);
        $result    = array();
        foreach ($quesidList as $value) {
            $cond   = array('id' => $value);
            $result = array_merge($result,M('questionbank')->where($cond)->select());
        }
        // p($result);//某几章节的所有题目二维数组
             
        foreach ($result as $key => $value) {
            $result[$key]['contents'] = C('COMMONPATH').C('QUESTIONPATH').$value['chapter'].'_'.$value['type'].'_'.$value['right_answer'].'_'.$value['id'].'.jpg';
            $result[$key]['answer'] = $TESTSELECT->getUserAnswer($openId,$testid,$value['id']);
        }
        // p($result);die;
        
        $this->assign('quesItem',$result)->display();
    }

    public function signin_map($signinId){
        $weixin       = new WeichatController();
        $signPackage  = $weixin->getJssdkPackage();
        $signinList   = M('StudentSignin')->where(array('signinId'=>$signinId))->select();
        $teacherLocation = M('TeacherSignin')->where(array('id'=>$signinId))->find();
        $this->assign('teacherLocation',$teacherLocation);
        $this->assign('signinList',$signinList);
        $this->assign('signPackage',$signPackage);
        $this->display();
    }
    public function test(){

        $homeworkoid = I('get.id');
        $class = M('homework_zg')->where(array('id'=>$homeworkoid))->getField("class");
        $classmate = M('student_info')->where("class='$class'")->order('number')->select();
        $SUBMIT = M('student_homework');
        // var_dump($classmate);die();
        foreach ($classmate as $key => $value) {
            $doc = $SUBMIT->where(array('homeworkoid'=>$homeworkoid,'openId'=>$value['openId']))->find();
            $submitList = $SUBMIT->where(array('homeworkoid'=>$homeworkoid,'openId'=>$value['openId']))->group('problemid')->select();
            $huping = $SUBMIT->where(array('homeworkoid'=>$homeworkoid,'correcter'=>$value['name']))->find();
            $complain = $SUBMIT->where(array('homeworkoid'=>$homeworkoid,'openId'=>$value['openId'],'complain'=>'1'))->find();
            if (!empty($complain)) {
                $classmate[$key]['complain'] = 'complain';
            }
            $classmate[$key]['score'] = 0;
            foreach ($submitList as $k => $v) {
                if ($v['mark'] == 'no') {
                    $classmate[$key]['score'] = '未批改';
                    break;
                }
                $classmate[$key]['score'] = $v['mark'] + $classmate[$key]['score'];
            }
            if (!empty($huping)) {
                $classmate[$key]['hpflag'] = 1;
            }
            if (empty($doc)) {
                $classmate[$key]['flag'] = 0;
            }else if ($doc['bj'] == 1) {
                $classmate[$key]['flag'] = 2;
            }else{
                $classmate[$key]['flag'] = 1;
            }
        }
        dump($classmate);die;
        $this->assign('classmate',$classmate);
        $this->assign('homeworkoid',$homeworkoid);
        $this->display('homework_view');
    }

}