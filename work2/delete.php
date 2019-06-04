<?php
$db = new mysqli('127.0.0.1','root','admin','mywork');
if ($db->connect_error) {
    die('無法連上資料庫：' . $db->connect_error);
}

$db->set_charset("utf8");
$id = $_GET['id'];
$user = $_GET['user'];
echo $id;
$sql = "DELETE FROM `recorddata` WHERE `id` = $id ";
$result = mysqli_query($db,$sql);
if($result){
    header("Location: edittable.php?account=".$user);
}
?>