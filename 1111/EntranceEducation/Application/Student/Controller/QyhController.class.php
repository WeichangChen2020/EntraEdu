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
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize = 3145728 ;// 设置附件上传大小
		$upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath = './public/'; // 设置附件上传根目录
		$upload->savePath = './homework/homework'.'1'.'/'; // 设置附件上传（子）目录
		// 上传文件
		$info = $upload->upload();
		if(!$info) 
		{// 上传错误提示错误信息
			$this->error($upload->getError());
		}else{// 上传成功
			$this->success('上传成功！');
		}

		// $domain       = 'public';
  //       $dir          = './homework/homework'.'1'.'/';
		// $saes = new \SaeStorage();
		// $url = $saes->write( $domain , $dir.$filename , $output );
	}




}

?>