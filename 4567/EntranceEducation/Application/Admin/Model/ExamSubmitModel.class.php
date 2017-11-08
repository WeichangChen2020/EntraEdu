<?php
namespace Admin\Model;
use Think\Model;
class ExamSubmitModel extends Model {

    /**
     * getSubmitNum 获取提交人数
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright  2017-10-29 14:28 Authors
     * @var  
     * @return  int
     */
    public function getSubmitNum($id) {

        $sql = "SELECT COUNT(*) FROM ee_exam_submit WHERE examid = '$id' ";

        $Model = new \Think\Model();
        $res = $Model->query($sql);

        if (empty($res)) {
            return 0;
        }
        return $res['0']['COUNT(*)'];
    }
    /**
     * getUnsubmitNum 获取未提交人数
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright  2017-10-29 16:59 Authors
     * @var  
     * @return  int
     */
    public function getUnsubmitNum($id) {

        $Student = M('StudentList');

        $college = D('Adminer')->getCollege();
        $map = array();

        if (!is_null($college)) {
            $map['academy'] = $college;
        }

        $count = $Student->where($map)->count();


        $sql = "SELECT COUNT(*) FROM ee_exam_submit WHERE examid = '$id' ";

        $Model = new \Think\Model();
        $res = $Model->query($sql);

        if (empty($res)) {
            return 'error';
        }
        return $count-$res['0']['COUNT(*)'];
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
            $map['academy'] = $college;
            $sql = "SELECT openid FROM ee_student_info WHERE  academy= $college AND NOT EXISTS (SELECT openid FROM ee_exam_submit where examid = '$id' )";
        } else {
            $sql = "SELECT openid FROM ee_student_info WHERE NOT EXISTS (SELECT openid FROM ee_exam_submit where examid = $id )";
        }

        $Model = new \Think\Model();
        $res = $Model->query($sql);
        dump($sql);
        dump($res);die;


        return $res;
    }


}