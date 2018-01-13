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
    
    // 时间跟答题量的可视化 
        // 时间跟答题人数的可视化
        // 时间 分为 具体到某个小时，某一天

        // 学院跟答题量（正确量）可视化，
        // 性别跟答题量（正确量）的可视化

        // 日志分析系统
    /**
     * 可视化接口
     * @param start 开始时间
     * @param end   结束时间
     * @param type    类型 day 看每一天的，hour 看每一个小时的
     * @param result  结果 1 答题量 2 正确题数
     */
    public function data_v($mouth = 10, $day = -1) {
        $year = 2017;
        $MOUTH = array(10, 11, 12);
        $DAY = array();  //to do 赋值day有效值
        
        // to do  入参校验

        //查月份的
        if ($day == -1) {
            $mouth = $_GET['mouth'] ? $_GET['mouth'] : 10;
            $this->ajaxReturn($mouth);
            $start_time = $year . '-' . $mouth;
            $end_time = $year . '-' . ($mouth+1);
            $sql = "SELECT DATE_FORMAT(time,'%Y-%m-%d' ) as 'date', COUNT(*) as 'ans_cnt' FROM `ee_exercise` where time >= '$start_time' AND time < '$end_time' group by year(time), month(time), day(time)";
            //echo $sql; die;
            $data = D('Exercise')->query($sql);
            $this->ajaxReturn($data);
        } else {
            $start_time = strtotime($year . '-' . $mouth);
            $end_time = strtotime($year . '-' . $mouth+1);
        }
        
        

    }


   
}