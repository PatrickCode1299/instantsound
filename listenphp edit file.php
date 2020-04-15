<?php
if(isset($_COOKIE['user']) && isset($_GET['mid'])){
	require 'db.php';
	include_once 'loginheader.php';

	$songid=base64_decode($_GET['mid']);
$sqlstream="SELECT * FROM user_post WHERE image='$songid'";
$resultstream=mysqli_query($conn,$sqlstream);
if($rowstream=mysqli_fetch_assoc($resultstream)){
	$username=$rowstream['username'];
	$hitid=$rowstream['audio'];
	$sql="INSERT INTO streamcount(username,postid) VALUES('$username','$hitid')";
$result=mysqli_query($conn,$sql);
}
}elseif (!isset($_COOKIE['user']) && isset($_GET['mid'])) {
	require 'db.php';
		$songid=base64_decode($_GET['mid']);
$sqlstream="SELECT * FROM user_post WHERE image='$songid'";
$resultstream=mysqli_query($conn,$sqlstream);
if($rowstream=mysqli_fetch_assoc($resultstream)){
	$username=$rowstream['username'];
	$hitid=$rowstream['audio'];
	$sql="INSERT INTO streamcount(username,postid) VALUES('$username','$hitid')";
$result=mysqli_query($conn,$sql);
}
	echo "<!Doctype html>";
	echo "<html>";
	require 'db.php';
	echo "<head>";
	echo "<meta charset='utf-8'>
<meta name='description' content=''>
<meta name='viewport' content='width=device-width,initial-scale=1.0'/> ";
	$sid=base64_decode($_GET['mid']);
$sql="SELECT * FROM user_post WHERE image='$sid'";
$result=mysqli_query($conn,$sql);
if($row=mysqli_fetch_assoc($result)){
	echo "<title>".$row['caption']."</title>";

}
	echo "<link rel='stylesheet' type='text/css' href='fontawesome-free/css/all.css'>
	<script  src='script/jquery-3.3.1.min.js'></script>
	";
	echo "<link rel='stylesheet' type='text/css' href='css/login.css'>";
	echo "</head>";
	echo "<body>";
	echo "<div style='position:fixed; background:white; width:100%; height:auto; padding:5px 5px;  margin-left:0px;   top:0px; bottom:auto; z-index:2; padding:4px 4px;'>
   <p style='text-align:center; font-weight:400; word-wrap:break-word; line-height:20px;'>Join Instantsound Community and Listen to beautiful songs by upcoming artists. <a href='index.php'>link</a></p>
	</div>";
}elseif (isset($_COOKIE['user']) && is_numeric($_GET['mid'])) {
header('Location:home.php');
}elseif (isset($_COOKIE['user']) && strlen($_GET['mid']) < 3) {
header('Location:home.php');
}
elseif (!isset($_COOKIE['user']) && strlen($_GET['mid']) < 3) {
header('Location:home.php');
}
elseif (!isset($_COOKIE['user']) && is_numeric($_GET['mid'])) {
header('Location:home.php');
}
?>
<style type="text/css">
body{
	background:black;
}
</style>

<?php
$sid=base64_decode($_GET['mid']);
$sql="SELECT * FROM user_post WHERE image='$sid'";
$result=mysqli_query($conn,$sql);
if($row=mysqli_fetch_assoc($result)){
	echo "<div style='position:fixed; background:none;  background-size:cover; left:50px; right:50px; background-position:center; margin:0px auto;  margin-top:0px; width:50%; height:100%; padding:5px 5px;'>
<marquee style='margin-top:60px;  position:fixed; left:0px; width:100%; background:black; opacity :0.8; border:1px solid white;  padding:4px 4px;	 text-transform:uppercase;   color:white; margin-left:0px;'></marquee>
   <div style=' margin:0px auto; margin-top:150px; border-radius:50%; width:200px; height:200px; '><img src='image/".$row['image']."' style='width:100%; border:1px solid white; border-radius:50%; height:200px;'>

   </div>
	";?>
<div class='audio-controller' style=' background:none; box-sizing:border-box; width:100%; bottom:0px; padding-top:4px; padding-bottom:4px; '>
<?php echo"<ul style='display:inline; text-align:left;'><li style='margin-left:30px; margin-top:0px; display:block;'><a href='audio/".$row['audio']."' style='color:red; font-size:20px; margin-top:0px;' download><i class='fa fa-download' style='color:white; font-size:20px;'></i></li></a></ul>";  
echo"<input id='songdetail' type='hidden' value=' ".base64_decode($_GET['mid'])." '>";
?>
<center><button id='audiocontrol' onclick="document.getElementById('songelement').play()" class='playbtn' style=''><i class='fa fa-play-circle' style='font-size:20px;'></i></button>
<button id='audiocontrol' class='pausebtn' style='display:none;' onclick="document.getElementById('songelement').pause()"><i class='fa fa-pause'  style='font-size:20px;'></i></button></center>
</div>
	<?php echo "
       <audio  id='songelement' value=".$row['userpostid']." onmouseover='streamcount()' onplay='isplaying()' onpause='ispaused()' onended='isended()'  ontimeupdate='updateTrackTime()'      style='width:100%;' autoplay   loop>
    <source src='audio/".$row['audio']."' type='audio/mpeg'>
    <source src='audio/".$row['audio']."' type='audio/ogg'>
    </audio>
	";
	?>
	</div>
<script type="text/javascript">
function isplaying(){
	$(".pausebtn").css('display','block');
	$(".playbtn").css('display','none');
	$("marquee").html("Now playing  <?php echo $row['caption']; ?>");
	
	
}
function ispaused(){
	$(".playbtn").css('display','block');
$(".pausebtn").css('display','none');
$("marquee").html("Paused <?php echo $row['caption']; ?>");
	

}

 
</script>
	<?php
mysqli_close($conn);
}

?>

</body>
</html>