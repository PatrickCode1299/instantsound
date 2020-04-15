<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
?>
<?php
if(isset($_POST['like'])){
require 'db.php';
$username=$_POST['username'];
$postid=$_POST['postid'];
$redbutton=$_POST['changeid'];
$sql="INSERT INTO post_likes(username,postid) VALUES(?,?)";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){
	echo "Sorry Something Went Wrong";
}else{
	mysqli_stmt_bind_param($stmt,"ss",$username,$postid);
	mysqli_stmt_execute($stmt);
	 	echo "<script>
	$('.$redbutton').css('color','red');
		$('.$redbutton').attr('name','unlike');

	$('#$redbutton').attr('action','unlike.php');

	</script>";

	

}

}

?>
<?php
}
?>