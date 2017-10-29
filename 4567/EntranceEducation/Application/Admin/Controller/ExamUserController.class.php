<?php 
namespace Admin\Controller;
use Think\Controller;

/**
 * EXAMUSER 控制器 新生考试 模拟考试
 * @author 陈伟昌<1339849378@qq.com>
 * @copyright  2017-10-29 14:128Authors
 * @var  
 * @return 
 */
class ExamUserController extends CommonController{
	
	/**
	 * index 模拟考试主页面 显示考试列表，提交人数等
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-10-29 15:34Authors
	 * @var  
	 * @return 
	 */

	public function index() {

        $EXAM = M('ExamSetup');

        // 查询条件
        $college = D('Adminer')->getCollege();
        $map = array();

        if (!is_null($college)) {
            $map['academy'] = $college;
        }

        $list = $EXAM->where($map)->page($_GET['p'].',20')->select();
        $count = $EXAM->where($map)->count();

        $this->assign('examList',$list);

        $Page       = new \Think\Page($count,20);
        $show       = $Page->show();
        $this->assign('page', $show);
   
        $this->display();

	}




}