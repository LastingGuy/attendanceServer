<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2016/8/21
 * Time: 10:12
 */
namespace Student\Controller;
use Think\Controller;
use Common\Common;
class AttendanceController extends Controller{
    public function index()
    {
        if(!session('?student'))
        {
            header('Location:'.U("Home/Index/index"));
        }

        $stu_id = session("student");
        $res_path = C("RES_PATH");
        $this->assign("res_path",$res_path);
        $model = D("ClassSitutation");
        $data = $model->where("sid='$stu_id'")->getField('cid',true);
        $list = array();
        foreach($data as $course){
            $stu = Common\AttendanceRateUtil::queryStudent($stu_id,$course);
            array_push($list,$stu[0]);
        }
        $this->assign("list",$list);
        $this->display();
    }
}