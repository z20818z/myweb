<?php 
header("X-XSS-Protection: 0");
$db = new mysqli('127.0.0.1','root','admin','mywork');
$printdata = $db->real_escape_string($_GET['date']);
$user = $db->real_escape_string($_GET['user']);
$datas = array();
if($db){
    mysqli_query($db, "SET NAMES utf8");

}
else{
    echo '無法連線mysql資料庫 :<br/>' . mysqli_connect_error();
}
$sql = "SELECT * FROM `recorddata` Where `startTime` = '{$printdata}'";
$result =  mysqli_query($db, $sql);

if($result){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            if($row['userID'] == $user){//new
                $datas[] = $row;
                $enddate = date_parse($row['endTime']);
                print_r ($row['title'].'(~'.$enddate['month'].'/'.$enddate['day'].')');
                echo '<br>';
            }
            
        }
    }

    mysqli_free_result($result);
}
?>