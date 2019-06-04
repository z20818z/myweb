<?php
session_start();
header("X-XSS-Protection: 0");
$db = new mysqli('127.0.0.1','root','admin','mywork');
/*$host = "localhost";
$dbuser = 'root';
$dbpw = 'admin';
$db_name = 'mywork';
*/
$remember = @$db->real_escape_string($_POST['remember']);
$account = $db->real_escape_string($_POST['account']);
$account = htmlspecialchars($account,ENT_NOQUOTES);
$pw = $db->real_escape_string($_POST['pw']);
$pw = htmlspecialchars($pw,ENT_NOQUOTES);
echo $remember.'<br>';
echo $account;
//$link = mysqli_connect($host,$dbuser,$dbpw,$db_name);
$sql = "SELECT * FROM account where account = '$account'";
$result = mysqli_query($db, $sql);
$row = @mysqli_fetch_row($result);
$hash = $row[1];

if (!filter_var($account,FILTER_VALIDATE_EMAIL)){ 
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
