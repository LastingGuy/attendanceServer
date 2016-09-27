<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2016/8/15
 * Time: 10:01
 */
namespace Background\Model;
use Think\Model\RelationModel;
class CourseModel extends RelationModel{
    protected $pk  = 'cid';

    protected $_link = array(

        'Student' => array(
            'mapping_type' => self::MANY_TO_MANY,
            'class_name' => 'Student',
            'mapping_name' => 'Student',
            'foreign_key' => 'cid',
            'relation_table' => 'kaoqin_Class_Situtation',
            'relation_foreign_key' => 'sid'
        ),
        'Teacher' =>array(
            'mapping_type' => self::BELONGS_TO,
            'class_name'  => 'Teacher',
            'mapping_name' => 'teacher',
            'foreign_key' => 'tid'
        )
    );
}
