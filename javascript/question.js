function addQuestion(type){
    var info_num = $("#" + type + "_num").val();
    info_num++;
    $("#" + type + "_num").val(info_num);
    var new_q = '';
    if (type == 's'){
        new_q = '<div id="q_' + type + '_' + info_num + '" class="question well form-horizontal">' + 
            '<table class="table"><tbody>' + 
            '<tr><td>题目：<input type="text" class="input-xlarge" name="content"/></td></tr>' + 
            '<tr><td>图片URL：<input type="text" class="input-xlarge" name="img"/></td></tr>' + 
            '<tr><td>A:<input type="text" class="input-medium" id="a" name="a"/><input type="checkbox" name="ans" value="a" /></td>' + 
            '<td>B:<input type="text" class="input-medium" id="b" name="b"/><input type="checkbox" name="ans" value="b" /></td>' +
            '</tr><tr>' + 
            '<td>C:<input type="text" class="input-medium" id="c" name="c"/><input type="checkbox" name="ans" value="c" /></td>' + 
            '<td>D:<input type="text" class="input-medium" id="d" name="d"/><input type="checkbox" name="ans" value="d" /></td>' + 
            '</tr></tbody></table>'+
            '<input class="btn btn-small" type="button" name="btn_del_q" onclick="javascript:return delQuestion(this)" value="删除此题目"/>' + 
            '</div>';
    } else {
        new_q = '<div id="q_' + type + '_' + info_num + '" class="question well form-horizontal">'+
            '<p><input type="text" class="input-xlarge" name="'+type+'q" />'+
            '<label class="control-label" for="'+type+'q">题目：</label></p>'+
            '<p><input type="text" class="input-xlarge" name="img"/>' + 
            '<label class="control-label" for="img">图片URL</label></p>' +
            (type == 'b' ? 
            '<p><input type="text" class="input-xlarge" name="'+type+'a" />' : 
            '<p><textarea class="textarea-xlarge" name="'+type+'a" />') +
            '<label class="control-label" for="'+type+'a">答案：</label>'+
            '<p><input class="btn btn-small" type="button" name="btn_del_q" onclick="javascript:return delQuestion(this)" value="删除此题目"/>'+
            '</p></p></div>';
    }
    
    $('#q_'+type+'_container').append(new_q);
}

function delQuestion(obj) {
    $(obj).parents('.question').remove();
}

function submitQuestion(){
    var data_s = new Array();
    var data_b = new Array();
    var data_a = new Array();
    var correct = true;
    $('#q_s_container').children('.question').each(function(i, data){
        var sq = $(data).find("input[name='content']").val();
        var img = $(data).find("input[name='img']").val();
        var a = $(data).find("input[name='a']").val();
        var b = $(data).find("input[name='b']").val();
        var c = $(data).find("input[name='c']").val();
        var d = $(data).find("input[name='d']").val();
        var ans = '';//$(data).find("input[name='ans']").val();
        $(data).find("input[name='ans']:checked").each(function(j, cdata){
            ans+=($(cdata).val()+',');
        });
        
        if (sq==""&&a==""&&b==""&&c==""&&d==""&&ans==""){
            // do nothing
        } else {
            if (sq == "") {alert("题目不能为空");correct = false;}
            if (a == "" || b == "" || c == "" || d =="") {alert("选择题选项不能为空");correct = false;}
            if (ans == "") {alert("选择题答案不能为空");correct = false;}
        }
        
        data_s[i] = {q:sq,img:img,a:a,b:b,c:c,d:d,ans:ans};
    });
    
    if (correct == false) {return false;}
    
    $('#q_b_container').children('.question').each(function(i, data){
        var bq = $(data).find("input[name='bq']").val();
        var img = $(data).find("input[name='img']").val();
        var ba = $(data).find("input[name='ba']").val();
        if (bq==""&&ba==""){
            // do nothing
        } else {
            if (bq=="") {alert("填空题题目不能为空");correct = false;}
            if (ba=="") {alert("填空题答案不能为空");correct = false;}
        }
        data_b[i] = {q:bq,img:img,a:ba};
    });
    if (correct == false) {return false;}
    $('#q_a_container').children('.question').each(function(i, data){
        var aq = $(data).find("input[name='aq']").val();
        var img = $(data).find("input[name='img']").val();
        var aa = $(data).find("textarea[name='aa']").val();
        if (aq==""&&aa==""){
            // do nothing
        } else {
            if (aq=="") {alert("简答题题目不能为空");correct = false;}
            if (aa=="") {alert("简答题答案不能为空");correct = false;}
        }
        data_a[i] = {q:aq,img:img,a:aa};
    });
    if (correct == false) {return false;}
    var data = {s:data_s,b:data_b,a:data_a};
    var jsonData = $.toJSON(data);
    //alert(jsonData);
    
    $.ajax({
        type:'POST',
        url:'ajax_add_question.php',
        data:{'data' : jsonData},
        complete:function(result){
            checkAddStatus(result);
        }
    });
    
    return false;
}

function checkAddStatus(result){
    if(result.status != 200) {
        alert("网络错误，请稍后重试");
        return;
    }
    
    var t = result.responseText.trim();
    if (t == 'S') {
        alert("添加成功");
    } else {
        alert("添加失败，请重试");
    }
}
