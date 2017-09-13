<?php


namespace Student\Controller;
use Think\Controller;
use Think\Model;

class RanknewController extends Controller {
	public function index(){

        $openId=session('openId');
        session('openId',$openId);

		$this->display('rankSchool');
	}
	public function rankSchool(){
        $openId = session('openId');  
        // dump($openId);
        $rankList = D('exercise')->getRankList();
        $me = array();
        foreach($rankList as $key=>$value){
        	if ($value['openid']==$openId) {
        		$me['rank'] = $key +1;
        		$me['grade'] = $value['sum(result)'];
        		continue;
        	}
		}
        foreach($rankList as $key=>$value){
        	if ($key == 10) {
        		break;
        	}
        	$rankList[$key]['info']=M('studentInfo')->where(array('openId' => $value['openid']))->find();
            if ($rankList[$key]['info']['class'] == null ) {
                $rankList[$key]['info']['class'] = "非新生用户！";
            }
		}
		// dump($rankList);

		$this->assign('me',$me);
		$this->assign('rankList',$rankList);
		$this->display();

	}


}