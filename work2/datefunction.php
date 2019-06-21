<?php
ignore_user_abort();//關掉瀏覽器，PHP腳本也可以繼續執行.
set_time_limit(0);// 通過set_time_limit(0)可以讓程式無限制的執行下去
include('../mail.php');
$interval = $_GET['interval'];
$title = $_GET['title'];
$invite = @$_GET['invite'];
echo $title;
if($interval > 0){
    sleep((int)$interval);
    sendmail($title);
}

if(isset($invite)){
    invite($title,$invite);
}

?>