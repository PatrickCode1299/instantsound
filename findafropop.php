<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
require 'db.php';
?>
<?php
$visitor=$_COOKIE['user'];
$genre='Afropop';
$getodayrap="SELECT username,genre,image,caption FROM user_post WHERE username !='$visitor' AND genre='$genre'";
$queryrequest=mysqli_query($conn,$getodayrap);
if(mysqli_num_rows($queryrequest) > 0){
while ($getrequest=mysqli_fetch_assoc($queryrequest)) {
echo "<a href='listen.php?mid=".base64_encode($getrequest['image'])."'><li  style='padding:5px 5px; position:relative;'><img src='image/".$getrequest['image']."' class='trend-disc'  style=' border-radius:50px;'></a><a href='listen.php?mid=".base64_encode($getrequest['image'])."'><span style='position:absolute; top:25px; margin-top:10px; color:white; margin-top:5px; font-size:15px; font-family:helvetica; clear:both; margin-left:5px;'>".$getrequest['caption']."</span></a></li>";
}
}else{
	echo "<h3 style='text-align:center;'>No recent afircan pop songs yet</h3>";
}
?>
<?php
mysqli_close($conn);
}
?>