<?php
// +----------------------------------------------------------------------
// | 概率论与数理统计教学互动平台
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://23.testet.sinaapp.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: lijj <hello_lijj@qq.com>
// +----------------------------------------------------------------------
// | Time: 2016-07-20  9:49
// +----------------------------------------------------------------------
namespace Student\Controller;
use Think\Controller;
use Think\Model;
use Think\Upload;   
use Com\WechatAuth;   

/*管理员类*/
class AdminController extends Controller{

    //判断是否为管理员
    public function isAdmin($openId){
        if($openId === '')
            return true;
        else
            return false;
    }

    //添加教师
    public function teacherAdd(){
        
    }

    //删除教师
    public function teacherDelete(){

    }

    public function test(){
        $sch = new EduController();
        $res = $sch->getSchedule('oIpKjs3DE064wNEyil_o-PNS_QGs');
        p($res);
    }
}