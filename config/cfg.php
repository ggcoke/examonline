<?php

/**
 * 基础配置文件。
 * 本文件包含以下配置选项: MySQL 设置和ABSPATH
 * 
 * @author GGCoke
 * 
 */
// ** 数据库设置 - 根据主机情况进行修改 ** //
/** 使用的数据库类型 */
define('DB_DRIVER', 'mysql');

/** HuanXiTao 数据库的名称 */
define('DB_NAME', 'examination');

/** 数据库用户名 */
define('DB_USER', 'root');

/** 数据库密码 */
define('DB_PASSWORD', '123456');

/** 数据库主机 */
define('DB_HOST', 'localhost');

/** 创建数据表时默认的文字编码 */
define('DB_CHARSET', 'utf8');

/** 设置开发者调试模式 */
//define('ICG_DEBUG', true);

/** 设置时区 */
define('TIMEZONE', 'Asia/Chongqing');

/** 数据库调试信息 */
if (defined('ICG_DEBUG'))
    define('DB_DEBUG', true);
else
    define('DB_DEBUG', false);

/* * other info from 'configuration.properties' */

define('QUESTION_TYPE_SELECT', 0);
define('QUESTION_TYPE_BLANK', 1);
define('QUESTION_TYPE_SHORT', 2);

$ANSWER_KEY_MAP = array(0=>'A',1=>'B',2=>'C',3=>'D');

// 用户权限
define('USER_ROLE_MANAGER', 0);
define('USER_ROLE_TEACHER', 1);
define('USER_ROLE_STUDENT', 2);

// 用户在线状态
define('USER_STATUS_OFFLINE', 0);
define('USER_STATUS_ONLINE', 1);

// 考试状态
define('EXAM_STATUS_INACTIVE',0);
define('EXAM_STATUS_ACTIVE',1);

$USER_ROLE = array(
    USER_ROLE_MANAGER=>'管理员',
    USER_ROLE_TEACHER=>'教师',
    USER_ROLE_STUDENT=>'学生'
);

$USER_ONLINE_STATUS = array(
    USER_STATUS_OFFLINE=>'离线',
    USER_STATUS_ONLINE=>'在线'
);

// End of script
