<?php


namespace Student\Controller;
use Think\Controller;
use Think\Model;

class RandomController extends Controller {
	public function index(){
		//session('openId',null);
        $openId=session('openId');
        session('openId',$openId);
		//$openId = session('account');//I('openId');
		// session('openId',$openId);
		//var_dump($_SESSION);
		//echo $openId;
		$this->display();
	}
	public function random(){
		/*=========定义变量=======*/
		$QUESTION = M('question');
		$RECORD = M('random_answer_record');
		//$COMMENT = D('Student/RandomComment');
		//$REPLY = D('Student/RandomReply');
		
		$openid = session('?openId')? session('openId'): $this->error('由于某种原因，您的某些关键数据丢失，请在微信端发送0重新授权登录,然后再获取该链接');
		//echo $openid;	
		/*======获取答题数量======*/
			
		$itemnum  =   $QUESTION->count(); //
		
		/*======读取随机试题======*/
		$chapter = I('chapter');
		if($chapter){
			$count = $QUESTION->where('chapter="'.$chapter.'"')->count();
			$min = $QUESTION->where('chapter="'.$chapter.'"')->min('id');		
		}else{
			$count = $QUESTION->count();
			$min = $QUESTION->min('id');		
		}
		$pro_id = rand($min,$min+$count-1);
		//echo $pro_id;
		$item  = $QUESTION->where("id=".$pro_id)->find();
		 

		// var_dump($item);	

		/*=======答题情况==========*/
		$answerNum = $RECORD->where('openId="'.$openid.'"')->count();
		$answerRightNum = $RECORD->where('openId="'.$openid.'" AND answerResult = "RIGHT"' )->count();
		$answerRecord = array(
			'answerNum' => $answerNum, 
			'answerRightNum' => $answerRightNum,
			'questionItem' => $answerNum + 1, 
			);
		//var_dump($answerRecord);

		/*=========评论数量=======*/
		// $commentNum = $COMMENT->where('questionId="'.$item['id'].'"')->count();
		// $replyNum = $REPLY->where('questionId="'.$item['id'].'"')->count();
		// $sumNum = $commentNum + $replyNum;

		/*======将题目分配到html页面中=====*/
		$this->assign('item',$item);
		$this->assign('enterTime',time());
		$this->assign('openid',$openid);
		$this->assign('itemid',$item['id']);
		$this->assign('answerRecord',$answerRecord);
		//$this->assign('sumNum',$sumNum);
		$type = $QUESTION->where("id=".$pro_id)->getField('type');//单选多选和判断？
		//echo $type;
		session('type',$type);
		if ($type=='2') {
			$this->display('randomMultiple');
		}elseif ($type=='3') {
			$this->display('randomJudge');
		}else{
			$this->display();
			//$this->display('randomMultiple');
			//$this->display('randomJudge');
		}
		
    }


    public function getRightAns(){
		/*=========判断是否通过ajax方式传输数据=======*/
		//var_dump(23333);
		// echo 2333;
		// die();
		if(IS_AJAX){
			
			/*=========定义变量=======*/
            $itemid   = I('post.itemid');
            $openid   = I('post.openid');
            //$answer   = I('post.answer');
            $enterTime = I('enterTime');
            $leaveTime = time();
			$QUESTION = M('question');
			$RECORD = M('random_answer_record');
			$type=session('type');
			//echo $type;
			if ($type == '2') {
				$answer1 = I('post.answer1');
				$answer2 = I('post.answer2');
				$answer3 = I('post.answer3');
				$answer4 = I('post.answer4');
				$answer = $answer1.$answer2.$answer3.$answer4;
				//echo $answer;
			}else{
				$answer  = I('post.answer');
			}
			/*=======获取正确答案=======*/	
			$ajaxreturn['rightAnswer']     = $QUESTION->where("id=".$itemid)->getField("rightAnswer");
			$ajaxreturn['analysisPicPath'] = $QUESTION->where("id=".$itemid)->getField("analysisPicPath");
			$ajaxreturn['analysisPicName'] = $QUESTION->where("id=".$itemid)->getField("analysisPicName");
			//var_dump($ajaxreturn);

			/*=======记录答题情况=====*/
			$this->recordOption($answer,$openid,$itemid,$enterTime,$leaveTime,$ajaxreturn['rightAnswer']);
		
			/*========获取各个选项的数量*/			
			// $ajaxreturn['opANum'] = $RECORD->where('questionId="'.$itemid.'" AND answer="A"')->count();
			// $ajaxreturn['opBNum'] = $RECORD->where('questionId="'.$itemid.'" AND answer="B"')->count();
			// $ajaxreturn['opCNum'] = $RECORD->where('questionId="'.$itemid.'" AND answer="C"')->count();
			// $ajaxreturn['opDNum'] = $RECORD->where('questionId="'.$itemid.'" AND answer="D"')->count();
			// $ajaxreturn['opAllNum'] = $RECORD->where('questionId="'.$itemid.'" ')->count();
			// $ajaxreturn['opANum'] = "A选项的数量";
			
			/*====返回答案解析到前台==*/
			$this->ajaxReturn($ajaxreturn);     
        }else 
			$this->ajaxReturn('非法的请求方式'); 	
	}

