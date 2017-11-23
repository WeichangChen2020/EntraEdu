<?php
namespace Admin\Controller;
use Think\Controller;
class ExerciseController extends CommonController {
    
    public function index(){

        $Question = M('Questionbank');
        $list = $Question->page($_GET['p'].',20')->select();
        $this->assign('questionList',$list);

        $count      = $Question->count();
        $this->assign('count', $count);
        $Page       = new \Think\Page($count,20);
        $show       = $Page->show();
        $this->assign('page',$show);
       
        $this->display();
    }

    /**
     * submiter 不允许考试人员详情
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright  2017-11-21 13:48Authors
     * @var  
     * @return 
     */
    public function ban(){
    // 查询条件
        $college = D('Adminer')->getCollege();
        $map['type'] = 0;

        if (!is_null($college)) {
            $map['academy'] = $college;
        }
        $map['present']  = array('elt',0.6);
        $map['is_newer'] = 1;
        $list = M('StudentInfo')->where($map)->page($_GET['p'].',20')->select();
        $count = M('StudentInfo')->where($map)->count();

        $this->assign('studentList', $list);

        $Page       = new \Think\Page($count,20);
        $show       = $Page->show();
        $this->assign('page', $show);
        $this->assign('count', $count);


        $this->assign('export', 0);
        $this->assign('id',$id);
        $this->display();
    }

}