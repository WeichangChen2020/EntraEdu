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
    	$Database=M('langrensha');
    	/*var_dump($Database);
    	die();*/
    	$information=I('post.flag');
    	$people=I('post.people');
    	$langren=I('post.langren');
    	$nvwu=I('post.nvwu');
    	$lieren=I('post.lieren');
    	$yyj=I('post.yyj');
    	$shouwei=I('post.shouwei');
    	$baichi=I('post.baichi');
    	$cunmin=$people-$langren-$nvwu-$yyj-$lieren-$shouwei-$baichi;

/*    	$jiaose=array();                                             //角色数组
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

   		$jiaose[rand(0,$people)];

   		
    	
   		session('jiaose',$jiaose);*/

    	if ($information=='1') {                                   //是房主
    		$fangjianhao=rand(1000,9999);
    		
			$Database->fangjianhao=$fangjianhao;
			$Database->cunmin=$cunmin;
			$Database->langren=$langren;
			$Database->nvwu=$nvwu;
			$Database->yyj=$yyj;
			$Database->lieren=$lieren;

			$Database->Rfangjianhao=$fangjianhao;
			$Database->Rcunmin=$cunmin;
			$Database->Rlangren=$langren;
			$Database->Rnvwu=$nvwu;
			$Database->Ryyj=$yyj;
			$Database->Rlieren=$lieren;

			if ($shouwei) {
				$Database->shouwei=$shouwei;
				$Database->Rshouwei=$shouwei;
			}
			if ($baichi) {
				$Database->baichi=$baichi;
				$Database->Rbaichi=$baichi;
			}
			$Database->add();
			$this->assign('fangjianhao',$fangjianhao);
			session('fangjianhao',$fangjianhao);
			$this->assign('title',$fangjianhao);
			/*$jiaose=rand(1,7);
			$Database[$jiaose]*/
			$number=$Database->where("fangjianhao='$fangjianhao'")->find();
			
			
    		$this->display();

    	} else {
    		$this->error('你乱来的',U('Game/index'));
    	}
    	
    }

    public function gamehome()         //分发身份
    {
    	$i=$i++;     //人数
    	$flag=I('post.flag');           //是否是组员身份（非房主）     
  
    	if ($flag) { 
    		$fangjianhao=I('post.fangjianhao');
    	} else {
    		$fangjianhao=I('get.fangjianhao');
    	}
    	
    	$Database=M('langrensha');
    	$jiaose=array();
    	$number=$Database->where("fangjianhao='$fangjianhao'")->find();
    	$cunmin=$number[Rcunmin];
    	$langren=$number[Rlagnren];
    	$nvwu=$number[Rnvwu];
    	$yyj=$number[Ryyj];
    	$lieren=$number[Rlieren];
    	$shouwei=$number[Rshouwei];
    	$baichi=$number[Rbaichi];

    	if ($cunmin) {
    		for($i=0;$i<$cunmin;$i++){
    		$jiaose[]='村民';
    		}
    	}
    	if ($langren) {
    		for($i=0;$i<$langren;$i++){
    		$jiaose[]='狼人';
    		}
    	}
    	if ($nvwu) {
    		$jiaose[]='女巫';
    	}
    	if ($yyj) {
    		$jiaose[]='预言家';
    	}
    	if ($lieren) {
    		$jiaose[]='猎人';
    	}
    	if ($shouwei) {
    		$jiaose[]='守卫';
    	}
    	if ($baichi) {
    		$jiaose[]='白痴';
    	}
    	








    	$this->assign('title',$fangjianhao.号房);
    	$this->display();


    }
   		public function jinqu()
    {
    	$fangjianhao=I('post.fangjianhao');
    	var_dump(U('Game/gamehome'));
    	die();
    	$this->redirect('71/index.php/Home/Game/gamehome.html');
    	$thid->success('成功',U('Game/gamehome'),1);
    	$this->redirect("Game/gamehome");
    }


   
}