<?php
date_default_timezone_set('Africa/Lagos');
include_once 'timeago.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="description" content="">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no"/> 
<link rel="icon" type="img/png" href="css/instar.png">
<link rel="stylesheet" type="text/css" href="css/login.css">
<link rel="stylesheet" type="text/css" href="fontawesome-free/css/all.css">
<script type="text/javascript" src='script/jquery-3.3.1.min.js'></script>
<script type="text/javascript" src="script/streamcount.js"></script>
<script type="text/javascript">
function handle(){
	var result=confirm("Hey <?php echo $_COOKIE['user']; ?> Are You Leaving Now");
	if(result==true){
		window.location.href='logout.php';
	}else{
		
	}
}</script>
<title><?php echo $_COOKIE['user']; ?></title>
</head>
<body>
<header>
	
		<ul>
			<a href='home.php'><li><i class='fa fa-home' style='font-size:18px;'></i></li></a>
			<a href='profile.php'><li><i class='fa fa-user' style='font-size:18px;'></i></li></a>
			<li onclick="seen()"><i class='fa fa-bell' style='font-size:18px;' ></i><span style='color:white; border-radius:5px; padding:2px 2px; background:red; font-size:13px;'><?php 
			$username=$_COOKIE['user'];
			$sql="SELECT count(details) AS total FROM notifications WHERE owner='$username' AND status=0";
			$result=mysqli_query($conn,$sql);
			while($row=mysqli_fetch_assoc($result)){
				if($row['total'] > 10){
                 echo "10+";
				}else{
                 echo $row['total'];
				}
			
			}
			?></span></li>
			<script type="text/javascript" src='script/seen.js'></script>
			<a href='load_message.php'><li><i class='fa fa-envelope'></i><span style='color:white; border-radius:5px; padding:2px 2px; background:red; font-size:13px;'><?php 
			$username=$_COOKIE['user'];
			$sql="SELECT count(message) AS total FROM chat WHERE reciever='$username' AND status=0";
			$result=mysqli_query($conn,$sql);
			while($row=mysqli_fetch_assoc($result)){
				if($row['total'] > 10){
					echo "10+";
				}else{
                   echo $row['total'];
				}
				
			}
			?></span></li></a>
			<a href="songcart.php"><li><i class='fa fa-headphones'></i><span style='color:white; border-radius:5px; padding:2px 2px; background:red; font-size:13px;'><?php 
			$username=$_COOKIE['user'];
			$sql="SELECT count(audio) AS total FROM user_post WHERE username='$username' AND status !='shared' AND audio !=''";
			$result=mysqli_query($conn,$sql);
			while($row=mysqli_fetch_assoc($result)){
				if($row['total'] > 10){
					echo "10+";
				}else{
                   echo $row['total'];
				}
				
			}
			?></span></li></a>
			<a href='find.php'><li><i class='fa fa-search' id='icon' style='font-size:18px;'></i></li></a>
			<li id='showdropdown' onclick='dropdown()' ondoubleclick='hidedropdown()' style='position:relative;'><i class='fa fa-cog' style='font-size:18px;'></i>
				<ul class='dropdown-menu'>
					<li onclick="window.location.href='connect.php';"><i class='fa fa-user-plus' style='font-size:18px;'></i></li>
					<li onclick='handle()'><i class='fa fa-share-square' style='font-size:18px;'></i></li>
					<li></li>
				</ul>
			</li>
		</ul>
</header>
<div class="search-bar-box" id="search-bar-box">
<span onclick="hidebar()" style='float:left; font-weight:bold; font-size:20px; color:red; cursor:pointer; margin-top:5px; margin-left:5px; '><i class='fa fa-arrow-left' style='font-size:18px;'></i></span>
<form method='POST' action='search.php' style='width:90%; margin:0 auto; position:relative; margin-top:5px; padding:4px 4px;' id='search-form'>
<center><input type='text' id='searchvalue' name='search' onkeydown="runajax()"  style='margin-top:2px; width:250px; border:none; border:1px solid black; background:grey;  padding-left:4px; padding-top:4px; padding-bottom:4px;' placeholder='search for an artiste' >
</center>
</form>
<div id='response'>
</div>
</div>
<script type="text/javascript">
	function show(){
	$("#search-bar-box").css('display','block');
	$("#search-bar-box").css("height","100%");
   
	}
	
	</script>
	<script type="text/javascript">
	function runajax(){
 $.ajax({
	url:'search.php',
	type:'POST',
	data:{search:$("#searchvalue").val()},
	success:function(response){
  $("#response").html(response)
	}
});

 
	}
	</script>
