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
    if(!regex.test(email)) {
        return false;
    }else{
        return true;
    }}
    </script>
</head>

<body>

    <form id="login" action="login_check.php" method="POST" >
        帳號:<input type="email" name="account" id="email">
        密碼:<input type="password" name="pw">
        <input type="checkbox" name="remember">記住我
        <input id="log" type="submit" value="登入">
    </form>
    <button onclick="location.href=('register.php')">註冊會員</button>

</body>
</html>