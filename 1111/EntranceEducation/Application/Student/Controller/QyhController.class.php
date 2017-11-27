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
            'maxSize' => 3145728,
            'exts'=>array('jpg', 'gif', 'png', 'jpeg'),
            'rootPath'=>'/public/', //文件在本地调试时上传的目录，其实也等同于public的domain下的Uploads文件夹
            'savePath'=>'./homework/homework'.'1'.'/',
            'autoSub'=>false  
        );
		$upload = new \Think\Upload($config,'sae');// 实例化上传类
		
		

		// 上传文件
		$info = $upload->upload($_FILES['photo']);
		if(!$info) 
		{// 上传错误提示错误信息
			$this->error($upload->getError());
		}else{// 上传成功
			$this->success('上传成功！');
		}

		// $domain       = 'public';
  //       $dir          = './homework/homework'.'1'.'/';
		 // $saes = new \SaeStorage();
		 // $saes->upload('public',$name,$_FILES['file']['tmp_name']);

		// $url = $saes->write( $domain , $dir.$filename , $output );
	}




}

?>