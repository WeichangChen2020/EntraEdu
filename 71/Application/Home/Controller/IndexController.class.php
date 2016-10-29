<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    
   

	public function login (){
		layout(false);
		$this->display();	
	}



    public function index(){

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