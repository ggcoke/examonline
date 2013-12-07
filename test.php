<?php

require './common.php';
require './lib/PHPExcel.php';

global $global_conn;
$sql_i_b = 'INSERT INTO blank(content,img,answer,chapter,kword,level,qtime,qname,qstatus) VALUES (?,?,?,?,?,?,?,?,1)';

$input_file = ('C:/Users/GGCoke/Desktop/test.xls');
$objPHPExcel = PHPExcel_IOFactory::load($input_file);

$sheet_count = $objPHPExcel->getSheetCount();
$currentSheet = $objPHPExcel->getSheet(0); // 当前页
$row_num = $currentSheet->getHighestRow(); // 当前页行数
$col_max = $currentSheet->getHighestColumn(); // 当前页最大列号
for ($i = 5; $i < 6/*($row_num-4)*/; $i++) {
    $cell_values = array();
    for ($j = 'A'; $j <= $col_max; $j++) {
        $address = $j . $i; // 单元格坐标
        $cell_values[] = $currentSheet->getCell($address)->getFormattedValue();
    }
    
    // 题目或答案为空，不录入数据库
    if (is_null($cell_values[2]) || is_null($cell_values[3]))
        continue;
    
    // 看看数据 
    var_dump($cell_values);
    $global_conn->Execute($sql_i_b, 
            array(
                mysql_escape_string(str_replace("（）", "#", $cell_values[2])),    /* 题目 */
                null,                                                              /* 图片 */
                mysql_escape_string(str_replace("；", "#", $cell_values[3])),      /* 答案 */
                mysql_escape_string($cell_values[1]),    /* 章节 */
                mysql_escape_string($cell_values[4]),    /* 关键词 */
                mysql_escape_string($cell_values[5]),    /* 难度 */
                $cell_values[6],     /* 出题时间 */
                $cell_values[7]));   /* 出题人 */
}
echo 'End<br/>';