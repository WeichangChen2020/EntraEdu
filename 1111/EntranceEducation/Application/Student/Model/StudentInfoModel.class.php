<?php
namespace Student\Model;
use Think\Model;
class StudentInfoModel extends Model {
	// protected $tablePrefix = 'db_';
 
	public function getName($openid){
		return  $this->where('openId="'.$openid.'"')->getField('name');
	}
	public function getClass($openid){
		return  $this->where('openId="'.$openid.'"')->getField('class');
	}
	public function getNumber($openid){
		return  $this->where('openId="'.$openid.'"')->getField('number');
	}

	public function getStuInfo($openid){
		return  $this->where('openId="'.$openid.'"')->find();
	}
	//获取某个班级总人数
	public function getStuNum($openid){
		$class = $this->getClass($openid);
		$stuNum = $this->where(array('class'=>$class))->count();
		return $stuNum;
	}

	/**
	 * getStuNumByClass  通过班级名获取班级人数
	 * @author 陈伟昌<1339849378@qq.com>
	 * @copyright 2018-03-25T13:35:43+0800
	 * @var
	 * @param     string                   $class [description]
	 * @return    int                          [description]
	 */
	public function getStuNumByClass($class){
		$stuNum = $this->where(array('class'=>$class))->count();
		return $stuNum;
	}
	//判断是否注册
	public function isRegister($openId){
		$condition['openId'] = $openId;                //查询条件
		if($this->where($condition)->find())                    
			return true;
		else
			return false;
	}

	//返回新手列表里的信息
	public function newerInfo($number) {
		$info = D('student_list')->where(array('number'=>$number))->find();
		
		if (empty($info)) {
			return false;
		}

		return $info;
	}

	/**
	 * 判断用户是否为新生
	 * @author 李俊君<hello_lijj@qq.com>
	 * @copyright  2017-10-3 14:25Authors
	 * @param $openid
	 * @return true or false
	 */
	public function isNewer ($openid){

		$newer = $this->where(array('openid'=>$openid))->getField('is_newer');
		if ($newer)
			return true;
		else
			return false;
		
	}
	public function classList() {
		$sql = "SELECT DISTINCT(class) FROM (SELECT DISTINCT(class),time FROM db_student_info ORDER BY time DESC) P LIMIT 15";
		$Model = new \Think\Model();
		$class = $Model->query($sql);

		if (empty($class)) {
			return false;
		}
		// dump($class);
		return $class;
    }

    /**
     * getClassmate  获取某个班学生的数组
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright 2018-01-25T18:42:38+0800
     * @var
     * @param     string                   $class [description]
     * @return    [type]                          [description]
     */
    public function getClassmate($class) {
        if ($class == '') {
            return false;
        } else{
            return $this->where(array('class'=>$class))->order('number asc')->select();
        }
    }
        
}