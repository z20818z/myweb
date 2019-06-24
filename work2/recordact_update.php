<?php
/*
header("X-XSS-Protection: 0");
$db = new mysqli('127.0.0.1','root','admin','mywork');
if ($db->connect_error) {
    die('無法連上資料庫：' . $db->connect_error);
}

$invite = $_POST['invite'];
$db->set_charset("utf8");
$id = $_POST['id'];
$userID = $_POST['user'];
$title  = $db->real_escape_string($_POST['title']);
$startTime  = $db->real_escape_string($_POST['startTime']);
$endTime  = $db->real_escape_string($_POST['endTime']);
$content_2  = $db->real_escape_string($_POST['content_2']);
$starthour  = $db->real_escape_string($_POST['starthour']);
$endhour  = $db->real_escape_string($_POST['endhour']);
$sql_account = "SELECT * FROM account where account = '$invite'";
$result_account = mysqli_query($db, $sql_account);
$row = @mysqli_fetch_row($result_account);
if($row){
    $rowuserID = $row[0];
    $sql_add = "INSERT INTO recorddata (title, startTime,starthour,endTime,endhour,userID,user) VALUES ('$title','$startTime','$starthour','$endTime','$endhour','$rowuserID','$invite')";
    mysqli_query($db,$sql_add);
}else if(!isset($row) && ($invite!=null)){
    include('../mail.php');
    invite("invite you to join".$title."  <a href='localhost/work2'>localhost/work2</a>",$invite);
}
$sql = "UPDATE `recorddata` SET `title`= '$title' ,`startTime`= '$startTime' , `endTime`= '$endTime',`userID` = '$userID',`content_2` = '$content_2'  WHERE `id` = $id ";
$result = mysqli_query($db,$sql);

if($result)
{
    header("Location: edittable.php?userID=".$userID);
}else{
    echo 'failed';
}*/

$dbms='mysql';    
$host='localhost'; 
$dbName='mywork';   
$username='root';   
$pass='admin';          
$dsn="$dbms:host=$host;dbname=$dbName";
$id = $_POST['id'];
$userID = $_POST['user'];
$title  = $_POST['title'];
$startTime  = $_POST['startTime'];
$starthour  = $_POST['starthour'];
$endTime  = $_POST['endTime'];
$endhour  = $_POST['endhour'];
$content_2  = $_POST['content_2'];
$dataID = $_POST['dataID'];
$invite = $_POST['invite'];
echo $content_2;
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
    /*foreach ($dbh->query('SELECT * from account') as $row) {
        echo($row['account'].'<br>');
    }*/
    $stmt = $dbh->prepare("SELECT * FROM `account` WHERE `account` = ?");
    $stmt->execute(array($invite));
    $row = $stmt->fetch();
    $rowuserID = $row[0];
    if($row){
        $invite_name=$row['account'];
        $stmt = $dbh->prepare("SELECT * FROM `recorddata` WHERE `user` = ? AND `dataID` = ?");
        $stmt->execute(array($invite_name,$dataID));
        $invite_user_exist = $stmt->fetch();
        if($invite_user_exist){
            echo '此人已經有此行程若是您有修改將一起更新';
        }else{
            $stmt = $dbh->prepare("INSERT INTO `recorddata` (title, startTime,starthour,endTime,endhour,userID,user,content_2,dataID,filepath) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $stmt -> execute(array($title,$startTime,$starthour,$endTime,$endhour,$rowuserID,$invite,$content_2,$dataID,$file_place));
            echo '新加入資料了';
        }
        
    }else{
        echo '此人還沒加入';
        include('../mail.php');
        invite("invite you to join".$title."  <a href='localhost/work2'>localhost/work2</a>",$invite);
    }
    $stmt = $dbh->prepare("UPDATE `recorddata` SET `title`= ? ,`startTime`= ?,`starthour`=? ,`endtime`=? ,`endhour`=?,`content_2`=?,`filepath`=? WHERE `dataID` = ?");
    $stmt->execute(array($title,$startTime,$starthour,$endTime,$endhour,$content_2,$file_place,$dataID));
    //echo "<meta http-equiv=REFRESH CONTENT=1;url=table.php?userID=$user>";
    header("Location: edittable.php?userID=".$userID);
    $dbh = null;
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}
?>