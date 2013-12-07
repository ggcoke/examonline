<?php

/**
 * 处理字符串的常用方法
 * modified from StringUtil.java
 *
 * @author GGCoke
 * 2012-2-20 14:01:44
 */
class StringUtil
{


    function __construct()
    {
        ;
    }

    /**
     * 生成特定长度的随机字符串
     * @param int $length 生成的字符串的长度
     * @return string 随机字符串
     */
    static function generate_random_string($len)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $string = "";
        for (; $len >= 1; $len--) {
            $position = rand() % strlen($chars);
            $string .= substr($chars, $position, 1);
        }
        return $string;
    }


    /**
     * 将长字符串进行格式化为指定长度的字符串，指定的长度为中文字符的个数，如果为英文字符，则为两倍。超出的部分用"…"代替
     * @author GGCoke
     * @param String $string 原字符串
     * @param int $length 保留的字数
     * @param String $default 如果$string为空时显示的内容
     * @return String 格式化之后的字符串
     */
    static function format_long_string($string, $length, $default)
    {
        if ($string == null || mb_strlen($string, 'utf-8') == 0) {
            return $default;
        } else {
            if (mb_strlen($string, 'utf-8') == strlen($string))
                $length *= 2;

            if (mb_strlen($string, 'utf-8') <= $length)
                return $string;
            /** 此处如果使用substr会出现乱码，因此需要使用mb_substr,同时指定编码格式 */
            $string = mb_substr($string, 0, $length, 'utf-8');
            $string .= '…';
            return $string;
        }
    }

    /**
     * 将长字符串进行格式化为指定长度的字符串改进版，指定的长度为中文字符的个数，如果为英文字符，则为$multiple的倍数。超出的部分用"…"代替
     * 计算长度时是逐个字符分别计算的
     * @author GGCoke
     * @param String $string 原字符串
     * @param int $length 保留的字数
     * @param String $default 如果$string为空时显示的内容
     * @param int $multiple 英文字符的倍数
     * @return String 格式化之后的字符串
     */
    static function format_long_string_improved($string, $length, $default, $multiple = 2)
    {
        if ($string == null || mb_strlen($string, 'utf-8') == 0) {
            return $default;
        } else {
            $tmp_length = 0;
            $sub_length = 0;
            $big_count = 0;
            $small_count = 0;
            $big_array = array('m', 'M', 'w', 'W');
            $small_array = array('f', 'i', 'j', 'l', 'r', 't', 'I');
            while ($tmp_length <= $length * $multiple) {
                $tmpstr = mb_substr($string, $sub_length, 1, 'utf-8');
                if (strlen($tmpstr) > 1 || in_array($tmpstr, $big_array)) {
                    $tmp_length += 2;
                    $big_count++;
                } else if (in_array($tmpstr, $small_array)) {
                    $tmp_length += 0.8;
                    $small_count++;
                } else {
                    $tmp_length += 1;
                }
                $sub_length++;
            }

            if ($tmp_length != $sub_length) {
                $sub_length--;
            }

            if (mb_strlen($string, 'utf-8') <= $sub_length)
                return $string;
            /** 此处如果使用substr会出现乱码，因此需要使用mb_substr,同时指定编码格式 */
            $string = mb_substr($string, 0, $sub_length, 'utf-8');
            $string .= '…';
            return $string;
        }
    }

    function get_first_char($s0)
    {
        $fchar = ord(trim($s0{0}));
        if ($fchar >= ord("A") and $fchar <= ord("z")) return strtoupper($s0{0});
        $firstchar_ord = ord(strtoupper($s0{0}));
        if (($firstchar_ord >= 65 and $firstchar_ord <= 91)or($firstchar_ord >= 48 and $firstchar_ord <= 57)) return $s0{0};

        $s = iconv("UTF-8", "gb2312", $s0);
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 and $asc <= -20284) return "A";
        if ($asc >= -20283 and $asc <= -19776) return "B";
        if ($asc >= -19775 and $asc <= -19219) return "C";
        if ($asc >= -19218 and $asc <= -18711) return "D";
        if ($asc >= -18710 and $asc <= -18527) return "E";
        if ($asc >= -18526 and $asc <= -18240) return "F";
        if ($asc >= -18239 and $asc <= -17923) return "G";
        if ($asc >= -17922 and $asc <= -17418) return "H";
        if ($asc >= -17417 and $asc <= -16475) return "J";
        if ($asc >= -16474 and $asc <= -16213) return "K";
        if ($asc >= -16212 and $asc <= -15641) return "L";
        if ($asc >= -15640 and $asc <= -15166) return "M";
        if ($asc >= -15165 and $asc <= -14923) return "N";
        if ($asc >= -14922 and $asc <= -14915) return "O";
        if ($asc >= -14914 and $asc <= -14631) return "P";
        if ($asc >= -14630 and $asc <= -14150) return "Q";
        if ($asc >= -14149 and $asc <= -14091) return "R";
        if ($asc >= -14090 and $asc <= -13319) return "S";
        if ($asc >= -13318 and $asc <= -12839) return "T";
        if ($asc >= -12838 and $asc <= -12557) return "W";
        if ($asc >= -12556 and $asc <= -11848) return "X";
        if ($asc >= -11847 and $asc <= -11056) return "Y";
        if ($asc >= -11055 and $asc <= -10247) return "Z";
        return "others";
    }

    function icg_number_format($number)
    {
        $number_string = $number;
        if ($number > 1000000) {
            $number_string = round($number_string / 1000000.0, 2) . 'M';
        } else if ($number > 1000) {
            $number_string = round($number_string / 1000.0, 2) . 'K';
        }
        return $number_string;
    }

    /**
     * 格式化时间格式，将形如2011-12-10 12:24:36的时间转换为*小时前或*天前等
     * @author libis
     */
    static function format_time($time)
    {
        $timeDisplay = "";
        $now_time = time();
        $diff = $now_time - strtotime($time);
        $day = round($diff / (24 * 60 * 60));
        $hour = round($diff / (60 * 60));
        $min = round($diff / 60);
        $second = round($diff);
        if ($day != 0 || date("Y-m-d", $now_time) != date("Y-m-d", strtotime($time))) {
            $timeDisplay = substr($time, strpos($time, "-") + 1, 11);
        } else if ($hour != 0) {
            $temp = substr($time, strpos($time, " ") + 1, 5);
            $timeDisplay = "今天 " . $temp;
        } else if ($min > 0 && $min <60) {
            $timeDisplay = $min . "分钟前";
        } else if ($second >= 0 && $second < 60) {
            $timeDisplay = "刚刚";
        }
        return $timeDisplay;
    }
}

//end of script