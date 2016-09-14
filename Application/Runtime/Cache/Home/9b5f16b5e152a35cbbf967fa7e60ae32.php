<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lumino - Dashboard</title>

    <link href="<?php echo ($res_path); ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo ($res_path); ?>/css/datepicker3.css" rel="stylesheet">
    <link href="<?php echo ($res_path); ?>/css/bootstrap-table.css" rel="stylesheet">
    <link href="<?php echo ($res_path); ?>/css/styles.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="<?php echo ($res_path); ?>/js/html5shiv.js"></script>
    <script src="<?php echo ($res_path); ?>//respond.min.js"></script>
    <![endif]-->

</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><span>Lumino</span>Admin</a>
<ul class="user-menu">
    <li class="dropdown pull-right">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> User <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
    </li>
</ul>
        </div>
    </div><!-- /.container-fluid -->
</nav>

<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <form role="search">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Search">
        </div>
    </form>
    <!--包括导航栏-->
    <ul class="nav menu">
    <li><a href="../Course/index"><span class="glyphicon glyphicon-list-alt"></span> 课程管理</a></li>
    <li><a href="../Student/index"><span class="glyphicon glyphicon-pencil"></span> 学生管理</a></li>
    <li><a href="../Teacher/index"><span class="glyphicon glyphicon-pencil"></span> 教师管理</a></li>
    <li><a href="../Attendance/studentQuery"><span class="glyphicon glyphicon-pencil"></span> 出勤率查询</a></li>
</ul>
</div><!--/.sidebar-->

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="active">出勤率查询</li>
        </ol>
    </div><!--/.row-->

    <ul class="nav nav-pills" role="tablist">
        <li role="presentation" class="active"><a href="../Attendance/studentQuery">学生查询</a></li>
        <li role="presentation"><a href="../Attendance/courseQuery">课程查询</a></li>
        <li role="presentation"><a href="../Attendance/countryQuery">国籍查询</a></li>
    </ul>
    <div style="padding: 15px"></div>

    <div class="panel panel-info">
        <div class="panel-heading">学 生 课 程 到 课 率 查 询</div>
        <div class="panel-body">
            <form class="form-horizontal"  enctype="multipart/form-data">

                <div class="form-group">
                    <label  class="col-lg-1 col-lg-offset-1 col-sm-3 control-label">学号</label>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" placeholder="请输入学号"  id="sid" name="sid" >
                    </div>

                    <label  class="col-lg-1  col-sm-3 control-label">课程号</label>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" placeholder="请输入课程号"  id="cid" name="cid" >
                    </div>

<<<<<<< HEAD
<<<<<<< HEAD
                    <button type="button" class="btn btn-primary" onclick="queryStudent()"> 查 询 </button>

=======
                    <button type="button" class="btn btn-primary">查 询</button>
                    <button type="button" class="btn btn-primary">全 部 查 询</button>
>>>>>>> origin/master
=======
                    <button type="button" class="btn btn-primary">查 询</button>
                    <button type="button" class="btn btn-primary">全 部 查 询</button>
>>>>>>> origin/master
                </div>
            </form>
            <table id="table" data-toggle="table" data-url=""  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                <thead>
                <tr>
                    <th data-field="state" data-checkbox="true" >Item ID</th>
<<<<<<< HEAD
<<<<<<< HEAD
                    <th data-field="sid" data-sortable="true">学 号</th>
                    <th data-field="sname">姓 名</th>
                    <th data-field="cid">课程号</th>
                    <th data-field="cname">课程名</th>
                    <th data-field="times">应 到</th>
                    <th data-field="attendance">实 到</th>
                    <th data-field="absence">未 到</th>
                    <th data-field="rate">到课率</th>
=======
=======
>>>>>>> origin/master
                    <th data-field="id" data-sortable="true">学 号</th>
                    <th data-field="name">姓 名</th>
                    <th data-field="teacher_name">课程号</th>
                    <th data-field="teacher_id">课程名</th>
                    <th data-field="attendance">到课率</th>
