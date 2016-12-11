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

			$Database->rfangjianhao=$fangjianhao;
			$Database->rcunmin=$cunmin;
			$Database->rlangren=$langren;
			$Database->rnvwu=$nvwu;
			$Database->ryyj=$yyj;
			$Database->rlieren=$lieren;

			if ($shouwei) {
				$Database->shouwei=$shouwei;
				$Database->rshouwei=$shouwei;
			}
			if ($baichi) {
				$Database->baichi=$baichi;
				$Database->rbaichi=$baichi;
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
    	    //人数
    	$flag=I('post.flag');           //是否是组员身份（非房主）    
        
  
    	if ($flag) { 
    		$fangjianhao=I('post.fangjianhao');
    	} else {
    		$fangjianhao=I('get.fangjianhao');
    	}

        
    	
    	$Database=M("langrensha");
    	$jiaose=array();
    	$number=$Database->where("fangjianhao='$fangjianhao'")->find();

  

    	$cunmin=$number[rcunmin];
    	$langren=$number[rlangren];
    	$nvwu=$number[rnvwu];
    	$yyj=$number[ryyj];
    	$lieren=$number[rlieren];
    	$shouwei=$number[rshouwei];
    	$baichi=$number[rbaichi];
        $people=0;
      

    	if ($cunmin) {
    		for($i=0;$i<$cunmin;$i++){
    		$jiaose[]='村民';
            $people++;
    		}
            
    	}
    	if ($langren) {
    		for($i=0;$i<$langren;$i++){
    		$jiaose[]='狼人';
            $people++;
    		}
    	}
    	if ($nvwu) {
    		$jiaose[]='女巫';
             $people++;
    	}
    	if ($yyj) {
    		$jiaose[]='预言家';
             $people++;
    	}
    	if ($lieren) {
    		$jiaose[]='猎人';
             $people++;
    	}
    	if ($shouwei) {
    		$jiaose[]='守卫';
             $people++;
    	}
    	if ($baichi) {
    		$jiaose[]='白痴';
             $people++;
    	}
    	
        if ($people!=1) {
            $fenpei=$jiaose[rand(0,$people-1)];             //分配的角色
        } else {
           $fenpei=$jiaose[0];
        }
        
       /* var_dump($jiaose);
            die();
*/
  /*      var_dump($fenpei);
        die();*/
        
        switch ($fenpei) {
            case '村民':
               $data['fangjianhao']=$fangjianhao;
               $data['rcunmin']=$number[rcunmin]-1;
             /*  var_dump($data['rcunmin']);
               die();*/
               $Database->save($data);
              
                break;
            
            case '狼人':
                $data['fangjianhao']=$fangjianhao;      
                $data['rlangren']=$number[rlangren]-1;
                $Database->save($data);
                break;     

            case '女巫':
                $data['fangjianhao']=$fangjianhao;
                $data['rnvwu']=$number[rnvwu]-1; 
                $Database->save($data);
                break;

            case '预言家':
                $data['fangjianhao']=$fangjianhao;
                $data['ryyj']=$number[ryyj]-1;
                $Database->save($data);
                break;

            case '猎人':
                $data['fangjianhao']=$fangjianhao;
                $data['rlieren']=$number[rlieren]-1;
                $Database->save($data);
                break;

            case '守卫':
                $data['fangjianhao']=$fangjianhao;
                $data['rshouwei']=$number[rshouwei]-1;
                $Database->save($data);
                break;

            case '白痴':
                $data['fangjianhao']=$fangjianhao;
                $data['rbaichi']=$number[rbaichi]-1;
                $Database->save($data);
                break;
            default:
           
                echo '人满啦';
                break;
        }

            /*if ($flag) {
                $this->assign('flag','0');
            } else {
                $this->assign('flag','hidden');
            }*/
            


        
        /*var_dump(!$flag);
        die();*/
        $this->assign('jiaose',$fenpei);
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