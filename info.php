<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
require 'db.php';
?>
<?php
include_once 'loginheader.php';
?>
<div class='user-container'>
<?php
$id=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
echo $id;
?>
</div>
<?php
}
?>