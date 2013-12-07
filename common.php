<?php

/**
 * @author GGCoke
 * 2012-2-18 11:41:35
 */

/** 定义项目根目录 */
define('ABSPATH', dirname(__FILE__));

$context_path = explode('/', $_SERVER['REQUEST_URI']);
define('SITEURI', 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/' . $context_path[1]);
/** 读取配置文件 */
if (file_exists(ABSPATH . '/config/cfg.php')){
	require_once( ABSPATH . '/config/cfg.php' );
} else {
    die("找不到配置文件" . ABSPATH . "/config/cfg.php");
}

// 加载通用方法
require_once( ABSPATH . '/util/functions.php' );
require_once( ABSPATH . '/util/StringUtil.php' );

/** 设置时区 */
set_timezone();

/** 连接数据库 */
require_conn();

//end of script