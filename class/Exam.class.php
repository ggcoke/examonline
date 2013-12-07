<?php
class Exam {
    private $SQL_NEW_EXAM = 'INSERT INTO exam(uid,exam_name,tf_value,tf_count,tf_level,
        s_value,s_count,s_level,ms_value,ms_count,ms_level,b_value,b_count,b_level,
        a_value,a_count,a_level,exam_status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
    private $SQL_EXAM_UPDATE_STATUS = 'UPDATE exam SET exam_status = ? WHERE id = ?';
    private static $SQL_GET_EXAM_INFO_BY_STATUS = 'SELECT e.id, e.uid, e.exam_name, e.tfvalue, e.tf_count, e.tf_level,
        e.s_value, e.s_count, e.s_level, e.ms_value, e.ms_count, e.ms_level, e.b_value, e.b_count, e.b_level,
        e.a_value, e.a_count, e.a_level FROM exam e WHERE e.exam_status = ?';
    private static $SQL_GET_EXAM_INFO_BY_ID = 'SELECT e.id, e.uid, e.exam_name, e.tfvalue, e.tf_count, e.tf_level,
        e.s_value, e.s_count, e.s_level, e.ms_value, e.ms_count, e.ms_level, e.b_value, e.b_count, e.b_level,
        e.a_value, e.a_count, e.a_level, e.exam_status FROM exam e WHERE e.id = ?';
    
    /**
     * 新建考试信息
     * @global type $global_conn
     * @param type $uid   创建人id
     * @param type $exam_name    考试名称
     * @param type $tf_value
     * @param type $tf_count
     * @param type $tf_level
     * @param type $s_value
     * @param type $s_count
     * @param type $s_level
     * @param type $ms_value
     * @param type $ms_count
     * @param type $ms_level
     * @param type $b_value
     * @param type $b_count
     * @param type $b_level
     * @param type $a_value
     * @param type $a_count
     * @param type $a_level
     * @return int 考试id 
     */
    function exam_create(
            $uid, $exam_name, $tf_value, $tf_count, $tf_level,
            $s_value, $s_count, $s_level, $ms_value, $ms_count, $ms_level,
            $b_value, $b_count, $b_level, $a_value, $a_count, $a_level) {
        global $global_conn;
        $global_conn->Execute($this->SQL_NEW_EXAM, array(
            $uid, $exam_name, $tf_value, $tf_count, $tf_level,
            $s_value, $s_count, $s_level, $ms_value, $ms_count, $ms_level,
            $b_value, $b_count, $b_level, $a_value, $a_count, $a_level, EXAM_STATUS_ACTIVE));
        return $global_conn->Insert_ID();
    }
    
    /**
     * 更新考试状态
     * @param type $uid
     * @param type $eid
     * @param type $status
     * @return boolean 更新成功返回true，无权限修改返回false 
     */
    function exam_status_update($uid, $eid, $status) {
        if (!User::isAdmin($uid)) 
            return false;
        global $global_conn;
        $global_conn->Execute($this->SQL_EXAM_UPDATE_STATUS, array($status, $eid));
    }
    
    static function get_exam_by_id($eid) {
        global $global_conn;
        return get_array_from_resultset($global_conn->Execute(self::$SQL_GET_EXAM_INFO_BY_ID, array($eid)));
    }
    
    static function get_exam_by_status($status) {
        global $global_conn;
        return get_array_from_resultset($global_conn->Execute(self::$SQL_GET_EXAM_INFO_BY_STATUS, array($status)));
    }
}
