<?php
header("X-XSS-Protection: 0");
/*$db = new mysqli('127.0.0.1','root','admin','mywork');
$host = "localhost";
$dbuser = 'root';
$dbpw = 'admin';
$db_name = 'mywork';

$account = $db->real_escape_string($_POST['account']);
$account = htmlspecialchars($account,ENT_NOQUOTES);
$pw = $db->real_escape_string($_POST['pw']);
$pw = htmlspecialchars($pw,ENT_NOQUOTES);
$hash = password_hash($pw, PASSWORD_DEFAULT);
//$link = mysqli_connect($host,$dbuser,$dbpw,$db_name);
$sql = "SELECT * FROM account where account = '$account'";
$result = mysqli_query($db, $sql);
$row = @mysqli_fetch_row($result);
$exit = false;
//echo password_verify($pw, $reg="/^(\w @\w (\.)com|net|cn)$/"; 
*/
//ACCOUNT驗證
$dbms='mysql';    
$host='localhost'; 
$dbName='mywork';   
$user='root';   
$pass='admin';          
$dsn="$dbms:host=$host;dbname=$dbName";

if (!filter_var($_POST['account'],FILTER_VALIDATE_EMAIL)){ 
        echo "郵箱必須含有@，且以com結尾";header("refresh:2;url=register.php"); die; 
}

$account = $_POST['account'];
$pw = $_POST['pw'];
$hash = password_hash($pw, PASSWORD_DEFAULT);
if($account == null || $pw == null){
        echo '請仔細填寫資料';
        echo '<meta http-equiv=REFRESH CONTENT=3;url=register.php>';
        echo die;
}
$rand = md5(uniqid());
try {
        $dbh = new PDO($dsn, $user, $pass); //初始化PDO
        echo "Register Successful<br/>";
        /*foreach ($dbh->query('SELECT * from account') as $row) {
            echo($row['account'].'<br>');
        }*/
        $stmt = $dbh->prepare("SELECT * FROM account Where `account`=?");
        if($stmt->execute(array($account))){
                $row = $stmt->fetch();
        }
        if($row[0]==null){
                echo '成功註冊';
                $stmt = $dbh->prepare("INSERT INTO account (userID,account, pw) VALUES (?,?, ?)");
                $stmt->bindParam(1, $rand);
                $stmt->bindParam(2, $account);
                $stmt->bindParam(3, $hash);
                $stmt->execute();
                echo '<meta http-equiv=REFRESH CONTENT=3;url=index.php>';
        }else{
                echo '帳號已存在';
                echo '<meta http-equiv=REFRESH CONTENT=3;url=index.php>';
        }
        
        
        $dbh = null;
    } catch (PDOException $e) {
        die ("Error!: " . $e->getMessage() . "<br/>");
    }

?>

