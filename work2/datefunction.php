<?php
ignore_user_abort();//關掉瀏覽器，PHP腳本也可以繼續執行.
set_time_limit(0);// 通過set_time_limit(0)可以讓程式無限制的執行下去
$interval = $_GET['interval'];
$title = $_GET['title'];
echo $title;
echo $interval;
sleep($interval);
include('../mail.php');
sendmail($title);
echo'finish';

?>