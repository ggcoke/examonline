<?php
require_once './common.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>用户注册</title>
        <link type="text/css" rel="stylesheet" href="css/style.css" />
    </head>
    <body>
    <?php include('./header.php'); ?>
    <div class="container">
        <div class="row">
            <div class="span10">
                <div class="tab-content">
                    <div class="tab-pane active" id="signup">
                        <form class="well form-horizontal" action="#" method="post">
                            <p>
                                <input type="text" class="input-xlarge" id="username" name="username" onblur="javascript:vUsername()" />
                                <label class="control-label" for="username">用户名：</label>
                            </p>
                            <p>
                                <input type="password" class="input-xlarge" id="password" name="password"/>
                                <label class="control-label" for="password">密码：</label>
                            </p>
                            <p>
                                <input type="password" class="input-xlarge" id="repassword" name="repassword"/>
                                <label class="control-label" for="repassword">重复密码：</label>
                            </p>
                            <div class="row-fluid">
                                <label class="control-label" for="role">用户类型：</label>
                                <div class="span6" style="margin-left: 0;">
                                    <select class="input-xlarge" id="role" name="role">
                                        <option value=<?php echo USER_ROLE_MANAGER;?>>管理员</option>
                                        <option value=<?php echo USER_ROLE_TEACHER;?>>教师</option>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <input class="btn" type="submit" name="signup_btn" onclick="javascript:return goRegiste()" value="注册">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="javascript/jquery.min.js"></script>
    <script type="text/javascript" src="javascript/common.js"></script>
    <script type="text/javascript" src="javascript/md5.js"></script>
    <script type="text/javascript" src="javascript/register.js"></script>
</body>
</html>