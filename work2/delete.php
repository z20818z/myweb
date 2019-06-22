<?php
session_start();
if(@!$_SESSION['login']){
    header("Location: index.php");
}
$dbms='mysql';    
$host='localhost'; 
$dbName='mywork';   
$username='root';   
$pass='admin';          
$dsn="$dbms:host=$host;dbname=$dbName";
$id = $_GET['id'];
$user = $_GET['userID'];
try {
    $dbh = new PDO($dsn, $username, $pass); //初始化PDO
    $dbh->exec("set names utf8");
    echo "Successful<br/>";
    $stmt = $dbh->prepare("DELETE FROM `recorddata` WHERE `id` = ? ");
    $stmt->execute(array($id));
    header("Location: edittable.php?userID=".$user);
    $dbh = null;
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}
?>