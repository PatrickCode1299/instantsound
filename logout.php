<?php
session_start();
session_destroy();
session_unset();
if(isset($_COOKIE['user']) || isset($_COOKIE['email']) ){
unset($_COOKIE['user']);
unset($_COOKIE['email']);
setcookie('user',null,-1,'/');
setcookie('email',null,-1,'/');
header('Location:index.php');
}
?>