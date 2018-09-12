<?php
namespace Student\Model;
use Think\Model;
class StudentSigninModel extends Model {

    /**
     * isSignin  是否已签到
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright 2018-01-25T16:21:36+0800
     * @var
     * @param     string                   $openId   [description]
     * @param     int                      $signinId [description]
     * @return    boolean                            [description]
     */
    public function isSignin($openId,$signinId){
        if($this->where(array('openId' => $openId,'signinId' => $signinId))->find())
            return true;
        else 
            return false;
    }

    /**
     * getSigninNum   获取某次签到的已签到人数
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright 2018-01-25T16:25:39+0800
     * @var
     * @param     int                   $signinId [description]
     * @return    int                             [description]
     */
    public function getSigninNum($signinId){
        return $this->where(array('signinId'=>$signinId))->count();
    }

    /**
     * updateSignin  修改签到情况
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright 2018-01-30T22:04:31+0800
     * @var
     * @param     $openId                   $openId 用户openId
     * @param     string                   $func   类型 dai：代签;jia：请假;que：缺席
     * @return    string                           error传参错误，fail修改错误；success成功
     */
    public function changeSignin($openId,$func){
        if (empty($openId)) {
            return 'error';
        }
        $studentInfo = M('StudentInfo')->where(array('openId' => $openId))->find();
        $teacherInfo = M('TeacherSignin')->where(array('openId'=>session('openId')))->find();
        $studentInfo['signinId'] = session('signinId');
        $signin        = array(
            'openId'   => $studentInfo['openId'],
            'name'     => $studentInfo['name'],
            'class'    => $studentInfo['class'],
            'number'   => $studentInfo['number'],
            'signinId' => $studentInfo['signinId'],
                //代签坐标与老师相同
            'latitude' => $teacherInfo['latitude'],
            'longitude'=> $teacherInfo['longitude'],
            'accuracy' => $teacherInfo['accuracy'],
            'time'     => date('Y-m-d H:i:s',time()),
        );
        if ($func == 'dai') {
            $signin['location'] = '代';
        }else if($func == 'jia'){
            $signin['location'] = '假';
        }
        //如果缺席操作则删除数据
        if ($func == 'que') {
            if (false == $this->where(array('openId' => $openId ))->delete()) {
                return 'fail';
            }else{
                return 'success';
            }
        }
        //判断数据库有没有该数据
        if(NULL == $this->where(array('openId'=>$studentInfo['openId']))->find()){
            return $this->add($signin) == false ? 'fail':'success';
        }else{
            return $this->where(array('openId'=>$studentInfo['openId']))->save($signin) == false ? 'fail':'success';
        }

    }
}