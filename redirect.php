<?php

session_start();
require_once './common.php';
$uid = $_SESSION['uid'];
$role = $_SESSION['role'];
if (is_null($uid) || is_null($role)) {
    ?>
    <script>
        alert("请登录：）");
        window.location.href='login.php';
    </script>
<?php } else if (USER_ROLE_MANAGER == $role) {
    // 管理员
    ?>
    <script>
        window.location.href='manager.php';
    </script>
    <?php
} else if (USER_ROLE_TEACHER == $role) {
    // 教师
    ?>
    <script>
        window.location.href='manager.php';
    </script>
    <?php
}

?>
