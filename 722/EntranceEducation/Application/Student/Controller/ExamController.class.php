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
     * @param openid
     **/
    public function list() {
        
        // $examList = D('ExamSetup')->list();
        // p($examList);die;
        // $this->assign('examList', $examList)->display();

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


    
}

