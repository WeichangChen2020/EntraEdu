<?php
namespace Student\Model;
use Think\Model;
class TeacherSigninModel extends Model {
    /**
     * getSigninList($openId) 获取用户签到列表
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright  2018-1-25 16:07Authors
     * @var  $openId
     * @return  array
     */
    public function getSigninList($openid = '') {

        $class = M('studentInfo')->where(array('openId' => $openid))->field('class')->find();
        if ($class == '') {
            return false;
        } else {
            $map['class'] = array('like','%'.$class['class'].'%');
            $list  = $this->where($map)->order('time desc')->select();
            return $list;
        }
    }

    /**
     * getDetail  签到详细情况
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright 2018-01-25T17:46:26+0800
     * @var
     * @param     string                 $signinId [description]
     * @return    array                            [description]
     */
    public function getDetail($signinId = '') {

        $info = $this->where(array('id' => $signinId))->find();
        $info['class'] = explode('_', $info['class'],-1);
        if ($info == '') {
            return false;
        } else {
            return $info;
        }
    }

    /**
     * setSigninName  生成签到名称
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright 2018-01-26T17:01:41+0800
     * @var
     * @var openId [<description>]
     * @return    string                   [description]
     */
    public function setSigninName($openId){
        $no           = 1;
        $name         = date('m月d日',time())."(".$no.")";
        while (NULL != $this->where(array('signinName'=>$name,'openId'=>$openId))->find()) {
            $name         = date('m月d日',time())."(".$no.")";
            $no++;
        }
        return $name
    }
}