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

    
}