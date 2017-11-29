<?php
namespace Admin\Controller;
use Think\Controller;
class QuestionController extends CommonController {
    
    public function index(){

        $Question = M('Questionbank');
        $list = $Question->page($_GET['p'].',20')->select();
        $this->assign('questionList',$list);

        $count      = $Question->count();
        $this->assign('count', $count);
        $Page       = new \Think\Page($count,20);
        $show       = $Page->show();
        $this->assign('page',$show);
       
        $this->display();
    }

    public function quesRec() {



    }

    //题目修改界面
    public function edit($id){
        if (IS_POST) {
        	$QUESTION = M('questionbank');
            $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
            // dump($data);
            if ($QUESTION->where(array('id' => $id))->save($data))
	            $this->success('题目修改成功', U('Question/index'));
            else
            	$this->error('修改失败');
        } else {
            $question = M('Questionbank')->where(array('id'=>$id))->find();
            // dump($question);
            $this->assign('question',$question);
            $this->display();
        }
    }
    //增加题目
    public function add(){
    	if (IS_POST) {
	        $QUESTION = M('Questionbank');
	        $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
	        if ($QUESTION->add($data))
	        	$this->success('题目添加成功',U('Question/add'));
	        else
	        	$this->error('添加失败');
    	}
    	$this->display();
    }

    //删除题目
    public function delete($id){
        $QUESTION = M('Questionbank');
        $QUESTION->where(array('id' => $id))->delete();
        $this->success('题目删除成功', U('Question/index'));
    }

    //搜索题目
    //搜索条件为空则显示全部，搜索结果返回到result数组
    public function search(){
    	if (IS_POST) {
	        $QUESTION = M('Questionbank');
	        $data = I();
            $data = array_map('trim', $data);  //trim去除多余回车
            if (!empty($data['id']))
            	$map['id'] = $data['id'];
            if (!empty($data['chapter']))
            	$map['chapter'] = $data['chapter'];
            if (!empty($data['type']))
            	$map['type'] = $data['type'];
            if (!empty($data['contents']))
            	$map['contents'] = array('like','%'.$data['contents'].'%','AND');
	        $result = $QUESTION -> where($map) ->select();
	        $this->assign('result',$result);
            $this->assign('data',$data);
    	}

    	$this->display();
    }

    //导出到excel
    public function export() {

        $title = array('id','题目章节', '题目类型', '题干内容', '选项A','选项B','选项C','选项D','正确选项', '答题人数', '正确率');
        $filename  = '浙江工商大学新生始业教育题库';

        $list = array();
        $question = M('Questionbank')->select();
        foreach ($question as $key => $value) {
            $list[$key]['id'] = $value['id'];
            $list[$key]['chapter'] = getChapterName($value['chapter']);
            $list[$key]['type'] = get_ques_type($value['type']);
            $list[$key]['contents'] = $value['contents'];
            $list[$key]['option_a'] = $value['option_a'];
            $list[$key]['option_b'] = $value['option_b'];
            $list[$key]['option_c'] = $value['option_c'];
            $list[$key]['option_d'] = $value['option_d'];
            $list[$key]['right_answer'] = $value['right_answer'];
            $list[$key]['answerNumber'] = getAnswerNum($value['id']);
            $list[$key]['accuracy'] = getAccuracy($value['id']);
        }
            dump($list['982']);die;
        $this->excel($list, $title, $filename);
    }

    //导出成绩报表
    public function excel($arr=array(),$title=array(),$filename='export'){
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");  
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
      
        if (!empty($title)){
            foreach ($title as $k => $v) {
                $title[$k]=iconv("UTF-8", "GB2312",$v);
            }
            $title= implode("\t", $title);
            echo "$title\n";
        }
        //查询数据库  $arr 是二维数组

        if(!empty($arr)){
            foreach($arr as $key=>$val){
                foreach ($val as $ck => $cv) {
                    $arr[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
                }
                $arr[$key]=implode("\t", $arr[$key]);
            }
            echo implode("\n",$arr);
        }

        die;
        // 使用die是为了避免输出多余的模板html代码
    }

}