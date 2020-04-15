<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
require 'db.php';
?>
<?php
$user=$_COOKIE['user'];
$sql="UPDATE notifications SET status=1 WHERE owner='$user'";
$result=mysqli_query($conn,$sql);
?>
<?php
}
?>