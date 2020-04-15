<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
?>
<?php
if(isset($_POST['countryupdate'])){
	$username=$_COOKIE['user'];
	$country=$_POST['country'];
	if($country=='country'){
		echo "<script>window.location.href='profile.php';</script>";
	}else{
		$sql="UPDATE artiste_info SET country='$country' WHERE username='$username'";
		$result=mysqli_query($conn,$sql);
		echo "<script>window.location.href='profile.php';</script>";
	}
}
?>
<?php
}
?>