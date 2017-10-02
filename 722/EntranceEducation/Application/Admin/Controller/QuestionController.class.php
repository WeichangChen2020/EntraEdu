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
            $data = I();
            foreach ($data as $key => $value) {
                $quesData = array();
                $quesData['examid'] = $id;
                $quesData['chapid'] = intval(substr($key, 8));
                $quesData['chap_num'] = intval($value);
                D('ExamQuestionbank')->add($quesData);
            }
            $this->success('题目添加成功', U('Exam/index'));
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