<?php

/**
 * @author GGCoke
 * 2013-11-1 10:18:32
 */
session_start();
require_once './common.php';
global $global_conn;
$sql = 'SELECT id, username, role FROM user WHERE username = ? AND password = ?';
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

$result = get_array_from_resultset($global_conn->Execute($sql, array($username, $password)));

if (is_null($result) || count($result) == 0) {
    echo 'LOGIN_FAILED';
} else {
    $sql_update_online = 'UPDATE user SET online = 1,lastlogin = now() WHERE id = ?';
    
    $user_info = $result[0];
    $_SESSION['uid'] = $user_info['id'];
    $_SESSION['uname'] = $user_info['username'];
    $_SESSION['role'] = $user_info['role'];
    
    // 设置用户状态为online
    $global_conn->Execute($sql_update_online, array($user_info['id']));
    echo 'LOGIN_SUCCESSED';
}
