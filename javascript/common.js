String.prototype.trim= function(){
    return this.replace(/(^\s*)|(\s*$)/g, "");
}
function logout(){
    $.ajax({
        type:'POST',
        url:'ajax_logout.php',
        complete:function checkLotoutStatus(data, textStatus){
            alert("退出成功，返回首页");
            location.href = 'login.php';
        }
    });
	
    return false;
}