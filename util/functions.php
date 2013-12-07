<?php

/**
 * 一些公用的函数
 * @author GGCoke
 * 2012-2-18 14:38:29
 */

/**
 * 获取数据库连接, $icgdb为全局变量
 * @global type $global_conn
 */
function require_conn() {
    global $global_conn;
    require_once (ABSPATH . "/util/DB.class.php");

    if (isset($global_conn))
        return;
    $db = new DB(DB_DRIVER, DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_DEBUG);
    $global_conn = $db->get_connection();

    /** 设置FetchMode为ASSOC */
    $global_conn->SetFetchMode(ADODB_FETCH_ASSOC);

    /** 数据库连接失败，停止运行 */
    if (is_null($global_conn)) {
        die("连接数据库失败，请检查配置。");
    }
}

/**
 * 设置系统时区
 */
function set_timezone() {
    if (defined('TIMEZONE')) {
        date_default_timezone_set(TIMEZONE);
    } else {
        date_default_timezone_set('UTC');
    }
}

/**
 * 将ADOResultSet封装为Array。
 * @param ADOResultSet $rs
 * @return array 搜索出错或者搜索结果为空时null, 需要判断返回结果是不是null
 */
function get_array_from_resultset($rs) {
    /* ResultSet 为空时返回 null */
    if (!$rs || $rs->RecordCount() == 0)
        return null;

    $result = array();
    $column_count = $rs->FieldCount();
    $rs->Move(0);
    while ($row = $rs->FetchRow()) {
        $array_of_row = array();
        for ($i = 0; $i < $column_count; $i++) {
            $column_name = $rs->FetchField($i)->name;
            $array_of_row[$column_name] = $row[$column_name];
        }
        array_push($result, $array_of_row);
    }

    return $result;
}

/**
 * 格式化时间格式，将形如2011-12-10 12:24:36的时间转换为*小时前或*天前等
 * @author GGCoke
 */
function format_time($time) {
    $timeDisplay = "";
    $diff = mktime() - strtotime($time);
    $day = round($diff / (24 * 60 * 60));
    $hour = round($diff / (60 * 60) - $day * 24);
    $min = round($diff / 60 - $day * 24 * 60 - $hour * 60);
    $second = round($diff - $day * 24 * 60 * 60 - $hour * 60 * 60 - $min * 60);
    if ($day != 0) {
        $timeDisplay = $day . "天";
    } else if ($hour != 0) {
        $timeDisplay = $hour . "小时";
    } else if ($min != 0) {
        $timeDisplay = $min . "分钟";
    } else if ($second >= 0) {
        if ($second == 0)
            $second = 1;
        $timeDisplay = $second . "秒";
    }
    return $timeDisplay;
}

/**
 * 格式化时间格式，将当天的时间转换，其他时间不转换
 * @author GGCoke
 * modified in 2012-08-03
 */
function format_time_modified($time) {
    $timeDisplay = "";
    $diff = mktime() - strtotime($time);
    $day = round($diff / (24 * 60 * 60));
    $hour = round($diff / (60 * 60) - $day * 24);
    $min = round($diff / 60 - $day * 24 * 60 - $hour * 60);
    $second = round($diff - $day * 24 * 60 * 60 - $hour * 60 * 60 - $min * 60);
    if ($day != 0) {
        $timeDisplay = date("Y-m-d", strtotime($time));
    } else {
        if ($hour != 0) {
            $timeDisplay = $hour . "小时" . "前";
        } else {
            if ($min != 0) {
                $timeDisplay = $min . "分钟" . "前";
            } else {
                if ($second == 0) {
                    $second = 1;
                }
                $timeDisplay = $second . "秒" . "前";
            }
        }
    }
    return $timeDisplay;
}

/**
 * 去除数组中重复的元素
 */
function assoc_unique(&$arr, $key) {
    $tmp_arr = array();
    foreach ($arr as $k => $v) {
        if (in_array($v[$key], $tmp_arr)) {
            unset($arr[$k]);
        } else {
            $tmp_arr[] = $v[$key];
        }
    }
    return $arr;
}

