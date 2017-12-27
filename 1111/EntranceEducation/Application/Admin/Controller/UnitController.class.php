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
                    'rootPath'   =>    './Uploads/', // 设置附件上传目录// 上传文件 
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
                                'type' => I('type'),
                                'questionPicPath' => 'http://testtest11-uploads.stor.sinaapp.com/'.$info[$i]['savepath'].$info[$i]['savename'],
                                'rightAnswer' => substr(I('right_answer'), $i,1) ,   //get each answer of input
                                'analysisPicPath' => 'http://testtest11-uploads.stor.sinaapp.com/'.$info[$i+count($info)/2]['savepath'].$info[$i+count($info)/2]['savename'],
                                'time' => date('Y-m-d H:i:s'),
                            );
                        }
                    }else{
                        for($i = 0 ; $i < $numQuestionPic ; $i++){
                            $uploadExercise[$i] = array(
                                'type' => I('type'),
                                'questionPicPath' => 'http://testtest11-uploads.stor.sinaapp.com/'.$info[$i]['savepath'].$info[$i]['name'],
                                'rightAnswer' => substr(I('right_answer'), $i,1) ,   //get each answer of input
                                'time' => date('Y-m-d H:i:s'),
                                );
                        }
                    }

                    /*===============将试题信息存入数据库==========*/
                    if(M('questionbank')->addAll($uploadExercise)){
                        $this->success('上传成功');
                    }else{
                        $this->error('上传失败');
                    }
                }
            }            
        } else {
            $sidenav = get_sidenav();
            $topmenu = get_topmenu();
            $this->assign('sidenav', $sidenav);
            $this->assign('topmenu', $topmenu);

            $units = D('questionunit')->getUnits();
            $this->assign('units', $units);     

            $this->addCrumb('题库管理', '', '')
                 ->addCrumb('添加题目', '')
                 ->addNav('添加章节', U('Unit/lists'), '')
                 ->addNav('添加题目', '', 'active')
                 ->display();
        }
		
}