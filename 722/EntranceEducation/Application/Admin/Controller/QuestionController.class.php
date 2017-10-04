<?php
namespace Admin\Controller;
use Think\Controller;
class QuestionController extends Controller {
    public function index(){
        $QUESTION = M('Questionbank')->select();
        $this->assign('questionList',$QUESTION);
        $this->display();
    }

    //题目修改界面
    public function edit($id){
        if (IS_POST) {
        	$QUESTION = M('questionbank');
            $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
            // dump($data);
            $QUESTION->where(array('id' => $id))->save($data);
            $this->success('题目修改成功', U('Question/index'));
        } else {
            $question = M('Questionbank')->where(array('id'=>$id))->find();
            // dump($question);
            $this->assign('question',$question);
            $this->display();
        }
    }

    //删除题目
    public function delete($id){
        $QUESTION = M('Questionbank')->select();
        $QUESTION->where(array('id' => $id))->delete();
        $this->success('题目删除成功', U('Question/index'));
        $this->display();
    }

    //搜索题目
    public function search(){
    	if (IS_POST) {
	        $QUESTION = M('Questionbank');
	        $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
            if (!empty($data['id']))
            	$map['id'] = $data['id'];
            if (!empty($data['chapter']))
            	$map['chapter'] = $data['chapter'];
            if (!empty($data['type']))
            	$map['type'] = $data['type'];
            if (!empty($data['contents']))
            	$map['contents'] = array('like','%'.$data['contents'].'%','AND');
	        $result = $QUESTION -> where($map) ->select();
	        $this->assign('result',$result);
    	}

    	$this->display();
    }
}