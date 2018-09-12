<?php
namespace Student\Model;
use Think\Model;
/**
 * 微社区帖子数据相关
 */
class ChatDataModel extends Model {
    /**
     * getList  获取主题帖列表
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright 2018-02-08T15:42:40+0800
     * @var
     * @return    array                         
     */
    public function getList() {
        return $this->where(array('belongTo'=>'0','delete'=>'0'))->order('time desc')->select();  
    }
    /**
     * 函数名  函数描述
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright 2018-02-08T15:49:55+0800
     * @var
     * @param      int                  $id 主题帖id
     * @return    int                       回复数
     */
    public function getReplyNum($id='') {
        if (empty($id)) {
            return false;
        }else {            
            return $this->where(array('belongTo'=>$id,'delete'=>'0'))->count();  
        }
    }
    /**
     * getFinalList  获取帖子楼层(包括楼中楼)
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright 2018-02-09T12:39:16+0800
     * @var
     * @param     int                   $id 帖子id
     * @return    array                       二维数组
     */
    public function getFinalList($id='') {
        if (empty($id)) {
            return false;
        }else {
            //帖子下的楼层         
            $list   = $this->where(array('belongTo'=>$id,'replyTo'=>$id))
                ->order('time asc')
                ->field('id,name,contents,belongFloor,replyTo,time,delete')
                ->select();
            foreach ($list as $key => $value) {
                //楼中楼
                $temp = $this->where(array('belongTo'=>$id,'belongFloor'=>$value['id']))
                    ->order('time asc')
                    ->field('id,name,contents,belongFloor,replyTo,time,delete')
                    ->select();
                if (!empty($temp)) {
                    $list[$key]['child'] = $temp;
                }
            }
            return $list;
        }
    }
    /**
     * checkTime  整理时间，包括几小时前，几分钟前等
     * @author 陈伟昌<1339849378@qq.com>
     * @copyright 2018-02-10T13:02:44+0800
     * @var
     * @param     array                   $list 数组
     * @param     string                  $string 数组中被整理的名称
     * @return    array                         整理时间后的数组
     */
    public function checkTime($list,$string){
        $now  = time();
        if (empty($string)) {
            $string = 'time';
        }
        foreach ($list as $key => $value) {
            $st = strtotime($value['time']);
            if (date("Y-m-d",$st) == date("Y-m-d",$now)) {
                if ($list[$key][$string] = floor(($now-$st)/60/60) == 0) {
                $list[$key][$string] = floor(($now-$st)/60);
                $list[$key][$string] .= "分钟前";
                }else{
                $list[$key][$string] = floor(($now-$st)/60/60);
                $list[$key][$string] .= "小时前";
                }
            } else if(date("Y",$st) == date("Y",$now)){
                $list[$key][$string] = date("m-d H:i",$st);
            }else{
                $list[$key][$string] = date("Y-m-d H:i",$st);
            }
        }
        return $list;
    }
}