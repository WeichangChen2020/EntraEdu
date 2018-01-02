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
            if(I('password') != I('password2')) $this->error('密码请保持一致');
	        $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
            $data['type'] = 2;
	        if ($QUESTION->add($data))
	        	$this->success('添加成功',U('Class/index'));
	        else
	        	$this->error('添加失败');
    	}else{
            $this->display();
        }
    }
    public function lists($id){
    	$Student = M('StudentList');
		$Info = M('teacher_class');
        $map = $Info->field('class')->find($id);

        $list = $Student->where($map)->page($_GET['p'].',20')->select();
        $count = $Student->where($map)->count();
       
        $this->assign('userList',$list);

        $Page       = new \Think\Page($count,20);
        $show       = $Page->show();
        $this->assign('page', $show);    
       $this->assign('empty','<table>没有数据 </table>');
        $this->display();
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
        $QUESTION = M('teacher_class');
        $QUESTION->where(array('id' => $id))->delete();
        $this->success('删除成功', U('Class/index'));
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
     public function export() {

        // 查询条件
        $college = D('Adminer')->getCollege();
        $map = array();

        if (!is_null($college)) {
            $map['academy'] = $college;
        }

        $title = array('序号','学院', '班级', '学号', '姓名');
        $filename  = is_null($college) ? '浙江工商大学' : $college;
      $type = 1；
        if($type == 1) {
            $map['type'] = 1;
            $list = M('StudentList')->where($map)->field('id,academy,class,number,name')->order('academy,class,number,id')->select();
            $filename .= '计算机网络学习平台注册用户';
        } else {
            $map['type'] = 0;
            $list = M('StudentList')->where($map)->field('id,academy,class,number,name')->select();
            $filename .= '计算机网络学习平台未注册用户';
        }

        $this->excel($list, $title, $filename);
    }

    //导出成绩报表
    public function excel($arr=array(),$title=array(),$filename='export'){
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

        die;
        // 使用die是为了避免输出多余的模板html代码
    }
}