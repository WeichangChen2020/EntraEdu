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


    public function t() {

        $no_newer = M('student_info')->where(array('academy'=>'非新生'))->select();

        foreach ($no_newer as $key => $value) {
            
            $name = $value['name'];
            $newer = M('student_list')->where(array('name'=>$name))->find();
            if ($newer) {
                p($newer);

                if ($newer['type'] == 0) {
                    $data = array('academy'=>$newer['academy']);
                    M('student_info')->where(array('name'=>$name))->save($data);
                    M('student_list')->where(array('name'=>$name))->save(array('type'=>1));
                }
            } else{

            }

        }
    }





   
   
}