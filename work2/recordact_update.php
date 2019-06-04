<?php
header("X-XSS-Protection: 0");
$db = new mysqli('127.0.0.1','root','admin','mywork');
if ($db->connect_error) {
    die('無法連上資料庫：' . $db->connect_error);
}
$invite = $_GET['invite'];
$db->set_charset("utf8");
$id = $_GET['id'];
$user = $_GET['user'];
echo '404 Error<br>';
$title  = $db->real_escape_string($_GET['title']);
$startTime  = $db->real_escape_string($_GET['startTime']);
$endTime  = $db->real_escape_string($_GET['endTime']);
$content_2  = $db->real_escape_string($_GET['content_2']);
$sql_account = "SELECT * FROM account where account = '$user'";
$result_account = mysqli_query($db, $sql_account);
$row = @mysqli_fetch_row($result_account);
if($row){
    $sql_add = "INSERT INTO recorddata (title, startTime,endTime,user,content_1) VALUES ('$title','$startTime','$endTime','$id','$invite')";//加入檢索 另外建立一個資料夾搜索
    mysqli_query($db,$sql_add);
}else{
    include('../mail.php');
    sendmail($user."邀請你參加".$title);
}
$sql = "UPDATE `recorddata` SET `title`= '$title' ,`startTime`= '$startTime' , `endTime`= '$endTime',`user` = '$user'  WHERE `id` = $id ";
$result = mysqli_query($db,$sql);

if($result)
{
    header("Location: edittable.php?account=".$user);
}else{
    echo 'failed';
}
?>