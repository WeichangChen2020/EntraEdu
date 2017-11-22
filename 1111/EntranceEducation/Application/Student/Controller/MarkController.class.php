<?php

namespace Student\Controller;
use Think\Controller; 


/**
 * 积分类
 */

class MarkController extends Controller{

    public function index(){

        $openId=session('openId');
        session('openId',$openId);

        $this->display('markClass');
    }

    public function markClass(){

        $openId   = session('openId');  
        $MARK = D('StudentMark');
        $STUDENT = M('studentInfo');
        if (IS_AJAX) {
            if(session('?start')){
                $start = session('start') + 20;
                session('start',$start );
            } else {
                session('start',0);
                $start = 0;
            }
            $rankList = $MARK->getRankList($start);
            // P($rankList);
            // foreach($rankList as $key => $value){
            //     $rankList[$key]['info'] = $STUDENT->where(array('openId' => $value['openid']))->find();
            // }
            $this->ajaxReturn($rankList);

        } else {
            session('start',0);
            // dump($openId);
            $rankList = $MARK->getRankList();
            //P($rankList);
            // foreach($rankList as $key=>$value){
            //     $rankList[$key]['info'] = $STUDENT->where(array('openId' => $value['openid']))->find();
            // }
            //P($rankList);
            $this->assign('rankList',$rankList);
            $this->display();
        }

    }    
    
    //积分更新接口
    public function update(){
        $STU  = M('student_info')->getField('openId', true); // 获取openId数组
        $MARK = M('student_mark');
        foreach ($STU as $value) {
            $markInfo = $this->getDetails($value);
            $markInfo['lastMark'] = $this->getMark($value);
            if($MARK->where(array('openId' => $value))->find())
                $MARK->where(array('openId' => $value))->save($markInfo);
            else
                $MARK->add($markInfo);
        }
    }

    public function rank() {
        $r = new SaeRank();
        $r->create("list", 100); //创建一个榜单。
        $r->set("list", "a", 3); //设置值
        $r->set("list", "b", 4);
        $r->set("list", "c", 1);
        $r->increase("list", "c"); //增加值
        $ret = $r->getList("list", true); //获得排行榜
        dump($ret);
        $ret = $r->getRank("list", "a"); //获得某个键的排名,注意是从0开始
        dump($ret);
        $r->clear("list"); //清空排行榜
    }

    // 查询成绩详细信息
    public function getDetails($openId){
        /*========定义一些变量==========*/
        $MESSREC     = M('weixin_message_record');   
        //$COM_COMMENT = M('community_comment');
        //$COM_REPLY   = M('community_reply');
        //$RAN_COMMENT = M('random_comment');
        //$RAN_REPLY   = M('random_reply');
        $RAN_RECORD  = M('random_answer_record');
        //$CLASSTEST   = M('student_classtest_record');
        $EXAM   = M('exam_select');
        $SIGNIN      = M('student_signin');
        $HOMEWORK    = M('student_homework');//这个表里字段名是openId
        $user        = new UserController();

        $mark = array();
        $mark = array_merge($mark,$user->getUserInfo($openId));
        $mark['weixinMessageNum']  = $MESSREC->where(array('openId' => $openId))->count();   //微信后台回复的数量
        //$mark['comCommentNum']     = $COM_COMMENT->where(array('openId' => $openId))->count();    //社区留言评论
        //$mark['comReplyNum']       = $COM_REPLY->where(array('openId' => $openId))->count();         //社区留言回复
        //$mark['ranCommentNum']     = $RAN_COMMENT->where(array('openId' => $openId))->count(); //自由练习评论
        //$mark['ranReplyNum']       = $RAN_REPLY->where(array('openId' => $openId))->count();   //自由练习回复
        $mark['doRanNum']          = $RAN_RECORD->where(array('openid' => $openId))->count();   //自由练习做的题目的个数
        $mark['doRanRightNum']     = $RAN_RECORD->where(array('openid' => $openId,'result' => '1'))->count();   //自由练习答对题数
        $mark['registerNum']       = $user->isRegister($openId) ? 1 : 0; //是否注册
        $mark['classTestNum']      = $EXAM->where(array('openid' => $openId))->count();//参与测试次数
        $mark['classTestRightNum'] = $EXAM->where(array('openid' => $openId,'result' => '1'))->count();//模拟测试答对题数
        $mark['signinNum']         = $SIGNIN->where(array('openid' => $openId))->count();//签到次数
        $homeworkMark = $HOMEWORK->where(array('openId' => $openId))->sum('mark');
        if(empty($homeworkMark))
            $mark['homeworkMark'] = 0;
        else 
            $mark['homeworkMark'] = $HOMEWORK->where(array('openId' => $openId))->sum('mark');

        return $mark;
    }

