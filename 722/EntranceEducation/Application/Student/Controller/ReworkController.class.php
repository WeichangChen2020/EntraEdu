<?php 
namespace Student\Controller;
use Think\Controller;

class ReworkController extends Controller{
	
	public function index() {

		$openid = session('openId');
		// echo $openid;
		$this->assign('openId',$openid);
		$this->display();
	}

	public function chose(){

		$openId = session('openId');
		$QUESTION= M('questionbank');
		$MISTAKE = D('MistakeHistory');
		$quesid = $MISTAKE->getMistakeRand($openId);
		$ques = $QUESTION->where(array('id'=>$quesid))->find();
		$num = $MISTAKE->getMistakeNum($openId);
		$quesid = $MISTAKE->getMistakeData($openId);
		session('quesid',$quesid);
		$name = M('StudentInfo')->where('openId="'.$openId.'"')->getField('name');
		$ques['chapter'] = getChapterName($ques['chapter']);
		$ques['type'] = get_ques_type($ques['type']);

		$this->assign('num',$num);
		$this->assign('name',$name);
		$this->assign('quesid',$quesid);
		$this->assign('ques',$ques);
		$this->assign('openId',$openId);
		if ($num == 0) {
			$this->display('tip');
			return false;
		}
		if ($ques) {
			if ($ques['type'] == '单选题') {
				$this->display('chose');
			} else if ($ques['type'] == '判断题') {
				$this->display('judge');
			} else if ($ques['type'] == '多选题') {
				$this->display('mutil');
			} else {
				dump('该题题目有错，请联系管理员');
			}
		} else {
			$this->display('tip');
		}

	}
	public function submit() {
		if (!IS_AJAX) {
			$this->error('您访问的页面不存在');
		}
		$openid       = session('openId');
		$quesid       = session('quesid');
		// $data         = M('MistakeHistory')->where(array('openid'=>$openid,'quesid'=>$quesid));
		$option       = trim(I('option'));
		$time     = I('time');
		$right_answer = trim(D('Questionbank')->getRightAnswer($quesid));
		$data = array(	
			'openid' => $openid,
			'quesid' => $quesid,
			'answer' => $option,
			'result' => $option == $right_answer ? 1 : 0,
			'spend'  => $time,
			'time'   => date('Y-m-d:H:i:s', time())
		);


		M('MistakeHistory')->where(array('openid'=>$openid,'quesid' => $quesid))->save($data);

		$this->ajaxReturn($right_answer, 'json');
	}
	public function test(){


		$openId = session('openId');
		$QUESTION= M('questionbank');
		$MISTAKE = D('MistakeHistory');
		$quesid = $MISTAKE->getMistakeRand($openId);
		$ques = $QUESTION->where(array('id'=>$quesid))->find();
		$num = $MISTAKE->getMistakeNum($openId);
		$quesid = $MISTAKE->getMistakeData($openId);
		session('quesid',$quesid);
		$name = M('StudentInfo')->where('openId="'.$openId.'"')->getField('name');
		$ques['chapter'] = getChapterName($ques['chapter']);
		$ques['type'] = get_ques_type($ques['type']);
		dump($MISTAKE->where(array('openid'=>$openiId,'result'=>0))->order('rand()')->limit(1)->select());die;

		$this->assign('num',$num);
		$this->assign('name',$name);
		$this->assign('quesid',$quesid);
		$this->assign('ques',$ques);
		$this->assign('openId',$openId);
		if ($num == 0) {
			$this->display('tip');
			return false;
		}
		if ($ques) {
			if ($ques['type'] == '单选题') {
				$this->display('chose');
			} else if ($ques['type'] == '判断题') {
				$this->display('judge');
			} else if ($ques['type'] == '多选题') {
				$this->display('mutil');
			} else {
				dump('该题题目有错，请联系管理员');
			}
		} else {
			$this->display('tip');
		}
        // $EXERCISE = M('Exercise');
        // $HISTORY = M('MistakeHistory');
        // $mistake = $EXERCISE->where(array('result'=>0))->limit('0,10000')->select();
        // foreach ($mistake as $key => $value) {
        //     $final = $HISTORY
        //         ->where(
        //             array('result'=>1,
        //                 'openid'=>$value['openid'],
        //                 'quesid'=>$value['quesid']))
        //         ->find();
        //         unset($value['id']);
        //     if($final == NULL){
                
        //     dump($HISTORY->add($value));
        //     }
                
        // }
        // dump('0');
		// $num = $EXERCISE->where(array('result'=>0))->count();
		// dump($num);die;

	}
	public function del(){

        $HISTORY = M('MistakeHistory');
        $mistake = $HISTORY->where(array('result'=>1))->limit('0,5000')->select();
        foreach ($mistake as $key => $value) {
            $final = $HISTORY
                ->where(
                    array('result'=>1,
                        'openid'=>$value['openid'],
                        'quesid'=>$value['quesid']))
                ->find();
            // dump($final);
            if($final != NULL)
                $HISTORY->where(array('id'=>$value['id']))->delete();
        }
        dump($mistake['0']);
        // $mistake = $HISTORY->where(array('openid'=>'ohd41tw4FlskmDIvtn9fIYnOpGf8','quesid'=>29,'result'=>0))->find();
        // $final = $HISTORY->where(array('openid'=>'ohd41tw4FlskmDIvtn9fIYnOpGf8','quesid'=>29,'result'=>1))->find();
        // dump($mistake);
        // dump($final == NULL);
        // dump($mistake);
//         delete from `ee_mistake_history` a
// where (a.openid,a.quesid,a.result) in (select openid,quesid,result from `ee_mistake_history` group by openid,quesid,result having count(*) > 1) 
// and id not in (select min(id) from `ee_mistake_history` group by  openid,quesid,result having count(*)>1) 
        die;

	}

}

 ?>