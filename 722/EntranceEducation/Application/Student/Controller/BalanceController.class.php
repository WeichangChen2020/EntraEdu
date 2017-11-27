<?php

namespace Student\Controller;
use Think\Controller;
use Think\Model;
  

// 负载均衡
class BalanceController extends Controller{


	// 负载均衡方法
	public function balance($openid = '') {

		$college = M('student_info')->where(array('openId'=>$openid))->getField('academy');

		$url = array(

			'管理学院'    => 'http://722.adsweixin.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'人文学院'    => 'http://722.adsweixin.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'外国语学院'  =>'http://722.adsweixin.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'工商学院'    =>'http://722.adsweixin.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,


			'管工学院'    =>'http://722.testet.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'管电学院'    =>'http://722.testet.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'信息学院'    =>'http://722.testet.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'统计学院'    =>'http://722.testet.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,

			'马克思学院'  =>'http://722.classtest.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'信电学院'    =>'http://722.classtest.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'财会学院'    =>'http://722.classtest.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,


			'环境学院'    =>'http://722.dataplatform.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'食品学院'    =>'http://722.dataplatform.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'经济学院'    =>'http://722.dataplatform.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,

			'东语学院'    =>'http://722.testtest11.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'法学院'      =>'http://722.testtest11.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'旅游学院'    =>'http://722.testtest11.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,

			'公管学院'    =>'http://newer.gailvlunpt.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'艺术学院'    =>'http://newer.gailvlunpt.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'金融学院'    =>'http://722.cprogramplatform.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,

			'非新生'      =>'http://722.cprogramplatform.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			
		);


		header("location: ".$url[$college]);
	} 


	// 用户测试负载均衡 去了哪些链接
	public function test() {

		$openid = 'ohd41t3hENwHiNZTFBlbsUaB-gGw';
		$url = array(

			'管理学院'    => 'http://722.adsweixin.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'人文学院'    => 'http://722.adsweixin.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'外国语学院'  =>'http://722.adsweixin.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'工商学院'    =>'http://722.adsweixin.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,


			'管工学院'    =>'http://722.testet.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'管电学院'    =>'http://722.testet.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'信息学院'    =>'http://722.testet.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'统计学院'    =>'http://722.testet.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,

			'马克思学院'  =>'http://722.classtest.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'信电学院'    =>'http://722.classtest.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'财会学院'    =>'http://722.classtest.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,


			'环境学院'    =>'http://722.dataplatform.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'食品学院'    =>'http://722.dataplatform.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'经济学院'    =>'http://722.dataplatform.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,

			'东语学院'    =>'http://722.testtest11.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'法学院'      =>'http://722.testtest11.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'旅游学院'    =>'http://722.testtest11.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,

			'公管学院'    =>'http://newer.gailvlunpt.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'艺术学院'    =>'http://newer.gailvlunpt.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			'金融学院'    =>'http://722.cprogramplatform.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,

			'非新生'      =>'http://722.cprogramplatform.sinaapp.com/EntranceEducation/index.php/User/index/openId/'.$openid,
			
		);

		var_dump($url);
	}

}