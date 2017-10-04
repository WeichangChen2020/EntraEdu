<?php
namespace Admin\Controller;
use Think\Controller;
class QuestionController extends Controller {
    public function index(){
        $QUESTION = M('Questionbank')->select();
        $this->assign('questionList',$QUESTION);
        $this->display();
    }
    public function edit($id){
        if (IS_POST) {
        	$questionbank = M('questionbank');
            $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
            // dump($data);
            $questionbank->where(array('id' => $id))->save($data);
            $this->success('题目修改成功', U('Question/index'));
        } else {
            $question = M('Questionbank')->where(array('id'=>$id))->find();
            // dump($question);
            $this->assign('question',$question);
            $this->display();
        }
    }
    public function delete($id){
        $QUESTION = M('Questionbank')->select();
        $this->assign('questionList',$QUESTION);
        $this->display();
    }
}