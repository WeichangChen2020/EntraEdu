<?php
namespace Admin\Controller;

use Think\Controller;
class StatisController extends Controller
{
    public function index() {
    	$this->display('count');
    }

    public function data() {
    	
        $now = time();
        // $timeArray = new array();
        for($i=1;$i<=60;$i++){
            
            $time = $now - 3600 + 60 * $i;
            $timeArray[] = date('Y-m-d H:i', $time);

            $map = array(
                'gt' => date('Y-m-d H:i', $time),
                'lt' => date('Y-m-d H:i', $time + 60);
            );
            $dataArray[] = D('Exercise')->where($map)->count();
        }

        $data = array($timeArray, $dataArray);
        echo "<pre>";
        var_dump($data);die;

        


     //    $data = array(	
    	// 	'categories' => array("衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜1子"),
    	// 	'data' => array(5, 20, 36, 10, 10, 20),
    	// );
    	// $this->ajaxReturn($data);
    }





   
   
}