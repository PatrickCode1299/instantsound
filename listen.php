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
}elseif (!isset($_COOKIE['user']) && !isset($_GET['mid'])) {
	header('Location:index.php');
}
elseif (!isset($_COOKIE['user']) && empty($_GET['mid'])) {
	header('Location:index.php');
}
elseif (!isset($_COOKIE['user']) && isset($_GET['mid'])) {
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
	echo "<div style='position:fixed; box-sizing:border-box; background:white; width:100%; height:auto; padding:5px 5px;  margin-left:0px;   top:0px; bottom:auto; z-index:2; padding:4px 4px;'>
   <p style='text-align:center; font-weight:400; word-wrap:break-word; line-height:20px;'>Join Instantsound Community and Listen to beautiful songs by this artiste and other talents. <a href='index.php'>link</a></p>
	</div><br />";
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
	echo "<div style='position:fixed;   background-size:cover; left:50px; right:50px; background-position:center; margin:0px auto;  margin-top:0px; width:50%; height:100%; padding:5px 5px;'>
<marquee style='margin-top:60px; font-family:arial; font-weight:bold;  position:fixed; left:0px; width:100%; background:black; opacity :0.8; border:1px solid white;  padding:4px 4px;	 text-transform:uppercase;   color:white; margin-left:0px;'></marquee>
   <div style=' margin:0px auto; margin-top:150px; margin-bottom:20px; border-radius:50%; width:200px; height:200px; '><img src='image/".$row['image']."' class='rotate' style='width:100%; border:2px solid white; border-radius:50%; height:200px;'>

   </div>
	";?>
	<?php echo"<center><span style='margin-top:10px; margin-bottom:5px; display:block;'><a href='audio/".$row['audio']."'  download><i class='fa fa-download' style='color:white; font-size:20px;'></i></span></center></a>";  
echo"<input id='songdetail' type='hidden' value=' ".base64_decode($_GET['mid'])." '>";
?>
<div class='audio-controller' style=' background:none; box-sizing:border-box; width:100%; bottom:0px; padding-top:4px; padding-bottom:4px; '>

<?php
$songowner=$row['username'];
$sql2="SELECT count(audio) AS total FROM user_post WHERE username='$songowner' AND audio !=''";
$result2=mysqli_query($conn,$sql2);
while($row2=mysqli_fetch_assoc($result2)){
	if($row2['total'] > 2){
echo "<div><form style='margin-top:0px; margin-right:0px;  float:left;' method='POST' action='prev.php'>
	<input type='hidden' name='data' value='".base64_decode($_GET['mid'])."'>
	<button type='submit' name='prev' style='border:none; border:2px solid white; border-radius:50%;  opacity:1; background:none; cursor:pointer; padding:5px 5px; margin-left:5px;'><i class='fa fa-step-backward' style='font-size:20px; color:white;'></i></button>
	</form>
	<form method='POST' style='float:right; margin-left:0px; margin-top:0px;' action='next.php'>
	<input type='hidden' id='infodata' name='data' value='".base64_decode($_GET['mid'])."'>
	<button type='submit' name='next' style='border:none; opacity:1; border:2px solid white; cursor:pointer; padding:5px 5px; background:none; border-radius:50%; margin-right:10px;'><i class='fa fa-step-forward' style='font-size:20px; color:white;'></i></button>
	</form></div>";
	}else{
		echo "";
	}
}
?>
<center><button id='audiocontrol' onclick="document.getElementById('songelement').play()" class='playbtn' style='border:2px solid white; '><i class='fa fa-play-circle' style='font-size:30px;'></i></button>
<button id='audiocontrol' class='pausebtn' style='display:none; border:2px solid white; ' onclick="document.getElementById('songelement').pause()"><i class='fa fa-pause'  style='font-size:30px;'></i></button></center>

</div>
	<?php echo "
       <audio  id='songelement' value=".$row['userpostid']." onmouseover='streamcount()' onplay='isplaying()' onpause='ispaused()' onended='isended()'  ontimeupdate='updateTrackTime()'      style='width:100%;' autoplay >
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
function isended(){
//do nothing at first
//it works here
$.ajax({
      url:'next.php',
      type:'POST',
      async:true,
     data:{data:$("#infodata").val()},
     success:function(response){
 $("body").append(response);
  }

	});
}

 
</script>
<style id="rotatedisc" class="rotatedisc">
.rotate{
animation-name:rotation;
animation-duration:50s;
animation-iteration-count:infinite;
animation-timing-function:ease;

}
@keyframes rotation{
0%{
transform:rotate(0deg);
}
25%{
transform:rotate(45deg);
}
50%{
transform:rotate(90deg);
}
75%{
transform:rotate(180deg);
}
100%{
transform:rotate(360deg);
}
}
</style>
	<?php
mysqli_close($conn);
}

?>

</body>
</html>