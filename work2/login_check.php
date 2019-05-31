<?php
session_start();
$host = "localhost";
$dbuser = 'root';
$dbpw = 'admin';
$db_name = 'mywork';
$remember = @$_POST['remember'];
$account = $_POST['account'];
$pw = $_POST['pw'];
echo $remember;
$link = mysqli_connect($host,$dbuser,$dbpw,$db_name);
$sql = "SELECT * FROM account where account = '$account'";
$result = mysqli_query($link, $sql);
$row = @mysqli_fetch_row($result);
$hash = $row[1];
$reg="/^(\w @\w (\.)com|net|cn)$/"; 
if(!preg_match($reg,$account)){ 
        echo "郵箱必須含有@，且以com結尾";header("refresh:2;url=register.php"); die; 
}
if($account != null && $pw != null && $row[0] == $account && password_verify($pw, $hash))
{
        //將帳號寫入session，方便驗證使用者身份
        if(isset($remember)){
                $_SESSION['account'] = $account;
                $_SESSION['pw'] = $pw;
        }
        echo '登入成功!';
        echo "<meta http-equiv=REFRESH CONTENT=1;url=table.php?account=$account>";
}else{
        echo '登入失敗';
        echo "<meta http-equiv=REFRESH CONTENT=1;url=index.php";
}
echo $account.$pw;
?>
