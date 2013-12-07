
$(function() {
    $('#sname').inputLabel("空表示搜索所有",{
        color:"#999999"
    });
});

function searchUser() {
    var username = $('#sname').val();
    var role = $('#srole').val();
    $.ajax({
        type:'GET',
        url:'ajax_user_action.php',
        data:{
            'action':'search',
            'username':username,
            'role':role
        },
        complete: function(data) {
            if (data.status != 200) {
                alert("网络错误，请重试");
                return;
            }
    
            var response = data.responseText.trim();
            $("#result_content").empty();
            $('#result_content').append(response);
        }
    });
}

function updateUserInfo(uid) {
    var role = $('#value_role').val();
    var sid = $('#sid').val();
    var workunit = $('#workunit').val();
    var degree = $('#degree').val();
    $.ajax({
        type:'POST',
        url:'ajax_user_action.php',
        data:{
            'action':'update',
            'uid':uid,
            'role':role,
            'sid':sid,
            'workunit':workunit,
            'degree':degree
        },
        complete: function(data) {
            if (data.status != 200) {
                alert("网络错误，请重试");
                return;
            }
            var response = data.responseText.trim();
            if (response == 'success') {
                alert('更新成功');
                location.href = 'manager.php';
            } else {
                alert('更新失败，请重试');
            }
        }
    });
}
