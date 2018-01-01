<?php
namespace Admin\Controller;
use Think\Controller;
class ClassController extends CommonController {
     function _initialize()
    {
       if($_SESSION['type'] != 1)  $this->error('无权限进行此操作');
    }
    public function index(){
		
        
        $Info = M('teacher_class');
        $list = $Info->select();
        $this->assign('classList',$list);
		
        $T = M('teacher_info');
        $t = $T->field('name');
        $this->assign('teacherList',$T);
        $this->display();
    }
	 public function addClass(){
    	if (IS_POST) {
	        $QUESTION = M('teacher_class');
	        $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
	        if ($QUESTION->add($data))
	        	$this->success('添加成功',U('Class/index'));
	        else
	        	$this->error('添加失败');
    	}else{
            $Adminer = M('adminer');
            $ads = $Adminer->field('nickname')->select();
            $this->assign('adminerList',$ads);
            $this->display();
        }
    }
	 public function addTeacher(){
    	if (IS_POST) {
	        $QUESTION = M('adminer');
	        $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
	        if ($QUESTION->add($data))
	        	$this->success('添加成功',U('Class/index'));
	        else
	        	$this->error('添加失败');
    	}else{
            $this->display();
        }
    }
    //题目修改界面
    public function edit($id){
        if (IS_POST) {
        	 $Info = M('student_info');
            $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
            // dump($data);
            if ($QUESTION->where(array('id' => $id))->save($data))
	            $this->success('题目修改成功', U('Question/index'));
            else
            	$this->error('修改失败');
        } else {
            $question = M('Questionbank')->where(array('id'=>$id))->find();
            // dump($question);
            $this->assign('question',$question);
            $this->display();
        }
    }
    //增加题目
    public function add(){
    	if (IS_POST) {
	        $QUESTION = M('Questionbank');
	        $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
	        if ($QUESTION->add($data))
	        	$this->success('题目添加成功',U('Question/add'));
	        else
	        	$this->error('添加失败');
    	}
    	$this->display();
    }

    //删除题目
    public function delete($id){
        $QUESTION = M('Questionbank');
        $QUESTION->where(array('id' => $id))->delete();
        $this->success('题目删除成功', U('Question/index'));
    }

    //搜索题目
    //搜索条件为空则显示全部，搜索结果返回到result数组
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
            $this->assign('data',$data);
    	}

    	$this->display();
    }
}