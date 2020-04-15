<?php
if(isset($_POST['delete'])){
require 'db.php';
$username=$_POST['username'];
$postid=$_POST['postid'];
$sql="DELETE FROM user_post WHERE post_day='$postid' AND username='$username';";
$result=mysqli_query($conn,$sql);
header('Location:profile.php');
}
?>