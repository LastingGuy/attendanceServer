<?php
namespace HOME\Model;

use Think\Model\ViewModel;

class CourseListModel extends ViewModel
{
    public $viewFields=array(
        'ClassSitutation'=>array('cid','sid'),
        'Course'=>array('cname','cid','tid','_on'=>'ClassSitutation.cid=Course.cid'),
        'Teacher'=>array('tname','_on'=>'Course.tid=Teacher.tid'),
        'Student'=>array('sname','_on'=>'Student.sid=ClassSitutation.sid')
    );
}
?>