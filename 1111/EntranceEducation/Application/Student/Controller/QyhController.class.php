<?php
namespace Student\Controller;
use Think\Controller;
use Think\Model;

/**
* author: qyh
*/
class QyhController extends Controller
{	
	public function index()
	{
		$this->display();
	}

	public function upload()
	{
		$config = array(
            'maxSize' => 314572800,
            'exts'=>array('jpg', 'gif', 'png', 'jpeg'),
            'rootPath'=>'/public/', //文件在本地调试时上传的目录，其实也等同于public的domain下的Uploads文件夹
            'savePath'=>'./homework/homework'.'1'.'/',
            'autoSub'=>false
            // 'saveName'=>'qyhtest2'
        );
		$upload = new \Think\Upload($config,'sae');// 实例化上传类
		
		

		// 上传文件
		$info = $upload->upload();
		if(!$info) 
		{// 上传错误提示错误信息
			$this->error($upload->getError());
		}else{// 上传成功
			$STU          = D('StudentInfo');
        	$HOMEWORK     = M('student_homework');
        	$openId       = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        	$homeworkId   = session('?homeworkId') ? session('homeworkId') : $this->error('请重新获取改页面');
        	$cond         = array('openId' => $openId);
        	$stuInfo      = $STU->where($cond)->find();
        	$homeworkInfo = array(
            'openId'  => $openId,
            'name'    => $stuInfo['name'],
            'number'  => $stuInfo['number'],
            'class'   => $stuInfo['class'],
            'homeworkId' => $homeworkId,
            'correcter' => '未批改',
            'time'    => date('Y-m-d H:i:s',time()),
            );
        	$HOMEWORK->add($homeworkInfo);


			$this->success('上传成功！',U('Homework/index'));
		}


	}




}

?>