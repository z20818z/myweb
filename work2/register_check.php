<?php
header("X-XSS-Protection: 0");
$db = new mysqli('127.0.0.1','root','admin','mywork');
/*$host = "localhost";
$dbuser = 'root';
$dbpw = 'admin';
$db_name = 'mywork';*/

$account = $db->real_escape_string($_POST['account']);
$account = htmlspecialchars($account,ENT_NOQUOTES);
$pw = $db->real_escape_string($_POST['pw']);
$pw = htmlspecialchars($pw,ENT_NOQUOTES);
$hash = password_hash($pw, PASSWORD_DEFAULT);;
//$link = mysqli_connect($host,$dbuser,$dbpw,$db_name);
$sql = "SELECT * FROM account where account = '$account'";
$result = mysqli_query($db, $sql);
$row = @mysqli_fetch_row($result);
$exit = false;
//echo password_verify($pw, $reg="/^(\w @\w (\.)com|net|cn)$/"; 

if (!filter_var($account,FILTER_VALIDATE_EMAIL)){ 
        echo "郵箱必須含有@，且以com結尾";header("refresh:2;url=register.php"); die; 
}//ACCOUNT驗證
if($row[0]!=null){
        $exit = true;
        /*echo'重複';
        print_r ($row[0]);
        echo password_verify($pw, $hash);*/
}
if($account != null && $pw != null && $exit == false)
{
        $sql = "INSERT INTO account (account,pw) VALUES ('$account','$hash')";
        mysqli_query($link, $sql);
        //將帳號寫入session，方便驗證使用者身份
        //$_SESSION['username'] = $id;
        echo '註冊成功!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
}else{
        echo '註冊失敗 請重新填答';
        echo '<meta http-equiv=REFRESH CONTENT=3;url=index.php>';
}
