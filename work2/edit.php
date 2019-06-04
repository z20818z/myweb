<?php 
date_default_timezone_set("Asia/Taipei");
header("X-XSS-Protection: 0");
$host = "localhost";
$dbuser = 'root';
$dbpw = 'admin';
$db_name = 'mywork';
$id = $_GET['id'];
$user = $_GET['user'];
echo $id;
$link = mysqli_connect($host,$dbuser,$dbpw,$db_name);

if($link){
    mysqli_query($link, "SET NAMES utf8");
    //echo "已正確連線\n";
    //echo $printdata;
}
else{
    echo '無法連線mysql資料庫 :<br/>' . mysqli_connect_error();
}
$sql = "SELECT * FROM `recorddata` WHERE `id` = $id";
$result =  mysqli_query($link, $sql);

if($result){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            $startTime = $row['startTime'];
            $endTime = $row['endTime'];
            $title = $row['title'];
            $content_2 = $row['content_2'];
        }
    }

    mysqli_free_result($result);
}

echo $endTime;
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
    <script type="text/javascript" src = "js/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src = "js/jquery-3.3.1.min.js"></script>
    <script>
    $(document).ready(function(){
    $("#email").blur(function(){
        if(isemail($("#email").val())==false){
            alert('請輸入正確EMAIL格式');
            $(".log").hide();
        }else{
            $(".log").show();
        }
    });
    });
    function isemail(email) { 
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)) {
        return false;
    }else{
        return true;
    }}
    </script>
</head>
<body>
<form action="recordact_update.php" method="GET">
            <input type="text" name="id" style="display:none;" value="<?php echo $id;?>"></div>
            <input type="text" name="user" style="display:none;" value="<?php echo $user;?>"></div>
            <div>任務添加:
            <input id="title" name="title"  style=" border:1px; border-bottom-style: solid;border-top-style: none;border-left-style:none;border-right-style:none;"></div>
            
            <div>起始時間: <input id="start" type="date" name="startTime" value="<?php echo $startTime;?>">
                <!--<select id="starthr" name="startTimehr"></select><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option>
            <option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option>
            <option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option>
            <option>20</option><option>21</option><option>22</option><option>23</option></select>點--></div>   
            <div>結束時間:<input id="end" type="date" name="endTime" value="<?php echo $endTime; ?>"><!-- <select id="endhr" name="endTimehr"></select><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option>
            <option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option>
            <option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option>
            <option>20</option><option>21</option><option>22</option><option>23</option></select>點--></div>  
            <div>通知:<input id="call-num" type="number" name="call-num"></div><select name="call-time" id="call-time"><option>分</option><option>小時</option><option>日</option></select>
            <textarea name="content_2" id="content_2" rows="10" cols="80" ><?php echo $content_2;?></textarea>
            <script>
                CKEDITOR.replace( "content_2", {});
                width:500;
            </script>
            <div>邀請對象</div>
            <input id="email" placeholder="新增邀請對象" name="invite">
            <input class="log" id="submit" type="submit" name="senddata" value="送出" onclick="sendmail()">
        </form>
        <iframe id="id_iframe" name="id_iframe" style="display:none"></iframe>
</body>
<script>
//送信
function sendmail(){  
    console.log($('#call-time').val());
    interval = 0;
    second = parseInt($('#call-num').val());
    
    switch($('#call-time').val()){
        case "分":
            interval = second * 60;
            break;
        case "小時":
            interval = second * 60 * 60;
            break;
        case "日":
            interval = second * 60 * 60 * 24;
            break;
        default:
            console.log($('#call-time').val());
            break;
    }
    $.ajax({
        type:'GET',
        url: "datefunction.php", 
        data:{'interval':interval ,'title':$('#title').val()},
        dataType:'html',
        success: function(data){
            console.log(data);}
        });
    
}
</script>
</html>