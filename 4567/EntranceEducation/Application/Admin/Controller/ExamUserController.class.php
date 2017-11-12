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
	 * @copyright  2017-10-29 14:12Authors
	 * @var  
	 * @return 
	 */

	public function index() {

		$EXAM = M('ExamSetup');
        $EXAMCOLLEGE = D('ExamCollege');

        $college = D('Adminer')->getCollege();
        $list = $EXAMCOLLEGE->getExamList($college);
        foreach ($list as $key => $value) {
        	$list[$key]['info'] = $EXAM->where(array('id' => $value['examid']))->find();
        }
        $this->assign('examList',$list);

        $this->display();
	}

	/**
	 * detail 模拟考试详细信息 提交人员详情
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-11-7 15:12Authors
	 * @var  
	 * @return 
	 */

	public function detail($id = 0) {

		$SUBMIT = M('ExamSubmit');
        $college = D('Adminer')->getCollege();

		$submitList = $SUBMIT->where(array('examid'=>$id))->select();

        $Page       = new \Think\Page($count,20);
        $show       = $Page->show();
        $this->assign('page', $show);

        $this->assign('export', 1);
		$this->assign('submitList',$submitList);
		$this->assign('id',$id);
		$this->display();
	}


	/**
	 * unSubmit 模拟考试详细信息 未提交人员详情
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-11-7 15:50Authors
	 * @var  
	 * @return 
	 */

	public function unSubmit($id = 0) {

		$STUDENT = D('ExamSubmit');

		$unSubmitList = $STUDENT->getUnsubmitList($id);
		
		$Page       = new \Think\Page($count,20);
        $show       = $Page->show();
        $this->assign('page', $show);

        $this->assign('export', 0);
		$this->assign('submitList',$unSubmitList);
		$this->assign('id',$id);
		$this->display();
	}


    /**
     * 导出到excel
     * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-11-12 15:00Authors
	 * @var  
	 * @return 
     */
    public function export($type,$id) {

		$SUBMIT = M('ExamSubmit');

        // 查询条件
        $college = D('Adminer')->getCollege();
        $map = array();

        if (!is_null($college)) {
            $map['academy'] = $college;
        }

        $title = array( '姓名', '班级', '学号','正确数');
        $filename  = is_null($college) ? '浙江工商大学' : $college;

        if($type == 1) {
            $map['type'] = 1;
            $list = $SUBMIT->where(array('examid'=>$id))->select();
            $filename .= '新生入学考试平台注册用户';
        } else {
            $map['type'] = 0;
            $list = M('StudentList')->where($map)->field('id,academy,class,number,name')->select();
            $filename .= '新生入学考试平台未注册用户';
        }

        $this->excel($list, $title, $filename);
    }



}