<?php
namespace Admin\Model;
use Think\Model;
class ExamSubmitModel extends Model {


    // 正式考试的examid
    public $formal_examid = array(11, 12, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 24, 26);

    /**
     * getSubmitNum 获取提交人数
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright  2017-10-29 14:28 Authors
     * @var  
     * @return  int
     */
    public function getSubmitNum($college,$id) {
        $map = array();
        $map['is_newer'] = 1;
        if (!empty($college)) {
            $map['academy'] = $college;
        }
        $map['examid'] = $id;
        $submitNum = M('ExamSubmit')->where($map)->count();
        return $submitNum;
    }
    /**
     * getFailNum 获取提交人数
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright  2017-10-29 14:28 Authors
     * @var  
     * @return  int
     */
    public function getFailNum($college,$id) {
        $res = $this->getFailList($college,$id);
        return count($res);
    }
    /**
     * getUnsubmitNum 获取未提交人数
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright  2017-10-29 16:59 Authors
     * @var  
     * @return  int
     */
    public function getUnsubmitNum($college,$id) {

        $Student = M('StudentList');

        $map = array();
        $map['is_newer'] = 1;
        if (!empty($college)) {
            $map['academy'] = $college;
        }
        $total = M('StudentInfo')->where($map)->count();
        $map['examid'] = $id;
        $submitNum = M('ExamSubmit')->where($map)->count();
        return $total-$submitNum;
        // if (!is_null($college)) {
        //     $map['academy'] = $college;
        //     $sql = "SELECT  openId FROM ee_student_info, ee_student_list WHERE ee_student_list.number = ee_student_info.number AND ee_student_list.academy = $college AND openId NOT IN (SELECT openid FROM ee_exam_submit WHERE examid = $id)";
        //     $count = $Student->where($map)->count();
        // } else {
        //     $sql = "SELECT  openId FROM ee_student_info, ee_student_list WHERE ee_student_list.number = ee_student_info.number AND openId NOT IN (SELECT openid FROM ee_exam_submit WHERE examid = $id)";
        //     $count = $Student->count();
        // }



        // $sql = "SELECT COUNT(*) FROM ee_exam_submit WHERE examid = '$id' ";

        // $Model = new \Think\Model();
        // $res = $Model->query($sql);

        // if (empty($res)) {
        //     return 'error';
        // }
        // return $count-$res['0']['COUNT(*)'];
    }
    /**
     * getUnsubmitList 获取未提交名单
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright  2017-11-7 16:00 Authors
     * @var  
     * @return  array('openid')
     */
    public function getUnsubmitList($id) {

        $Student = M('StudentList');
        $college = D('Adminer')->getCollege();
        $map = array();

        if (!is_null($college)) {
            $sql = "SELECT  openId FROM ee_student_info, ee_student_list WHERE ee_student_list.number = ee_student_info.number AND ee_student_list.academy = $college AND openId NOT IN (SELECT openid FROM ee_exam_submit WHERE examid = $id)";
        } else {
            $sql = "SELECT  openId FROM ee_student_info, ee_student_list WHERE ee_student_list.number = ee_student_info.number AND openId NOT IN (SELECT openid FROM ee_exam_submit WHERE examid = $id)";
        }

        $Model = new \Think\Model('student_info');
        $res = $Model->query($sql);
        
        return $res;
    }
    
    /**
     * getSubmitList 获取$examid考试的提交 人员名单
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright  2017-11-23 16:35 Authors
     * @var  $id
     * @return  array
     */
    public function getSubmitList($college,$id) {
        if (empty($college)) {
            $res = M('ExamSubmit')->where(array('examid'=>$id))->select();
        }else{
            $STUDENT = D('StudentInfo');
            $res = array();
            $list = M('ExamSubmit')->where(array('examid'=>$id))->select();
            foreach ($list as $key => $value) {
                $info = $STUDENT->getInfo($value['openid']);
                if($info['0']['academy']==$college)
                    array_push($res, $value);
            }
        }
        if (empty($res)) {
            return 0;
        }
        return $res;
    }
    
    /**
     * getFailList 获取$examid考试的提交 人员名单
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright  2017-11-23 16:35 Authors
     * @var  $id
     * @return  array
     */
    public function getFailList($college,$id) {
        $res = array();
        $submitList = $this->getSubmitList($college,$id);
        foreach ($submitList as $key => $value) {
            if (pass(getResult(getNumberByOpenid($value['openid']))) == '否') {
                array_push($res, $value);
            }
        }
        return $res;
    }


}

