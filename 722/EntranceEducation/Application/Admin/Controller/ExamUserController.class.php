<?php 
namespace Admin\Controller;
use Think\Controller;

/**
 * EXAMUSER 控制器 新生考试 模拟考试
 * @author 陈伟昌<1339849378@qq.com>
 * @copyright  2017-10-29 14:128Authors
 * @var  
 * @return 
 */
class ExamUserController extends CommonController{
    
    /**
     * index 模拟考试主页面 显示考试列表，提交人数等
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright  2017-10-29 14:12Authors
     * @var  
     * @return 
     */

    public function index() {

        $EXAM = M('ExamSetup');
        $EXAMCOLLEGE = D('ExamCollege');

        $college = D('Adminer')->getCollege();
        $list = $EXAMCOLLEGE->getExamList($college);
        foreach ($list as $key => $value) {
            $list[$key]['info'] = $EXAM->where(array('id' => $value['examid']))->find();
        }
        $this->assign('examList',$list);

        $this->display();
    }

    /**
     * submiter 提交人员详情
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright  2017-11-7 15:50Authors
     * @var  
     * @return 
     */

    public function submiter($id = 0) {

        $college = D('Adminer')->getCollege();
        $STUDENT = M('ExamSubmit');
        // $submitList = $STUDENT->getSubmitList($college,$id);
        if (!is_null($college)) {
            $map['academy'] = $college;
        }
        $submitList = $STUDENT->where($map)->page($_GET['p'].',20')->select();

        $count = $STUDENT->where($map)->count();
        
        $this->assign('submitList',$submitList);

        $Page       = new \Think\Page($count,20);
        $show       = $Page->show();
        $this->assign('page', $show);
        
        $this->assign('export', 1);
        $map['score'] = array('lt','60');
        $this->assign('failNum',$STUDENT->where($map)->count());
        $this->assign('submitNum', $count);
        $this->assign('id',$id);
        $this->display();
    }
    /**
     * fail 考试未通过名单
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright  2017-11-23 17:33Authors
     * @var  
     * @return 
     */

    public function fail($id = 0) {
        $college = D('Adminer')->getCollege();
        $STUDENT = M('ExamSubmit');
        $map = array();
        // $submitList = $STUDENT->getSubmitList($college,$id);
        if (!is_null($college)) {
            $map['academy'] = $college;
        }
        $map['score'] = array('lt','60');
        $failList = $STUDENT->where($map)->page($_GET['p'].',20')->select();

        $count = $STUDENT->where(array('academy'=>$college))->count();
        
        $this->assign('submitList',$failList);

        $Page       = new \Think\Page($count,20);
        $show       = $Page->show();
        $this->assign('page', $show);
        
        $this->assign('export', 0);

        $this->assign('failNum',$STUDENT->where($map)->count());
        $this->assign('submitNum', $count);
        $this->assign('id',$id);
        $this->display();
    }

    /**
     * 导出$id号考试信息到excel
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright  2017-11-24 18:00Authors
     * @var  
     * @return 
     */
    public function export($type,$id) {

        $SUBMIT = D('ExamSubmit');

        // 查询条件
        $college = D('Adminer')->getCollege();
        $map = array();

        if (!is_null($college)) {
            $map['academy'] = $college;
        }

        $title = array( '姓名', '班级', '学号','得分','是否通过');
        $filename  = is_null($college) ? '浙江工商大学' : $college;
        $filename .= D('ExamSetup')->getExamName($id);
        dump($filename);die;
        if($type == 1) {
            $openid = $SUBMIT->where(array('examid'=>$id))->field('openid')->select();
            foreach ($openid as $key => $value) {
                $list[$key]['name'] = getNameByOpenid($value['openid']);
                $list[$key]['class'] = getClassByOpenid($value['openid']);
                $list[$key]['number'] = getNumberByOpenid($value['openid']);
                $list[$key]['result'] = $value['score'];
                $list[$key]['result'] = pass($value['score']);
            }
            $filename .= '提交用户';
        } else {
            $map['score'] = array('lt','60');
            $openid = $SUBMIT->where($map)->select();
            foreach ($openid as $key => $value) {
                $list[$key]['name'] = getNameByOpenid($value['openid']);
                $list[$key]['class'] = getClassByOpenid($value['openid']);
                $list[$key]['number'] = getNumberByOpenid($value['openid']);
                $list[$key]['result'] = $value['score'];
                $list[$key]['result'] = pass($value['score']);
            }
            $filename .= '未通过用户';
        }

        $this->excel($list, $title, $filename);
    }

    //导出成绩报表
    public function excel($arr=array(),$title=array(),$filename='export'){
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");  
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
      
        if (!empty($title)){
            foreach ($title as $k => $v) {
                $title[$k]=iconv("UTF-8", "GB2312",$v);
            }
            $title= implode("\t", $title);
            echo "$title\n";
        }
        //查询数据库  $arr 是二维数组

        if(!empty($arr)){
            foreach($arr as $key=>$val){
                foreach ($val as $ck => $cv) {
                    $arr[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
                }
                $arr[$key]=implode("\t", $arr[$key]);
            }
            echo implode("\n",$arr);
        }

        die;
        // 使用die是为了避免输出多余的模板html代码
    }

    //更新学生答题进度
    public function update(){
        $STUDENT = M('StudentInfo');
        $List = $STUDENT->select();
        $count = M('Questionbank')->count();
        foreach ($List as $key => $value) {
            $wNum = D('Student/Exercise')->getCurrentProgress($value['openId']);
            dump($wNum);
            
            $value['present'] = $wNum/$count;
            $STUDENT->save($value);
            dump($value);
        }
    }
    // public function test(){
    //     $SELECT = M('ExamSelect');
    //     $SUBMIT = M('ExamSubmit');
    //     $List = M('ExamSubmit')->select();
    //     foreach ($List as $key => $value) {
    //         // $info = D('StudentInfo')->getInfo($value['openid']);
    //         // $value['academy'] = $info['0']['academy'];
    //         $score = $SELECT->where(array('openid'=>$value['openid'],'examid'=>$value['examid'],'result'=>1))->count();
    //         $value['score'] = $score;
    //         $SUBMIT->save($value);
    //     }
    // }


}