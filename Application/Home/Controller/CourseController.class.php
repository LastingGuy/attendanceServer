<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2016/7/3
 * Time: 10:36
 */
namespace Home\Controller;
use Think\Controller;
use Think\Exception;
class CourseController extends Controller
{
    public function index()
    {
        if(!session('?admin'))
        {
            header('Location:'.U("Home/Index/index"));
        }

        $res_path = C("RES_PATH");
        $this->assign("res_path", $res_path);
        $model = D("Course");
        $list = $model->relation(true)->select();
        $this->assign("list", $list);
        $this->display();
    }

    public function add()
    {
        if(!session('?admin'))
        {
            header('Location:'.U("Home/Index/index"));
        }

        //得到数据
        $data['cid'] = I("get.id");
        $data['cname'] = I("get.name");
        $data['tid'] = I("get.teacher");

        $model = M("Course");

        try {
            $result = $model->add($data);
        } catch (Exception $e) {
            $result = false;
        }

        if ($result == true)
            $data['success'] = true;
        else
            $data['success'] = false;

        $this->ajaxReturn($data);

    }

    public function delete()
    {
        if(!session('?admin'))
        {
            header('Location:'.U("Home/Index/index"));
        }

        $ids = I("get.ids");
        $model = M("Course");
        $result = Array();
        foreach ($ids as $value) {
            $result[$value] = $model->delete($value);
        }

        $this->ajaxReturn($result);
    }

    public function findTeachers()
    {
        if(!session('?admin'))
        {
            header('Location:'.U("Home/Index/index"));
        }

        $model = M('Teacher');
        $list = $model->select();
        $this->ajaxReturn($list);

    }

    public function editBefore()
    {
        if(!session('?admin'))
        {
            header('Location:'.U("Home/Index/index"));
        }
        $id = I("get.id");

        $model = M("Course");
        $data = $model->where("cid='$id'")->find();
        $this->ajaxReturn($data);
    }

    public function update()
    {
        if(!session('?admin'))
        {
            header('Location:'.U("Home/Index/index"));
        }

        //得到数据
        $data['cid'] = I("get.id");
        $data['cname'] = I("get.name");
        $data['tid'] = I("get.teacher");

        $model = M("Course");

        try {
            $result = $model->save($data);
        } catch (Exception $e) {
            echo $e;
            $result = false;
        }

        if ($result == true)
            $res['success'] = true;
        else
            $res['success'] = false;

        $this->ajaxReturn($res);

    }


    //课程考勤表
    public function courseCondition()
    {
        if(!session('?admin'))
        {
            header('Location:'.U("Home/Index/index"));
        }

        $course_id = I('get.course_id');
        $model = M("Course");
        $course_name = $model->where("cid=$course_id")->getField("cname");

        $res_path = C("RES_PATH");
        $this->assign("res_path", $res_path);
        $this->assign("course_id", $course_id);
        $this->assign("course_name", $course_name);

        $filelist = Array();
        $dir = C("SAVE_ROOT");
        $files = scandir($dir . '/' . $course_id);
        foreach ($files as $file) {
            if (!is_dir($file)) {
                array_push($filelist,str_replace(".xml","",$file));
            }
        }
        $this->assign("list", $filelist);
        $this->display("courseCondition");
    }

