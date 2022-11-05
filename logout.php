<?php 
include_once('functions.php');
session_destroy();
setcookie('user_id', '', time()-3600);
setcookie('user_email', '', time()-3600);
setcookie('user_first_name', '', time()-3600);
setcookie('user_last_name', '', time()-3600);

header('Location:'.website_url);
die();
?>