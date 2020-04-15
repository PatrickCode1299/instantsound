 <?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
  header('Location:index.php');
}else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
?>
<?php
$user=$_POST['followinguser'];
$current=$_POST['mainuser'];
if(empty($_POST['followinguser'])){
	echo "";
}else{
$sql="SELECT * FROM followership INNER JOIN artiste_info ON followership.following=artiste_info.username
WHERE followership.following LIKE '%$user%' AND followership.follower='$current';";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
while ($row=mysqli_fetch_assoc($result)) {
	$user=$_COOKIE['user'];
	if($row['profile_pic']=='' && $row['username']==$user ){
echo "<ul class='following-list'>
	<li id='".$row['following']."'><img src='profilepic/default.jpg' style='width:40px; height:40px; float:left; border:2px solid white; border-radius:5px;'><a href='profile.php'><span style='margin-left:2px; margin-top:5px; display:inline-block; font-weight:400; color:white;'>".$row['following']."</span></a></li><br />
	</ul>";
	}elseif ($row['profile_pic']=='' && $row['username']!=$user) {
	echo "<ul class='following-list'>
	<li id='".$row['following']."'><img src='profilepic/default.jpg' style='width:40px; height:40px; float:left; border:2px solid white; border-radius:5px;'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:5px; display:inline-block; font-weight:400; color:white;'>".$row['following']."</span></a></li><br />
	</ul>";
	}elseif ($row['profile_pic']!='' && $row['username']==$user) {
		echo "<ul class='following-list'>
	<li id='".$row['following']."'><img src='profilepic/".$row['profile_pic']."' style='width:40px; float:left; height:40px; border:2px solid white; border-radius:5px;'><a href='profile.php'><span style='margin-left:2px; margin-top:5px; display:inline-block; font-weight:400; color:white;'>".$row['following']."</span></a></li><br />
	</ul>";
	}
	else{
echo "<ul class='following-list'>
	<li id='".$row['following']."'><img src='profilepic/".$row['profile_pic']."' style='width:40px; float:left; height:40px; border:2px solid white; border-radius:5px;'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:5px; display:inline-block; font-weight:400; color:white;'>".$row['following']."</span></a></li><br />
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