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
            //代签坐标在老师坐标基础上加一个随机数(防止在地图上重合)
            'latitude' => $teacherInfo['latitude']+0.00000001*rand(-15000,15000),
            'longitude'=> $teacherInfo['longitude']+0.00000001*rand(-15000,15000),
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
            if (false == $this->where(array('openId' => $openId,'signinId'=>$studentInfo['signinId']))->delete()) {
                return 'fail';
            }else{
                return 'success';
            }
        }
        //判断数据库有没有该数据
        if(NULL == $this->where(array('openId'=>$studentInfo['openId'],'signinId'=>$studentInfo['signinId']))->find()){
            return ($this->add($signin) == false) ? 'fail':'success';
        }else{
            return $this->where(array('openId'=>$studentInfo['openId'],'signinId'=>$studentInfo['signinId']))->save($signin) == false ? 'fail':'success';
        }
    }

   /**
    * getdistance  求两个已知经纬度之间的距离,单位为米
    * @author 陈伟昌<1339849378@qq.com>
    * @copyright 2018-03-01T15:43:10+0800
    * @var
    * @param lng1 $ ,lng2 经度
    * @param lat1 $ ,lat2 纬度
    * @return    float                     单位米
    */
    function getdistance($lng1, $lat1, $lng2, $lat2) {
        // 将角度转为狐度
        $radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
        return $s;
    } 
}