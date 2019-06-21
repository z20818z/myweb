<?php 
header("X-XSS-Protection: 0");
/*
$host = "localhost";
$dbuser = 'root';
$dbpw = 'admin';
$db_name = 'mywork';
$user = $_GET['userID'];
$link = mysqli_connect($host,$dbuser,$dbpw,$db_name);
if($link){
    mysqli_query($link, "SET NAMES utf8");
}
else{
    echo '無法連線mysql資料庫 :<br/>' . mysqli_connect_error();
}
function read(){
    global $link,$user;
    $sql = "SELECT * FROM `recorddata` Where `userID` = '{$user}' ORDER BY startTime ASC";
    $result =  mysqli_query($link, $sql);

    if($result){
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr><td>{$row['startTime']}</td><td>{$row['endTime']}</td><td>{$row['title']}</td><td>{$row['content_2']}</td><td><a href='edit.php?id={$row["id"]}&userID={$user}'>修改</a></td><td><a href='delete.php?id={$row["id"]}&userID={$user}'>刪除</a></td></tr>";
            }
        }

        mysqli_free_result($result);
    }
}*/

$dbms='mysql';    
$host='localhost'; 
$dbName='mywork';   
$username='root';   
$pass='admin';          
$dsn="$dbms:host=$host;dbname=$dbName";
$user = $_GET['userID'];
function read(){
    global $link,$user,$dsn,$username,$pass;
    try {
        $dbh = new PDO($dsn, $username, $pass); //初始化PDO
        $dbh->exec("set names utf8");
        //echo "Successful<br/>";
        $stmt = $dbh->prepare("SELECT * FROM `recorddata` Where `userID` = ? ORDER BY startTime ASC");
        if ($stmt->execute(array($user))) {
        while ($row = $stmt->fetch()) {
            echo "<tr><td>{$row['startTime']}</td><td>{$row['endTime']}</td><td>{$row['title']}</td><td>{$row['content_2']}</td><td><a href='edit.php?id={$row["id"]}&userID={$user}'>修改</a></td><td><a href='delete.php?id={$row["id"]}&userID={$user}'>刪除</a></td></tr>";
        }
        }
        $dbh = null;
    } catch (PDOException $e) {
        die ("Error!: " . $e->getMessage() . "<br/>");
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>查看行程</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src = "js/jquery-3.3.1.min.js"></script>
</head>
<body>
<a href="table.php?userID=<?php echo $user;?>">返回</a>
    <table class="table text-center table-striped table-bordered table-condensed" id="contentTable">
        <thead>
            <tr>
            <th>開始日</th><th>結束日</th><th>任務標題</th><th>任務內容</th><th>修改</th><th>刪除</th>
            </tr>
        </thead>
        <tbody>
        <?php read();?>
        </tbody>
        <tbody>
        </tbody>
    </table>
</body>
</html>