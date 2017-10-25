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

       
        $this->display('index');
        
    }

    
    public function export($type) {

        // 查询条件
        $college = D('Adminer')->getCollege();
        $map = array();

        if (!is_null($college)) {
            $map['academy'] = $college;
        }

        $title = array('序号', '姓名', '班级', '学号');

        $register = M('StudentInfo')->where($map)->getField('id,name,class','number');

        p($register);
        // $map['type'] = 0;
        // $unRegist = M('StudentList')->where($map)->select();
 


    }

    //导出成绩报表
    public function excel($arr=array(),$title=array(),$filename='export'){
        $MARK = M('student_mark');
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");  
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
      
        if (!empty($title)){
            foreach ($title as $k => $v) {
                $title[$k]=iconv("UTF-8", "GB2312",$v);
            }
            $title= implode("\t", $title);
            echo "$title\n";
        }
        //查询数据库  $arr 是二维数组

        if(!empty($arr)){
            foreach($arr as $key=>$val){
                foreach ($val as $ck => $cv) {
                    $arr[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
                }
                $arr[$key]=implode("\t", $arr[$key]);
            }
            echo implode("\n",$arr);
        }
    }



}