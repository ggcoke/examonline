<?php
session_start();
require_once './common.php';
$sql_update_online = 'UPDATE user SET online = 0 WHERE id = ?';
global $global_conn;
$uid = $_SESSION['uid'];
$_SESSION = array();
session_destroy();
$global_conn->Execute($sql_update_online, array($uid));
