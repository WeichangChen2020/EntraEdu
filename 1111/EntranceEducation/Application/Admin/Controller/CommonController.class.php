<?php
namespace Admin\Controller;

use Think\Controller;
class CommonController extends Controller
{
    function _initialize()
    {
        $Profile = M('Profile');
        $list = $Profile->select();
       
        
        $member = D('teacher_info');
        $arr = $member->where("name = '%s'", $_SESSION['username'])->find();
        
        $isAdminer = ( $_SESSION['username'] == $list['管理账户名'])? true:false;
        if ($_SESSION['username'] == "" || $arr == null) {
            $this->error('请登录！', U('Login/index'), 3);
        }
        
        $this->assign('attributes',$list);
      
    }
   
}