    //考勤显示
    public function result()
    {
        if(!session('?admin'))
        {
            header('Location:'.U("Home/Index/index"));
        }

        $res_path = C("RES_PATH");
        $this->assign("res_path", $res_path);
        $course_id = I('get.course_id');
        $course_name = I("get.course_name");
        $date = I('get.date');

        $filename = $date . ".xml";
        $dir = C("SAVE_ROOT");
        $filepath = $dir . '/' . $course_id . '/' . $filename;

        $xml = new \DOMDocument();
        $xml->load($filepath);
        //从xml文件中读取的数据存放在此处
        $stu_data = array();
        $course_data = array();

        $root = $xml->documentElement;
        $course_data['course_id'] = $root->getElementsByTagName("courseid")->item(0)->nodeValue;
        $course_data['date'] = $root->getElementsByTagName("date")->item(0)->nodeValue;
        $course_data['begin_time'] = $root->getElementsByTagName("ts")->item(0)->nodeValue;
        $course_data['end_time'] = $root->getElementsByTagName("te")->item(0)->nodeValue;

        $students = $root->getElementsByTagName("stu");
        foreach ($students as $stu) {
            $data = array();
            $data['id'] = $stu->getElementsByTagName("id")->item(0)->nodeValue;
            $data['name'] = $stu->getElementsByTagName("name")->item(0)->nodeValue;
            $data['college'] = $stu->getElementsByTagName("college")->item(0)->nodeValue;
            $data['major'] = $stu->getElementsByTagName("major")->item(0)->nodeValue;
            $data['class'] = $stu->getElementsByTagName("sclass")->item(0)->nodeValue;
            $data['sex'] = $stu->getElementsByTagName("sex")->item(0)->nodeValue;
            $data['check'] = $stu->getElementsByTagName("check")->item(0)->nodeValue;
            $data['arrive_time'] = $stu->getElementsByTagName("arrive_time")->item(0)->nodeValue;
            array_push($stu_data, $data);
        }

        $this->assign("course_id", $course_id);
        $this->assign("course_name", $course_name);
        $this->assign("stu_data",$stu_data);
        $this->assign("course_data",$course_data);
        $this->display();

    }

    //获得学生名单
    public function studentsList()
    {
        //检测是否登陆和是否有post提交
        if(!session("?admin"))
        {
            $this->redirect('Index/index');
        }

        //获取课程id
        $cid = I('get.cid');
        // $cid='1001';

        //连接并查找数据库
        $model = D('ClassSitutation');
        $list = $model->relation(true)->where("cid='$cid'")->select();
        
        $this->assign("cid",$cid);
        $this->assign("list",$list);
        $this->display();
    }

    //返回学生信息
    public function getstuinfo()
    {
        //检测是否登陆和是否有post提交
        if(!IS_POST||!session('?admin'))
        {
            return;
        }
        else
        {
            //获得sid
            $sid = I("post.sid");
            
            //连接并查找数据库
            $model = D('student');
            $stu = $model->find($sid);

            $this->ajaxReturn($stu);
        }
    }

    //为课程添加学生
    public function addStudent()
    {
        //检测是否登陆和是否有post提交
        if(!session('?admin'))
        {
            $this->ajaxReturn('fail');
        }
        else
        {
            //获得sid
            $sid = I("post.sid");
            $cid = I("post.cid");

            // $cid='1001';
            // $sid='1003';

            $stu = D('student');
            if(null==($stu->find($sid)))
            {
                $this->ajaxReturn("fail");
            }
            $course = D("course");
            if(null==($course->find($cid)))
            {
                $this->ajaxReturn("fail");
            }

            //连接并查找数据库
            $model = D('ClassSitutation');
            $model->sid = $sid;
            $model->cid = $cid;
            $model->absence_number=0;
            $r = $model->where("cid=$cid and sid=$sid")->find();
            //var_dump($r);
            if(isset($r))       //在数据库中已存在此选课信息
            {  
                $this->ajaxReturn("fail");
            }
            else
            {
                $model->add();
                $model = D('ClassSitutation');
                $list = $model->relation(true)->where("cid=$cid and sid=$sid")->select();
                $this->ajaxReturn($list);
            }
                
        }
    }

    //删除学生
    public function deleteRelation()
    {
        if(!IS_POST||!session('?admin'))
        {
            $this->ajaxReturn("fail");
        }

        $ids = I("post.ids");
        $cid = I("post.cid");

        $model = M("ClassSitutation");
        $result = Array();
        foreach ($ids as $value) 
        {
            $result[$value] = $model->where("cid=$cid and sid=$value")->delete();
        }

        $this->ajaxReturn('success');
    }
}