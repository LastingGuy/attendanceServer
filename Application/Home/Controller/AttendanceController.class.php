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


        $this->display();
    }
    
}