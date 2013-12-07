<?php

session_start();
require_once './common.php';
global $global_conn;

$action = key_exists('action', $_REQUEST) ? $_REQUEST['action'] : null;
if (is_null($action)) {
    echo 'failed';
} else if ('registe' == $action) {
    $sql_check_username = 'SELECT id FROM user WHERE username = ?';
    $sql_new_user = 'INSERT INTO user(username, password, role, online) VALUES (?,?,?,1)';
    $username = key_exists('username', $_REQUEST) ? $_REQUEST['username'] : null;
    $pwd = key_exists('password', $_REQUEST) ? $_REQUEST['password'] : null;
    $role = key_exists('role', $_REQUEST) ? $_REQUEST['role'] : null;

    if (is_null($username) || is_null($pwd) || is_null($role)) {
        echo 'failed';
    } else {
        $exist_id = $global_conn->GetOne($sql_check_username, array($username));
        if (!is_null($exist_id) && $exist_id != 0) {
            echo 'duplicate';
        } else {
            $global_conn->Execute($sql_new_user, array($username, $pwd, $role));
            $uid = $global_conn->Insert_ID();
            $_SESSION['uid'] = $uid;
            $_SESSION['uname'] = $username;
            $_SESSION['role'] = $role;
            echo 'successed';
        }
    }
} else if ('search' == $action) {
    $sql_search_s = 'SELECT u.id, u.username, u.role, u.online, s.sid, s.workunit, s.degree FROM user u, student s WHERE u.username LIKE ? AND u.role = ?';
    $sql_search = 'SELECT id, username, role, online FROM user WHERE username LIKE ? AND role = ?';
    $username = key_exists('username', $_REQUEST) ? $_REQUEST['username'] : null;
    $role = key_exists('role', $_REQUEST) ? $_REQUEST['role'] : null;
    if ($username == '空表示搜索所有') {
        $username = '%';
    } else {
        $username ='%' . $username . '%';
    }
    
    $result = array();
    if (USER_ROLE_STUDENT == $role) {
        $result = get_array_from_resultset($global_conn->Execute($sql_search_s, array($username, $role)));
    } else {
        $result = get_array_from_resultset($global_conn->Execute($sql_search, array($username, $role)));
    }
    
    if (!is_null($result) && count($result) > 0) {
        ?>
        <table id="members" class="table table-striped table-bordered well">
                                <caption>用户信息</caption>
                                <thead class="title">
                                    <tr>
                                        <th class="name">用户名</th>
                                        <?php if (USER_ROLE_STUDENT == $role) {
                                            ?>
                                        <th class="sid">学号</th>
                                        <th class="sid">单位</th>
                                        <th class="sid">学历</th>
                                            <?php
                                        }
                                        ?>
                                        <th class="role">用户类型</th>
                                        <th class="status">账户状态</th>
                                        <th class="edit">设置</th>
                                    </tr>
                                </thead>
                                <tbody>
        <?php
        foreach ($result as $item) {
        ?>
        <tr class="success">
            <td><?php echo $item['username']; ?></td>
            <?php if (USER_ROLE_STUDENT == $role) {
                ?>
            <td><?php echo $item['sid']; ?></td>
            <td><?php echo $item['workunit']; ?></td>
            <td><?php echo $item['degree']; ?></td>
                <?php
            } ?>
            <td><?php echo $USER_ROLE[$item['role']]; ?></td>
            <td><?php echo $USER_ONLINE_STATUS[$item['online']]; ?></td>
            <td class="edit"><button class="btn btn-success" type="button" onclick="location.href='user_edit.php?id=<?php echo $item['id'] ?>&r=<?php echo $role; ?>'">修改</button></td>
        </tr>
        <?php } ?>
        </tbody></table>
        <?php
    } else {
        ?>
<p>未找到符合条件的用户</p>
        <?php
    }
} else if ('update' == $action) {
    $uid = key_exists('uid', $_REQUEST) ? $_REQUEST['uid'] : null;
    $role = key_exists('role', $_REQUEST) ? $_REQUEST['role'] : null;
    
    if (is_null($uid) || is_null($role)) {
        echo 'failed';
    } else {
        $sql_update = 'UPDATE user SET role = ? WHERE id = ?';
        $global_conn->Execute($sql_update, array($role, $uid));
        if (USER_ROLE_STUDENT == $role) {
            $sid = $_REQUEST['sid'];
            $workunit = $_REQUEST['workunit'];
            $degree = $_REQUEST['degree'];
            $sql_update_s = 'UPDATE student SET sid = ?, workunit = ?, degree = ? WHERE id = ?';
            $global_conn->Execute($sql_update_s, array($sid, $workunit, $degree, $uid));
        }
        
        echo 'success';
    }
}
