<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}
elseif (!isset($_GET['nmid'])) {
	header('Location:home.php');
}elseif (is_numeric($_GET['nmid'])) {
	header('Location:home.php');
}elseif (strlen($_GET['nmid']) < 6) {
	header('Location:home.php');
}
else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
include_once 'loginheader.php';
?>
<style type="">
body{
	background:#000;
}
</style>
<br /><br /><br /><br /><br /><br />
<div class='profile-pic-view'>
<img src="profilepic/<?php echo base64_decode($_GET['nmid']);  ?>" id='profilepic'>
</div>
<?php
mysqli_close($conn);
}
?>