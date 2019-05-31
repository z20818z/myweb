<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src = "js/jquery-3.3.1.min.js"></script>
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
    <form action="register_check.php" method="POST" style="margin-left:30%;">
        帳號:<input id="email" type="email" name="account">
        密碼:<input type="password" name="pw">
        <button id="log" type="submit">註冊</button>
    </form>
</body>
</html>