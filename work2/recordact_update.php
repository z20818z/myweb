<?php
header("X-XSS-Protection: 0");
$db = new mysqli('127.0.0.1','root','admin','mywork');
if ($db->connect_error) {
    die('無法連上資料庫：' . $db->connect_error);
}
$invite = @$_GET['invite'];
$db->set_charset("utf8");
$id = $_GET['id'];
$userID = $_GET['user'];
$title  = $db->real_escape_string($_GET['title']);
$startTime  = $db->real_escape_string($_GET['startTime']);
$endTime  = $db->real_escape_string($_GET['endTime']);
$content_2  = $db->real_escape_string($_GET['content_2']);
$sql_account = "SELECT * FROM account where account = '$invite'";
$result_account = mysqli_query($db, $sql_account);
$row = @mysqli_fetch_row($result_account);
if($row){
    $rowuserID = $row['userID'];
    $sql_add = "INSERT INTO recorddata (title, startTime,endTime,userID,user) VALUES ('$title','$startTime','$endTime','$rowuserID','$invite')";
    mysqli_query($db,$sql_add);
}else if(!isset($row) && isset($invite)){
    include('../mail.php');
    sendmail($user."invite you to join".$title."  here is the url:localhost/work2");
}
$sql = "UPDATE `recorddata` SET `title`= '$title' ,`startTime`= '$startTime' , `endTime`= '$endTime',`userID` = '$userID',`content_2` = '$content_2'  WHERE `id` = $id ";
$result = mysqli_query($db,$sql);

if($result)
{
    header("Location: edittable.php?userID=".$userID);
}else{
    echo 'failed';
}
?>