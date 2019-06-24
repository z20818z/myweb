<?php
/*
header("X-XSS-Protection: 0");
$db = new mysqli('127.0.0.1','root','admin','mywork');
if ($db->connect_error) {
    die('無法連上資料庫：' . $db->connect_error);
}
$db->set_charset("utf8");
$user = $_POST['user'];
$title  = $_POST['title'];
$startTime  = $_POST['startTime'];
$starthour  = $_POST['starthour'];
$endTime  = $_POST['endTime'];
$endhour  = $_POST['endhour'];
$content_2  = $_POST['content_2'];
$sql = "INSERT INTO recorddata (title, startTime,starthour,endTime,endhour,content_2,user) VALUES ('$title','$startTime','$starthour','$endTime','$endhour','$content_2','$user')";
mysqli_query($db,$sql);
*/
$dbms='mysql';    
$host='localhost'; 
$dbName='mywork';   
$username='root';   
$pass='admin';          
$dsn="$dbms:host=$host;dbname=$dbName";
$user = $_POST['user'];
$title  = $_POST['title'];
$startTime  = $_POST['startTime'];
$starthour  = $_POST['starthour'];
$endTime  = $_POST['endTime'];
$endhour  = $_POST['endhour'];
$content_2  = $_POST['content_2'];
$rand = md5(uniqid());
print_r($_FILES);
if ((($_FILES["file"]["type"] == "image/gif")
            || ($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/jpg")
            || ($_FILES["file"]["type"] == "image/png"))
            && ($_FILES["file"]["size"] < 200000)) {
            if ($_FILES["file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
            } else {
                echo "檔名: " . $_FILES["file"]["name"] . "<br />";
                echo "檔案型別: " . $_FILES["file"]["type"] . "<br />";
                echo "檔案大小: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
                echo "快取檔案: " . $_FILES["file"]["tmp_name"] . "<br />";

            //設定檔案上傳路徑，選擇指定資料夾

                if (file_exists("upload/" . $_FILES["file"]["name"])) {
                    echo $_FILES["file"]["name"] . " already exists. ";
                } else {
                    move_uploaded_file(
                        $_FILES["file"]["tmp_name"],
                        "upload/" . $_FILES["file"]["name"]
                    );
                    echo "儲存於: " . "upload/" . $_FILES["file"]["name"];//上傳成功後提示上傳資訊
                }
            }
        } else {
            echo "上傳失敗！";//上傳失敗後顯示錯誤資訊
        }
    $file_place = "upload/" . $_FILES["file"]["name"];
try {
    $dbh = new PDO($dsn, $username, $pass); //初始化PDO
    $dbh->exec("set names utf8");
    echo "Successful<br/>";
    $stmt = $dbh->prepare("SELECT * FROM `account` WHERE `userID` = ?");
    $stmt->execute(array($user));
    $row = $stmt->fetch();
    if($row == null){
        echo"FBBBB";
        echo $user;
        $stmt = $dbh->prepare("SELECT * FROM `fbaccount` WHERE `userID` = ?");
        $stmt->execute(array($user));
        $row = $stmt->fetch();
    }
    print_r($row);
    $stmt = $dbh->prepare("INSERT INTO recorddata (title,userID,startTime,starthour,endTime,endhour,dataID,content_2,user,filepath) VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->execute(array($title,$user,$startTime,$starthour,$endTime,$endhour,$rand,$content_2,$row['account'],$file_place));
    echo '成功輸入<br>';
    print_r(array($title,$user,$startTime,$starthour,$endTime,$endhour,$rand,$content_2,$row['account'],$file_place));
    echo "<meta http-equiv=REFRESH CONTENT=1;url=table.php?userID=$user>";
    $dbh = null;
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}

echo '<p><a href="table.php?userID='.$user.'">返回</a></p>';
echo '<img src="'.$file_place.'">'
?>