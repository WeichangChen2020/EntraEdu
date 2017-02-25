<?php
namespace Home\Controller;
use Think\Controller;
//use Common\Controller\ConnectController;
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
        $Database2=M('shenfen');
        $Database3=M('siren');
        $Database4=M('meiyesiren');
        $Database5=M('dijitian');
    	
    	$information=I('post.flag');
    	$people=I('post.people');
    	$langren=I('post.langren');
    	$nvwu=I('post.nvwu');
    	$lieren=I('post.lieren');
    	$yyj=I('post.yyj');
    	$shouwei=I('post.shouwei');
    	$baichi=I('post.baichi');
    	$cunmin=$people-$langren-$nvwu-$yyj-$lieren-$shouwei-$baichi;



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
            $Database2->fangjianhao=$fangjianhao;
            $Database2->add();
            $Database3->fangjianhao=$fangjianhao;
            $Database3->add();
            $Database4->fangjianhao=$fangjianhao;
            $Database4->add();
            $Database5->fangjianhao=$fangjianhao;
            $Database5->add();
			$this->assign('fangjianhao',$fangjianhao);
			session('fangjianhao',$fangjianhao);
			$this->assign('title',$fangjianhao);
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
    	if($flag) 
        {                  //非房主
    		$fangjianhao=I('post.fangjianhao');
    	} 
        else 
        {
            
    		$fangjianhao=I('get.fangjianhao');
            $fangjianhao=session('fangjianhao');
            $Database5=M('dijitian');
            $data5=$Database5->where("fangjianhao='$fangjianhao'")->find();
            $data5['day']=0;
            $Database5->save($data5);
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
        
        switch ($fenpei) {
            case '村民':
               $data['fangjianhao']=$fangjianhao;
               $data['rcunmin']=$number[rcunmin]-1;
             /*  var_dump($data['rcunmin']);
               die();*/
               $Database->save($data);
               $Ejiaose='cunmin';
                break;
            
            case '狼人':
                $data['fangjianhao']=$fangjianhao;      
                $data['rlangren']=$number[rlangren]-1;
                $Database->save($data);
                $Ejiaose='langren';
                break;     

            case '女巫':
                $data['fangjianhao']=$fangjianhao;
                $data['rnvwu']=$number[rnvwu]-1; 
                $Database->save($data);
                $Ejiaose='nvwu';
                session('jieyao',1);
                session('duyao',1);
                break;

            case '预言家':
                $data['fangjianhao']=$fangjianhao;
                $data['ryyj']=$number[ryyj]-1;
                $Database->save($data);
                $Ejiaose='yyj';
                break;

            case '猎人':
                $data['fangjianhao']=$fangjianhao;
                $data['rlieren']=$number[rlieren]-1;
                $Database->save($data);
                $Ejiaose='lieren';
                break;

            case '守卫':
                $data['fangjianhao']=$fangjianhao;
                $data['rshouwei']=$number[rshouwei]-1;
                $Database->save($data);
                $Ejiaose='shouwei';
                break;

            case '白痴':
                $data['fangjianhao']=$fangjianhao;
                $data['rbaichi']=$number[rbaichi]-1;
                $Database->save($data);
                $Ejiaose='baichi';
                break;
            default:
           
                echo '人满啦';
                break;
        }

        $this->assign('Ejiaose',$Ejiaose);
        $this->assign('jiaose',$fenpei);
    	$this->assign('title',$fangjianhao.号房);
        $this->assign('flag',$flag);               //0房主，1非房主
    	$this->display();
    }


   	    /*public function jinqu()
        {
        	$fangjianhao=I('post.fangjianhao');
        	var_dump(U('Game/gamehome'));
        	die();
        	$this->redirect('71/index.php/Home/Game/gamehome.html');
        	$thid->success('成功',U('Game/gamehome'),1);
        	$this->redirect("Game/gamehome");

        }*/

        public function shenfen()
        {
            
            $Database2=M('shenfen');
            $information=I('post.');
            $jiaose=$information['jiaose'];
            $zuoweihao=$information['zuoweihao'];
            $Ejiaose=$information['Ejiaose'];
            $flag=$information['flag'];                 //0房主，1非房主
            if ($flag) {
                $this->assign('flag','none');
            } else {
                $this->assign('flag','display');
            }
            
            $fangjianhao=session('fangjianhao');
            //$data=$Database->where("fangjianhao='$fangjianhao'")->find();
            $data['fangjianhao']=$fangjianhao;          //要提示主键
            $data['['.$zuoweihao.']']=$jiaose;
            $Database2->save($data);
            $this->assign('title',$jiaose);    
            $this->display("$Ejiaose");                //英语名称的角色

        }

  

        public function langren2()           //存储狼人杀人，给女巫判断
        {
            $fangjianhao=session('fangjianhao');
            $Database5=M('dijitian');
            $data5=$Database5->where("fangjianhao='$fangjianhao'")->find();
            $data5['day']++;
            $Database5->save($data5);
            $siren=I('post.data1');
            $Database3=M('siren');
            $data3=$Database3->where("fangjianhao='$fangjianhao'")->find();

            if ($data3['['.$siren.']']=='守') 
            {
                $data3['['.$siren.']']='守死';
            } 
            else 
            {
                $data3['['.$siren.']']='死';
            }
            
            
            $Database3->save($data3);

        }



        public function nvwu2()        //看昨夜是谁死了
        {
            if (session('jieyao'))     //有解药可以查看昨晚死的人
            {
                $Database3=M('siren');
                $fangjianhao=session('fangjianhao');

                $data=$Database3->where("fangjianhao='$fangjianhao'")->find();

                for ($id=1; $id < 13; $id++) 
                { 
                    if($data['['.$id.']']=='死'||$data['['.$id.']']=='守死')
                        {   
                            
                            $siren=$id;
                            session('siren',$siren);
                            break;
                        }
                }
           
                $this->ajaxReturn($siren);
            // echo $siren;
            }
            else
            {
                $siren='无法查看';
                $this->ajaxReturn($siren);
            }
             
        }

        public function nvwu3()                                    //女巫功能
        {
            $Database=M('langrensha');
            $Database2=M('shenfen');
            $Database3=M('siren');
            $Database4=M('meiyesiren');
            $Database5=M('dijitian');
            $fangjianhao=session('fangjianhao');
            $data1=$Database->where("fangjianhao='$fangjianhao'")->find();
            $data2=$Database2->where("fangjianhao='$fangjianhao'")->find();
            $data3=$Database3->where("fangjianhao='$fangjianhao'")->find();
            $data4=$Database4->where("fangjianhao='$fangjianhao'")->find();
            $data5=$Database5->where("fangjianhao='$fangjianhao'")->find();
            $day=$data5['day'];
            $caozuo=I('post.caozuo');
            

            if ($caozuo=='救') 
            {
                $jieyao=0;         //没有解药了
                session('jieyao',$jieyao);
            
                for ($id=1; $id < 13; $id++) 
                { 
                    if($data3['['.$id.']']=='死')
                    {   
                        $data3['['.$id.']']='0';
                        $Database3->save($data3);
                        break;
                    }

                    if($data3['['.$id.']']=='守死')
                    {   
                        $data3['['.$id.']']='1';
                        $Database3->save($data3);
                        $data4['['.$day.']']=$id;
                        $Database4->save($data4);
                        break;
                    }

                }
            }

            if ($caozuo=='毒') 
            {
                $duyao=0;
                session('duyao',$duyao);
                $dujihao=I('post.dujihao');
                $data3['['.$dujihao.']']='1';                   //1代表确定死了
                $Database3->save($data3);

                $sf=$data2['['.$dujihao.']'];
                for ($id=1; $id < 13; $id++) 
                { 
                    if($data3['['.$id.']']=='死')
                    {   
                        $data3['['.$id.']']='1'; //被狼杀的确定死了
                        $Database3->save($data3);

                        if ($dujihao<$id) {
                            $data4['['.$day.']']=$dujihao.','.$id;
                        } 
                        elseif ($dujihao>$id) {
                            $data4['['.$day.']']=$id.','.$dujihao;    //第几夜死的是谁
                        } 
                        else {
                            $data4['['.$day.']']=$dujihao;
                        }
                        
                        $Database4->save($data4);
                        break;
                    }

                    if ($data3['['.$id.']']=='守死') 
                    {
                        $data3['['.$id.']']='0';
                        $Database3->save($data3);
                        $data4['['.$day.']']=$dujihao;
                        $Database4->save($data4);
                    }
                }
            }

            if ($caozuo=='什么也不做')      //把狼杀的人确定为死人了
            {
                for ($id=1; $id < 13; $id++) 
                { 
                    if($data3['['.$id.']']=='死')
                    {   
                        $data3['['.$id.']']='1';
                        $Database3->save($data3);
                        $data4['['.$day.']']=$id;
                        $Database4->save($data4);
                        break;
                    }

                    if ($data3['['.$id.']']=='守死') {
                        $data3['['.$id.']']='0';
                        $Database3->save($data3);
                    }
                }           
            }
            for ($i=1; $i<13 ; $i++) 
            {
                if ($data3['['.$i.']']=='1') 
                {
                    
                    switch ($data2['['.$i.']']) 
                    {
                        case '村民':
                        $Ejiaose='cunmin';
                        break;
                    
                        case '狼人':
                        $Ejiaose='langren';
                        break;     

                        case '女巫':
                        $Ejiaose='nvwu';
                        break;

                        case '预言家':
                        $Ejiaose='yyj';
                        break;

                        case '猎人':
                        $Ejiaose='lieren';
                        break;

                        case '守卫':
                        $Ejiaose='shouwei';
                        break;

                        case '白痴':
                        $Ejiaose='baichi';
                        break;

                        default:
                        echo '???';
                        break;

                    }

                    $data1[$Ejiaose]--;
                }
            }
            $Database->save($data1);
            $this->ajaxReturn($caozuo);
            
        }

        public function yyj()
        {
            $yanjihao=I('post.yan1');
            $Database2=M('shenfen');
            $fangjianhao=session('fangjianhao');
            $data2=$Database2->where("fangjianhao='$fangjianhao'")->find();
            if ($data2['['.$yanjihao.']']=='狼人') {
                $shenfen='坏人';
            } else {
                $shenfen='好人';
            }
            $this->ajaxReturn($shenfen);
            
        }

        public function shouwei()
        {
            $shoushui=I('post.shoushui');
            $fangjianhao=session('fangjianhao');
            $Database=M('langrensha');
            $Database2=M('shenfen');
            $Database3=M('siren');
            $Database4=M('meiyesiren');
            $Database5=M('dijitian');
            $data1=$Database->where("fangjianhao='$fangjianhao'")->find();
            $data2=$Database2->where("fangjianhao='$fangjianhao'")->find();
            $data3=$Database3->where("fangjianhao='$fangjianhao'")->find();
            $data4=$Database4->where("fangjianhao='$fangjianhao'")->find();
            $data5=$Database5->where("fangjianhao='$fangjianhao'")->find();
            $day=$data5['day'];

            $data3['['.$shoushui.']']='守';
            $Database3->save($data3);
            /*if($data3['['.$shoushui.']']=='死')
            {   
                $data3['['.$shoushui.']']='';
                $Database3->save($data3);
                
            }
            if ($data3['['.$shoushui.']']==$day+1) 
            {
                $data3['['.$shoushui.']']=1;
                    
            }   */ 


            
        }

        public function lieren()
        {
            $daizou=I('post.daizou');
            $Database=M('langrensha');
            $Database2=M('shenfen');
            $fangjianhao=session('fangjianhao');
            $data1=$Database->where("fangjianhao='$fangjianhao'")->find();
            $data2=$Database2->where("fangjianhao='$fangjianhao'")->find();
            
            switch ($data2['['.$daizou.']']) 
                    {
                        case '村民':
                        $Ejiaose='cunmin';
                        break;
                    
                        case '狼人':
                        $Ejiaose='langren';
                        break;     

                        case '女巫':
                        $Ejiaose='nvwu';
                        break;

                        case '预言家':
                        $Ejiaose='yyj';
                        break;

                        case '猎人':
                        $Ejiaose='lieren';
                        break;

                        case '守卫':
                        $Ejiaose='shouwei';
                        break;

                        case '白痴':
                        $Ejiaose='baichi';
                        break;

                        default:
                        echo '???';
                        break;

                    }

                    $data1[$Ejiaose]--;
                    $Database->save($data1);

        }

        public function zuowansideshi()
        {
            $fangjianhao=session('fangjianhao');
            $Database4=M('meiyesiren');
            $data4=$Database4->where("fangjianhao='$fangjianhao'")->find();
           
            $Database3=M('siren');
            $data3=$Database3->where("fangjianhao='$fangjianhao'")->find();
        
        }

        public function tianliangle()
        {
            $fangjianhao=session('fangjianhao');
            $Database4=M('meiyesiren');
            $Database5=M('dijitian');
            $data4=$Database4->where("fangjianhao='$fangjianhao'")->find();
            $data5=$Database5->where("fangjianhao='$fangjianhao'")->find();
            $day=$data5['day'];
            $siderenshi=$data4['['.$day.']'];
            $this->ajaxReturn($siderenshi);
        }

        public function toupiao()
        {
            $fangzhutoupiao=I('post.fangzhutoupiao');
            $fangjianhao=session('fangjianhao');
            $Database=M('langrensha');
            $Database2=M('shenfen');
            $data1=$Database->where("fangjianhao='$fangjianhao'")->find();
            $data2=$Database2->where("fangjianhao='$fangjianhao'")->find();
            switch ($data2['['.$fangzhutoupiao.']']) 
                    {
                        case '村民':
                        $Ejiaose='cunmin';
                        break;
                    
                        case '狼人':
                        $Ejiaose='langren';
                        break;     

                        case '女巫':
                        $Ejiaose='nvwu';
                        break;

                        case '预言家':
                        $Ejiaose='yyj';
                        break;

                        case '猎人':
                        $Ejiaose='lieren';
                        break;

                        case '守卫':
                        $Ejiaose='shouwei';
                        break;

                        case '白痴':
                        $Ejiaose='baichi';
                        break;

                        default:
                        echo '???';
                        break;

                    }

                    $data1[$Ejiaose]--;
                    $Database->save($data1);

        }

        /*public function test()
        {
            echo 2233;
            
            $Daa=M('test');
            $data=$Daa->where("a=7")->find();
            var_dump($data);
            die();
            $data['b']=888;
           /* var_dump($data['a']);
            die();
            $Daa->save($data);
           

        }*/
     



}