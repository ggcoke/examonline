<?php

/**
 * @author GGCoke
 * 2013-10-31 12:37:50
 */
include "../common.php";
global $global_conn;
$sql_select = 'SELECT DISTINCT s.id, s.content, s.img FROM select_question AS s JOIN (SELECT ROUND(RAND() * (SELECT MAX(id) - MIN(id) FROM select_question) + (SELECT MIN(id) FROM select_question)) AS id FROM select_question)AS s2 ON s.id = s2.id AND s.qstatus = true LIMIT 15';
$sql_blank = 'SELECT DISTINCT b.id, b.content, b.img, b.answer FROM blank AS b JOIN (SELECT ROUND(RAND() * (SELECT MAX(id) - MIN(id) FROM blank) + (SELECT MIN(id) FROM blank)) AS id FROM blank)AS b2 ON b.id = b2.id AND b.qstatus = true LIMIT 15';
$sql_short = 'SELECT DISTINCT s.id, s.content, s.img, s.answer FROM shortq AS s JOIN (SELECT ROUND(RAND() * (SELECT MAX(id) - MIN(id) FROM shortq) + (SELECT MIN(id) FROM shortq)) AS id FROM shortq)AS s2 ON s.id = s2.id AND s.qstatus = true LIMIT 5';
$sql_choices = 'SELECT a.choice_key, a.choice_value, a.is_answer FROM select_answer a WHERE a.sid = ?';

$result = new stdClass();
$result->choices = array();
$result->blanks = array();
$result->shorts = array();

$log = '';

// 选择题题目
$result_select = get_array_from_resultset($global_conn->Execute($sql_select, null));

if (count($result_select) > 0) {
    $index = 0;
    
    $log .= "\r\nSelect(" . count($result_select) . "):\r\n";
    
    foreach($result_select as $item) {
        // 选择题对应选项
        $result_choices = get_array_from_resultset($global_conn->Execute($sql_choices, array($item['id'])));
        $select_count = count($result_choices);
        if ($select_count <= 0)
            continue;
        
        $choice = new stdClass();
        $choice->id = $item['id'];
        $choice->index = ++$index;
        $choice->type = QUESTION_TYPE_SELECT;
        $choice->questioncontent = $item['content'];
        $choice->img = $item['img'];
        $choice->answer = 0;
        for ($sindex = 0; $sindex < $select_count; $sindex++) {
            // 是否是正确答案
            if ($result_choices[$sindex]['is_answer']) {
                $choice->answer = $result_choices[$sindex]['choice_key'];
            }
            $attr = "choice" . ($sindex + 1);
            $choice->$attr = $ANSWER_KEY_MAP[$result_choices[$sindex]['choice_key']] . '. ' . $result_choices[$sindex]['choice_value'];
        }
        
        array_push($result->choices, $choice);
        
        // 记录日志
        $log .= ($item['id'] . ',');
    }
}

// 填空题题目及答案
$result_blank = get_array_from_resultset($global_conn->Execute($sql_blank, null));

if (count($result_blank) > 0) {
    $log .= "\r\nBlank(".count($result_blank). "):\r\n";
    
    $index = 0;
    foreach($result_blank as $item) {
        $blank = new stdClass();
        $blank->id = $item['id'];
        $blank->index = ++$index;
        $blank->type = QUESTION_TYPE_BLANK;
        $blank->questioncontent = $item['content'];
        $blank->img = $item['img'];
        $blank->answer = $item['answer'];
        array_push($result->blanks, $blank);
        
        $log .= ($item['id'] . ",");
    }
}

// 简答题题目及答案
$result_short = get_array_from_resultset($global_conn->Execute($sql_short, null));

if (count($result_short) > 0) {
    $log .= "\r\nShort_Answer(".count($result_short)."):\r\n";
    $index = 0;
    foreach($result_short as $item) {
        $short = new stdClass();
        $short->id = $item['id'];
        $short->index = ++$index;
        $short->type = QUESTION_TYPE_SHORT;
        $short->questioncontent = $item['content'];
        $short->img = SITEURI . '/image/' . $item['img'];
        $short->answer = $item['answer'];
        array_push($result->shorts, $short);
        
        $log .= ($item['id'] . ",");
    }
}
$log .= "\r\n";
write_log('exam_log.log', $log);
echo json_encode($result);
