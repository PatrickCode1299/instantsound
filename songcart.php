<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
include_once 'loginheader.php';
?>
<style type="text/css">
body{
	background:black;
}
</style>
<div class='cartholder'>
<ul style='list-style:none; padding:0px;'>
<?php
$username=$_COOKIE['user'];
$sql="SELECT * FROM user_post WHERE username='$username' AND status !='shared' AND audio !=''ORDER BY userpostid desc;";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
while($row=mysqli_fetch_assoc($result)){
echo "<a href='listen.php?mid=".base64_encode($row['image'])."'><li class='discparent' style='padding:0px; position:relative;'><img src='image/".$row['image']."' id='cartthumbnail'></a><a href='deletesong.php?mid=".$row['audio']."'><span style='float:right; display:block; margin-top:30px; margin-right:10px; cursor:pointer;'><i class='fa fa-trash' style='color:white;'></i></span></a><a href='listen.php?mid=".base64_encode($row['image'])."'><span style='position:absolute; top:25px; margin-top:10px; color:white; margin-top:5px; font-size:15px; font-family:helvetica; clear:both; margin-left:5px;'>".$row['caption']."</span></a></li>";
}
}else{
	echo "<p style='margin-top:80px; text-transform:uppercase; color:white; text-shadow:2px 2px 2px black; font-weight:bold; text-align:center;'>A list of your song will be here</p>";
}
?>
</ul>
</div>

<?php
mysqli_close($conn);
}
?>