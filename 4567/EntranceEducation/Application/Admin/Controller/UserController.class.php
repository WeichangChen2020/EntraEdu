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
       
        $this->display();
    }

    // 未注册名单
    public function unRegister() {

        
        
        $this->assign('userList',$list);

        $Page       = new \Think\Page($count,20);
        $show       = $Page->show();
        $this->assign('page', $show);
       
        $this->display();
    }
    
    public function update() {

        // 注册用户
        $Student = M('StudentInfo');

        $list = $Student->where(array('is_newer'=>1))->select();

        foreach ($list as $key => $value) {
            $map = array(
                'number'=> $value['number'],
            );
            M('StudentList')-> where($map)->setField('type', 1);
        }
        
        
    }



}