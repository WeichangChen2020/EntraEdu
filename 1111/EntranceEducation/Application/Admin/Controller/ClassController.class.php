<?php
namespace Admin\Controller;
use Think\Controller;
class ClassController extends CommonController {
     function _initialize()
    {
       	 parent::_initialize();
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
    public function testt(){
         $Q = M("StudentInfo");
   			$T=M('StudentList');
        $ops = $Q->select();
        foreach($ops as $k=>$v){
        	$result = $T->where("name ='".$v['name']."'")->save( array("openId" => $v['openId']));
            if(!$result) p($T->getError());
        }
       
    }
	 public function addClass(){
    	if (IS_POST) {
	        $QUESTION = M('teacher_class');
	        $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
            $course = $data['class'];
            $teacher = $data['name'];
            
            if(strlen($course) >15) $this->error("课堂名过长");
            	  // 上传
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =    1048576 ;// 设置附件上传大小
            $upload->exts      =     array('xls', 'xlsx', 'csv');// 设置附件上传类型
            $upload->rootPath  =     './upload/'; // 设置附件上传根目录
            $upload->savePath  =     'excel/'; // 设置附件上传（子）目录
            //$upload->subName   =     array('date', 'Ym');
            $upload->subName   =     '';
            // 上传文件  
            $info   =   $upload->upload();
			if(!$info)  $this->error($upload->getErrorMsg());
            
            //$file_name =  'http://classtest-public.stor.sinaapp.com/'.$info[0]['savepath'].$info[0]['savename'];
          
            $exl = $this->import_exl($info[0]['savepath'].$info[0]['savename']);

            // 去掉第exl表格中第一行
            unset($exl[0]);

            // 清理空数组
            foreach($exl as $k=>$v){
                if(empty($v) || is_null($v['name']) || is_null($v['number']) ){
                    unset($exl[$k]);
                }
            };
            // 重新排序
            sort($exl);
		
            $count = count($exl);
            // 检测表格导入成功后，是否有数据生成
            if($count<1){
                $this->error('未检测到有效数据');    
            }

            // 开始导入数据库
            $Q = M("StudentList");
 			
            foreach($exl as $k=>$v){
                $v['course'] = $course;
                $v['type']=0;
              
                if (!$Q->add($v)) $this->error('添加失败');    
            }
		
            // 删除Excel文件
            unlink($file_name);
            
            //加入teacher_class表和teacher_info表
            $R = M("TeacherInfo");            
            $openId = $Q->where( array("name"=> $teacher))->find();
            if(!$openId){
            	$openId = $R->where( array("name"=> $teacher))->find();              
            }

	        if (!$QUESTION->add(array(
            		"class" => $course,
                	"name" => $teacher,
                	'openId'=> $openId['openId']
            	))){
                $this->error('添加失败');
	        	
            }
            
            $infos = $R->where( array("name"=> $teacher))->find();  
            if(!info){
            	$result = $R->add($openId);
                if(!result) $this->error('添加失败');
            }
            
	        $this->success('添加成功',U('Class/index'));
	        	
    	}else{
            $Teacher = M('teacher_info');
            $teachers = $Teacher->field('name')->select();
            
            $Student = M('studentList');
            $students = $Student->field('name')->select();
            
            $this->assign('adminerList',array_merge($teachers,$students));
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
	            $this->success('修改成功', U('Question/index'));
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
        $course = $QUESTION->find($id);
        $QUESTION->where(array('id' => $id))->delete();
        $LIST = M('StudentList');
        if( is_null($course['class'])) $this->error('删除失败');
        $res = $LIST->where(array("course"=> $course['class']))->save(array("isDelete"=>1));
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
      $type = 1;
        if($type == 1) {
            $map['type'] = 1;
            $list = M('StudentList')->where($map)->field('id,academy,class,number,name')->order('academy,class,number,id')->select();
            $filename .= '学生信息';
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
    /* 处理上传exl数据
     * $file_name  文件路径
     */
    public function import_exl($name){
        vendor('PHPExcel');
    	vendor('PHPExcel.IOFactory');
    	vendor('PHPExcel.Reader.Excel5');
        //$objReader = \PHPExcel_IOFactory::createReader('Excel5');
        //$objPHPExcel = $objReader->load($file_name,$encode='utf-8');
        $s=new \SaeStorage();
        file_put_contents(SAE_TMP_PATH.'/upload.xlsx',$s->read('upload',$name));
        
        $objPHPExcel = \PHPExcel_IOFactory::load(SAE_TMP_PATH.'upload.xlsx',$encode='utf-8');
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
        
        for($i=1;$i<$highestRow+1;$i++){
            $tmp['name'] =   $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();    
            $tmp['number'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();    
            $tmp['sex'] =   $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();    
            $tmp['academy'] = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();    
            $tmp['class'] =  $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();          
            $data[]=$tmp;
        }
        return $data;    
    }
}