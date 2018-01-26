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
        if(M('student_signin')->where(array('openId' => $openId,'signinId' => $signinId))->find())
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
        return M('student_signin')->where(array('signinId'=>$signinId))->count();
    }
}