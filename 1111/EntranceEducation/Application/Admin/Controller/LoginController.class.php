<?php
namespace Admin\Controller;

use Think\Controller;
class LoginController extends Controller
{
    public function index()
    {
        $Profile = M('Profile');
        $list = $Profile->select();
        $this->assign('attributes',$list);
        $this->display();
    }

    public function checklogin()
    {
        $username = I('post.username');
        $password = I('post.password');
        $member = D('teacher_info');
        $result = $member->where("name='%s' AND password='%s'", $username, $password)->find();
        
         $Profile = M('Profile');
       	 $list = $Profile->select();
        
        if ($result || ($username == $list[2]['value'] && $password == $list[3]['value'])) {
            $_SESSION['username'] =  $username;
            $_SESSION['nickname'] = $password;
            $_SESSION['type'] = ($result)? $result['type']:1;
            $this->success('登陆成功', U('Index/index'), 3);
        } else {  
            $this->error('登陆失败');
        }
    }
    
    public function logout()
    {
        session(null);
        $this->success('欢迎再来', U('/'), 3);
    }
}