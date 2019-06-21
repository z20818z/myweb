<?php
session_start();
header("X-XSS-Protection: 0");
$db = new mysqli('127.0.0.1','root','admin','mywork');
/*$host = "localhost";
$dbuser = 'root';
$dbpw = 'admin';
$db_name = 'mywork';
*/
$id = $db->real_escape_string($_GET['id']);
$email = $db->real_escape_string($_GET['email']);

//$link = mysqli_connect($host,$dbuser,$dbpw,$db_name);
$sql = "SELECT * FROM fbaccount where id = '$id'";
$result = mysqli_query($db, $sql);
if(!$result){
    $sql = "INSERT INTO account (id,email) VALUES ('$account','$hash')";
}

echo $id.$email;
?>
