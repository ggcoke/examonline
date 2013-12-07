<?php

class User {

    private $SQL_CHECK_USERNAME = 'SELECT id FROM user WHERE username = ?';
    private $SQL_USER_REGISTE = 'INSERT INTO user(username, password, role, online) VALUES (?,?,?,1)';
    private $SQL_USER_UPDATE = 'UPDATE user SET role = ? WHERE id = ?';
    private $SQL_STUDENT_UPDATE = 'UPDATE student SET sid = ?, workunit = ?, degree = ? WHERE id = ?';
    private $SQL_USER_SEARCH = 'SELECT id, username, role, online FROM user WHERE username LIKE ? AND role = ?';
    private $SQL_STUDENT_SEARCH = 'SELECT u.id, u.username, u.role, u.online, s.sid, s.workunit, s.degree FROM user u, student s WHERE u.username LIKE ? AND u.role = ?';
    private static $SQL_USER_ROLE = 'SELECT u.role FROM user u WHERE u.id = ?';
    
    /**
     * 判断用户名是否重复
     * @global type $global_conn
     * @param type $username
     * @return boolean 重复返回true，否则返回false 
     */
    function username_exist($username) {
        global $global_conn;
        $exist_id = $global_conn->GetOne($this->SQL_CHECK_USERNAME, array($username));
        if (!is_null($exist_id) && $exist_id != 0) {
            return true;
        }

        return false;
    }

    /**
     * 用户注册
     * @param type $username
     * @param type $password
     * @param type $role
     * @return int 返回用户id 
     */
    function user_registe($username, $password, $role) {
        global $global_conn;
        $global_conn->Execute($this->SQL_USER_REGISTE, array($username, $password, $role));
        $uid = $global_conn->Insert_ID();
        return $uid;
    }

    function user_update($id, $role) {
        global $global_conn;
        $global_conn->Execute($this->SQL_USER_UPDATE, array($role, $id));
    }

    function student_update($uid, $sid, $workunit, $degree) {
        global $global_conn;
        $global_conn->Execute($this->SQL_STUDENT_UPDATE, array($sid, $workunit, $degree, $uid));
    }

    function user_search($username, $role) {
        if ($username == '空表示搜索所有') {
            $username = '%';
        } else {
            $username = '%' . $username . '%';
        }
        
        if (USER_ROLE_STUDENT == $role) {
            return get_array_from_resultset($global_conn->Execute($this->SQL_STUDENT_SEARCH, array($username, $role)));
        } else {
            return get_array_from_resultset($global_conn->Execute($this->SQL_USER_SEARCH, array($username, $role)));
        }
    }
    
    /**
     * 用户是否是管理员
     * @global type $global_conn
     * @param type $uid
     * @return 是管理员返回true，否则返回false 
     */
    static function isAdmin($uid) {
        global $global_conn;
        $role = $global_conn->GetOne(self::$SQL_USER_ROLE, array($uid));
        return USER_ROLE_MANAGER == $role || USER_ROLE_TEACHER == $role;
    }
}