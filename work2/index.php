<?php
    session_start();
    $logout = @$_GET['logout'];
    if($logout == 1){
        unset($_SESSION['account']);
        unset($_SESSION['pw']);
    }
    if(isset($_SESSION['account']) && $_SESSION['pw']){
        header("Location:table.php?account={$_SESSION['account']}"); 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src = "js/jquery-3.3.1.min.js"></script>
    <style>
        form{
            margin-left:30%;
            position: fixed; 
            }
        button{
            margin-left:65%;
        }
    </style>
    <script>
    $(document).ready(function(){
    $("#email").blur(function(){
        if(isemail($("#email").val())==false){
            alert('請輸入正確EMAIL格式');
            $("#log").hide();
        }else{
            $("#log").show();
        }
    });
    });
    function isemail(email) { 
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)){
        return false;
    }else{
        return true;
    }}
    </script>
    
<script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>
</head>

<body>
<script>
window.fbAsyncInit = function() {
FB.init({
    appId      : '621094128375188',
      cookie     : true,
      xfbml      : true,
      version    : 'v3.3'
});

FB.getLoginStatus(function(response) {
statusChangeCallback(response);
});
};

// 處理各種登入身份
function statusChangeCallback(response) {
console.log(response);

// 登入 FB 且已加入會員
if (response.status === 'connected') {
console.log("已登入 FB，並加入 WFU BLOG DEMO 應用程式");

FB.api('/me?fields=id,name,email', function(response) {
console.log(response);
console.log("會員暱稱：" + response.name);
console.log("會員 email：" + response.email);
//window.location.href="login_check.php?account="
});
}

// 登入 FB, 未偵測到加入會員
else if (response.status === "not_authorized") {
console.log("已登入 FB，但未加入 WFU BLOG DEMO 應用程式");
}

// 未登入 FB
else {
console.log("未登入 FB");
}
}

function checkLoginState() {
FB.getLoginStatus(function(response) {
statusChangeCallback(response);
});
}

// 載入 FB SDK
(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s);
js.id = id;
js.src = "https://connect.facebook.net/zh_TW/sdk.js";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<div>
    <form id="login" action="login_check.php" method="POST" >
        帳號:<input type="email" name="account" id="email">
        密碼:<input type="password" name="pw">
        <input type="checkbox" name="remember">記住我
        <input id="log" type="submit" value="登入">
    </form>
    <button onclick="location.href=('register.php')">註冊會員</button>
    <fb:login-button scope="public_profile,email" autologoutlink="true" onlogin="checkLoginState();"></fb:login-button>
</div>
</body>
</html>