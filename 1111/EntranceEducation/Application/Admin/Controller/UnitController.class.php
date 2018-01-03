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
       	$this->assign('chapterid',$chapterid);
        $this->display();
    }
    public function imgdelete($id){
         $QUESTION = M('image_questionbank');
        $QUESTION->where(array('id' => $id))->delete();
        $this->success('题目删除成功');
    }
     public function imglists($chapterid){

        $Question = M('image_questionbank');
        $list = $Question->where(array('chapter'=> $chapterid))->page($_GET['p'].',5')->select();
        $this->assign('questionList',$list);

        $count      = $Question->where(array('chapter'=> $chapterid))->count();
        $this->assign('count', $count);
        $Page       = new \Think\Page($count,5);
        $show       = $Page->show();
        $this->assign('page',$show);
       	$this->assign('chapterid',$chapterid);
        $this->display();
    }
  	public function export($id='all'){
    	$Question = M('Questionbank');
        if($id!='all') $list = $Question->where(array('chapter'=> $id))->field('chapter,type,contents,option_a,option_b,option_c,option_d,right_answer,analysis')->select();
        else $list = $Question->field('chapter,type,contents,option_a,option_b,option_c,option_d,right_answer,analysis')->select();
        $this->exportExcel($list,'questionbank_chapter'.$id.date("Y_m_d"),
                           array("章节号（数字）","题目类型(1单选 2判断 3多选)","题干","选项A","选项B","选项C","选项D","正确答案","解析（如无则不填）"),"questionbank");

    }
    public function imgexport($id='all'){
    	$Question = M('ImageQuestionbank');
        if($id!='all') $list = $Question->where(array('chapter'=> $id))->field('chapter,type,contents,right_answer,analysis')->select();
        else $list = $Question->field('chapter,type,contents,right_answer,analysis')->select();
        $this->exportExcel($list,'image_questionbank'.$id.date("Y_m_d"),
                           array("章节号（数字）","题目类型(1单选 2判断 3多选)","题干","正确答案及解析"),"image_questionbank",1);

    }
    public function tests($name){
         vendor("PHPExcel");
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getActiveSheet()->setTitle('111');//设置sheet名称
        $objPHPExcel->setActiveSheetIndex(0);//设置当前sheet
        
        ob_end_clean();//清除缓冲区,避免乱码
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$name.'.xls"');  //日期为文件名后缀
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  //excel5为xls格式，excel2007为xlsx格式
        $objWriter->save('php://output');
    }
    public function addChapter(){
        if (IS_POST) {
            $Chapter = M('Question_chapter');
            $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
           
            if ($Chapter->add($data))
                $this->success('章节添加成功',U('Unit/index'));
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
        $Q = M('Questionbank');
        $Q->where(array('chapter' => $chapterid))->delete();
        $this->success('题库删除成功', U('Unit/index'));
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
            $id = I('id');
            if(!empty($id)){
            	if(!is_numeric($id) || !is_null( $QUESTION->find($id) ) ) $this->error('id错误');
            }
	        if ($QUESTION->add($data))
	        	$this->success('题目添加成功',U('Unit/add'));
	        else
	        	$this->error('添加失败');
    	}else{
            
    		$this->display();
        }
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
				$existAnalysis = 1;
                /*=====上传的题目数量要与答案数量一致============*/
                //$numQuestionPic == strlen(I('right_answer')) || $this->error('图片的数量与答案的数量不一致');
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
                                'contents' => 'http://testroom-upload.stor.sinaapp.com/'.$info[$i]['savepath'].$info[$i]['savename'],
                                //'rightAnswer' => substr(I('right_answer'), $i,1) ,   //get each answer of input
                                'right_answer' => 'http://testroom-upload.stor.sinaapp.com/'.$info[$i+count($info)/2]['savepath'].$info[$i+count($info)/2]['savename'],
                                'time' => date('Y-m-d H:i:s'),
                            );
                        }
                    }else{
                        for($i = 0 ; $i < $numQuestionPic ; $i++){
                            $uploadExercise[$i] = array(
                                 'chapter' => I('chapter'),
                                'type' => 1,
                                'questionPicPath' => 'http://testroom-upload.stor.sinaapp.com/'.$info[$i]['savepath'].$info[$i]['name'],
                                'rightAnswer' => substr(I('right_answer'), $i,1) ,   //get each answer of input
                                'time' => date('Y-m-d H:i:s'),
                                );
                        }
                    }

                    /*===============将试题信息存入数据库==========*/
                    if(M('image_questionbank')->addAll($uploadExercise)){
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
       		$this->assign('chapter',I('chapter'));
                 $this->display();
        }
    }
    public function exportExcel($data, $savefile, $fileheader, $sheetname,$isImage=0){
        //引入phpexcel核心文件，不是tp，你也可以用include（‘文件路径’）来引入
    
        vendor('PHPExcel');
    	vendor('PHPExcel.Reader');
        //或者excel5，用户输出.xls，不过貌似有bug，生成的excel有点问题，底部是空白，不过不影响查看。
        //import("Org.Util.PHPExcel.Reader.Excel5");
        //new一个PHPExcel类，或者说创建一个excel，tp中“\”不能掉
        $excel = new \PHPExcel();
        if (is_null($savefile)) {
            $savefile = time();
        }else{
            //防止中文命名，下载时ie9及其他情况下的文件名称乱码
            iconv('UTF-8', 'GB2312', $savefile);
        }
        //设置excel属性
        $objActSheet = $excel->getActiveSheet();
        //根据有生成的excel多少列，$letter长度要大于等于这个值
        $letter = array('A','B','C','D','E','F','F','G','H','I','J');
        
        foreach($letter as $l){
            //单独设置D列宽度为15
       		$objActSheet->getColumnDimension($l)->setWidth('30px');	
        }
        $objActSheet->getColumnDimension('A')->setWidth('5px');	
         $objActSheet->getColumnDimension('B')->setWidth('5px');	
      
        //设置当前的sheet
        $excel->setActiveSheetIndex(0);
        //设置sheet的name
        $objActSheet->setTitle($sheetname);
        //设置表头
        for($i = 0;$i < count($fileheader);$i++) {
            //单元宽度自适应,1.8.1版本phpexcel中文支持勉强可以，自适应后单独设置宽度无效
            //$objActSheet->getColumnDimension("$letter[$i]")->setAutoSize(true); 
            //设置表头值，这里的setCellValue第二个参数不能使用iconv，否则excel中显示false
            $objActSheet->setCellValue("$letter[$i]1",$fileheader[$i]); 
            //设置表头字体样式
            $objActSheet->getStyle("$letter[$i]1")->getFont()->setName('微软雅黑');
            //设置表头字体大小
            $objActSheet->getStyle("$letter[$i]1")->getFont()->setSize(12);
            //设置表头字体是否加粗
            $objActSheet->getStyle("$letter[$i]1")->getFont()->setBold(true);
            //设置表头文字垂直居中
            $objActSheet->getStyle("$letter[$i]1")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //设置文字上下居中
            $objActSheet->getStyle($letter[$i])->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
            //设置表头外的文字垂直居中
            $excel->setActiveSheetIndex(0)->getStyle($letter[$i])->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
       
        //这里$i初始值设置为2，$j初始值设置为0，自己体会原因
        for ($i = 2;$i <= count($data) + 1;$i++) {
            $j = 0;
            foreach ($data[$i - 2] as $key=>$value) {
                //不是图片时将数据加入到excel，这里数据库存的图片字段是img
                if($image == 0){
                    $objActSheet->setCellValue("$letter[$j]$i",$value);
                }
                //是图片是加入图片到excel
                if($image == 1 && ($key == 'contents'|| $key == 'right_answer')){
                    if($value != ''){
                        $value = iconv("UTF-8","GB2312",$value); //防止中文命名的文件
                        // 图片生成
                        $objDrawing[$key] = new \PHPExcel_Worksheet_Drawing();
                        // 图片地址
                        $objDrawing[$key]->setPath('.\Uploads'.$value);
                        // 设置图片宽度高度
                        $objDrawing[$key]->setHeight('80px'); //照片高度
                        $objDrawing[$key]->setWidth('80px'); //照片宽度
                        // 设置图片要插入的单元格
                        $objDrawing[$key]->setCoordinates('D'.$i);
                        // 图片偏移距离
                        $objDrawing[$key]->setOffsetX(12);
                        $objDrawing[$key]->setOffsetY(12);
                        //下边两行不知道对图片单元格的格式有什么作用，有知道的要告诉我哟^_^
                        //$objDrawing[$key]->getShadow()->setVisible(true);
                        //$objDrawing[$key]->getShadow()->setDirection(50);
                        $objDrawing[$key]->setWorksheet($objActSheet);
                    }
                }
                $j++;
            }
            //设置单元格高度，暂时没有找到统一设置高度方法
            $objActSheet->getRowDimension($i)->setRowHeight('20px');
           
        }
       
       	ob_end_clean();//清除缓冲区,避免乱码 
        header('Content-Type: application/vnd.ms-excel');
        //下载的excel文件名称，为Excel5，后缀为xls，不过影响似乎不大
        header('Content-Disposition: attachment;filename="' . $savefile . '.xls"'); 
        header('Cache-Control: max-age=0');
        // 用户下载excel
       
        $objWriter = \PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $objWriter->save('php://output');
        // 保存excel在服务器上
        //$objWriter = new PHPExcel_Writer_Excel2007($excel);
        //或者$objWriter = new PHPExcel_Writer_Excel5($excel);
        //$objWriter->save("保存的文件地址/".$savefile);
    
	}
    public function import(){
        if (IS_POST) {
        
       		  // 上传
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('xls', 'xlsx', 'csv');// 设置附件上传类型
            $upload->rootPath  =     './Upload/'; // 设置附件上传根目录
            $upload->savePath  =     'excel/'; // 设置附件上传（子）目录
            //$upload->subName   =     array('date', 'Ym');
            $upload->subName   =     '';
            // 上传文件  
            $info   =   $upload->upload();
			if(!$info)  $this->error($upload->getErrorMsg());
            
            $file_name =  'http://testroom-upload.stor.sinaapp.com/'.$info[0]['savepath'].$info[0]['savename'];
           
            $exl = $this->import_exl($info[0]['savepath'].$info[0]['savename']);

            // 去掉第exl表格中第一行
            unset($exl[0]);

            // 清理空数组
            foreach($exl as $k=>$v){
                if(empty($v) || is_null($v['chapter']) || is_null($v['type']) || is_null($v['contents']) || is_null($v['right_answer'])){
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
                if (!$Q->add($v)) $this->error('添加失败');    
            }
            // 实例化数据
            $this->assign('total',$total);

            // 删除Excel文件
            unlink($file_name);
             $this->success('题目添加成功');
            //$this->display('info');
    	}
    	else $this->display();
    }
  
/* 处理上传exl数据
     * $file_name  文件路径
     */
    public function import_exl($name){
        $file_name= 'http://testroom-upload.stor.sinaapp.com/excel/5a47884661a67.xlsx';
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
            $tmp['chapter'] =   $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();    
            $tmp['type'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();    
            $tmp['contents'] =   $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();    
            $tmp['option_a'] =   $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();    
            $tmp['option_b'] =  $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();    
            $tmp['option_c'] =  $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getValue();    
            $tmp['option_d'] =  $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getValue();  
            $tmp['right_answer']  = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getValue(); 
            $tmp['analysis']  = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getValue(); 
            $data[]=$tmp;
        }
        return $data;    
    }
	
}