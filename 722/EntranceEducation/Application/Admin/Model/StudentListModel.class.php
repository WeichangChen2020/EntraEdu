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

        $num['registerCount'] = M('StudentInfo')->where($map)->count();
        $map['type'] = 0;
        $num['unRegistCount'] = $this->where($map)->count();

        return $num;
	}
 
}