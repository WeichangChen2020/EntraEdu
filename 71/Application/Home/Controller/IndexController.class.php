<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    
   

	public function login (){
		layout(false);
		/*$openid = I('get.openid');*/
		$openid=isset($_GET['openid'])?I('get.openid'):session('openid');
		session('openid',$openid);
		

        //echo 'a'.$openid;
        /*session('openid',$openid);*/
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


    public function add(){
    	$user=I('post.');
    	$Db=M('user');
    	$data['id']=session.openid;
    	$data['name']=$user.name;
    	$data['password']=$user.password;
    	$Db->add($data);







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



    public function testAcm1()
    {
        $this->display();
    }

    public function testAcm2()
    {
        print_r("34342344242");
        // $url='http://acm.gailvlunpt.com/submit.php';
        

        // $post_data = array (

        //         "id"        =>"1000"
        //         "language"  =>"0"
        //         "source"    =>"dfsaasf"
        //         "input_text"=>"1 2"
        //         "out"       =>"SHOULD BE:3"
        //         "csrf"      =>"V1kzljZNesiWoDexDa15qOGUKiFQrwGf"

        //     );

        //     $ch = curl_init();

        //     curl_setopt($ch, CURLOPT_URL, $url);

        //     //设置头文件的信息作为数据流输出  
        //     curl_setopt($ch, CURLOPT_HEADER, 0); 
        //     //设置获取的信息以文件流的形式返回，而不是直接输出。
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //      // 设置请求为post类型
        //     curl_setopt($ch, CURLOPT_POST, 1);
        //     // 添加post数据到请求中
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        //     $libReturn = curl_exec($ch);

        //     curl_close($ch);

        //     var_dump($libReturn); 
    }


}