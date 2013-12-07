var username;
var password;
var repassword;
var role;

function goRegiste(){
    if (!checkRegisterInfo())
        return false;
    $.ajax({
        type:'POST',
        url:'ajax_user_action.php',
        data:{
            'action':'registe',
            'username':username,
            'password':password,
            'role':role
        },
        complete: function(data) {
            checkRegisteStatus(data);
        }
    });
	
    return false;
}

function vUsername(){
    return true;
    username = $('#username').val().trim();
    if (username == ''){
        return false;
    }
    $.ajax({
        type:'POST',
        url:'ajax_user_action.php',
        data:{
            'action':'checkUsername',
            'username':username.trim()
        },
        complete:function(data){
            var result = data.responseText.trim();
            if (result == 'duplicate') {
                alert("用户名已存在");
                $('#username').focus();
                return false;
            }
        }
    });
}

function isEmail(obj) {
    var patrn=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/; 
    return patrn.exec(obj);
}

function checkUsernameLength(){
    username = $('#username').val().trim();
    if(username.length==0) {
        alert("请输入用户名");
        $('#username').focus();
        return false;
    }
    return true;
}

function checkPasswordLength(){
    password = $('#password').val().trim();
    if(password.length>20 || password.length<6) {
        alert("密码长度应在6-20位之间");
        $('#password').focus();
        return false;
    }
    return true;
}

function checkPasswordDiff(){
    repassword = $('#repassword').val().trim();
    if(password.length == 0) {
        alert("请先设置密码");
        $('#password').focus();
        return false;
    }
    if(password != repassword) {
        alert("两次密码输入不一致");
        $('#repassword').focus();
        return false;
    }
	
    return true;
}

function checkEmail(){
    email = $('#email').val().trim();
    if (email == '' || !isEmail(email)){
        alert("请输入正确的邮箱");
        return false;
    }
		
    return true;
}
function checkRegisterInfo(){
    if (!checkUsernameLength())
        return false;
	
    if (!checkPasswordLength())
        return false;
	
    if (!checkPasswordDiff())
        return false;
	
    password = hex_md5(password);
    role = $('#role').val();
    return true;
}

function checkRegisteStatus(data, textStatus){
    if (data.status != 200) {
        alert('网络错误，请重新注册');
        $('#username').focus();
        return;
    }
    var response = data.responseText.trim();
    if (response == "failed") {
        alert('注册失败，请重新注册');
    } else if (response == "duplicate") {
        alert("用户名已存在");
        $('#username').focus();
    } else {
        location.href = 'redirect.php';
    }
}
