<?php 
namespace Admin\Controller;
use Think\Controller;

/**
 * EXAM 控制器 新生考试 模拟考试
 * @author 李俊君<hello_lijj@qq.com>
 * @copyright  2017-9-12 15:08Authors
 * @var  
 * @return 
 */
class ExamController extends CommonController{
    
    /**
     * index 自由练习主页面 能显示当前进度，答题了多少道
     * @author 李俊君<hello_lijj@qq.com>
     * @copyright  2017-9-10 9:39Authors
     * @var  
     * @return 
     */

    public function index() {

        $examList = D('ExamSetup')->select();
        // p($examList);
        $this->assign('examList', $examList);
        $this->display();
    }


    /**
     * add 创建新生考试
     * @author 李俊君<hello_lijj@qq.com>
     * @copyright  2017-9-15 21:18Authors
     * @var  
     * @return 
     */
    public function add() {
        if (IS_POST) {
            
            $st = I('start_time');
            $st = str_replace('T', ' ', $st).':00';

            $data = array(
                'title' => I('title'),
                'start_time' => strtotime($st),
                'set_time' => I('spend_time'),
                'is_on' => intval(I('is_on')),
                'time' => date('Y-m-d H:i:s'),
            );

            $res = D('ExamSetup')->add($data);

            if($res) {
                if (D('ExamCollege')->init($res)) {
                    $this->success('考试创建成功', U('Exam/index'));
                }else{
                    $this->error('初始化失败');
                }
            } else {
                $this->error('考试创建失败');
            }

        } else {
            
            $this->display();
        }
    }

    /**
     * delete 创建新生考试
     * @author 李俊君<hello_lijj@qq.com>
     * @copyright  2017-9-15 21:18Authors
     * @var  
     * @return 
     */
    public function delete($id = 0) {

        $res = M('exam_setup')->where(array('id' => $id))->delete();

        if($res) {
            $this->success('删除成功', U('Exam/index'));
        } else {
            $this->success('删除失败', U('Exam/index'));
        }
    }

    /**
     * edit 设置考试信息
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright  2017-9-16 11:12Authors
     * @var  $id
     * @return 
     */
    public function edit($id = 0) {
        if (IS_POST) {
        	$SET = M('ExamSetup');

            $st = I('start_time');
            $st = str_replace('T', ' ', $st).':00';
            $time = $SET->where(array('id'=>$id))->field('time')->find();
            $data = array(
                'title' => I('name'),
                'start_time' => strtotime($st),
                'set_time' => I('set_time'),
                'is_on' => intval(I('is_on')),
                'time' => $time['time'],
            );
            if($SET->data($data)->where(array('id' => $id))->save($date))
            	$this->success('修改成功', U('Exam/index'));
            else
            	$this->error('修改失败', U('Exam/index'));
        }else{

            $info = M('ExamSetup')->find($id);
            $this->assign('info',$info)->display();
        }
    }

    /**
     * addQues 添加（设置）考试章节题目数量
     * @author 李俊君<hello_lijj@qq.com>
     * @copyright  2017-9-16 11:12Authors
     * @var  $id
     * @return 
     */
    public function addQues($id) {
        if (IS_POST) {
            $data = I();
            foreach ($data as $key => $value) {
                $quesData = array();
                $quesData['examid'] = $id;
                $quesData['chapid'] = intval(substr($key, 8));
                $quesData['chap_num'] = intval($value);

                D('ExamQuestionbank')->add($quesData);
                
            }
            $this->success('题目添加成功', U('Exam/index'));
        } else {
            
            $examList = D('ExamSetup')->where(array('id'=>$id))->find();
            // dump($examList['title']);
            $chapterList = M('QuestionChapter')->select();
            foreach($chapterList as $key=>$value){
                $chapterList[$key]['maxNum']=D('Student/Questionbank')->getQuesChapterNum($key+1);
                $map = array(
                    'examid'=>$id,
                    'chapid'=>$value['id'],
                );
                $selectNum = M('ExamQuestionbank')->where($map)->getField('chap_num');
                $chapterList[$key]['selectNum']=is_null($selectNum) ? 0 : $selectNum;
            }
            // dump($chapterList);
            $this->assign('chapterList',$chapterList);

            $this->assign('examList',$examList['title']);

            $this->display();
        }

    }


    /**
     * college 设置考试参与学院信息
     * @author 李俊君<hello_lijj@qq.com>
     * @copyright  2017-10-26 13:05Authors
     * @var  $id
     * @return 
     */
    public function college($id) {
        //创建考试的时候就已经向exam_college写入数据

        if (IS_POST) {
            # code...
        } else {
            $list = D('ExamCollege')->getInfo($id);
            if ($list == false) {
                $this->error('读取失败');
            }
            $this->assign('list',$list);
            
            $this->display();
        }
    }