/**
 * 将ip地址转换成整型，解决ip2long转化成整数后，是负的
 * 这是因为得到的结果是有符号整型，最大值是2147483647.要把它转化为无符号的
 * @param string $ip_address ip地址
 * @return int  
 */
function ip2int($ip_address) {
    return bindec(decbin(ip2long($ip_address)));
}

/**
 * 日志记录方法，记录的格式为 时间:IP:用户ID(未登录则为0):内容
 * @param type $filename 日志文件的文件名,自动保存到 ABSPATH/log/目录下
 * @param type $content 日志内容
 * @param type $user_id  用户ID，未登录则为0
 */
function write_log($filename, $content, $user_id = 0) {
    $file = fopen('/home/ichangge/resource/log/' . $filename, 'a+');
    $now = date("Y-m-d H:i:s", mktime());
    $ip = getIp();
    fwrite($file, $now . "\t" . $ip . "\t" . $user_id . "\t" . $content . "\r\n");
    fclose($file);
}

/**
 * 获取字符串第i个字符
 * @param type $string 原字符串
 * @param type $index 索引
 * @return type 查找到的字符
 */
function char_at($string, $index) {
    if ($index < mb_strlen($string)) {
        return mb_substr($string, $index, 1);
    } else {
        return -1;
    }
}

function get_array_from_key_array($key_array, $key) {
    if (is_null($key_array) || count($key_array) == 0)
        return NULL;
    $result = array();
    foreach ($key_array as $item) {
        array_push($result, $item[$key]);
    }
    return $result;
}

/**
 * Return TRUE if the client is smart mobile phone.
 * Add smart phone HTTP_USER_AGENT feature phrase in the $regex_match to cover potential phone types
 *
 * @author yuyong.li
 * 2012-9-19 9:43:40
 */
function is_mobile() {
    $regex_match = "/(nokia|iphone|ios|ipad|windows phone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";
    $regex_match.="htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";
    $regex_match.="blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";
    $regex_match.="symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";
    $regex_match.="jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";
    $regex_match.=")/i";
    return isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']) or preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT']));
}

/**
 * 格式化数字，使用K, M表示很大的数字
 * @param type $number
 * @return string 
 */
function icg_number_format($number) {
    $number_string = $number;
    if ($number > 1000000) {
        $number_string = round($number_string / 1000000.0, 2) . 'M';
    } else if ($number > 1000) {
        $number_string = round($number_string / 1000.0, 2) . 'K';
    }
    return $number_string;
}

/**
 * 重命名并移动文件 
 * @param type $frompath    原文件路径
 * @param type $topath      新文件路径
 * @return boolean
 */
function icg_move_file($frompath, $topath) {
    if ($frompath != null) {
        if (!file_exists(dirname($topath))) {
            mkdir(dirname($topath), 0777, true);
        }
        return rename($frompath, $topath);
    } else {
        return false;
    }
}

/**
 * 安全删除文件 
 * @param type $path  文件路径
 * @return boolean
 */
function icg_remove_file($path) {
    if (file_exists($path)) {
        return unlink($path);
    } else {
        return true;
    }
}

/**
 * 循环删除目录和文件函数 
 * @param type $dirName
 * @return boolean
 */
function delDirAndFile($dirName) {
    if ($filehandle = opendir("$dirName")) {
        while (false !== ($item = readdir($filehandle))) {
            if ($item != "." && $item != "..") {
                if (is_dir("$dirName/$item")) {
                    delDirAndFile("$dirName/$item");
                } else {
                    unlink("$dirName/$item");
                }
            }
        }
        closedir($filehandle);
        return rmdir($dirName);
    } else {
        return false;
    }
}

/**
 * 读取客户端ip
 * @return type
 */
function getIp() {
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = "unknown";
    return ($ip);
}

function isManager($role) {
    return USER_ROLE_MANAGER == $role || USER_ROLE_TEACHER == $role;
}

function isTeacher($role) {
    return USER_ROLE_TEACHER == $role;
}

function isStudent($role) {
    return USER_ROLE_STUDENT == $role;
}

//end of script