<?php
namespace Admin\Controller;
use Think\Controller;
class UnitController extends CommonController {
    
    public function index(){

        $Chapter = M('Question_chapter');
        $list = $Chapter->select();
        $this->assign('chapterList',$list);
       
        $this->display();
    }
    public function lists($chapterid){

        $Question = M('Questionbank');
        $list = $Question->where(array('chapter'=> $chapter))->page($_GET['p'].',20')->select();
        $this->assign('questionList',$list);

        $count      = $Question->where(array('chapter'=> $chapter))->count();
        $this->assign('count', $count);
        $Page       = new \Think\Page($count,20);
        $show       = $Page->show();
        $this->assign('page',$show);
       
        $this->display();
    }
	public function addChapter(){
    }
    public function editChapter($chapterid){
    	 if (IS_POST) {
        	$QUESTION = M('Question_chapter');
            $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
          
            // dump($data);
            if ($QUESTION->where(array('id' => $chapterid))->save($data))
	            $this->success('题目修改成功', U('Unit/index'));
            else
            	$this->error('修改失败');
        } else {
            $question = M('Question_chapter')->where(array('id'=>$id))->find();
            // dump($question);
            $this->assign('question',$question);
            $this->display();
        }
    }
    public function deleteChapter($chapterid){
    }
    //题目修改界面
    public function edit($id){
        if (IS_POST) {
        	$QUESTION = M('questionbank');
            $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
          
            // dump($data);
            if ($QUESTION->where(array('id' => $id))->save($data))
	            $this->success('题目修改成功', U('Unit/index'));
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
    	
	        $QUESTION = M('Questionbank');
	        $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
            if (!empty($data['search']))
            	$map['contents|option_a|option_b|option_c|option_d|analysis'] = array('like','%'.$data['search'].'%','OR');
	        $result = $QUESTION ->where($map) ->page($_GET['p'].',20')->select();
	        $this->assign('questionList',$result);
            $this->assign('search',$data['search']);
            
            $count      =  $QUESTION->where($map)->count();
        	
        	$this->assign('count', $count);
        	$Page       = new \Think\Page($count,20);
        	$show       = $Page->show();
        	$this->assign('page',$show);
       		
            $this->display();
    
    	
    }
}