	public function recordOption($answer,$openid,$itemid,$enterTime,$leaveTime,$rightans){
		/*==========定义变量=============*/
		$ANSWER = M('random_answer_record');
		$QUESTION = M('question');
		$DOER = M('student_info');
		$name = $DOER->where('openId="'.$openid.'"')->getField('name');
		$class = $DOER->where('openId="'.$openid.'"')->getField('class');
		$questionType = $QUESTION->where('id="'.$itemid.'"')->getField('chapter');
		$answerResult = $answer == $rightans? "RIGHT" : "WRONG" ;//多选题如何比较？？
		$answerTimeSecond = $leaveTime - $enterTime;    //回答时间的秒数int型
		$answerTime = (ceil($answerTimeSecond / 60)-1).'分'.($answerTimeSecond % 60).'秒';
		/*=======构造插入数据库答题信息数组======*/
		$record = array(
			'openId' => $openid, 
			'name' => $name,
			'class' => $class,
			'questionId' => $itemid,
			'questionType' => $questionType,
			'answer' => $answer,
			'rightAnswer' => $rightans,
			'answerResult' => $answerResult,
			'enterPageTime' => date("Y-m-d H:i:s",$enterTime),
			'leavePageTime' => date("Y-m-d H:i:s",$leaveTime),
			'answerTime' => $answerTime,
		);
		//var_dump($record);
		//die();
		$ANSWER->data($record)->add();
		//$ANSWER -> add($record);

		//如果回答错误，并且表里没有这题，把答题信息记录到错题回顾表
		$WRONG = M('wrong_review_record');
		$exsit_wrong = $WRONG->where(array('openId' => $openid , 'questionId' => $itemid))->find();
		if ($answerResult == "WRONG" && !$exsit_wrong) {
			
			$WRONG->data($record)->add();
		}

	}

	public function collect(){
		/*==========定义变量=============*/
        $itemid   = I('post.itemid');
        $openid   = I('post.openid');
        //$answer   = I('post.answer');
        $enterTime = I('enterTime');
        if ($type == '2') {
			$answer1 = I('post.answer1');
			$answer2 = I('post.answer2');
			$answer3 = I('post.answer3');
			$answer4 = I('post.answer4');
			$answer = $answer1.$answer2.$answer3.$answer4;
				//echo $answer;
		}else{
			$answer  = I('post.answer');
		}
        $leaveTime = time();
		$ANSWER = M('collect_record');
		$QUESTION = M('question');
		$DOER = M('student_info');
		$name = $DOER->where('openId="'.$openid.'"')->getField('name');
		$class = $DOER->where('openId="'.$openid.'"')->getField('class');
		$questionType = $QUESTION->where('id="'.$itemid.'"')->getField('chapter');
		$rightans = $QUESTION->where("id=".$itemid)->getField("rightAnswer");
		$answerResult = $answer == $rightans? "RIGHT" : "WRONG" ;//多选题如何比较？？
		$answerTimeSecond = $leaveTime - $enterTime;    //回答时间的秒数int型
		$answerTime = (ceil($answerTimeSecond / 60)-1).'分'.($answerTimeSecond % 60).'秒';
		/*=======构造插入数据库答题信息数组======*/
		$record = array(
			'openId' => $openid, 
			'name' => $name,
			'class' => $class,
			'questionId' => $itemid,
			'questionType' => $questionType,
			'answer' => $answer,
			'rightAnswer' => $rightans,
			'answerResult' => $answerResult,
			'enterPageTime' => date("Y-m-d H:i:s",$enterTime),
			'leavePageTime' => date("Y-m-d H:i:s",$leaveTime),
			'answerTime' => $answerTime,
		);
		//var_dump($record);
		//die();
		$exsit = $ANSWER->where(array('openId' => $openid , 'questionId' => $itemid))->find();
		if (!$exsit) { //如果没有收藏过才插入表中
			$ANSWER->data($record)->add();
		}
		
		//$ANSWER -> add($record);

	}

