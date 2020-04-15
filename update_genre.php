<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
?>
<?php
if(isset($_POST['genreupdate'])){
	$username=$_COOKIE['user'];
	$genre=$_POST['genre'];
    $sql="UPDATE artiste_info SET genre='$genre' WHERE username='$username'";
    $result=mysqli_query($conn,$sql);
   echo "<script>window.location.href='profile.php';</script>";
	
}
?>
<?php
}
?>