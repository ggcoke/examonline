<?php
session_start();
require_once './common.php';
$uid = key_exists('uid', $_SESSION) ? $_SESSION['uid'] : null;
$role = key_exists('role', $_SESSION) ? $_SESSION['role'] : null;

if (is_null($uid) || is_null($role) || !isManager($role)) {
    ?>
    <script>
        alert("请登录：）");
        window.location.href='login.php';
    </script>
    <?php
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>人员管理</title>
        <link type="text/css" rel="stylesheet" href="./css/style.css" />
    </head>
    <body>
        <?php include('./header.php'); ?>
        <div class="container">
            <div class="row">
                <div class="span2 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav fix">
                        <li><a href="new_exam2.php#type=s">选择题</a></li>
                        <li><a href="new_exam2.php#type=b">填空题</a></li>
                        <li><a href="new_exam2.php#type=a">简答题</a></li>
                        <li><button class="btn btn-success nav-btn" type="button" onclick="javascript:return submitQuestion()">提交题目</button></li>
                        <li><button class="btn btn-danger nav-btn" type="button" onclick="javascript:logout()"> 注销</button></li>
                    </ul>
                </div>
                <div class="span10">
                    <div class="tab-content">
                        <div class="well form-horizontal">
                            <p>
                                <input type="text" class="input-xlarge" id="sname" name="sname" />
                                <select class="search" id="srole" name="srole">
                                    <option name="crole" value=<?php echo USER_ROLE_MANAGER; ?>>管理员</option>
                                    <option name="crole" value=<?php echo USER_ROLE_TEACHER; ?>>教师</option>
                                    <option name="crole" value=<?php echo USER_ROLE_STUDENT; ?>>学生</option>
                                </select>
                                <button type="button" class="btn btn-primary" onclick="javascript:searchUser()">搜索</button>
                                <label class="control-label" for="repassword">搜索用户：</label>
                            </p>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div id="result_content"></div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="javascript/jquery.min.js"></script>
        <script type="text/javascript" src="javascript/common.js"></script>
        <script type="text/javascript" src="javascript/inputvalue.js"></script>
        <script type="text/javascript" src="javascript/user.js"></script>
    </body>
</html>
