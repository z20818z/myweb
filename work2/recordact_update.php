<?php
$db = new mysqli('127.0.0.1','root','admin','mywork');
if ($db->connect_error) {
    die('無法連上資料庫：' . $db->connect_error);
}

$db->set_charset("utf8");
$id = $_GET['id'];
echo '404 Error<br>';
$title  = $_GET['title'];
$startTime  = $db->real_escape_string($_GET['startTime']);
$endTime  = $db->real_escape_string($_GET['endTime']);
$content_2  = $db->real_escape_string($_GET['content_2']);
$sql = "UPDATE `recorddata` SET `title`= $title ,`startTime`= '$startTime' , `endTime`= '$endTime'  WHERE `id` = $id ";
$result = mysqli_query($db,$sql);

if($result){
    header("Location: edittable.php");
}
?>