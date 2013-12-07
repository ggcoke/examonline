var username;
var password;
function goLogin(){
    if (!checkLoginInfo()){
        return false;
    }
	
    $.ajax({
        type: "POST",
        url: "ajax_login.php",
        data:{
            'username' : username, 
            'password' : password
        },
        complete: function(data) {
            checkLoginStatus(data);
        } 
    });
	
    return false;
}

function checkLoginInfo(){
    username = $('#username').val();
    password = $('#password').val();
	
    if (username == "" || username == "username") {
        alert("请输入用户名");
        $('#username').focus();
        return false;
    }
	
    if (password == "") {
        alert('请输入密码');
        $('#password').focus();
        return false;
    }
	
    password = hex_md5(password);
    return true;
}


function checkLoginStatus(data){
    if (data.status != 200) {
        alert('网络错误，请重新登录');
        $('#username').focus();
        return;
    }
    var response = data.responseText.trim();
    if (response == "LOGIN_FAILED") {
        alert('用户名或密码错误，请重新登录');
    } else {
        location.href = 'redirect.php';
    }
}