<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
?>
<?php
if(isset($_POST['unlike'])){
require 'db.php';
$username=$_POST['username'];
$postid=$_POST['postid'];
$redbutton=$_POST['changeid'];
$sql="DELETE FROM post_likes WHERE username='$username' AND postid='$postid'";
$result=mysqli_query($conn,$sql);
echo "<script>
$('.$redbutton').css('color','black');
		$('.$redbutton').attr('name','like');

	$('#$redbutton').attr('action','like.php');


	</script>";

}
?>
<?php
}
?>