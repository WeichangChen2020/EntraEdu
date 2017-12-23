<?php
namespace Admin\Controller;
use Think\Controller;
class ProfileController extends CommonController {
    
    public function index(){

        $Question = M('Profile');
        $list = $Question->select();
        $this->assign('profileList',$list);

        $this->display();
    }

    //题目修改界面
    public function edit($id){
        if (IS_POST) {
        	$QUESTION = M('Profile');
            $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
            // dump($data);
            if ($QUESTION->where(array('id' => $id))->save($data))
	            $this->success('题目修改成功', U('Question/index'));
            else
            	$this->error('修改失败');
        } else {
            $profile = M('Profile')->where(array('id'=>$id))->find();
            // dump($question);
            $this->assign('profile',$profile);
            $this->display();
        }
    }
 
}