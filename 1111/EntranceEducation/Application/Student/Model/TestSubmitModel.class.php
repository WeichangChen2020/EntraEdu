<?php 
namespace Student\Model;
use Think\Model;

/**
 * 随堂测试提交模型
 * @author 蔡佳琪
 * @copyright  2017-12-19 19:39
 *
 */

class TestSubmitModel extends Model {
	
	public function isSubmit($openId,$testid){
        if(M('test_submit')->where(array('openid' => $openId,'testid' => $testid))->find())
            return true;
        else
            return false;
    }
    
    //获取提交人数
    public function getSubmitNum($testid){
        // $testList = M('test_submit')->where(array('testid' => $testid))->select();
        // $tea      = new TeacherController();
        // $testStu  = $tea->array_unset($testList,'openid');
        // return count($testStu);
        $submitNum = M('test_submit')->where(array('testid' => $testid))->count();
        return $submitNum;
    }

    //获取提交人数
    // public function getSubmitNum($testid){
    //     $testList = M('test_submit')->where(array('testid' => $testid))->select();
    //     $tea      = new TeacherController();
    //     $testStu  = $tea->array_unset($testList,'openid');
    //     return count($testStu);
    // }

}

 ?>