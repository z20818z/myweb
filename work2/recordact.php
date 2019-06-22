<?php
/*
header("X-XSS-Protection: 0");
$db = new mysqli('127.0.0.1','root','admin','mywork');
if ($db->connect_error) {
    die('無法連上資料庫：' . $db->connect_error);
}
$db->set_charset("utf8");
$user = $_GET['user'];
$title  = $_GET['title'];
$startTime  = $_GET['startTime'];
$starthour  = $_GET['starthour'];
$endTime  = $_GET['endTime'];
$endhour  = $_GET['endhour'];
$content_2  = $_GET['content_2'];
$sql = "INSERT INTO recorddata (title, startTime,starthour,endTime,endhour,content_2,user) VALUES ('$title','$startTime','$starthour','$endTime','$endhour','$content_2','$user')";
mysqli_query($db,$sql);
*/
$dbms='mysql';    
$host='localhost'; 
$dbName='mywork';   
$username='root';   
$pass='admin';          
$dsn="$dbms:host=$host;dbname=$dbName";
$user = $_GET['user'];
$title  = $_GET['title'];
$startTime  = $_GET['startTime'];
$starthour  = $_GET['starthour'];
$endTime  = $_GET['endTime'];
$endhour  = $_GET['endhour'];
$content_2  = $_GET['content_2'];
$userID = "";
$rand = md5(uniqid());
try {
    $dbh = new PDO($dsn, $username, $pass); //初始化PDO
    $dbh->exec("set names utf8");
    echo "Successful<br/>";
    /*foreach ($dbh->query('SELECT * from account') as $row) {
        echo($row['account'].'<br>');
    }*/
    $stmt = $dbh->prepare("SELECT * FROM `account` WHERE `userID` = ?");
    $stmt->execute(array($user));
    $row = $stmt->fetch();
    $userID = $row['userID'];
    echo $userID;
    $stmt = $dbh->prepare("INSERT INTO recorddata (title,userID,startTime,starthour,endTime,endhour,dataID,content_2,user) VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->execute(array($title,$userID,$startTime,$starthour,$endTime,$endhour,$rand,$content_2,$row['account']));
    echo '成功輸入<br>';
    print_r(array($title,$userID,$startTime,$starthour,$endTime,$endhour,$rand,$content_2,$row['account']));
    echo "<meta http-equiv=REFRESH CONTENT=1;url=table.php?userID=$user>";
    $dbh = null;
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}

echo '<p><a href="table.php?userID='.$userID.'">返回</a></p>';
?>