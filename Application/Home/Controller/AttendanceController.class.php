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
class AttendanceController extends Controller {
    public function studentQuery(){
        if(!session('?admin'))
        {
            header('Location:'.U("Home/Index/index"));
        }
        $res_path = C("RES_PATH");
        $this->assign("res_path",$res_path);
            
        $this->display();
    }

    public function courseQuery(){
        if(!session('?admin'))
        {
            header('Location:'.U("Home/Index/index"));
        }
        $res_path = C("RES_PATH");
        $this->assign("res_path",$res_path);

        $this->display();
    }

    public function countryQuery(){
        if(!session('?admin'))
        {
            header('Location:'.U("Home/Index/index"));
        }
        $res_path = C("RES_PATH");
        $this->assign("res_path",$res_path);

        $this->display();
    }
}