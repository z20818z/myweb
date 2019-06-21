<?php 
header("X-XSS-Protection: 0");
/*
$host = "localhost";
$dbuser = 'root';
$dbpw = 'admin';
$db_name = 'mywork';
*/
$db = new mysqli('127.0.0.1','root','admin','mywork');
$printdata = $_GET['date'];
$user = $_GET['user'];
$time = $_GET['time'];

//$user = htmlspecialchars($user,ENT_NOQUOTES); //new
//$link = mysqli_connect($host,$dbuser,$dbpw,$db_name);
$datas = array();
if($db){
    mysqli_query($db, "SET NAMES utf8");
    //echo "已正確連線\n";
    //echo $printdata;
}
else{
    echo '無法連線mysql資料庫 :<br/>' . mysqli_connect_error();
}
$sql = "SELECT * FROM `recorddata` Where `startTime` = '{$printdata}' AND `starthour` = '{$time}'";
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