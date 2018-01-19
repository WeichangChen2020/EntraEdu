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
        // var_dump($quesarr);die();
        


		$config = array(
            'maxSize' => 314572800,
            'exts'=>array('jpg', 'gif', 'png', 'jpeg'),
            'rootPath'=>'/public/', //文件在本地调试时上传的目录，其实也等同于public的domain下的Uploads文件夹
            'savePath'=>'./homework/'.$homeworkname.'/',
            'autoSub'=>false,
            // 'saveName'=>array($one,$two,$three,$four,$five,$six)
            // 'saveName'=>array('1','2','3','4','5','6')
        );
		$upload = new \Think\Upload($config,'sae');// 实例化上传类
		
		

		// 上传文件
		$info = $upload->upload();
		if(!$info) 
		{// 上传错误提示错误信息
			$this->error($upload->getError());
		}else{
            foreach($info as $key => $file){
                // var_dump($key);die();
                $imgurl = 'http://testroom-public.stor.sinaapp.com/homework/'.$homeworkname.'/'.$file['savename'];
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
            }

            $homework_zg = M('homework_zg');
            $map2 = array('homeworkname'=>$homeworkname,'id'=>session('homeworkoid'));
            $c = $homework_zg->where($map2)->find();
            $c['submit'] += 1;
            $homework_zg->where($map2)->save($c);



			$this->success('上传成功！',U('Homework/index'));
		}


	}




}

?>