<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller {
    
    // 用户列表
    public function index(){

        $Question = M('StudentInfo');

        $college = D('Adminer')->getCollege();

        $list = $Question->where(array('college'=>$college))->page($_GET['p'].',20')->select();
        $this->assign('userList',$list);

        $Page       = new \Think\Page($count,20);
        $show       = $Page->show();
        $this->assign('page', $show);
       
        $this->display();
    }

}