	public function commentArea(){
		/*======定义一些变量=======*/
		$openId = session('?openId')? session('openId'): $this->error('由于某种原因，您的某些关键数据丢失，请在微信端发送0重新授权登录,然后再获取该链接');
		$questionId = I('questionItem');
		$COMMENT = D('RandomComment');
		$REPLY = D('RandomReply');
		$comment = $COMMENT->where('questionId="'.$questionId.'"')->select();
		$reply = $REPLY->where('questionId="'.$questionId.'"')->select();
		//var_dump($comment);
		//var_dump($reply);
		//die();
		$this->assign('comment',$comment);
		$this->assign('reply',$reply);
		$this->display();
	}

	public function handComment(){
		/*=======定义一些原始变量======*/
		if(!IS_AJAX)
			$this->error('你访问的页面不存在！');
		$openId = session('?openId')? session('openId'): $this->error('由于某种原因，您的某些关键数据丢失，请在微信端发送0重新授权登录,然后再获取该链接');
		$questionId = I('questionId');
		$comment = I('comment');
		$STU = D('StudentInfo');
		$COMMENT = D('RandomComment');

		$name = $STU->getName($openId);
		$class = $STU->getClass($openId);
		//echo $name;
		//die();
		/*====定义储存数据数组=======*/
		$comment = array(
				'openId'     => $openId,
				'name'       => $name,
				'class'      => $class,
				'questionId' => $questionId,
				'comment'    => $comment,
				'time'       => date("Y-m-d H-i-s")   
				);
		/*=======将数据存入数据库======*/
		if($COMMENT->data($comment)->add())
        	$this->ajaxReturn(array('status' => 'success'),'json');
        else
        	$this->ajaxReturn(array('status' => 'failure'),'json');
	}

	public function reply(){
		/*======定义初始变量======*/
		$openId = session('?openId')? session('openId'): $this->error('由于某种原因，您的某些关键数据丢失，请在微信端发送0重新授权登录,然后再获取该链接');
		$commentId = I('commentId');
		$commentInfo = D('RandomComment')->where('id="'.$commentId.'"')->find();
		$this->assign('commentId',$commentId);
		$this->assign('commentInfo',$commentInfo);
		$this->display();
	}

	public function handReply(){
		/*if(!IS_AJAX)
			$this->error('你访问的页面不存在！');*/

		/*=======定义一些原始变量======*/
		$openId = session('?openId')? session('openId'): $this->error('由于某种原因，您的某些关键数据丢失，请在微信端发送0重新授权登录,然后再获取该链接');
		$commentId = I('commentId');
		$replyContent = I('reply');
		$STU = D('StudentInfo');
		$COMMENT = D('RandomComment');
		$REPLY = D('RandomReply');
		$author = $COMMENT->getName($commentId);         //评论的那个人
		$name = $STU->getName($openId);           //回复的那个人
		$class = $STU->getClass($openId);
		$questionId = $COMMENT->getQuestionId($commentId);
		/*====定义储存数据数组=======*/
		$reply = array(
				'openId'      => $openId,
				'name'        => $name,
				'class'       => $class,
				'questionId'  => $questionId,
				'commentId'   => $commentId,
				'replyContent'=> $replyContent,
				'time'        => date("Y-m-d H-i-s")   
		);
        // $this->ajaxReturn($reply,'json');
		//print_r($reply);
		//die();
		/*=======将数据存入数据库======*/
		if($REPLY->data($reply)->add()){
        	$this->ajaxReturn(array('status' => 'success'),'json');
		}else{
        	$this->ajaxReturn(array('status' => 'failure'),'json');
        }
	}
}