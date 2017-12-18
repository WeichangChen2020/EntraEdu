<?php
namespace Admin\Model;
use Think\Model;
class StudentListModel extends Model {

	/**
	 * getStudentNum 获取注册数量 未注册数量
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-10-25 21:18Authors
	 * @var  $college 
	 * @return  
	 */
	public function getStudentNum() {

		$college = D('Adminer')->getCollege();
        
        if (!is_null($college)) {
            $map['academy'] = $college;
        }

        $map['type'] = 1;
        $num['registerCount'] = $this->where($map)->count();
        $map['type'] = 0;
        $num['unRegistCount'] = $this->where($map)->count();

        return $num;
	}

	/**
	 * getCollegeList 获取所有学院名
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright  2017-10-26 14:25Authors
	 * @var   
	 * @return  array()
	 */
	public function getCollegeList(){

		$sql = "SELECT DISTINCT academy FROM  ee_student_list";
		
		$Model = new \Think\Model();
		$res = $Model->query($sql);

		if (empty($res)) {
			return false;
		}

		return $res;
	}


	/**
	 * getExercseNum 获取学生自由练习答题情况
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-11-24 13:48Authors
	 * @var   
	 * @return  array()
	 */

	public function getExercseNum() {

		$college = D('Adminer')->getCollege();
        
        if (!is_null($college)) {
            $map['academy'] = $college;
        }
        $map['type'] = 1;

        $user = $this->where($map)->field('number')->select();
        $num['allNum'] = count($user);
        $num['unFinshNum'] = 0;
        foreach ($user as $key => $value) {
        	if(is_ablity_exam($value['number']))
        		$num['unFinshNum'] ++;
        }
        
        return $num;
	}

 
}