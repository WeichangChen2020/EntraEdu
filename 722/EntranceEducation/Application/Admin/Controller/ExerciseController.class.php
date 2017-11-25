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
     * index_new index的新方法，用于展示 以用户的做题情况
     * @author 李俊君<hello_lijj@qq.com>
     * @copyright  2017-11-24 12:34Authors
     * @var  
     * @return 
     */
    public function index_new() {
        $Student = M('StudentList');

        // 查询条件
        $college = D('Adminer')->getCollege();
        $map = array();

        if (!is_null($college)) {
            $map['academy'] = $college;
        } else {
            $map['academy'] = array('neq', '非新生');
        }

        $list = $Student->where($map)->page($_GET['p'].',20')->select();
        $count = $Student->where($map)->count();

        $this->assign('userList',$list);

        $Page       = new \Think\Page($count,20);
        $show       = $Page->show();
        $this->assign('page', $show);

        $num['answer_num'] = M('exercise_rank')->where($map)->count();
        $where['right_num'] = array('LT', 875);
        $num['unpass_num'] = M('exercise_rank')->where($map)->where($where)->count();
        $this->assign('num', $num);

       
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


     /**
     * 导出 自由练习做题情况
     * @author 李俊君<hello_lijj@qq.com>
     * @copyright  2017-11-25 10:04Authors
     * @var  
     * @return 
     */
    public function export() {
        // 查询条件
        $college = D('Adminer')->getCollege();
        $map = array();

        if (!is_null($college)) {
            $map['academy'] = $college;
        }

        $title = array('序号','姓名', '学号', '学院', '班级', '正确题数', '答题数量');
        $filename  = is_null($college) ? '浙江工商大学' : $college;

        $list = M('exercise_rank')->where($map)->field('id,name,number,academy,class,right_num,answer_num')->order('academy,class,number,right_num')->select();
        $filename .= '新生始业平台自由练习答题情况';


        $excel = new UserController();
        $excel->excel($list, $title, $filename);
    }

}