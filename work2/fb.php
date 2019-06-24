<?php
header("X-XSS-Protection: 0");
session_start();
$dbms='mysql';    
$host='localhost'; 
$dbName='mywork';   
$user='root';   
$pass='admin';          
$dsn="$dbms:host=$host;dbname=$dbName";

$fbID = $_GET['fbID'];
$account = $_GET['account'];
$rand = md5(uniqid());
try {
        $dbh = new PDO($dsn, $user, $pass); //初始化PDO
        
        $stmt = $dbh->prepare("SELECT * FROM fbaccount WHERE `account`=?");
        $stmt->execute(array($account));
        $row = $stmt->fetch();
        if($row[0]==null){
                echo '成功註冊';
                $stmt = $dbh->prepare("INSERT INTO fbaccount (userID,fbID,account) VALUES (?,?,?)");
                $stmt->bindParam(1, $rand);
                $stmt->bindParam(2, $fbID);
                $stmt->bindParam(3, $account);
                $stmt->execute();
                $_SESSION['login'] = true;
                echo '<meta http-equiv=REFRESH CONTENT=3;url=table.php?userID='.$rand.'>';
        }else{
            $stmt = $dbh->prepare("SELECT * FROM fbaccount WHERE `account`=?");
            $stmt->execute(array($account));
            $row = $stmt->fetch();
                echo '帳號已存在';
                $_SESSION['login'] = true;
                header("Location: table.php?userID=".$row['userID']);
        }
        
        
        $dbh = null;
    } catch (PDOException $e) {
        die ("Error!: " . $e->getMessage() . "<br/>");
    }

?>

