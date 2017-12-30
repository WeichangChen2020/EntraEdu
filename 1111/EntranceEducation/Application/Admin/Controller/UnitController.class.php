<?php
namespace Admin\Controller;
use Think\Controller;
class UnitController extends CommonController {
    
    public function index(){

        $Chapter = M('Question_chapter');
        $list = $Chapter->select();
        $this->assign('chapterList',$list);
       
        $this->display();
    }
    public function lists($chapterid){

        $Question = M('Questionbank');
        $list = $Question->where(array('chapter'=> $chapterid))->page($_GET['p'].',20')->select();
        $this->assign('questionList',$list);

        $count      = $Question->where(array('chapter'=> $chapterid))->count();
        $this->assign('count', $count);
        $Page       = new \Think\Page($count,20);
        $show       = $Page->show();
        $this->assign('page',$show);
       
        $this->display();
    }
    public function tmp(){
    
    }
    public function import(){
        if (IS_POST) {
            $files = $_FILES['exl'];
        

            // exl格式，否则重新上传
            if($files['type'] !='application/vnd.ms-excel'){
                var_dump($files['type']);
                $this->error('不是Excel文件，请重新上传');    
            }

            // 上传
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('xls');// 设置附件上传类型
            $upload->rootPath  =     './Upload/'; // 设置附件上传根目录
            $upload->savePath  =     'excel/'; // 设置附件上传（子）目录
            //$upload->subName   =     array('date', 'Ym');
            $upload->subName   =     '';
            // 上传文件  
            $info   =   $upload->upload();

            $file_name =  $upload->rootPath.$info['exl']['savepath'].$info['exl']['savename'];
            $exl = $this->import_exl($file_name);

            // 去掉第exl表格中第一行
            unset($exl[0]);

            // 清理空数组
            foreach($exl as $k=>$v){
                if(empty($v)){
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
            $Q = M("Questionbank");
            $a=0;
            $b=0;
            foreach($exl as $k=>$v){
				var_dump($k);
                echo "<br>";
                var_dump($v);
              
            }
            // 实例化数据
            $this->assign('goods',$goods);
            //print_r($f);

            // 统计结果
            $total['count'] = $count;
            $total['success'] = $f;
            $total['error'] = $w;
            $this->assign('total',$total);

            // 删除Excel文件
            unlink($file_name);
            //$this->display('info');
    	}
    	else $this->display();
    }
  
/* 处理上传exl数据
     * $file_name  文件路径
     */
    public function import_exl($file_name){
        //$file_name= './Upload/excel/123456.xls';
        import("Org.Util.PHPExcel");   // 这里不能漏掉
        import("Org.Util.PHPExcel.IOFactory");
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load($file_name,$encode='utf-8');
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
        
        for($i=1;$i<$highestRow+1;$i++){
            $data[] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();    
        }
        return $data;    
    }
	public function addChapter(){
        if (IS_POST) {
            $Chapter = M('Question_chapter');
            $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
           
            if ($Chapter->add($data))
                $this->success('题目添加成功',U('Unit/index'));
            else
                $this->error('添加失败');
    	}
    	else $this->display();
    }
    public function editChapter($chapterid){
    	 if (IS_POST) {
        	$QUESTION = M('Question_chapter');
            $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
          
            // dump($data);
            if ($QUESTION->where(array('id' => $chapterid))->save($data))
	            $this->success('题目修改成功', U('Unit/index'));
            else
            	$this->error('修改失败');
        } else {
            $chapter = M('Question_chapter')->where(array('id'=>$chapterid))->find();
            // dump($question);
            $this->assign('chapter',$chapter);
            $this->display();
        }
    }
    public function deleteChapter($chapterid){
         $QUESTION = M('Question_chapter');
        $QUESTION->where(array('id' => $chapterid))->delete();
        $this->success('题目删除成功', U('Unit/index'));
    }
    //题目修改界面
    public function edit($id){
        if (IS_POST) {
        	$QUESTION = M('questionbank');
            $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
          
            // dump($data);
            if ($QUESTION->where(array('id' => $id))->save($data))
	            $this->success('题目修改成功', U('Unit/index'));
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
        $QUESTION = M('Questionbank');
        $QUESTION->where(array('id' => $id))->delete();
        $this->success('题目删除成功', U('Question/index'));
    }

    //搜索题目
    //搜索条件为空则显示全部，搜索结果返回到result数组
    public function search(){
    	
	        $QUESTION = M('Questionbank');
	        $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
            if (!empty($data['search']))
            	$map['contents|option_a|option_b|option_c|option_d|analysis'] = array('like','%'.$data['search'].'%','OR');
	        $result = $QUESTION ->where($map) ->page($_GET['p'].',20')->select();
	        $this->assign('questionList',$result);
            $this->assign('search',$data['search']);
            
            $count      =  $QUESTION->where($map)->count();
        	
        	$this->assign('count', $count);
        	$Page       = new \Think\Page($count,20);
        	$show       = $Page->show();
        	$this->assign('page',$show);
       		
            $this->display();
    
    	
    }
    // 题库上传类
	public function upload(){

        if (IS_POST) {		
            if (!empty($_FILES)) {

                /*=========整理上传图片信息===========*/
                $numQuestionPic = count($_FILES['question']['name']);  //题目的数量
                $numAnalysisPic = count($_FILES['analysis']['name']);  //解析的数量
                $_FILES['analysis']['name'][0] != '' ? $existAnalysis = ture : $existAnalysis = false ;
				
                /*=====上传的题目数量要与答案数量一致============*/
                $numQuestionPic == strlen(I('right_answer')) || $this->error('图片的数量与答案的数量不一致');
                if($existAnalysis) //
                    $numQuestionPic == $numAnalysisPic || $this->error('图片的数量与解析的数量不一致');

                /*================将图片上传至domain===============*/
                $config = array(    
                    'rootPath'   =>    './Upload/', // 设置附件上传目录// 上传文件 
                    'savePath'   =>    '',  
                    'saveName'   =>    '',
                    'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),    
                    'autoSub'    =>    true,   
                    'replace'    =>    true,          //支持相同文件名覆盖，否则上传不了
                );
                $upload = new \Think\Upload($config);// 实例化上传类
                $info   =   $upload->upload();
                if ($info === false) {
                    $this->error($upload->getError());
                }else{
                    /*============将上传的图片信息整理成一个二维数组===========*/
                    //分两种情况，有解析，没有解析
                    if($existAnalysis){
                        for($i = 0 ; $i < $numQuestionPic ; $i++){
                            $uploadExercise[$i] = array(
                                'chapter' => I('chapter'),
                                'type' => 1,
                                'questionPicPath' => 'http://testroom-uploads.stor.sinaapp.com/'.$info[$i]['savepath'].$info[$i]['savename'],
                                'rightAnswer' => substr(I('right_answer'), $i,1) ,   //get each answer of input
                                'analysisPicPath' => 'http://testroom-uploads.stor.sinaapp.com/'.$info[$i+count($info)/2]['savepath'].$info[$i+count($info)/2]['savename'],
                                'time' => date('Y-m-d H:i:s'),
                            );
                        }
                    }else{
                        for($i = 0 ; $i < $numQuestionPic ; $i++){
                            $uploadExercise[$i] = array(
                                 'chapter' => I('chapter'),
                                'type' => 1,
                                'questionPicPath' => 'http://testroom-uploads.stor.sinaapp.com/'.$info[$i]['savepath'].$info[$i]['name'],
                                'rightAnswer' => substr(I('right_answer'), $i,1) ,   //get each answer of input
                                'time' => date('Y-m-d H:i:s'),
                                );
                        }
                    }

                    /*===============将试题信息存入数据库==========*/
                    if(M('questionbankpic')->addAll($uploadExercise)){
                        $this->success('上传成功');
                    }else{
                        $this->error('上传失败');
                    }
                }
            }else{
            	 $this->error("没有上传文件");
            }
        } else {
            $Chapter = M('Question_chapter');
        	$list = $Chapter->select();
       		 $this->assign('chapterList',$list);
                 $this->display();
        }
    }
}