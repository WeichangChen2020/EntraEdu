<?php 
namespace Student\Controller;
use Think\Controller;

/**
 * EXAM 控制器 新生考试 模拟考试
 * @author 李俊君<hello_lijj@qq.com>
 * @copyright  2017-9-12 15:08Authors
 * @var  
 * @return 
 */
class ExamController extends Controller{
    
    /**
     * index 自由练习主页面 能显示当前进度，答题了多少道
     * @author 李俊君<hello_lijj@qq.com>
     * @copyright  2017-9-10 9:39Authors
     * @var  
     * @return 
     */

    public function index() {
    	$openid = session('openId');
        $examid = I('examid');
        session('examid',$examid);
        $examinfo = M('ExamSetup')->where(array('id'=>$examid))->find();
        $quesnum = M('ExamQuestionbank')->where(array('examid'=>$examid))->sum('chap_num');
        $studentInfo = M('StudentInfo')->where(array('openId' => $openid))->find();
        // dump($studentInfo);
        $this->assign('studentInfo',$studentInfo);
        $this->assign('quesnum',$quesnum);
        $this->assign('examinfo',$examinfo);
        $this->display();
    }

    public function exam() {

        $openid = session('openId');
        $examid = session('examid');
        echo $examid;

   }
    public function listExam() {
        $openId = session('openId');
        $student = M('StudentInfo')->where(array('openId' => $openId))->find();
        $examid = M('ExamCollege')->where(array('college' => $student['academy']))->field('examid')->select();

        //非新生(学院信息为空)显示所有考试
        if (empty($examid)) {
            $examid = M('ExamCollege')->distinct(true)->field('examid')->select();
        }

        foreach ($examid as $key => $value) {
            // $examid[$key]['examInfo'] = M('ExamSetup')->where(array('id' => $examid[$key]['examid']))->find();
            $examid[$key]['examTitle'] = M('ExamSetup')->where(array('id' => $examid[$key]['examid']))->field('title')->find();

            //从select表取得上述examid中是否有本用户openid的数据
            $map['examid']=$examid[$key]['examid'];
            $map['openid']=$openId;
            $examid[$key]['history'] = empty(M('ExamSubmit')->where($map)->find()) ? 0 : 1;
        }
        // dump($examid);

        $this->assign('examid',$examid);
        $this->display();
    }
    /*
    list界面用户只能看见自己的考试
        从studentInfo取得该openid的academic
        从college表取得所有该用户academic的examid
        从setup得到title

        是否已做？
        从submit表取得上述examid中是否有本用户answer为非空的数据

    非新生(学院信息为空)显示所有考试
        取得所有examid

    */


    public function enter_exam() {
        if (!IS_AJAX) {
            $this->error('你访问的页面不存在');
        }
        $openid       = session('openId');
        $examid       = session('examid');
        $examinfo     = M('ExamSetup')->where(array('id' => $examid))->find();

        if (empty($examinfo)) {
            $this->ajaxReturn('考试信息查询失败');
        }
        $submitHistory= M('ExamSubmit')->where(array('openid' => $openid , 'examid' => $examid))->find();
        if (!empty($submitHistory)) {
            $this->ajaxReturn('您已经做过该试卷了');
        }else if($examinfo['is_on'] == 0 && time() < $examinfo['start_time']) {
            $this->ajaxReturn('还没有到考试时间');
        }else {
            $this->ajaxReturn('enter');
        }
    }
}

