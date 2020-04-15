<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
    header('Location:index.php');
}elseif (!isset($_GET['uid'])) {
   header('Location:home.php');
}elseif (is_numeric($_GET['uid'])) {
    header('Location:home.php');
}
else{
require 'db.php';
?>
<?php
include_once 'loginheader.php';
?>
<div class="user-song-galla" style="">
	<h5 style="text-align:center; font-size:16px; color:white; margin-top:0px; padding:0px; font-weight:bold;"><?php echo "All Of ".base64_decode($_GET['uid'])."  Songs";  ?></h5>
<?php
$owner=base64_decode($_GET['uid']);
$getusersongs="SELECT username,caption,image,audio FROM user_post WHERE username='$owner' AND audio !=''";
$result=$conn -> query($getusersongs);
if(mysqli_num_rows($result) > 0){
while($row=mysqli_fetch_assoc($result)){
	echo "<div style='display:inline-block; border-radius:50px; margin:4px 4px; width:100px; height:100px;'>
	<a href='listen.php?mid=".base64_encode($row['image'])."'><image src='image/".$row['image']."' style='width:50px; height:50px; border-radius:50%; border:2px solid lightgreen;'></a>
	<a href='listen.php?mid=".base64_encode($row['image'])."'><p style='font-size:15px; margin-top:0px; padding-top:0px; font-weight:500; color:white; word-wrap:break-word;'>".$row['caption']."</p></a>
	</div>";
}
}else{
	echo "<p style='font-weight:bold; font-family:arial; color:white; text-align:center;'>$owner is cooking up some songs in studio deal with it.</p>";
}
?>
	
</div>
<?php
mysqli_close($conn);
}
?>