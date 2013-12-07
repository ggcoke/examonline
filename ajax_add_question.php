<?php

include "./common.php";
global $global_conn;

$sql_i_s_content = 'INSERT INTO select_question(content,img,qstatus) VALUES (?,?,1)';
$sql_i_s_choice = 'INSERT INTO select_answer (sid, choice_key, choice_value, is_answer) VALUES (?,0,?,?),(?,1,?,?),(?,2,?,?),(?,3,?,?)';
$sql_i_b = 'INSERT INTO blank(content,img,answer,qstatus) VALUES (?,?,?,1)';
$sql_i_a = 'INSERT INTO shortq(content,img,answer,qstatus) VALUES (?,?,?,1)';


$data = key_exists('data', $_REQUEST) ? $_REQUEST['data'] : null;

if (is_null($data) || $data == '')
    echo 'NULL';
else {
    $dataJson = json_decode($data);
    $qs = $dataJson->{'s'};
    $qb = $dataJson->{'b'};
    $qa = $dataJson->{'a'};

    if (is_null($data)) {
        echo 'NULL';
    } else {
        foreach ($qs as $s) {
            $content = $s->{'q'};
            $global_conn->Execute($sql_i_s_content, array(mysql_escape_string($s->{'q'}),$s->{'img'}));
            $sid = $global_conn->Insert_ID();
            $ans = explode(',', $s->{'ans'});
            $is_ans_a = in_array('a', $ans) ? 1:0;
            $is_ans_b = in_array('b', $ans) ? 1:0;
            $is_ans_c = in_array('c', $ans) ? 1:0;
            $is_ans_d = in_array('d', $ans) ? 1:0;
            $global_conn->Execute($sql_i_s_choice, array(
                $sid, mysql_escape_string($s->{'a'}), $is_ans_a,
                $sid, mysql_escape_string($s->{'b'}), $is_ans_b,
                $sid, mysql_escape_string($s->{'c'}), $is_ans_c,
                $sid, mysql_escape_string($s->{'d'}), $is_ans_d));
        }
        
        foreach ($qb as $b) {
            if ($b->{'q'}!=null && $b->{'a'}!=null) {
                $global_conn->Execute($sql_i_b, array(mysql_escape_string($b->{'q'}),$b->{'img'},mysql_escape_string($b->{'a'})));
            }
        }
        
        foreach ($qa as $a) {
            if ($a->{'q'}!=null && $a->{'a'}!=null) {
                $global_conn->Execute($sql_i_a, array(mysql_escape_string($a->{'q'}),$a->{'img'},mysql_escape_string($a->{'a'})));
            }
        }
        echo 'S';
    }
}
