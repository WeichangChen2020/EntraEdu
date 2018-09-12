<?php
namespace Admin\Controller;
use Think\Controller;
use sinacloud\sae\Storage as Storage;

//压缩图片
class TestController extends Controller {
	public function index()
	{
		$s = new Storage();
		// var_dump($s);
		// $list = $s->listBuckets(true);
		// var_dump($list);
		$limit = 30000;
		$list = $s->getBucket('collegephysics','','',$limit,'','');
		// echo "<pre>";
		// var_dump($list);

		foreach ($list as $v) {
			if($v['bytes'] == 0) continue;
			//进行压缩操作（下载，删除，压缩，上传）
			if($v['bytes'] > 1024000){

			}
		}
		
	}
}


?>