<<<<<<< HEAD
>>>>>>> origin/master
=======
>>>>>>> origin/master
                </tr>
                </thead>
                <tbody id="tbody">

                </tbody>
            </table>
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">学 生 总 到 课 率 查 询</div>
        <div class="panel-body">
            <div class="form-group">
                <form class="form-horizontal"  enctype="multipart/form-data">
                    <label  class="col-lg-1 col-lg-offset-1 col-sm-3 control-label">学号</label>
                    <div class="col-lg-2">
<<<<<<< HEAD
<<<<<<< HEAD
                        <input type="text" class="form-control" placeholder="请输入学号"  id="sid2" name="sid2" >
                    </div>
                    <button type="button" class="btn btn-primary" onclick="queryAllStudent()"> 查 询 </button>
=======
=======
>>>>>>> origin/master
                        <input type="text" class="form-control" placeholder="请输入学号"  id="sid2" name="sid" >
                    </div>

                    <button type="button" class="btn btn-primary">查 询</button>
                    <button type="button" class="btn btn-primary">全 部 查 询</button>
<<<<<<< HEAD
>>>>>>> origin/master
=======
>>>>>>> origin/master
                </form>
                <table id="table2" data-toggle="table" data-url=""  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                    <thead>
                    <tr>
                        <th data-field="state" data-checkbox="true" >Item ID</th>
<<<<<<< HEAD
<<<<<<< HEAD
                        <th data-field="sid" data-sortable="true">学 号</th>
                        <th data-field="sname">姓 名</th>
                        <th data-field="times">应 到</th>
                        <th data-field="attendance">实 到</th>
                        <th data-field="absence">未 到</th>
                        <th data-field="rate">总到课率</th>
=======
                        <th data-field="id" data-sortable="true">学 号</th>
                        <th data-field="name">姓 名</th>
                        <th data-field="attendance">总到课率</th>
>>>>>>> origin/master
=======
                        <th data-field="id" data-sortable="true">学 号</th>
                        <th data-field="name">姓 名</th>
                        <th data-field="attendance">总到课率</th>
>>>>>>> origin/master
                    </tr>
                    </thead>
                    <tbody id="tbody2">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


<script src="<?php echo ($res_path); ?>/js/jquery-1.11.1.min.js"></script>
<script src="<?php echo ($res_path); ?>/js/bootstrap.min.js"></script>
<script src="<?php echo ($res_path); ?>/js/bootstrap-table.js"></script>
<script src="<?php echo ($res_path); ?>/js/locale/bootstrap-table-zh-CN.js"></script>
<script>
<<<<<<< HEAD
<<<<<<< HEAD



    function queryStudent(){
        var stu_id = $('#sid').val();
        var cour_id = $('#cid').val();

        $.get("../AttendanceRate/queryOneStudent",{
            "sid":stu_id,
            "cid":cour_id
        },function(data,status){
            $('#sid2').val("");
            if(data==null)
                $('#table').bootstrapTable('removeAll');
            else
                $('#table').bootstrapTable('load',data);
        });
    }

    function queryAllStudent() {
        var stu_id = $('#sid2').val();

        $.get("../AttendanceRate/queryAllStudent", {
            "sid": stu_id,
        }, function (data, status) {
            $('#sid').val("");
            $('#cid').val("");
            if(data==null)
                $('#table2').bootstrapTable('removeAll');
            else
                $('#table2').bootstrapTable('load',data);
        });
    }
=======
=======
>>>>>>> origin/master
    var $remove = $('#remove');
    var $table = $('#table');
    $table.on('check.bs.table uncheck.bs.table ' +
            'check-all.bs.table uncheck-all.bs.table', function () {
        $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);
        // save your data, here just save the current page
        selections = getIdSelections();
        // push or splice the selections if you want to save all data selections
    });

    function getIdSelections() {
        return $.map($table.bootstrapTable('getSelections'), function (row) {
            return row.id
        });
    }

<<<<<<< HEAD
>>>>>>> origin/master
=======
>>>>>>> origin/master

</script>
</body>
</html>