<script type="text/javascript">
function hidebar(){
	$("#search-bar-box").css("display","none");
}
function nothing(){
alert("ok");
}
function dropdown(){
	$(".dropdown-menu").css('display','block');
	$(".dropdown-menu").css('height','80px');
}
function hidedropdown(){
	$(".dropdown-menu").css('display','none');
}
     $(document).click(function(){
$('.dropdown-menu').css('display','none');
});
 $(".dropdown-menu").click(function(e){
e.stopPropagation();
return false;
});
 $("#showdropdown").click(function(e){
e.stopPropagation();
return false;
});
</script>
<div class="not-info-container" id="not-container">
	<span onclick="hidenot()" style='float:left; font-weight:bold; margin-left:8px; margin-top:5px; margin-bottom:8px; color:black; cursor:pointer; margin-top:2px; margin-right:10px;'><i class='fa fa-arrow-left' style='font-size:18px;'></i></span><span style='font-weight:bold; font-size:15px;  display:block; margin-top:5px;'>Notifications</span>
	<?php
	$owner=$_COOKIE['user'];
   $sql="SELECT * FROM notifications INNER JOIN artiste_info ON notifications.sender=artiste_info.username
    WHERE notifications.owner='$username' ORDER BY notifications.id desc ";
   $result=mysqli_query($conn,$sql);
   if(mysqli_num_rows($result) > 0){
  while ($row=mysqli_fetch_assoc($result)) {
  if($row['profile_pic']=='' && $row['status']==0 && $row['location']=='comments'){
	echo "<li id='not-list'><img src='profilepic/default.jpg' id='not-profile-image' ><a href='post_comment.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:bold; margin-top:4px; padding:2px 2px; word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block;   float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
  elseif($row['profile_pic']!='' && $row['status']==0 && $row['location']=='comments'){
	echo "<li id='not-list'><img src='profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='post_comment.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:bold; margin-top:4px; padding:2px 2px; word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block;   float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
   elseif ($row['profile_pic']=='' && $row['status']==1 && $row['location']=='comments') {
	echo "<li id='not-list'><img src='profilepic/default.jpg' id='not-profile-image' ><a href='post_comment.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; padding:2px 2px; word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block;  float:right;  clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
   elseif ($row['profile_pic']!='' && $row['status']==1 && $row['location']=='comments') {
	echo "<li id='not-list'><img src='profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='post_comment.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; padding:2px 2px; word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block;    float:right;    clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
   elseif($row['profile_pic']=='' && $row['status']==0 && $row['location']=='audio'){
	echo "<li id='not-list'><img src='profilepic/default.jpg' id='not-profile-image' ><a href='listen.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:bold; margin-top:4px; padding:2px 2px; word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block;  float:right;    clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
  elseif($row['profile_pic']!='' && $row['status']==0 && $row['location']=='audio'){
	echo "<li id='not-list'><img src='profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='listen.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:bold; margin-top:4px; padding:2px 2px; word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block;   float:right;  clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
  elseif ($row['profile_pic']=='' && $row['status']==1 && $row['location']=='audio') {
	echo "<li id='not-list'><img src='profilepic/default.jpg' id='not-profile-image' ><a href='listen.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; padding:2px 2px; word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block;   float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
   elseif ($row['profile_pic']!='' && $row['status']==1 && $row['location']=='audio') {
	echo "<li id='not-list'><img src='profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='listen.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; padding:2px 2px; word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block;  float:right;   clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
    elseif($row['profile_pic']=='' && $row['status']==0 && $row['location']=='follow'){
	echo "<li id='not-list'><img src='profilepic/default.jpg' id='not-profile-image' ><a href='info.php?id=".base64_encode($row['sender'])."' style='color:black;'><p style='font-weight:bold; margin-top:4px; padding:2px 2px; word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block;  float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
  elseif($row['profile_pic']!='' && $row['status']==0 && $row['location']=='follow'){
	echo "<li id='not-list'><img src='profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='info.php?id=".base64_encode($row['sender'])."' style='color:black;'><p style='font-weight:bold; margin-top:4px; padding:2px 2px; word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block;  float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
  elseif ($row['profile_pic']=='' && $row['status']==1 && $row['location']=='follow') {
	echo "<li id='not-list'><img src='profilepic/default.jpg' id='not-profile-image' ><a href='info.php?id=".base64_encode($row['sender'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; padding:2px 2px; word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block;  float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
   elseif ($row['profile_pic']!='' && $row['status']==1 && $row['location']=='follow') {
	echo "<li id='not-list'><img src='profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='info.php?id=".base64_encode($row['sender'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; padding:2px 2px; word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block;   float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
     elseif($row['profile_pic']=='' && $row['status']==0 && $row['location']=='reply'){
	echo "<li id='not-list'><img src='profilepic/default.jpg' id='not-profile-image' ><a href='post_comment.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:bold; margin-top:4px; padding:2px 2px; word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block;  float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
  elseif($row['profile_pic']!='' && $row['status']==0 && $row['location']=='reply'){
	echo "<li id='not-list'><img src='profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='post_comment.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:bold; margin-top:4px; padding:2px 2px; word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block;  float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
  elseif ($row['profile_pic']=='' && $row['status']==1 && $row['location']=='reply') {
	echo "<li id='not-list'><img src='profilepic/default.jpg' id='not-profile-image' ><a href='post_comment.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; padding:2px 2px; word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block;   float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
   elseif ($row['profile_pic']!='' && $row['status']==1 && $row['location']=='reply') {
	echo "<li id='not-list'><img src='profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='post_comment.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; padding:2px 2px; word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block;   float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
    elseif($row['profile_pic']=='' && $row['status']==0 && $row['location']=='shared'){
	echo "<li id='not-list'><img src='profilepic/default.jpg' id='not-profile-image' ><a href='info.php?id=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:bold; margin-top:4px; padding:2px 2px; word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block; float:right;  clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
  elseif($row['profile_pic']!='' && $row['status']==0 && $row['location']=='shared'){
	echo "<li id='not-list'><img src='profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='info.php?id=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:bold; margin-top:4px; padding:2px 2px; word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block; float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
  elseif ($row['profile_pic']=='' && $row['status']==1 && $row['location']=='shared') {
	echo "<li id='not-list'><img src='profilepic/default.jpg' id='not-profile-image' ><a href='info.php?id=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; padding:2px 2px; word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block; float:right;  clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
   elseif ($row['profile_pic']!='' && $row['status']==1 && $row['location']=='shared') {
	echo "<li id='not-list'><img src='profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='info.php?id=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; padding:2px 2px; word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block; float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }


  }
   }else{
echo "<p style='text-align:center; font-weight:bold; margin-top:10px;'>No new notifications Yet</p>";
   }

function getnot(){
require 'db.php';
$owner=$_COOKIE['user'];
$day=date('Y-m-d');
$getoldnot="SELECT * FROM notifications WHERE owner='$owner'";
$findoldnot=mysqli_query($conn,$getoldnot);
while ($getallnot=mysqli_fetch_assoc($findoldnot)) {
	$clearoldnots="DELETE FROM notifications WHERE owner='$owner' AND duedate !='$day'";
	$execute=mysqli_query($conn,$clearoldnots);
}
}
getnot();

	?>
</div>
<noscript style="color:white; font-weight:bold; font-size:25px;">Oh no you can't disable javascript in this browser am not gonna work.</noscript>