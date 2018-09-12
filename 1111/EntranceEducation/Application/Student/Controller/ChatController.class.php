<?php

namespace Student\Controller;
use Think\Controller;

/*管理员类*/
class ChatController extends Controller{

    //社区主页面
    public function index(){
        $CHAT = D('ChatData');
        $list = $CHAT->getList();
        $now  = time();
        $isTeacher = D('teacherInfo')->checkTeacher(session('openId'));
        foreach ($list as $key => $value) {
            $list[$key]['reNum']   = $CHAT->getReplyNum($value['id']);
            if (strlen($list[$key]['contents'])>50) {
                //防止将一个中文字锯开
                $list[$key]['contents']= mb_substr($list[$key]['contents'] , 0 , 40,'utf-8');
                $list[$key]['contents'].= '...';
            }
        }
        $finalList = $CHAT->checkTime($list,'time');
        $this->assign('isTeacher',$isTeacher);
        $this->assign('list',$finalList);
        $this->display();
    }
    //新帖子
    public function create(){
        if (IS_AJAX) {
            $CHAT   = M('ChatData');
            $INFO   = D('StudentInfo');
            $openid = session('?openId') ? session('openId') : $this->error('请重新获取该页面');
            $data   = array(
                'openid'     => $openid,
                'name'       => $INFO->getName($openid),
                'title'      => I('title'),
                'contents'   => I('contents'),
                'belongTo'   => '0',
                'belongFloor'=> '0',
                'replyTo'    => '0',
            );
            if ($CHAT->add($data))
                $this->ajaxReturn('success');
            else
                $this->ajaxReturn('fail');
        }
        $this->display();
    }
    //帖子详情
    public function detail($id=''){
        if (IS_AJAX) {
            $CHAT   = M('ChatData');
            $INFO   = D('StudentInfo');
            $openid = session('?openId') ? session('openId') : $this->error('请重新获取该页面');
            $data   = array(
                'openid'  => $openid,
                'name'    => $INFO->getName($openid),
                'title'   => '',
                'contents'=> I('contents'),
                'belongTo'=> I('belongTo'),
                'belongFloor'=> I('belongFloor'),
                'replyTo'=> I('replyTo'),
            );
            if ($CHAT->add($data))
                $this->ajaxReturn('success');
            else
                $this->ajaxReturn('fail');
        }else{
            if (!session('?openId')) {
                $this->error('请重新获取该页面');
            }
            $isTeacher = D('teacherInfo')->checkTeacher(session('openId'));
            $CHAT   = D('ChatData');
            $info   = $CHAT->where(array('id'=>$id))->select();
            $info   = $CHAT->checkTime($info,'time');
            $list = $CHAT->getFinalList($id);
            $now  = time();
            $list = $CHAT->checkTime($list,'time');
            foreach ($list as $key => $value) {
                if (!empty($value['child'])) {
                    $list[$key]['child'] = $CHAT->checkTime($value['child'],'time');
                }
            }
            $this->assign('id',$id);
            $this->assign('isTeacher',$isTeacher);
            $this->assign('list',$list);
            $this->assign('info',$info);
            $this->display();
        }
    }
    //帖子详情
    public function delete(){
        if (IS_AJAX) {
            $data   = array(
                'id'      => I('id'),
                'delete'  => '1',
            );
            if (M('ChatData')->save($data))
                $this->ajaxReturn('success');
            else
                $this->ajaxReturn('删除失败');
        }
    }

}