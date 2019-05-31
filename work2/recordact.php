<?php
$db = new mysqli('127.0.0.1','root','admin','mywork');
if ($db->connect_error) {
    die('無法連上資料庫：' . $db->connect_error);
}
$db->set_charset("utf8");/*
$startdate = date_parse($_POST['startTime']);
$enddate = date_parse($_POST['endTime']);*/

$user = $db->real_escape_string($_POST['user']);
$title  = $db->real_escape_string($_POST['title']);
$startTime  = $db->real_escape_string($_POST['startTime']);/*
$startYear = $db->real_escape_string($startdate['year']);
$startMonth = $db->real_escape_string($startdate['month']);
$startDay = $db->real_escape_string($startdate['day']);*/
$endTime  = $db->real_escape_string($_POST['endTime']);/*
$endYear = $db->real_escape_string($enddate['year']);
$endMonth = $db->real_escape_string($enddate['month']);
$endDay = $db->real_escape_string($enddate['day']);*/

$content_2  = $db->real_escape_string($_POST['content_2']);
$sql = "INSERT INTO recorddata (title, startTime,endTime,content_2,user) VALUES ('$title','$startTime','$endTime','$content_2','$user')";
mysqli_query($db,$sql);



echo '<p><a href="table.php?account='.$user.'">返回</a></p>';
?>