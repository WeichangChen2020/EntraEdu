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
     * list 模拟考试列表
     * @author 李俊君<hello_lijj@qq.com>
     * @copyright  2017-10-2 9:39Authors
     **/
    public function listExam(){
        $listExam = D('ExamSetup')->listExam();
        $this->assign('listExam', $listExam)->display();
    }


    /**
     * index 模拟考试首页面
     * @author 李俊君<hello_lijj@qq.com>
     * @copyright  2017-10-2 20:44Authors
     **/
    public function index() {

        // ******************获取用户信息*****************
        $openid   = session('openid');
        $stuInfo  = D('StudentInfo')->getStuInfo($openid);


        // ******************获取用户考试信息**************
        $examid   = I('examid');
        $examInfo = D('ExamSetup')->getExamInfo($examid);

        p($stuInfo);
        p($examInfo);

        // $this->display();
    }

    
}