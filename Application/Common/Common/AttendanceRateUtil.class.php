<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2016/9/18
 * Time: 14:14
 */
namespace Common\Common;
class AttendanceRateUtil{
    
    public static function queryStudent($sid,$cid){
        if(!session('?admin') and !session('?student') and !session('?teacher'))
        {
            header('Location:'.U("Home/Index/index"));
        }

        $model = null;
        if($sid!="" and $cid!="" and !is_null($cid)){
            $return_data = array();

            //学生数据
            $model = M("student");
            $find_data = $model->where("sid=$sid")->find();
            $return_data[0]['sid'] = $find_data['sid'];
            $return_data[0]['sname'] = $find_data['sname'];

            //课程数据
            $model = M("course");
            $find_data = $model->where("cid=$cid")->find();
            if($find_data==null){
                return null;
            }
            $return_data[0]['cid'] = $find_data['cid'];
            $return_data[0]['cname'] = $find_data['cname'];
            $return_data[0]['times'] = $find_data['times'];

            //缺勤数据
            $model = M("classSitutation");
            $find_data = $model->where("sid=$sid and cid=$cid")->find();
            $return_data[0]['absence'] = $find_data['absence_number'];

            $return_data[0]['attendance'] = $return_data[0]['times'] - $return_data[0]['absence'];
            if($return_data[0]['attendance']!=0)
                $return_data[0]['rate'] = number_format($return_data[0]['attendance'] / $return_data[0]['times'] * 100,2);
            else
                $return_data[0]['rate'] = 0;

            return $return_data;
        }
        else if($sid!="" and $cid=="" and !is_null($cid)){
            $return_data = array();

            //学生数据
            $model = M("student");
            $sname = $model->where("sid=$sid")->find()['sname'];

            $model = M("classSitutation");
            $course_data = $model->where("sid=$sid")->select();

            $model = M("course");
            foreach($course_data as $key=>$value){
                $return_data[$key]['sid'] = $sid;
                $return_data[$key]['sname'] = $sname;
                $return_data[$key]['cid'] = $value['cid'];
                $return_data[$key]['absence'] = $value['absence_number'];

                $data =  $model->where("cid=".$value['cid'])->find();
                $return_data[$key]['cname'] = $data['cname'];
                $return_data[$key]['times'] = $data['times'];
                $return_data[$key]['attendance'] = $return_data[$key]['time']-$return_data[$key]['absence'];
                if($return_data[$key]['attendance']!=0)
                    $return_data[$key]['rate'] = number_format($return_data[$key]['attendance'] / $return_data[$key]['times'] * 100,2);
                else
                    $return_data[$key]['rate'] = 0;
            }

            return $return_data;

        }
        else if($sid=="" and $cid=="" and !is_null($cid)){
            return array();
        }
        else if($sid=="" and $cid!="" and !is_null($cid)){
            return array();
        }
        else if($sid=="" and is_null($cid)){
            $return_data = array();
            //获取所有学生id
            $model = M("Student");
            $student = $model->getField("sid,sname");

            $i = 0;
            foreach($student as $key=>$value){
                $return_data[$i]['sid'] = $key;
                $return_data[$i]['sname'] = $value;
                $i++;
            }

            //查找每个学生的课程及总出勤率
            foreach($return_data as $key=>$value){

                //查找未到次数
                $model = M("classSitutation");
                $data = $model->where("sid=$key")->getField("cid,absence_number");
                $absence_number = 0;
                foreach ($data as $value2){
                    $absence_number = $absence_number + $value2;
                }
                $return_data[$key]['absence'] = $absence_number;

                //查找应到次数
                $model = M("course");
                $times = 0;
                foreach ($data as $key3=>$value3){
                    $each = $model->where("cid=$key3")->getField("times",true);
                    $times = $times + $each[0];
                }
                $return_data[$key]['times'] = $times;

                //计算出勤次数和出勤率
                $return_data[$key]['attendance'] = $times - $absence_number;
                if($return_data[$key]['attendance']!=0)
                    $return_data[$key]['rate'] = number_format($return_data[$key]['attendance'] / $return_data[$key]['times'] * 100,2);
                else
                    $return_data[$key]['rate'] = 0;
            }
            return $return_data;
        }
        else if($sid!="" and is_null($cid)){
            $return_data = array();

            $return_data[0]['sid'] = $sid;

            //查找学生姓名
            $model = M("student");
            $data = $model->where("sid=$sid")->getField("sname",true);
            if($data==null){
                return null;
            }
            $return_data[0]['sname'] = $data[0];


            //查找未到次数
            $model = M("classSitutation");
            $data = $model->where("sid=$sid")->getField("cid,absence_number");

            $absence_number = 0;
            foreach ($data as $value){
                $absence_number = $absence_number + $value;
            }
            $return_data[0]['absence'] = $absence_number;

            //查找应到次数
            $model = M("course");
            $times = 0;
            foreach ($data as $key=>$value){
                $each = $model->where("cid=$key")->getField("cname,times");
                $times = $times + $each[0];
            }
            $return_data[0]['times'] = $times;

            //计算出勤次数和出勤率
            $return_data[0]['attendance'] = $times - $absence_number;
            if($return_data[0]['attendance']!=0)
                $return_data[0]['rate'] = number_format($return_data[0]['attendance'] / $return_data[0]['times'] * 100,2);
            else
                $return_data[0]['rate'] = 0;

            return $return_data;
        }

    }

