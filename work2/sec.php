<?php
foreach ($_GET as $get_key=>$get_var)      
{      
if (is_numeric($get_var)) {      
  $get[strtolower($get_key)] = get_int($get_var);      
} else {      
  $get[strtolower($get_key)] = get_str($get_var);      
}      
}     

/* 過濾所有POST過來的變數 */     
foreach ($_POST as $post_key=>$post_var)      
{      
if (is_numeric($post_var)) {      
  $post[strtolower($post_key)] = get_int($post_var);      
} else {      
  $post[strtolower($post_key)] = get_str($post_var);      
}      
}     


 
/* 過濾函式 */     
//整型過濾函式      
function get_int($number)      
{      
    return intval($number);      
}      
//字串型過濾函式      
function get_str($string)      
{      
    if (!get_magic_quotes_gpc()) {      
return addslashes($string);      
    }      
    return $string;      
}
?>