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
        for($i=1;$i<=180;$i++){
            
            $time = $now - 3 * 60 * 60 + 60 * $i;
            $timeArray[] = date('Y-m-d H:i', $time);

            
            $map['time']  = array('between',array(date('Y-m-d H:i', $time),date('Y-m-d H:i', $time+60)));
            $dataArray[] = D('Exercise')->where($map)->count();
        }

        $data = array(
            'x_data'=>$timeArray, 
            'y_data'=>$dataArray
        );
        
        $this->ajaxReturn($data);
    }


    public function getSum() {

        $sum = D('Exercise')->count();

        $this->ajaxReturn($sum);
    }


   
}