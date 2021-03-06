<?php
namespace Student\Controller;
use Think\Controller;
use Think\Model;

/**
* author: qyh
*/
class QyhController extends Controller
{	
	public function index()
	{
		$this->display();
	}



	public function upload()
	{
        // var_dump($_FILES);die;
        $bj = I('get.bj');
		
      	//上传图片的张数
        $keynum = (count(array_filter($_FILES['photo']['name'])));

		$STU          = D('StudentInfo');
        $HOMEWORK     = M('student_homework');
        $openId       = session('?openId') ? session('openId') : $this->error('请重新获取改页面');
        // $homeworkId   = session('?homeworkId') ? session('homeworkId') : $this->error('请重新获取改页面');
        // var_dump($homeworkId);die();
        $cond         = array('openId' => $openId);
        $stuInfo      = $STU->where($cond)->find();
        $homeworkname = I('post.homeworkname');
        $quesarr      = session('quesarr');
        // var_dump($quesarr);die();//题目的题号，当前布置的作业的题号。
        


		$config = array(
            'maxSize' => 314572800,
            'exts'=>array('jpg', 'gif', 'png', 'jpeg'),
            'rootPath'=>'/public/', //文件在本地调试时上传的目录，其实也等同于public的domain下的Uploads文件夹
            'savePath'=>'./computernetwork/homework/'.$homeworkname.'/',
            'autoSub'=>false,
        );
		$upload = new \Think\Upload($config,'sae');// 实例化上传类
		// $info = $upload->upload();
		 // var_dump($_FILES);die;
        $image = new \Think\Image(); 
$data_file = array();
        if ($_FILES['photo']) {
                 
                 foreach ($_FILES['photo']["error"] as $key => $error) {
                
               $res =  $image->open($_FILES['photo']['tmp_name'][$key])->thumb(150, 150)->save('./thumb.jpg');
              echo "<img src="./thumb.jpg" alt="">";
                $info = $upload->uploadOne("./thumb.jpg");
 var_dump($res);die;

                // var_dump($file);
                // var_dump($info);exit;
                $data_file[$key] =$info['url']; 
            }
        }
  
              // $info = $upload->uploadOne($file);
               var_dump($data_file);die;

exit;
		// 上传文件
		
        
		if(!$info) 
		{// 上传错误提示错误信息
			$this->error($upload->getError());
		}else{
            foreach($info as $key => $file){
                // var_dump($key);die();

            


                $imgurl = 'http://testroom-public.stor.sinaapp.com/computernetwork/homework/'.$homeworkname.'/'.$file['savename'];
                $map['openId']          = $openId;
                $map['name']            = $stuInfo['name'];
                $map['number']          = $stuInfo['number'];
                $map['class']           = $stuInfo['class'];
                $map['homeworkname']    = $homeworkname;
                $map['imgurl']          = $imgurl;
                $map['time']            = date("Y-m-d H:i:s",time());
                $map['problemid']       = $quesarr[$key+1];
                $map['homeworkoid']     = session('homeworkoid');
                $map['bj']              = $bj;
                $res = $HOMEWORK->add($map);
                // var_dump($res);die();

            $homework_zg = M('homework_zg');
            $map2 = array('homeworkname'=>$homeworkname,'id'=>session('homeworkoid'));
            $c = $homework_zg->where($map2)->find();
            $c['submit'] += 1;
            $homework_zg->where($map2)->save($c);



			$this->success('上传成功！',U('Homework/index'));
		}


	}
}

    public function read(){
        $QUESTION = M('questionbank');
        $ques_info = $QUESTION->select();
        $data="";
        // p($ques_info);die;
        foreach ($ques_info as $key => $value) {
            // p($value);die;
            if($value['type']==1){
                if($value['option_d']){
                    $data = $value['contents'].'\t'.$value['option_a'].'\t'.$value['option_b'].'\t'.$value['option_c'].'\t'.$value['option_d'];
                    echo $data.'<br/>';
                }else{
                    $data = $value['contents'].'\t'.$value['option_a'].'\t'.$value['option_b'].'\t'.$value['option_c'];
                    echo $data.'<br/>';                    
                }    
            }elseif ($value['type']==2) {
                $data = $value['contents'];
                echo $data.'<br/>'; 
            }else{
                $data = $value['contents'].'\t'.$value['option_a'].'\t'.$value['option_b'].'\t'.$value['option_c'].'\t'.$value['option_d'];
                echo $data.'<br/>'; 
            }
            // file_put_contents("def.txt",$data);
        }
        
    }  


}

?>