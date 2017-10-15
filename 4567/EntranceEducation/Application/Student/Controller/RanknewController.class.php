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

        $openId   = session('openId');  

        if (IS_AJAX) {
            if(session('?start')){
                $start = session('start');
                session('start',parseInt($start) + 20);
            } else {
                session('start',0);
                $start = 0;
            }
            $rankList    = D('exercise')->getRankList($start);

            dump($rankList);
            $this->ajaxReturn($rankList, 'json');

        } else {
            // dump($openId);
            $rankList = D('exercise')->getRankList();
            // $me = array();
        //     获取"我的成绩与排名"
        //     foreach($rankList as $key=>$value){
        //      if ($value['openid']==$openId) {
        //        $me['rank'] = $key +1;
        //        $me['grade'] = $value['sum(result)'];
        //        break;
        //      }
        // }
            foreach($rankList as $key=>$value){

              $rankList[$key]['info']=M('studentInfo')->where(array('openId' => $value['openid']))->find();
        }
        // dump($rankList);

            $this->assign('length',COUNT($rankList));
        // $this->assign('me',$me);
        $this->assign('rankList',$rankList);
        $this->display();

      }

        }



}