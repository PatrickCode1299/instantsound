<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
?>
<?php
if(isset($_POST['repost'])){
	require 'db.php';
	$username=$_POST['realowner'];
	$sharer=$_POST['reposter'];
	$content=$_POST['content'];
	$unique_id=$_POST['unique_id'];
	$image=$_POST['image'];
	$day=$_POST['day'];
	$audio=$_POST['audio'];
	$status='shared';
	$unique_id=$_POST['unique_id'];
	$sql="INSERT INTO user_post(username,caption,image,post_day,audio,status,sharer,unique_id) VALUES
	('$username','$content','$image','$day','$audio','$status','$sharer','$unique_id')";
	$result=mysqli_query($conn,$sql);
	$sql2="INSERT INTO notifications(sender,details,owner,status,day,location,unique_id) VALUES('$sharer','$sharer shared your song','$username',0,'$day','shared','$sharer');";
	$result2=mysqli_query($conn,$sql2);
	echo "<script>alert('You made a repost');</script>";
}

?>
<?php
mysqli_close($conn);
}
?>