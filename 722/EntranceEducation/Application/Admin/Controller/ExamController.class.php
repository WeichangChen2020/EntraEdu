<?php 
namespace Admin\Controller;
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

		$examList = D('ExamSetup')->select();
		// p($examList);
		$this->assign('examList', $examList);
		$this->display();
	}


	/**
	 * add 创建新生考试
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-15 21:18Authors
	 * @var  
	 * @return 
	 */
	public function add() {
		if (IS_POST) {
			
			$st = I('start_time');
			$st = str_replace('T', ' ', $st).':00';

			$data = array(
				'title' => I('title'),
				'start_time' => strtotime($st),
				'set_time' => I('spend_time'),
				'is_on' => intval(I('is_on')),
				'time' => date('Y-m-d H:i:s'),
			);

			$collegeArr = explode(',', I('colleges'));	
			$res = D('ExamSetup')->add($data);
			if($res) {
				foreach ($collegeArr as $key => $value) {
					$collegeData = array(
						'examid' => $res,
						'college' => $value,
					);
					D('ExamCollege')->add($collegeData);
				}
				$this->success('考试创建成功', U('Exam/index'));
			} else {
				$this->error('考试创建失败');
			}

		} else {
			
			$this->display();
		}
	}

	/**
	 * delete 创建新生考试
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-15 21:18Authors
	 * @var  
	 * @return 
	 */
	public function delete($id = 0) {

		$res = M('exam_setup')->where(array('id' => $id))->delete();

		if($res) {
			$this->success('删除成功', U('Exam/index'));
		} else {
			$this->success('删除失败', U('Exam/index'));
		}
	}

	/**
	 * edit 设置考试信息
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-9-16 11:12Authors
	 * @var  $id
	 * @return 
	 */
	public function edit($id = 0) {

		$info = M('ExamSetup')->find($id);
		$this->assign('info',$info)->display();
	}


	public function addQues() {
		$this->display();
	}



}