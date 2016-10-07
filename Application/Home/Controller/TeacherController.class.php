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
class TeacherController extends Controller {
    public function index(){
        if(!session('?admin'))
        {
            header('Location:'.U("Home/Index/index"));
        }
        $res_path = C("RES_PATH");
        $this->assign("res_path",$res_path);
      /*  $tea = M('Teacher');
        $list = $tea->select();
        $this->assign('list',$list);*/

        $this->display();
    }

    public function getTeacher(){
        $offset = I("get.offset");
        $limit = I("get.limit");
        $search = I("get.search");
        if($search==""){
            $model = D("Teacher");
            $count = $model->count();
            $list = $model->order("tid")->limit($offset,$limit)->select();
            $return_data = array();
            $return_data['total'] = $count;
            $return_data['rows'] = $list;
            foreach ($return_data['rows'] as $key=>$value){
                $return_data['rows'][$key]['edit'] = "<button class='btn btn-primary btn-xs' data-toggle='modal'
                                             onclick='edit_before(". $return_data['rows'][$key]['tid'].");'>编 辑</button>";
            }
            $this->ajaxReturn($return_data);
        }
        else{
            $model = D("Teacher");
            $count = $model->where("tid=$search")->order("cid")->limit($offset,$limit)->count();
            $list = $model->where("tid=$search")->order("cid")->limit($offset,$limit)->select();
            $return_data = array();
            $return_data['total'] = $count;
            $return_data['rows'] = $list;
            foreach ($return_data['rows'] as $key=>$value){
                $return_data['rows'][$key]['edit'] = "<button class='btn btn-primary btn-xs' data-toggle='modal'
                                             onclick='edit_before(". $return_data['rows'][$key]['tid'].");'>编 辑</button>";
            }
            $this->ajaxReturn($return_data);
        }
    }

    public function add(){
        if(!session('?admin'))
        {
            header('Location:'.U("Home/Index/index"));
        }

        //得到数据
        $data['tid'] = I("get.id");
        $data['tname'] = I("get.name");
        $data['tsex'] = I("get.sex");
        $data['tpassword'] = I("get.passwd");

        $tea = M('Teacher');

        try{
            $result = $tea->add($data);
        }catch(\Think\Exception $e){
            $result = false;
            echo $e;
        }

        if($result == true)
            $res['success'] = true;
        else
            $res['success'] = false;

        $this->ajaxReturn($res);
        
    }

    public function delete(){
        if(!session('?admin'))
        {
            header('Location:'.U("Home/Index/index"));
        }

        $ids = I("get.ids");
        $model = M('Teacher');
        $result = Array();
        foreach($ids as $value)
        {
            $result[$value] = $model->delete($value);
        }

        $this->ajaxReturn($result);
    }


    public function editBefore(){

        if(!session('?admin'))
        {
            header('Location:'.U("Home/Index/index"));
        }
        $id = I("get.id");

        $model = M("Teacher");
        $data = $model->where("tid='$id'")->find();
        $this->ajaxReturn($data);
    }

    public function update(){
        if(!session('?admin'))
        {
            header('Location:'.U("Home/Index/index"));
        }
        
        //得到数据
        $data['tid'] = I("get.id");
        $data['tname'] = I("get.name");
        $data['tsex'] = I("get.sex");
        $data['tpassword'] = I("get.passwd");


        $model = M("Teacher");

        try{
            $result = $model->save($data);
        }catch(\Think\Exception $e){
            $result = false;
        }

        if($result == true)
            $data['success'] = true;
        else
            $data['success'] = false;

        $this->ajaxReturn($data);

    }


}