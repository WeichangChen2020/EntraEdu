<?php
namespace Home\Controller;
use Think\Controller;
class GameController extends Controller {
    public function index(){	
		$this->display();
    }
        
    public function kaifang(){
        $this->display();
    }

    public function jinfang(){
        $this->assign('title','进房');

        $this->display();
    }

    public function fangjiannum()
    {
    	
    	$information=I('post.flag');
    	$people=I('post.people');
    	$langren=I('post.langren');
    	$nvwu=I('post.nvwu');
    	$lieren=I('post.lieren');
    	$yyj=I('post.yyj');
    	$cunmin=$people-$langren-$nvwu-$yyj-$lieren-1;
    	$jiaose=array();                                             //角色数组
    	for($i=0;$i<$langren;$i++)
    	{
    		$jiaose[]='狼人';
    	}

    	for($i=0;$i<$cunmin;$i++)
    	{
    		$jiaose[]='村民';
    	}
   		$jiaose[]='女巫';
   		$jiaose[]='预言家';
   		$jiaose[]='猎人';
   		/*var_dump($jiaose);
   		die();
    	*/
   		session('jiaose',$jiaose);

    	if ($information=='1') {                                   //是房主
    		$fangjianhao=rand(1000,9999);
			$this->assign('fangjianhao',$fangjianhao);
			session('fangjianhao',$fangjianhao);
			$this->assign('title',$fangjianhao);
    		$this->display();

    	} else {
    		$this->error('你乱来的',U('Game/index'));
    	}
    	

    }

    public function gamehome()         //分发身份
    {
    	$i=$i++;     //人数
    	$flag=I('post.flag');           //是否是组员身份（非房主）     
    	/*var_dump($flag);
    	die();*/
    	if ($flag) { 
    		$fangjianhao=I('post.fangjianhao');

    		/*var_dump($fangjianhao);
    		die();*/

    		if(session('fangjianhao')==$fangjianhao)
    		{
    			/*随机给身份*/
    			
    		}
    		/*var_dump($fangjianhao);
    		die();*/
    	} else {
    		$fangjianhao=I('get.fangjianhao');
    	}
    	



    	$this->assign('title',$fangjianhao.号房);
    	$this->display();


    }
   /* public function jinqu()
    {
    	$fangjianhao=I('post.fangjianhao');
    	var_dump(U('Game/gamehome'));
    	die();
    	$this->redirect('71/index.php/Home/Game/gamehome.html');
    	$thid->success('成功',U('Game/gamehome'),1);
    	$this->redirect("Game/gamehome");
    }*/


   
}