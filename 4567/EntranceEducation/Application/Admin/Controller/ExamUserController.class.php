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

	// /**
	//  * detail 模拟考试详细信息 提交人员详情
	//  * @author 陈伟昌<1339849378@qq.com>
	//  * @copyright  2017-11-7 15:12Authors
	//  * @var  
	//  * @return 
	//  */

	// public function detail($id = 0) {

	// 	$SUBMIT = M('ExamSubmit');

	// 	$submitList = $SUBMIT->where(array('examid'=>$id))->select();
	// 	$this->assign('submitList',$submitList);
	// 	$this->assign('id',$id);
	// 	$this->display();
	// }


	// /**
	//  * unSubmit 模拟考试详细信息 未提交人员详情
	//  * @author 陈伟昌<1339849378@qq.com>
	//  * @copyright  2017-11-7 15:50Authors
	//  * @var  
	//  * @return 
	//  */

	// public function unSubmit($id = 0) {

	// 	$STUDENT = M('ExamSubmit');

	// 	$unSubmitList = $STUDENT->getUnsubmitList();
	// 	// $this->assign('submitList',$unSubmitList);
	// 	// $this->assign('id',$id);
	// 	// $this->display('detail');
	// }





}