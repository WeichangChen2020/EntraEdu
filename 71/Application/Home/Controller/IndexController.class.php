<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    
   

	public function login (){
		layout(false);
		/*$openid = I('get.openid');*/
		$openid=isset($_GET['openid'])?I('get.openid'):session('openid');
        //echo 'a'.$openid;
        session('openid',$openid);
		$this->display();	

		
        	}



    public function index(){
		$openid = I('get.openid');
        //echo 'a'.$openid;
        session('openid',$openid);

        /*$Info=M('user');
        $data= $Info->where("id='{$openid}'")->find();*/
      /*  if(1)
        {
            $this->success('充电成功！退出并前往其他页面',$this->display(),3);//不确定这样display行不行
                //session('class',$data['class']);
                //session('number',$data['number']);
                //session('perimission',$data['perimission']);
        }
        else
        {
            $this->success('未注册，请完成注册',U('Register/register'));
        }*/

		$this->display();
    }


    public function check(){
        $user=I('post.');
        session('user',$user);
		$Db=M('user');
		$result=$Db->where("id='$user[id]'")->find();
		

		if ($result) {
			if ($result[password]==$user[password]&&$user[password]!='0') {
				$this->success('欢迎你'.$user[id],'index',1);
			} else {
				$this->error('密码错误');
					}			
			}
		else {
				$this->error('帐号错误');	
				}

    }
}