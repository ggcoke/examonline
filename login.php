<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>登录</title>
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
                                <input type="text" class="input-xlarge" id="username" name="username" />
                                <label class="control-label" for="username">用户名：</label>
                            </p>
                            <p>
                                <input type="password" class="input-xlarge" id="password" name="password" />
                                <label class="control-label" for="password">密码：</label>
                            </p>
                            <input class="btn" type="submit" name="login_btn" onclick="javascript:return goLogin()" value="登录">
                            <input class="btn" type="button" name="registe_btn" onclick="location.href='register.php'" value="注册">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="javascript/jquery.min.js"></script>
    <script type="text/javascript" src="javascript/common.js"></script>
    <script type="text/javascript" src="javascript/md5.js"></script>
    <script type="text/javascript" src="javascript/login.js"></script>
</body>
</html>