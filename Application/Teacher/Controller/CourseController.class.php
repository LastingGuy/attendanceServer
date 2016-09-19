<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2016/8/21
 * Time: 15:19
 */
namespace Teacher\Controller;
use Think\Controller;
use Common\Common;
class CourseController extends Controller {
    public function index()
    {
        if(!session('?teacher'))
        {
            header('Location:'.U("Home/Index/index"));
        }
        $tea_id = session("teacher");

        $res_path = C("RES_PATH");
        $this->assign("res_path",$res_path);

        $list = array();
        $model = M('Course');
        $data = $model->where("tid='$tea_id'")->getField("cid",true);

        foreach ($data as $id){
            $course = Common\AttendanceRateUtil::queryCourse($id);
            array_push($list,$course[0]);
        }
        $this->assign("list",$list);
        $this->display();
    }
    //课程考勤表
    public function courseCondition()
    {
        if(!session('?teacher'))
        {
            header('Location:'.U("Home/Index/index"));
        }

        $course_id = I('get.course_id');
        $model = M("Coures");
        $course_name = $model->where("cid=$course_id")->getField("cnames");

        $res_path = C("RES_PATH");
        $this->assign("res_path", $res_path);
        $this->assign("course_id", $course_id);
        $this->assign("course_name", $course_name);

        $filelist = Array();
        $dir =  C("SAVE_ROOT");
        $files = scandir($dir . '/' . $course_id);
        foreach ($files as $file) {
            if (!is_dir($file)) {
                array_push($filelist,str_replace(".xml","",$file));
            }
        }
        $this->assign("list", $filelist);
        $this->display("courseCondition");
    }

    public function studentsList()
    {
        //检测是否登陆和是否有post提交
        if(!session("?teacher"))
        {
            $this->redirect('Index/index');
        }

        //获取课程id
        $cid = I('get.course_id');
        $model = M("Coures");
        $cname = $model->where("cid=$cid")->getField("cnames");

        // $cid='1001';

        //连接并查找数据库
        $model = D('ClassSitutation');
        $list = $model->relation(true)->where("cid='$cid'")->select();

        foreach ($list as $key=>$item) {
            $stu = Common\AttendanceRateUtil::queryStudent($item['sid'],$cid);
            $list[$key]['attendance'] = $stu[0];
        }
   
        $this->assign("cid",$cid);
        $this->assign("cname",$cname);
        $this->assign("list",$list);
        $this->display();
    }

    //考勤显示
    public function result()
    {
        if(!session('?teacher'))
        {
            header('Location:'.U("Home/Index/index"));
        }

        $res_path = C("RES_PATH");
        $this->assign("res_path", $res_path);
        $course_id = I('get.course_id');
        $model = M("Coures");
        $course_name = $model->where("cid=$course_id")->getField("cnames");
        $date = I('get.date');

        $filename = $date . ".xml";
        $dir =  C("SAVE_ROOT");
        $filepath = $dir . '/' . $course_id . '/' . $filename;

        $xml = new \DOMDocument();
        $xml->load($filepath);
        //从xml文件中读取的数据存放在此处
        $stu_data = array();
        $course_data = array();

        $root = $xml->documentElement;
        $course_data['course_id'] = $root->getElementsByTagName("courseid")[0]->nodeValue;
        $course_data['date'] = $root->getElementsByTagName("date")[0]->nodeValue;
        $course_data['begin_time'] = $root->getElementsByTagName("ts")[0]->nodeValue;
        $course_data['end_time'] = $root->getElementsByTagName("te")[0]->nodeValue;

        $students = $root->getElementsByTagName("stu");
        foreach ($students as $stu) {
            $data = array();
            $data['id'] = $stu->getElementsByTagName("id")[0]->nodeValue;
            $data['name'] = $stu->getElementsByTagName("name")[0]->nodeValue;
            $data['college'] = $stu->getElementsByTagName("college")[0]->nodeValue;
            $data['major'] = $stu->getElementsByTagName("major")[0]->nodeValue;
            $data['class'] = $stu->getElementsByTagName("sclass")[0]->nodeValue;
            $data['sex'] = $stu->getElementsByTagName("sex")[0]->nodeValue;
            $data['check'] = $stu->getElementsByTagName("check")[0]->nodeValue;
            $data['arrive_time'] = $stu->getElementsByTagName("arrive_time")[0]->nodeValue;
            array_push($stu_data, $data);
        }

        $this->assign("course_id", $course_id);
        $this->assign("course_name", $course_name);
        $this->assign("stu_data",$stu_data);
        $this->assign("course_data",$course_data);
        $this->display();

    }
}