    public function getMark($openId){
        $markInfo = $this->getDetails($openId);
        $markWeight = M('student_mark_weight')->find(1);
        
        $mark = $markInfo['weixinMessageNum'] * $markWeight['weixinMessage'] 
        //+ $markInfo['comCommentNum'] * $markWeight['comComment'] 
        //+ $markInfo['comReplyNum'] * $markWeight['comReply'] 
        //+ $markInfo['ranCommentNum'] * $markWeight['ranComment']
        //+ $markInfo['ranReplyNum'] * $markWeight['ranReply'] 
        + $markInfo['doRanNum'] * $markWeight['doRan']
        + $markInfo['doRanRightNum'] * $markWeight['doRanRight'] 
        + $markInfo['registerNum'] * $markWeight['register']
        + $markInfo['classTestNum'] * $markWeight['classTest'] 
        + $markInfo['classTestRightNum'] * $markWeight['classTestRight']
        + $markInfo['signinNum'] * $markWeight['signin'] 
        + $markInfo['homeworkMark'] * $markWeight['homework'] / 5;
        
        return ($mark);
    }



    /**
     * markMenu  这里的markMenu与User类的markMenu区别是：这里是教师端看到的，User是学生端看到的
     *
     */
    
    //导出成绩报表
    public function exportExcel($arr=array(),$title=array(),$filename='计算机网络成绩统计表'){
        $MARK = M('student_mark');
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");  
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        //数据库对应xls标题的定义
        $title=array('id','openId','name','number','class','weixinMessageNum','comCommentNum','comReplyNum','ranCommentNum','ranReplyNum','doRanNum','doRanRightNum','registerNum','classTestNum','classTestRightNum','signinNum','lastMark');
        if (!empty($title)){
            foreach ($title as $k => $v) {
                $title[$k]=iconv("UTF-8", "GB2312",$v);
            }
            $title= implode("\t", $title);
            echo "$title\n";
        }
        //查询数据库  $arr 是二维数组

        $arr = $MARK->select();
        if(!empty($arr)){
            foreach($arr as $key=>$val){
                foreach ($val as $ck => $cv) {
                    $arr[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
                }
                $arr[$key]=implode("\t", $arr[$key]);
            }
            echo implode("\n",$arr);
        }
    }


    public function markMenu(){
        $openId = session("openId");
        if(!$openId){
            $openId = getOpenId();
            session('openId',$openId);
        }
        $this->display();
    }
    
    public function markWeight(){
        $weight = M('student_mark_weight')->find(1);
        $this->assign('weight',$weight)->display();
    }

    public function setMarkWeigth(){
        $weight = I();
        $weight['openId'] = session('openId');
        $weight['name'] = M('teacher_info')->where(array('openId'=>$weight['openId']))->getField('name');
        $weight['comComment'] = $weight['ranReply'] = $weight['ranComment'] = $weight['comReply'] ;
        
        
        if(M('student_mark_weight')->where(array('id'=>1))->save($weight))
            $this->success('修改成绩权重成功',U('Teacher/index'));
        else
            $this->error('修改成绩权重失败');
    }



}