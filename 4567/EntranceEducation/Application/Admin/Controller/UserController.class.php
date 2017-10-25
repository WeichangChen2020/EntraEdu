<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends CommonController {
    
    // 用户列表
    public function index(){

        $Student = M('StudentInfo');

        // 查询条件
        $college = D('Adminer')->getCollege();
        $map = array();

        if (!is_null($college)) {
            $map['academy'] = $college;
        }

        $list = $Student->where($map)->page($_GET['p'].',20')->select();
        $count = $Student->where($map)->count();
        
        $this->assign('userList',$list);

        $Page       = new \Think\Page($count,20);
        $show       = $Page->show();
        $this->assign('page', $show);

        // 注册数量和未注册数量和导出
        $num = D('StudentList')->getStudentNum();
        $this->assign('num', $num);
        $this->assign('export', 1);

       
        $this->display();
    }

    // 未注册名单，思路就是注册的时候去List表里的type设置为1，然后去List读取那些为0的用户
    public function unRegister() {

        // 查询条件
        $college = D('Adminer')->getCollege();
        $map['type'] = 0;

        if (!is_null($college)) {
            $map['academy'] = $college;
        }

        $list = M('StudentList')->where($map)->page($_GET['p'].',20')->select();
        $count = M('StudentList')->where($map)->count();

        $this->assign('userList',$list);

        $Page       = new \Think\Page($count,20);
        $show       = $Page->show();
        $this->assign('page', $show);

        // 注册数量和未注册数量
        $num = D('StudentList')->getStudentNum();
        $this->assign('num', $num);
        $this->assign('export', 0);

       
        // $this->display('index');
        

    }

    
    public function export($type) {


    }



}