    public static function queryCourse($cid){
        if($cid==""){

            $return_data = array();

            //先查找所有课程
            $model = M("Course");
            $data = $model->getField("cid,cname",true);
            $i = 0;
            foreach ($data as $key=>$value){
                $return_data[$i]['cid'] = $key;
                $return_data[$i]['cname'] = $value;
                $i++;
            }

            foreach($return_data as $key=>$value){
                //查找未到数
                $model = M("classSitutation");
                $data = $model->where("cid=".$value['cid'])->getField("absence_number",true);
                $absence = 0;
                $stu_number = $model->where("cid=".$value['cid'])->count();
                foreach ($data as $key2=>$value2){
                    $absence += $value2;
                }

                //查找应到数
                $model = M("course");
                $data = $model->where("cid=".$value['cid'])->getField("times,tid");
                $times = 0;
                foreach ($data as $key2=>$value2){
                    $return_data[$key]['tid'] = $value2;
                    $times = $key2;
                }
                $times = $times*$stu_number;

                //查找教师姓名
                $model = M("teacher");

                $data = $model->where("tid=".$return_data[$key]['tid'])->getField("tname",true);
                $return_data[$key]['tname'] = $data[0];

                //计算实到数和出勤率
                $attendance = $times - $absence;
                if($attendance!=0)
                    $return_data[$key]['rate'] = number_format($attendance / $return_data[$key]['times'] * 100,2);
                else
                    $return_data[$key]['rate'] = 0;
            }

            return $return_data;
        }
        else if($cid!=""){
            $return_data = array();

            //查找未到数
            $model = M("classSitutation");
            $data = $model->where("cid=$cid")->getField("absence_number",true);
            $absence = 0;
            $stu_number = $model->where("cid=$cid")->count();
            foreach ($data as $key=>$value){
                $absence += $value;
            }

            //查找应到数
            $model = M("course");
            $data = $model->where("cid=$cid")->getField("cname,times,tid");
            if($data==null){
               return null;
            }
            $times = 0;
            foreach ($data as $key=>$value){
                $return_data[0]['cid'] = $cid;
                $return_data[0]['cname'] = $key;
                $return_data[0]['tid'] = $value['tid'];
                $times = $value['times'];
            }
            $times = $times*$stu_number;

            //查找教师姓名
            $model = M("teacher");
            $data = $model->where("tid=".$return_data[0]['tid'])->getField("tname",true);
            $return_data[0]['tname'] = $data[0];

            //计算实到数和出勤率
            $attendance = $times - $absence;
            if($attendance!=0)
                $return_data[0]['rate'] = number_format($attendance / $return_data[0]['times'] * 100,2);
            else
                $return_data[0]['rate'] = 0;

            return $return_data;
        }
    }
}