    public function editCollege($id, $state) {
        $COLLEGE = M('ExamCollege');
        if ($state == 0) {
            $state = 1;
        } else {
            $state = 0;
        }
        $data = $COLLEGE ->where(array('id'=>$id))->find();
        $data['state'] = $state;
        if ($COLLEGE->save($data)) {
            $this->success('修改成功', U('college',array('id'=>$data['examid'])));
        }else{
            $this->error('修改失败！', U('college',array('id'=>$data['examid'])));
        }

    }



    /**
     * inInit 为每一个学生创建一套考试题目
     * @author 李俊君<hello_lijj@qq.com>
     * @copyright  2017-11-23 10:40Authors
     * @var  $id
     * @return 
     */
    public function createExamQues($examid, $again = 2) {

        $EXAM    = D('Student/ExamSelect');
        $college = D('Student/ExamCollege')->getCollege($examid);
        $EXAM_SUBMIT = D('ExamSubmit');

        foreach ($college as $key => &$value) {

            if ($again == 2) {
                $this->error('你还没有传again 参数');
            }

            if ($again == 0) {

                $openidArr = M('Student_info')->where(array('academy'=>$value['academy']))->field('openId')->select();
                foreach ($openidArr as $k => $v) {
                    $is_init = $EXAM->isInit($v['openId'], $examid);//判断学生用户的这次题目是否初始化
                    if(!$is_init) {     //表里为空

                        $init = $EXAM->initExam($v['openId'], $examid);  // 往表里add题目
                        if ($init) {
                            echo $v['openId'].'同学'.$examid.'考试题目生成成功'.'<br/>';
                        } else {
                            echo $v['openId'].'同学'.$examid.'考试题目生成失败'.'<br/>';
                        }
                    } else {
                        echo $v['openId'].'同学'.$examid.'考试题目已经存在！'.'<br/>';
                    }
                }
            }


            if ($again == 1) {

                $list = $EXAM_SUBMIT->getUnPass($value);

                foreach ($list as $k => $v) {
                    $is_init = $EXAM->isInit($v['openId'], $examid);//判断学生用户的这次题目是否初始化
                    if(!$is_init) {     //表里为空

                        $init = $EXAM->initExam($v['openId'], $examid);  // 往表里add题目
                        if ($init) {
                            echo $v['openId'].'同学'.$examid.'考试题目生成成功'.'<br/>';
                        } else {
                            echo $v['openId'].'同学'.$examid.'考试题目生成失败'.'<br/>';
                        }
                    } else {
                        echo $v['openId'].'同学'.$examid.'考试题目已经存在！'.'<br/>';
                    }
                }
                # code...
            }
            


        }

        //$this->error('题目已经生成');
    }

    /**
     * preview 预览所有可以参加考试的学生信息
     * @author 蔡佳琪
     * @copyright  2017-11-28 20:45Authors
     * @var  
     * @var  $again  1:表示补考 0 表示首次考试
     * @return 
     */

    public function preview($examid, $again = 0) {

        $EXAM_SUBMIT = D('ExamSubmit');
        $EXAM    = D('Student/ExamSelect');
        $college = D('Student/ExamCollege')->getCollege($examid);
        $stuList = array();
        foreach ($college as $key => &$value) {
            if($again == 0) {
                $list = M('student_info')->where(array('academy'=>$value['academy']))->select();
                $stuList = array_merge($stuList, $list);
            }
            if($again == 1)
            {
                $list = $EXAM_SUBMIT->getUnPass($value);
            }
            $stuList = array_merge($stuList, $list);
        }

        $this->assign('userList',$stuList);
        $Page = new \Think\Page($count,20);
        $show = $Page->show();
        $this->assign('page', $show);
        $this->display();
    }

    /**
     * previewExamQues 预览某个学生的考试题目
     * @author 李俊君<hello_lijj@qq.com>
     * @copyright  2017-11-28 10:45Authors
     * @var  $examid  考试id
     * @var  $openid  学生id
     * @return 
     */
    public function previewExamQues($openid, $examid) {

        $ExamSelect = D('Student/ExamSelect');
        $examItem   = $ExamSelect->getExamItemList($openid, $examid);

        p($examItem); die;
        
    }


    public function unpass($examid) {
        $EXAM    = D('Student/ExamSelect');
        $college = D('Student/ExamCollege')->getCollege($examid);

        foreach ($college as $key => &$value) {
            $openidArr = M('Student_info')->where(array('academy'=>$value['academy']))->field('openId, name, number, class, academy')->select();
            foreach ($openidArr as $k => &$v) {
                $map = array(
                    'examid' => $examid,
                    'openid' => $v['openId'],
                    'result' => 1,
                );
                $v['score'] = $EXAM->where($map)->count();
                $v['is_pass'] = $v['score'] >= 80 ? '通过' : '不通过';

            }

        }
    }

}

