<?php
$user = @$_GET['userID'];
session_start();
if(@!$_SESSION['login']){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Work</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/calender.js"></script>
    <script type="text/javascript" src = "js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src = "js/calender_upload.js"></script>
    <script type="text/javascript" src = "js/ckeditor/ckeditor.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style type="text/css">
	#contentTable{
		table-layout:fixed; /* bootstrap-table設定colmuns中某列的寬度無效時，需要給整個表設定css屬性 */
		word-break:break-all; word-wrap:break-all; /* 自動換行 */
	}
</style>
</head>
<body>
<?php   echo '<div><button  type="button" onclick=location.href="edittable.php?userID='.$user.'">查看行程</button>';
        echo '<button  type="button" onclick="recordAct()">新增</button>'; 
        echo '<button  type="button" onclick=location.href="index.php?logout=1">登出</button>'
        ?>
<div class="container-fluid">
  <div class="row">
        <div class="col-sm-4">
            <table class="table text-center" id="tb1">
            <thead >
                <tr>
                <th id="y" colspan="7" class="text-center"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>一</td><td>二</td><td>三</td><td>四</td><td>五</td><td>六</td><td>日</td>
                </tr>
            </tbody>
            </table>
        </div>
        <div class="col-sm-8">
            <table class="table text-center table-striped table-bordered table-condensed" class="tb2" id="contentTable">
                <thead >
                    <tr>
                    <th>time</th><th>一</th><th>二</th><th>三</th><th>四</th><th>五</th><th>六</th><th>日</th>
                    </tr>
                    <tr>
                    <td></td><td id="day1">1</td><td id="day2">2</td><td id="day3">3</td><td id="day4">4</td><td id="day5">5</td><td id="day6">6</td><td id="day7">7</td>
                    </tr>
                </thead>
                <tbody id="schedule">
                    <script>
                        var user = '<?php echo $user; ?>';
                        createTable();
                        if(thisDay==0){
                            thisDay=7;
                        }
                        changeWeek(thisDate,thisDay);
                    </script>
                    
                </tbody>
            </table>
        </div>
    </div>
    <div class="back" id="back"></div>
<!--FORM-->

    <div class="dialog" id="dialogBox">
        <form action="recordact.php" method="GET">
        <input type="text" name="user" style="display:none;" value="<?php echo $user;?>">
        <div>
            <span>任務添加</span><input name="title" placeholder="新增標題"  style=" border:1px; border-bottom-style: solid;border-top-style: none;border-left-style:none;border-right-style:none;">
            <span class="close" style="border-bottom: 1px solid #eee;">X</span>
        </div> 
            <br>
            <div>起始時間: <input id="start" type="date" name="startTime"><select id="starthr" name="starthour">
                <option>0</option><option value="0">1</option><option>2</option><option>3</option><option>4</option>
            <option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option>
            <option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option>
            <option>20</option><option>21</option><option>22</option><option>23</option></select>點</div>   
            <div>結束時間:<input id="end" type="date" name="endTime"><select id="endhr" name="endhour"><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option>
            <option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option>
            <option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option>
            <option>20</option><option>21</option><option>22</option><option>23</option></select>點</div>  
            <!--<textarea name="content_1" id="content_1" rows="8" cols="60"></textarea>-->
            <textarea name="content_2" id="content_2" rows="10" cols="80"></textarea>
            <script>
                CKEDITOR.replace( "content_2", {});
                width:500;
            </script>
            <input id="submit" type="submit" name="senddata" value="送出" onclick="closeform()">
        </form>
        <iframe id="id_iframe" name="id_iframe" style="display:none"></iframe>
    </div>
</div>
    
</body>
<script>
    var user = '<?php echo $user; ?>';
    calender(thisYear,thisMonth);
    ajax_update();
</script>
</html>