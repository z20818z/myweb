<?php
session_start();
header("X-XSS-Protection: 0");/*
$db = new mysqli('127.0.0.1','root','admin','mywork');
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
                //$_SESSION['account'] = $account;
                //$_SESSION['pw'] = $pw;
                $_SESSION['remember'] = true;
                setcookie('account',$account,time()+3600*24*365);
                setcookie('pw',$account,time()+3600*24*365);
        }
        echo '登入成功!';
        echo "<meta http-equiv=REFRESH CONTENT=1;url=table.php?account=$account>";
}else{
        echo '登入失敗';
        echo "<meta http-equiv=REFRESH CONTENT=1;url=index.php";
}
echo $account.$pw;*/
$dbms='mysql';    
$host='localhost'; 
$dbName='mywork';   
$user='root';   
$pass='admin';          
$dsn="$dbms:host=$host;dbname=$dbName";
$remember = @$_POST['remember'];
$account = $_POST['account'];
$pw = $_POST['pw'];
if (!filter_var($_POST['account'],FILTER_VALIDATE_EMAIL)){ 
        echo "郵箱必須含有@，且以com結尾";header("refresh:2;url=register.php"); die; 
}
try {
    $dbh = new PDO($dsn, $user, $pass); //初始化PDO
    echo "Successful<br/>";
    /*foreach ($dbh->query('SELECT * from account') as $row) {
        echo($row['account'].'<br>');
    }*/
    if($account != null && $pw != null){
        $stmt = $dbh->prepare("SELECT * FROM account Where `account`=?");
        if($stmt->execute(array($account))) {
                $row = $stmt->fetch();
                $hash = $row[2];
                if($row[1] == $account && password_verify($pw, $hash)){
                        echo '登入成功! 即將跳轉至主頁面';
                        if(isset($remember)){
                                //$_SESSION['account'] = $account;
                                //$_SESSION['pw'] = $pw;
                                $_SESSION['remember'] = true;
                                
                                setcookie('account',$account,time()+3600*24*365);
                                setcookie('pw',$account,time()+3600*24*365);
                        }
                        $_SESSION['login'] = true;
                        echo "<meta http-equiv=REFRESH CONTENT=1;url=table.php?userID=$row[0]>";
                }else{
                        echo '2sec登入失敗';
                        echo "<meta http-equiv=REFRESH CONTENT=1;url=index.php";
                }
        }else{
                echo '1st登入失敗';
                echo "<meta http-equiv=REFRESH CONTENT=1;url=index.php";
        }
    }
    
    $dbh = null;
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}
?>
