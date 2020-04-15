 <?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
  header('Location:index.php');
}else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
?>
<?php
$_POST['user'];
$user=$_POST['user'];
$current=$_POST['current'];
if(empty($_POST['user'])){
	echo "";
}else{
$sql="SELECT * FROM followership INNER JOIN artiste_info ON followership.follower=artiste_info.username
WHERE followership.follower LIKE '%$user%' AND followership.following='$current';";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
while ($row=mysqli_fetch_assoc($result)) {
	$user=$_COOKIE['user'];
	if($row['profile_pic']=='' && $row['username']==$user ){
echo "<ul class='following-list'>
	<li id='".$row['follower']."'><img src='profilepic/default.jpg' style='width:40px; height:40px; float:left; border:2px solid white; border-radius:5px;'><a href='profile.php'><span style='margin-left:2px; margin-top:5px; display:inline-block; font-weight:400; color:white;'>".$row['follower']."</span></a></li><br />
	</ul>";
	}elseif ($row['profile_pic']=='' && $row['username']!=$user) {
	echo "<ul class='following-list'>
	<li id='".$row['follower']."'><img src='profilepic/default.jpg' style='width:40px; height:40px; float:left; border:2px solid white; border-radius:5px;'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:5px; display:inline-block; font-weight:400; color:white;'>".$row['follower']."</span></a></li><br />
	</ul>";
	}elseif ($row['profile_pic']!='' && $row['username']==$user) {
		echo "<ul class='following-list'>
	<li id='".$row['follower']."'><img src='profilepic/".$row['profile_pic']."' style='width:40px; float:left; height:40px; border:2px solid white; border-radius:5px;'><a href='profile.php'><span style='margin-left:2px; margin-top:5px; display:inline-block; font-weight:400; color:white;'>".$row['follower']."</span></a></li><br />
	</ul>";
	}
	else{
echo "<ul class='following-list'>
	<li id='".$row['follower']."'><img src='profilepic/".$row['profile_pic']."' style='width:40px; float:left; height:40px; border:2px solid white; border-radius:5px;'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:5px; display:inline-block; font-weight:400; color:white;'>".$row['follower']."</span></a></li><br />
	</ul>";
	}
}
}else{
	echo "This user is not on this list";
}
}
?>

<?php
mysqli_close($conn);
}
?>