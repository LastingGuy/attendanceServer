<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2016/9/13
 * Time: 10:12
 */
namespace Home\Controller;
use Common\Common;
use Think\Controller;
class AttendanceRateController extends Controller{

    /*
     * sid和cid都存在下，查询某个学生在某门课程的出勤率
     * sid存在，cid不存在下，查询某个学生在所有课程的出勤率
     * sid不存在，cid存在下，不做查询
     * sid,cid都不存在下，不做查询
     */
    public function queryOneStudent(){
        if(!session('?admin') and !session('?student') and !session('?teacher'))
        {
            header('Location:'.U("Home/Index/index"));
        }

        $sid = I("get.sid");
        $cid = I("get.cid");

        $data =  Common\AttendanceRateUtil::queryStudent($sid,$cid);
        $this->ajaxReturn($data);
    }

    /*
     * sid存在下，查询学生所有课程下的出勤率
     * sid不存在下，不做查询
     */
    public function queryAllStudent(){
        if(!session('?admin') and !session('?student') and !session('?teacher'))
        {
            header('Location:'.U("Home/Index/index"));
        }

        $sid = I("get.sid");
        $data =  Common\AttendanceRateUtil::queryStudent($sid,null);
        $this->ajaxReturn($data);
    }
    
    /*
     * cid存在下,查找某课程出勤率
     * cid不存在下，查找所有课程出勤率
     */
    public function queryCourse(){
        if(!session('?admin') and !session('?student') and !session('?teacher'))
        {
            header('Location:'.U("Home/Index/index"));
        }

        $cid = I("get.cid");

        $data = Common\AttendanceRateUtil::queryCourse($cid);

        $this->ajaxReturn($data);

    }

}