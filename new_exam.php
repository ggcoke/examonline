<?php
session_start();
require_once './common.php';
$uid = key_exists('uid', $_SESSION) ? $_SESSION['uid'] : null;
if (is_null($uid)) {
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
        <title>新建题目</title>
        <link type="text/css" rel="stylesheet" href="./css/style.css" />
    </head>
    <body>
        <?php include('./header.php'); ?>
        <div class="container">
            <div class="row">
                <div class="span2 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav fix">
                        <li><a href="#q_s_alert">选择题</a></li>
                        <li><a href="#q_b_alert">填空题</a></li>
                        <li><a href="#q_a_alert">简答题</a></li>
                        <li><button class="btn btn-success nav-btn" type="button" onclick="javascript:return submitQuestion()">提交题目</button></li>
                        <li><button class="btn btn-danger nav-btn" type="button" onclick="javascript:logout()"> 注销</button></li>
                    </ul>
                </div>
                <div class="span10">
                    <form action="#" method="post">
                        <input name="s_num" type="hidden" id="s_num" value="0" class="num">
                        <input name="b_num" type="hidden" id="b_num" value="0" class="num">
                        <input name="a_num" type="hidden" id="a_num" value="0" class="num">
                        <div class="alert alert-info">
                            <a name="q_s_alert"></a>
                            <h4>选择题</h4>
                            <h5><font color="red">注意：1. 括号处用#代替<br/>2. 选中正确答案</font></h5>
                            <div id="q_s_container"></div>
                            <input class="btn" type="button" name="btn_add_q" onclick="javascript:return addQuestion('s')" value="继续添加" />
                        </div>
                        <div class="alert alert-info" name="q_b_alert">
                            <a name="q_b_alert"></a>
                            <h4>填空题</h4>
                            <h5><font color="red">注意：题目中填空处用#代替，答案中几个填空答案用#分隔。例如：</font></h5>
                            <h5><font color="red">题目：贯彻三个代表要求，关键在#，核心在#，本质在#。</font></h5>
                            <h5><font color="red">答案：坚持与时俱进#保持党的先进性#坚持执政为民。</font></h5>
                            <div id="q_b_container"></div>
                            <input class="btn" type="button" name="btn_add_q" onclick="javascript:return addQuestion('b')" value="继续添加" />
                        </div>
                        <div class="alert alert-info" name="q_a_alert">
                            <a name="q_a_alert"></a>
                            <h4>简答题</h4>
                            <div id="q_a_container"></div>
                            <input class="btn" type="button" name="btn_add_q" onclick="javascript:return addQuestion('a')" value="继续添加" />
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="javascript/jquery.min.js"></script>
        <script type="text/javascript" src="javascript/common.js"></script>
        <script type="text/javascript" src="javascript/jquery.json-2.4.js"></script>
        <script type="text/javascript" src="javascript/question.js"></script>
    </body>
</html>
