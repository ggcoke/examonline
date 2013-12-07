<?php
session_start();
require_once './common.php';
global $global_conn;
$uid = key_exists('uid', $_SESSION) ? $_SESSION['uid'] : null;
$role = key_exists('role', $_SESSION) ? $_SESSION['role'] : null;
$sid = key_exists('id', $_REQUEST) ? $_REQUEST['id'] : null;
$srole = key_exists('r', $_REQUEST) ? $_REQUEST['r'] : null;

if (is_null($uid) || is_null($role) || !isManager($role)) {
    ?>
    <script>
        alert("请登录：）");
        window.location.href='login.php';
    </script>
    <?php
}
$sql_user = '';
if (USER_ROLE_STUDENT == $srole) {
    $sql_user = 'SELECT u.id, u.username, u.role, u.online, s.sid, s.workunit, s.degree FROM user u, student s WHERE u.id = ?';
} else if (isManager($srole)) {
    $sql_user = 'SELECT id, username, role, online FROM user WHERE id = ?';
}
$result = get_array_from_resultset($global_conn->Execute($sql_user, array($sid)));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>设置用户</title>
        <link type="text/css" rel="stylesheet" href="css/style.css" />
    </head>
    <body>
        <?php include('./header.php'); ?>
        <div class="container">
            <div class="row">
                <div class="span2 bs-docs-sidebar">
                    <ul class="nav nav-list bs-docs-sidenav">
                        <li>
                            <a href="javascript:void(0)">用户设置</a>
                        </li>
                    </ul>
                </div>
                <div class="span11">
                    <table id="members" class="table table-striped table-bordered ">
                        <caption>用户信息</caption>
                        <?php
                        if (!is_null($result) && count($result) > 0) {
                            $user_info = $result[0];
                            $select = array();
                            $select[$user_info['role']] = 'selected';
                            ?>

                            <thead class="title">
                                <tr>
                                    <th class="name">用户名</th>
                                    <?php if (USER_ROLE_STUDENT == $srole){
                                        ?>
                                    <th class="name">学号</th>
                                    <th class="name">单位</th>
                                    <th class="name">学历</th>
                                        <?php
                                    } ?>
                                    <th class="role">用户类型</th>
                                    <th class="status">账户状态</th>
                                    <th class="edit">设置</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="success">
                                    <td><?php echo $user_info['username']; ?></td>
                                    <?php if (USER_ROLE_STUDENT == $srole) {
                                        ?>
                                    <td><input type="text" class="input-small" id="sid" name="sid" value="<?php echo $user_info['sid']; ?>" /></td>
                                    <td><input type="text" class="input-medium" id="workunit" name="workunit" value="<?php echo $user_info['workunit']; ?>" /></td>
                                    <td><input type="text" class="input-small" id="degree" name="degree" value="<?php echo $user_info['degree']; ?>" /></td>
                                    <?php
                                    }?>
                                    <td class="role">
                                        <select id="value_role" style="width:100px;" class="role" name="role">
                                            <option value=<?php echo USER_ROLE_MANAGER; ?> <?php echo $select[USER_ROLE_MANAGER]; ?>>管理员</option>
                                            <option value=<?php echo USER_ROLE_TEACHER; ?> <?php echo $select[USER_ROLE_TEACHER]; ?>>教师</option>
                                            <option value=<?php echo USER_ROLE_STUDENT; ?> <?php echo $select[USER_ROLE_STUDENT]; ?>>学生</option>
                                        </select>
                                    </td>
                                    <td><?php echo $USER_ONLINE_STATUS[$user_info['online']]; ?></td>
                                    <td class="edit">
                                        <button class="btn btn-success" type="button" onclick="javascript:updateUserInfo(<?php echo $sid;?>)">确定</button>
                                        <button class="btn btn-danger" type="button" onclick="javascript:history.back()">取消</button>
                                    </td>
                                </tr>

                            <?php } else { ?>
                                用户不存在，<a href="manager.php">返回</a>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="javascript/jquery.min.js"></script>
        <script type="text/javascript" src="javascript/common.js"></script>
        <script type="text/javascript" src="javascript/user.js"></script>
    </body>
</html>