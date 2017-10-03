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
        // p($listExam);die;
        $this->assign('listExam', $listExam)->display();
    }


    /**
     * index 模拟考试首页面
     * @author 李俊君<hello_lijj@qq.com>
     * @copyright  2017-10-2 20:44Authors
     **/
    public function index() {

        // ******************获取用户信息*****************
        $openid   = session('openId');
        $stuInfo  = D('StudentInfo')->getStuInfo($openid);
        $this->assign('stuInfo', $stuInfo);


        // ******************获取用户考试信息**************
        $examid   = I('examid');
        session('examid', $examid);
        $examInfo = D('ExamSetup')->getExamInfo($examid);
        $this->assign('examInfo', $examInfo);


        $this->display();
    }


    /**
     * beforeInit 初始化考试之前判断用户是否满足考试条件
     * @author 李俊君<hello_lijj@qq.com>
     * @copyright  2017-10-2 21:36Authors
     * @return $info  = array(
          'is_on'     => 1,
          'is_end'    => 0,
          'is_submit' => 0,
          'is_init'   => 0,
        )  
     **/

        /*
            考虑以下问题
            1.是否是新生
            2.是否继续答题
            3.是否首次答题
            4.是否在规定的时间内
            5.考试是否开启
            6.考试是否结束
            7.考试是否提交
         */
    public function beforeInit() {
        
        if (!IS_AJAX) {
            $this->error('你访问的页面不存在');
        }

        $openid = session('openId');
        $examid = session('examid');
        $info   = D('ExamSetup')->beforeInitExam($openid, $examid);

        $this->ajaxReturn($info);
    }

    /**
     * initExam 初始化考试环境，即随机生成所需要的题目
     * @author 李俊君<hello_lijj@qq.com>
     * @copyright  2017-10-2 21:36Authors
     **/
    private function initExam() {

        $info = D('ExamSetup')->getExamInfo(12);
        p($info);

        
    }

    /**
     * exam 考试页面
     * @author 李俊君<hello_lijj@qq.com>
     * @copyright  2017-10-2 20:44Authors
     **/
    public function exam() {

        $this->initExam();

    }
    
}