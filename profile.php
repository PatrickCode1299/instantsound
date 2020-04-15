<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
?>
<?php
include_once 'loginheader.php';
include_once 'checkcount.php'; 
include_once 'commentcount.php';
include_once 'shares.php';
include_once 'streamcount.php';
include_once 'checkgenre.php';
include_once 'numberreducer.php';
?>
<script type="text/javascript" src='profilestories.js'></script>
<div class='main-profile' style='background:grey; position:relative;'>
	<?php
	$username=$_COOKIE['user'];
  $sql="SELECT coverbg FROM artiste_info WHERE username='$username'";
  $result=mysqli_query($conn,$sql);
  if($row=mysqli_fetch_assoc($result)){
   if($row['coverbg']==''){
   	echo "<script>
   	 	$('.main-profile').css('background-image','url(bg/default.jpg)');
   	 	$('.main-profile').css({'background-repeat':'no-repeat', 'background-position':'center','background-attachment':'fixed', 'background-size':'100% 100%'});
   	</script>";
   }else{
   
echo "<script>
   	 	$('.main-profile').css('background-image','url(bg/".$row['coverbg'].")');
   	 	$('.main-profile').css({'background-repeat':'no-repeat', 'background-position':'50% 50%','background-attachment':'fixed', 'background-size':'cover'});
   	</script>";
   	
   }
  }
	?>
	<div>
	
	<button style='background:none; border:none; cursor:pointer; margin-top:5px; float:left;' onclick='sidebar()'>
		<span id='nav'></span>
		<span id='nav'></span>
		<span id='nav'></span>
	</button>
	<?php
	$username=$_COOKIE['user'];
    $sql="SELECT profile_pic FROM artiste_info WHERE username='$username'";
    $result=mysqli_query($conn,$sql);
     if($row=mysqli_fetch_assoc($result)){
     	if($row['profile_pic']==''){
     	echo "<center><div class='profile-pic-div' ><img src='profilepic/default.jpg' class='main-pic'></div></center>";
     	}else{
     		echo "<center><div class='profile-pic-div'><img src='profilepic/".$row['profile_pic']."' class='main-pic'></div></center>";
     	}
     }

	?>
	<script type="text/javascript">
	$('form.ajax').on('submit' ,function(){
var that= $(this),
url= that.attr('action'),
type=that.attr('method'),
data={};
that.find('[name]').each(function(index, value){
	var that = $(this),
	  name=that.attr('name'),
	  value=that.val();
	  data[name]=value;

});
$.ajax({
	url:url,
	type:type,
	data:data,
	success:function(response){
    $("body").append(response);
	}
});

return false;
});
	</script>
	</form>
</div>
	<div class='main-details-container'>
	<figure><?php
		$username=$_COOKIE['user'];
	$sql="SELECT count(caption) AS total FROM user_post WHERE username='$username' AND status !='shared'";
	$result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
    	if($row['total'] > 1){
    		echo $row['total']."<figcaption>Posts</figcaption>";
    	}else{
    		echo number_format_short($row['total'])."<figcaption>Post</figcaption>";
    	}
    }
	?></figure>
	<figure class='users_click' onclick='showfollower()'><?php 
		$username=$_COOKIE['user'];
	$sql="SELECT count(follower) AS total FROM followership WHERE following='$username'";
	$result=mysqli_query($conn,$sql);
  while($row=mysqli_fetch_assoc($result)){
    	if($row['total'] > 1){
    		echo $row['total']."<figcaption>Fans</figcaption>";
    	}else{
    		echo number_format_short($row['total'])."<figcaption>Fan</figcaption>";
    	}
    }
	?></figure>
	<figure class='user_click' onclick='showfollowing()'><?php 
		$username=$_COOKIE['user'];
	$sql="SELECT count(following) AS total FROM followership WHERE follower='$username'";
	$result=mysqli_query($conn,$sql);
  while($row=mysqli_fetch_assoc($result)){
    	if($row['total'] > 1){
    		echo $row['total']."<figcaption>Following</figcaption>";
    	}else{
    		echo number_format_short($row['total'])."<figcaption>Following</figcaption>";
    	}
    }
	?></figure>
	<div onclick='popup()' style='float:right; color:white; padding:4px 4px; border-radius:5px; background:red; margin-right:2px;'><span>Post</span></div>
	<script type="text/javascript">
	function showfollowing(){
		$(".following-box").css('display','block');
	}
	function showfollower(){
		$(".follower-box").css('display','block');
	}


$(".users_click").click(function(e){
e.stopPropagation();
return false;
});
$(".user_click").click(function(e){
e.stopPropagation();
return false;
});
	</script>
</div>

</div>
<div class='bio-info-container'>
	<?php
		$username=$_COOKIE['user'];
   $sql="SELECT user_bio FROM artiste_info WHERE username='$username'";
   $result=mysqli_query($conn,$sql);
   if($row=mysqli_fetch_assoc($result)){
    if($row['user_bio']==''){

echo "";

    }else{
        echo "<p class='bio-holder' style=' margin-top:4px; font-size:14px; text-align:left; font-family:arial;
        '>Bio:  ".$row['user_bio']."</p>";
        
    }
   }
    ?>

</div>
<div class='follower-box' id="follower-box" >
	<span style='color:black; margin-left:10px;  cursor:pointer; ' onclick='hidebox()'><i class='fa fa-arrow-left' style='font-size:20px;'></i></span><span style='margin-left:5px;'>Followers</span>
	<?php echo"<form method='POST' style='margin-top:5px;'>
    <input type='hidden' id='main' name='username' value='".$_COOKIE['user']."'>
    <textarea name='search'  onclick='showfollowerResponse()' id='tofind' value='' onkeydown='checkfollowers()' style='resize:none; width:100%; border:none; height:30px;border:1px solid lightgrey; padding:4px 4px;' placeholder='Search followers'></textarea>
	</form>"; 

	?>
<div id='followers-response' onclick='hideresponsebox()' class='follower-res' style='position:fixed; margin-top:0px; display:none; height:100%;  padding:4px 4px; width:100%; opacity:0.8;   color:white; z-index:1; background:black;'>
</div>
	<script>
	function checkfollowers(){
 $.ajax({
	url:'findfollowers.php',
	type:'POST',
	data:{user:$("#tofind").val(),
	current:$("#main").val()
},
	success:function(response){
  $("#followers-response").html(response)
	}
});
	}
	function showfollowerResponse(){
		$("#followers-response").css('display','block');
	}
	function hideresponsebox(){
		$(".follower-res").css('display','none');
	}
	</script>
	<?php
$username=$_COOKIE['user'];
$sql="SELECT * FROM followership INNER JOIN artiste_info ON followership.follower=artiste_info.username WHERE followership.following='$username' ORDER BY followership.id desc LIMIT 30";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
while($row=mysqli_fetch_assoc($result)){
$tounfollow=$row['follower'];
$sql3="SELECT follower FROM followership WHERE follower='$username' AND following='$tounfollow'";
$result3=mysqli_query($conn,$sql3);
if(mysqli_num_rows($result3) > 0){
if($row['profile_pic']==''){
echo "<ul class='following-list'>
	<li id='".$row['follower']."'><img src='profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a><form method='POST' style='float:right; margin-top:10px;' id='unfollow-form' action='unfollow.php' class='ajax'  value='".$row['follower']."'>
	<input type='hidden' name='following' value='".$row['follower']."'>
	<input type='hidden' name='follower' value='".$_COOKIE['user']."'>
	<button type='submit' name='unfollow' onclick='callaction()' class='".$row['follower']."'  id='unfollow-button'>unfollow</button>
	</form></li><br />
	</ul>";
}else{
	echo "<ul class='following-list'>
	<li id='".$row['follower']."'><img src='profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a><form method='POST' style='float:right; margin-top:10px;' id='unfollow-form'  action='unfollow.php' class='ajax' value='".$row['follower']."'>
	<input type='hidden' name='following' value='".$row['follower']."'>
	<input type='hidden' name='follower' value='".$_COOKIE['user']."'>
	<button type='submit' name='unfollow' onclick='callaction()' class='".$row['follower']."'  name='unfollow' id='unfollow-button'>unfollow</button>
	</form></li><br />
	</ul>";
}
}else{
	if($row['profile_pic']==''){
echo "<ul class='following-list'>
	<li><img src='profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a><form method='POST' class='ajax'  style='float:right; margin-top:10px;' action='follow.php'>
	<input type='hidden' name='following' value='".$row['follower']."'>
	<input type='hidden' name='username' value='".$_COOKIE['user']."'>
	<button type='submit' name='follow' class='".$row['follower']."' id='unfollow-button'>follow</button>
	</form></li><br />
	</ul>";
	}else{
		echo "<ul class='following-list'>
	<li><img src='profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a><form method='POST' class='ajax' style='float:right;  margin-top:10px;' action='follow.php'>
	<input type='hidden' name='following' value='".$row['follower']."'>
	<input type='hidden' name='username' value='".$_COOKIE['user']."'>
	<button type='submit' name='follow' class='".$row['follower']."' id='unfollow-button'>follow</button>
	</form></li><br />
	</ul>";
	}
}
}
}else{
echo "<p style='text-align:center; font-size:18px; font-weight:bold; margin-top:10px;'>No Fan yet</p>";
}

	?>
</div>
<script type="text/javascript" src='getfollowers.js'></script>
<div class='following-box' id='following-box'>
	<span style='color:black; margin-left:10px;  cursor:pointer; ' onclick='hidebox()'><i class='fa fa-arrow-left' style='font-size:20px;'></i></span><span style='margin-left:5px;'>Following</span>
	
	<?php
$username=$_COOKIE['user'];
$sql="SELECT * FROM followership INNER JOIN artiste_info ON followership.following=artiste_info.username WHERE followership.follower='$username' ORDER BY followership.id desc LIMIT 30";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
while($row=mysqli_fetch_assoc($result)){
	if($row['profile_pic']=='' && $row['username']!='Superuser'){
echo "<ul class='following-list'>
	<li id='".$row['following']."'><img src='profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['following']."</span></a><form method='POST' value='".$row['following']."' id='unfollow-form' class='ajax' action='unfollow.php'   style='float:right; margin-top:10px;'>
	<input type='hidden' id='unfollow-details' name='following' value='".$row['following']."'>
	<input type='hidden' name='follower' value='".$_COOKIE['user']."'>
	<button type='submit' name='unfollow' onclick='callaction()' class='".$row['following']."' id='unfollow-button'>unfollow</button>
	</form></li><br />
	</ul>";
	}
	elseif ($row['profile_pic']=='' && $row['username']=='Superuser') {
		echo "<ul class='following-list'>
	<li id='".$row['following']."'><img src='profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['following']."</span></a></li><br />
	</ul>";
	}
	elseif ($row['profile_pic']!='' && $row['username']=='Superuser') {
		echo "<ul class='following-list'>
	<li id='".$row['following']."'><img src='profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['following']."</span></a></li><br />
	</ul>";
	}
	else{
		echo "<ul class='following-list'>
	<li id='".$row['following']."'><img src='profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['following']."</span></a><form method='POST' value='".$row['following']."' id='unfollow-form' class='ajax' action='unfollow.php'   style='float:right; margin-top:10px;'>
	<input type='hidden' id='unfollow-details' name='following' value='".$row['following']."'>
	<input type='hidden' name='follower' value='".$_COOKIE['user']."'>
	<button type='submit' name='unfollow' onclick='callaction()' class='".$row['following']."' id='unfollow-button'>unfollow</button>
	</form></li><br />
	</ul>";
	}
	
}
}else{
echo "<p style='text-align:center; font-size:15px; font-weight:bold; margin-top:10px;'>Follow people to stream their songs and get more followers</p>";
}

	?>
	
</div>
<script type="text/javascript">
	function hidebox(){
		$(".following-box").css("display","none");
		$(".follower-box").css('display','none');
	}
	</script>
<div class='side-bar'>
	<span class='close-bar' style='float:right; cursor:pointer; font-size:30px; color:red;'>&times;</span>
	<?php
$username=$_COOKIE['user'];
$sql="SELECT * FROM artiste_info WHERE username='$username'";
$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
	echo "<ul id='details-list'>
	<li><i class='fa fa-user' style='margin-right:5px;'></i>".$row['username']."</li><br />
	<li><i class='fa fa-envelope' style='margin-right:5px;'></i>".$row['email']."</li><br />
    <li><i class='fa fa-phone' style='margin-right:5px;'></i>".$row['phone']."</li><br />
	<li><i class='fa fa-microphone' style='margin-right:5px;'></i>".checkgenre($row['genre'])."</li><br />
	</ul>";
}

	?>
	<button type='button' style='width:100%; border:none; background:none; padding:4px 4px; border-radius:5px; border:1px solid black; cursor:pointer; margin-top:5px;' onclick='$(".edit-profile-div").css("display","block");'>Edit profile</button>

</div>
<div class='edit-profile-div'>
	<button id='hideedit' style='background:none; border:none; cursor:pointer; margin-top:8px; ' onclick='$(".edit-profile-div").css("display","none"); '><i class='fa fa-arrow-left' style='font-size:20px;'></i></button>
		<h2 style='text-align:center; font-weight:bold;'>Edit profile</h2>
	<div style='margin-top:10px; padding:4px 4px;'><form method='POST' action='bio.php' class='ajax'>
		<?php echo"<input type='hidden' name='username' value='".$_COOKIE['user']."'>"; ?>
		<center>
		<textarea placeholder='Write bio.....' name='bio' class='bioarea' onkeydown='raisebutton()'  style='resize:none;  font-size:15px; color:white; background:black; box-sizing:border-box; border:none; padding-top:4px; border-bottom:2px solid lightgrey; width:100%;'><?php
   $sql="SELECT user_bio FROM artiste_info WHERE username='$username'";
   $result=mysqli_query($conn,$sql);
   if($row=mysqli_fetch_assoc($result)){
   	if($row['user_bio']==''){

echo "Type your bio(Cannot be greater than 140 characters)";

   	}else{
   		echo $row['user_bio'];
   		
   	}
   }
	?></textarea>
		<button id='update-bio-button' type='submit' name='bio-update' style='display:none; width:100%; margin-top:0px; padding:4px 4px; box-sizing:border-box; background:none; border-radius:5px; border:none; border:1px solid black; cursor:pointer; margin-bottom:10px;'>Update bio</button>
</center></form></div>

		<button class='coverButton' style='border:none; margin-top:0px; background:none; padding:4px 4px; border:1px solid black; margin-bottom:10px; cursor:pointer; box-sizing:border-box; border-radius:5px; width:100%;' onclick='showbg()'>Cover Photo</button>
	<?php
  echo "<form method='POST' class='bgform' style='margin-top:5px; display:none;' action='bg.php' enctype='multipart/form-data'>
<input type='hidden' name='username' value='".$_COOKIE['user']."'>
<input type='file' name='file'><br />
<button type='submit' name='coverbg' style='margin-top:5px; color:white;  padding:5px 5px; border:none; background:none;  border:1px solid black; margin-bottom:10px; border-radius:5px;  cursor:pointer; width:100%;'>Update</button>
  </form>";

	?>
	<button class='edit-profile-button'>Change Profilepic</button>
	<form method='POST' id='editpic-form'  style='display:none; margin-top:5px;'  enctype='multipart/form-data' action='<?php echo htmlspecialchars('changepic.php');  ?>'>
	<input type='hidden' name='username' value='<?php echo $_COOKIE['user']; ?>'>
	<input type='file' name='file' value='file' id='file-browse'><br />
	<button type='submit' name='update' id='update'>Update</button>
</form>
		<script type="text/javascript">
	$(".edit-profile-button").click(function(){
	$(".edit-profile-button").css('display','none');
   $("#editpic-form").css('display','block');
	});
	</script>
	<?php
	$status=$_COOKIE['user'];
	$checkusercountry="SELECT country FROM artiste_info WHERE username='$status'";
	$fetchquery=mysqli_query($conn,$checkusercountry);
	if($row=mysqli_fetch_assoc($fetchquery)){
		if($row['country']==''){
			echo "<h2 style='margin-bottom:0px; font-weight:bold; margin-left:5px; ''>Country</h2>
	<form method='POST' action='update_location.php'>
	<select name='country' style='box-sizing:border-box; width:100%; border-radius:5px;'>
		<option  value='country'>Country</option>
		<option  value='Nigeria'>Nigeria</option>
		<option  value='Ghana'>Ghana</option>
		<option  value='Kenya'>Kenya</option>
		<option  value='Tanzania'>Tanzania</option>
		<option  value='Cameroon'>Cameroon</option>
	</select>
	<button type='submit' name='countryupdate' style='border:none; background:red; font-weight:normal; padding:4px 4px; box-sizing:border-box; cursor:pointer; color:white; border-radius:5px; margin-left:2px;'>Update Country</button>
</form>";
		}else{
			echo "";
		}
	}
	?>
	<?php
	$status=$_COOKIE['user'];
	$checkusercountry="SELECT genre FROM artiste_info WHERE username='$status'";
	$fetchquery=mysqli_query($conn,$checkusercountry);
	if($row=mysqli_fetch_assoc($fetchquery)){
		if($row['genre']==''){
	echo"<h2 style='margin-bottom:0px; font-weight:bold; margin-left:5px;'>Music Genre / Category</h2>
	<form method='POST' action='update_genre.php'>
	<select name='genre' style='box-sizing:border-box; width:100%; border-radius:5px;'>
		<option  value='Rap'>Rap</option>
		<option  value='R&b'>R&B / Soul</option>
		<option  value='Afropop'>Afropop</option>
		<option  value='Instrumentalist'>Instrumentalist</option>
		<option value='null'>I don't sing</option>

	</select>
	<button type='submit' name='genreupdate' style='border:none; background:red; font-weight:normal; padding:4px 4px; box-sizing:border-box; cursor:pointer; color:white; border-radius:5px; margin-left:2px;'>Update</button>
</form>";
}else{
echo "";
}
}
?>
</div>
<script type="text/javascript">
$('form.bio').on('submit' ,function(){
var that= $(this),
url= that.attr('action'),
type=that.attr('method'),
data={};
that.find('[name]').each(function(index, value){
	var that = $(this),
	  name=that.attr('name'),
	  value=that.val();
	  data[name]=value;

});
$.ajax({
	url:url,
	type:type,
	data:data,
	success:function(response){
    $("body").append(response);
	}
});

return false;
});
$('.close-bar').click(function(){
$(".side-bar").css('display','none');
$(".main-profile").css('margin-left','auto');
$("#postarea").css('margin-left', 'auto');


});
function showbox(){
	$("#edit-bio-button").css('display','none');
	$("#user-bio-form").css('display','block');
}
function sidebar(){
$(".side-bar").css('display','block');
	$(".side-bar").css('width','250px');
	$(".main-profile").css('margin-left','250px');
$("#postarea").css('margin-left', '250px');	
}
function raisebutton(){
	$("#update-bio-button").css('display','block');
}
function showbg(){
	$(".bgform").css('display','block');
	$(".coverButton").css('display','none');
}
</script>
<div class='profile-post-area' id='postarea'>
   <?php
	$username=$_COOKIE['user'];
     $sql="SELECT * FROM user_post INNER JOIN artiste_info ON user_post.username=artiste_info.username WHERE user_post.username='$username' AND user_post.status !='shared' OR user_post.sharer='$username'  ORDER BY user_post.userpostid DESC LIMIT 5";
     $result=mysqli_query($conn,$sql);
     if(mysqli_num_rows($result) > 0){
    while($row=mysqli_fetch_assoc($result)){
    if($row['image']=='' && $row['profile_pic']=='' && $row['audio']=='' && $row['colorbg']=='white'){
 echo "<div style='padding:5px 5px; margin-top:5px; background:grey; border:1px solid grey; border-radius:5px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span><form method='POST' action='deletepost.php'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='username' value='".$row['username']."'>
   <button type='submit' name='delete' style='border:none; background:none; cursor:pointer; float:right;'><i class='fa fa-trash' style='font-size:15px; color:red;'></i></button>
   </form></h3>
    <p style='word-wrap:break-word; font-family:arial; color:white;'>".htmlspecialchars($row['caption'])."</p>
    ";$user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
   	echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
   	echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
   	echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
    elseif($row['image']=='' && $row['profile_pic']=='' && $row['colorbg']=='lightblue'){
 echo "<div style='padding:5px 5px; margin-top:5px; background:lightblue; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span><form method='POST' action='deletepost.php'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='username' value='".$row['username']."'>
   <button type='submit' name='delete' style='border:none; background:none; cursor:pointer; float:right;'><i class='fa fa-trash' style='font-size:15px; color:red;'></i></button>
   </form></h3>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
   ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
   if(mysqli_num_rows($result2)>0){
   	echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
   	 	echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
    echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
     echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
   	echo"
    <form method='POST' style='margin-top:4px; margin-bottom:4px;' action='comment.php' class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
   }elseif ($row['image']=='' && $row['profile_pic']!='' && $row['colorbg']=='white') {
    	 echo "<div style='padding:5px 5px; margin-top:5px; background:grey; border:1px solid grey; border-radius:5px; margin-left:4px; margin-right:4px;' >
    <h3><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span><form method='POST' action='deletepost.php'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='username' value='".$row['username']."'>
   <button type='submit' name='delete' style='border:none; background:none; cursor:pointer; float:right;'><i class='fa fa-trash' style='font-size:15px; color:red;'></i></button>
   </form></h3>
    <p style='word-wrap:break-word; font-family:arial; color:white;'>".htmlspecialchars($row['caption'])."</p>
    ";$user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
   	echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
   	 	echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
   	echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
    elseif($row['image']=='' && $row['profile_pic']=='' && $row['colorbg']=='lightblue'){
 echo "<div style='background:;padding:5px 5px; margin-top:5px; border-radius:5px; background:lightblue; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span><form method='POST' action='deletepost.php'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='username' value='".$row['username']."'>
   <button type='submit' name='delete' style='border:none; background:none; cursor:pointer; float:right;'><i class='fa fa-trash' style='font-size:15px; color:red;'></i></button>
   </form></h3>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
   ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
   if(mysqli_num_rows($result2)>0){
   	echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
   	 	echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
    echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
     echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
   	echo"
    <form method='POST' style='margin-top:4px; margin-bottom:4px;' action='comment.php' class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
   }elseif ($row['image']=='' && $row['profile_pic']!='' && $row['colorbg']=='lightblue') {
    	 echo "<div style='background:;padding:5px 5px; margin-top:5px; border-radius:5px; background:lightblue; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span><form method='POST' action='deletepost.php'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='username' value='".$row['username']."'>
   <button type='submit' name='delete' style='border:none; background:none; cursor:pointer; float:right;'><i class='fa fa-trash' style='font-size:15px; color:black;'></i></button>
   </form></h3>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
    ";$user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
  if(mysqli_num_rows($result2)>0){
   	echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
   	 	echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
   	echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button' >Comment</button>
    </form>
    </div>";
    }
     elseif($row['image']=='' && $row['profile_pic']=='' && $row['colorbg']=='gold'){
 echo "<div style='background:;padding:5px 5px; margin-top:5px; background:gold; border-radius:5px; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; color:white; display:block; font-weight:bold;'>".$row['username']."</span><form method='POST' action='deletepost.php'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='username' value='".$row['username']."'>
   <button type='submit' name='delete' style='border:none; background:none; cursor:pointer; float:right;'><i class='fa fa-trash' style='font-size:15px; color:red;'></i></button>
   </form></h3>
    <p style='word-wrap:break-word; color:black;'>".htmlspecialchars($row['caption'])."</p>
   ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
   	echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
 	echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
   echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
     echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:black; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
   	echo"
    <form method='POST' style='margin-top:4px; margin-bottom:4px;' action='comment.php' class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button' style='background:white; border:none; color:black;'>Comment</button>
    </form>
    </div>";
   }elseif ($row['image']=='' && $row['profile_pic']!='' && $row['colorbg']=='gold') {
    	 echo "<div style='background:;padding:5px 5px; margin-top:5px; border-radius:5px; background:gold; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span style='margin-top:15px; color:white; display:block; font-weight:bold;'>".$row['username']."</span><form method='POST' action='deletepost.php'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='username' value='".$row['username']."'>
   <button type='submit' name='delete' style='border:none; background:none; cursor:pointer; float:right;'><i class='fa fa-trash' style='font-size:15px; color:black;'></i></button>
   </form></h3>
    <p style='word-wrap:break-word; font-family:AlexBrush-Regular; color:black; font-size:20px; '>".$row['caption']."</p>
    ";$user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
   	echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
   	 	echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:black; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
   	echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button' style='background:white; border:none; color:black;'>Comment</button>
    </form>
    </div>";
    }
    elseif ($row['image'] !='' && $row['image1']=='' && $row['profile_pic']=='' && $row['audio']=='' && $row['status'] !='shared') {
    	 echo "<div style='background:grey; border:1px solid grey; border-radius:5px; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'>".$row['username']."</h3>
    <img src='image/".$row['image']."' style='width:100%; height:auto;'>
    <p style='word-wrap:break-word; color:white;'>".htmlspecialchars($row['caption'])."</p>
   ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
   	echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
   	 	echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
   	echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
        elseif ($row['image'] !='' && $row['image1']=='' && $row['profile_pic']!='' && $row['audio']==''&& $row['status'] !='shared') {
    	 echo "<div style='background:grey; border:1px solid grey; border-radius:5px; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'>".$row['username']."</h3>
    <img src='image/".$row['image']."' style='width:100%; height:auto;'>
    <p style='word-wrap:break-word; color:white;'>".htmlspecialchars($row['caption'])."</p>
   ";
  $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
   if(mysqli_num_rows($result2)>0){
   	echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
   	 	echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
   	echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
    elseif($row['image'] !='' && $row['image1']!='' && $row['profile_pic']=='' && $row['audio']==''){
    	 echo "<div style='background:grey; border:1px solid grey; border-radius:5px; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'>".$row['username']."</h3>
    <div style='display:flex; flex-direction:row; flex-wrap:nowrap; flex-column-gap:20px;'><img src='image/".$row['image']."' style='width:50%; height:10%;'>
    <img src='image/".$row['image1']."' style='width:50%; height:10%;'></div>
    <p style='word-wrap:break-word; color:white;'>".htmlspecialchars($row['caption'])."</p>
   ";
     $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
   	echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
   	 	echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
   	echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
      elseif($row['image'] !='' && $row['image1']!='' && $row['profile_pic']!='' && $row['audio']==''){
    	 echo "<div style='background:white; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'>".$row['username']."</h3>
     <div style='display:flex; flex-direction:row; flex-wrap:nowrap; flex-column-gap:20px;'><img src='image/".$row['image']."' style='width:50%; height:10%;'>
    <img src='image/".$row['image1']."' style='width:50%; height:10%;'></div>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
   ";
     $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
 if(mysqli_num_rows($result2)>0){
   	echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
   	 	echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
   	echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
    elseif ($row['image'] !='' && $row['sharer']!=$_COOKIE['user'] && $row['audio']!='' && $row['profile_pic']=='' && $row['username']==$_COOKIE['user']) {
    	 echo "<div style='position:relative; padding:5px 5px; margin-top:5px; background:grey; border:1px solid grey; border-radius:5px; margin-left:4px; margin-right:4px;'>

    <h3>
    <a href='linkholder.php?linkid=".base64_encode($row['image'])."' style='color:red;'><span style='float:right;'><i style='color:red;' class='fa fa-headphones'></i></span></a>
    <img src='profilepic/default.jpg' id='post-profile-pic'><span style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span></h3>
   <div style=' box-sizing:border-box;  opacity:0.8; width:100%;  background:black; height:auto;'>
<p id='songname' style='text-align:center;  word-wrap:break-word;    color:white; '>".htmlspecialchars($row['caption'])."</p>
<center><img src='image/".$row['image']."'  style='width:100px; margin:0px auto; border:2px solid white; border-radius:50%;  height:100px; '></center><br />
   <audio id='songelement' value=".$row['id']." onmouseover='streamcount()' style='width:100%;' controls>
    <source src='audio/".$row['audio']."' type='audio/mpeg'>
    <source src='audio/".$row['audio']."' type='audio/ogg'>
    </audio>
   </div>
    <br />
    <br />
    ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
   	echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
   	 	echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo streamcount($row['audio']);
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
   echo shares($row['post_day']);
   echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
   	echo"
    <form method='POST' style='margin-top:4px; margin-bottom:4px; clear:both;' action='comment.php' class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
     elseif ($row['image'] !='' && $row['sharer']!=$_COOKIE['user'] && $row['audio']!='' && $row['profile_pic']!='' && $row['username']==$_COOKIE['user']) {
    	 echo "<div style='padding:5px 5px; margin-top:5px; position:relative;background:grey; border:1px solid grey; border-radius:5px; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'>
    <a href='linkholder.php?linkid=".base64_encode($row['image'])."' style='color:red;'><span style='float:right;'><i style='color:red;' class='fa fa-headphones'></i></span></a>
    <img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']." (Audio)</span></h3>
<div style=' box-sizing:border-box;  opacity:0.8; width:100%;  background:black; height:auto;'>
<p id='songname' style='text-align:center;  word-wrap:break-word;    color:white; '>".htmlspecialchars($row['caption'])."</p>
<center><img src='image/".$row['image']."'  style='width:100px; margin:0px auto; border:2px solid white; border-radius:50%;  height:100px; '></center><br />
   <audio id='songelement' value=".$row['id']." onmouseover='streamcount()' style='width:100%;' controls>
    <source src='audio/".$row['audio']."' type='audio/mpeg'>
    <source src='audio/".$row['audio']."' type='audio/ogg'>
    </audio>
   </div>
    <br />
    <br />
    ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
   	echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
   	 	echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo streamcount($row['audio']);
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
   echo shares($row['post_day']);
   echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
   	echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
  
    }elseif ($row['sharer']==$_COOKIE['user'] && $row['profile_pic'] !='') {
    	echo "<div style='padding:5px 5px; margin-top:5px; background:grey; border:1px solid grey; border-radius:5px;margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['sharer']." (Shared Audio)</span></h3>
    <h3>".$row['username']."</h3>
    <div style=' box-sizing:border-box;  opacity:0.8; width:100%;  background:black; height:auto;'>
<p id='songname' style='text-align:center;  word-wrap:break-word;    color:white; '>".htmlspecialchars($row['caption'])."</p>
<center><img src='image/".$row['image']."'  style='width:100px; margin:0px auto; border:2px solid white; border-radius:50%;  height:100px; '></center><br />
   <audio id='songelement' value=".$row['id']." onmouseover='streamcount()' style='width:100%;' controls>
    <source src='audio/".$row['audio']."' type='audio/mpeg'>
    <source src='audio/".$row['audio']."' type='audio/ogg'>
    </audio>
   </div>
    <br />
    <br />
    ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
   	echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
    	echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
 echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
 echo streamcount($row['audio']);
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo shares($row['post_day']);
      echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
   	echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
  
    }
    elseif ($row['sharer']==$_COOKIE['user'] && $row['profile_pic'] =='') {
    	echo "<div style='padding:5px 5px; margin-top:5px; background:grey; border:1px solid grey; border-radius:5px;margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['sharer']." (Shared Audio)</span></h3>
    <h3>".$row['username']."</h3>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
     <img src='image/".$row['image']."'style='width:100%; height:auto; '><br />
    <audio id='songelement' value=".$row['id']." onmouseover='streamcount()' style='width:100%;' controls  loop>
    <source src='audio/".$row['audio']."' type='audio/mpeg'>
    <source src='audio/".$row['audio']."' type='audio/ogg'>
    </audio><br />
    ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
 if(mysqli_num_rows($result2)>0){
   	echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
   	 	echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
 echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo shares($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
   	echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
    }
     }else{
     	echo "<h5 style='font-weight:bold; font-family:arial; text-align:center;'>When You Post Photos and songs It Will Appear Here</h5>";
     }
	?>
<div class="black-div" id="blackdiv">
</div>
<div class='pop-div'>
	<?php echo"<form method='POST' action='user_post.php' class='ajax' >
		<center><textarea id='maintext' name='text' onkeydown='checkcolors()'  style='resize:none; width:300px; margin-top:5px; border:1px solid lightgrey; padding-top:4px; padding-left:4px;' placeholder='Talk to Fans....'></textarea></center>
		<input type='hidden' id='colorloop' name='colorscheme' value='white'>
		<input type='hidden' name='username' value='".$_COOKIE['user']."'>
		<center><button type='submit' name='post_text' id='post-fan-button'>Post</button></center>";
		?>

		<script type="text/javascript">
			function changebrown(){
		document.getElementById("colorloop");
		colorloop.value='gold';
	}
	function changeblue(){
		document.getElementById("colorloop");
		colorloop.value='lightblue';
	}
	function checkcolors(){
	var loop=document.getElementById("colorloop").value;
	if(loop=='gold'){
		$(".preview").css('background-color','gold');
			$("#maintext").css('background-color','gold');
	}
	else if(loop=='lightblue'){
			$(".preview").css('background-color','lightblue');
			$("#maintext").css('background-color','lightblue');
	}
     var textvalue=document.getElementById("maintext").value;
		$(".preview").html(textvalue);
	}
		</script>
		<script type="text/javascript">
	$('form.ajax').on('submit' ,function(e){
var that= $(this),
url= that.attr('action'),
type=that.attr('method'),
data={};
that.find('[name]').each(function(index, value){
	var that = $(this),
	  name=that.attr('name'),
	  value=that.val();
	  data[name]=value;

});
e.stopImmediatePropagation();
$.ajax({
	url:url,
	type:type,
	data:data,
	success:function(response){
    $("body").append(response);
	}
});

return false;
});
	function streamcount(){
	$.ajax({
	url:'streamcount.php',
	type:'POST',
	data:{songid:$("#songelement").val()},
	success:function(response){
    $("#streamholder").html(response);
	}
});
}
	</script>
	</form>
	<h4>Change Color Appearance</h4>
	<div class='flex-pop'>
		<li onclick='changebrown()' id='colors' style='background:gold; cursor:pointer; margin-left:5px; width:30px; height:30px; list-style:none; border-radius:5px;'></li>
		<li onclick='changeblue()' id='colors' style='background:lightblue; cursor:pointer; margin-left:5px; width:30px; height:30px; list-style:none; border-radius:5px;'></li>
		<?php
		 $fella=$_COOKIE['user'];
         $checkthisuser="SELECT genre FROM artiste_info WHERE username='$fella'";
         $result=mysqli_query($conn,$checkthisuser);
         if($getusergenre=mysqli_fetch_assoc($result)){
         	if(empty($getusergenre['genre'])){
         		echo "<div class='fatal-info-div' style='box-sizing:border-box; position:fixed; bottom:0px; width:80%; word-wrap:break-word;'>
         		<p style='font-weight:bold; font-family:arial; color:red; word-wrap:break-word;'>Complete your profile on Instantsound click the three bar button on your profile you would see a side bar coming out on the side bar click the edit profile button to complete your profile in other to upload music on this website</p>
         		</div>";
         	}elseif ($getusergenre['genre']=='null') {
         		echo "";
         	}else{
         		echo "<li onclick='showaudio()' id='colors' style='margin-left:5px; cursor:pointer;'><i class='fa fa-microphone' style='font-size:20px; list-style:none; color:red;'></i></li>";
         	}
         }
        ?>
        <li onclick='showphoto()' id='colors' style='margin-left:5px; cursor:pointer;'><i class='fa fa-image'  style='font-size:20px; list-style:none; color:lightblue;'></i></li>

	</div><br />

    <div id='song-up-div'  class='song-up-div'>
    	<span style='float:right; font-size:20px; color:red; cursor:pointer;' onclick='hidesongform()'>&times;</span>
    	<span class="upload-tile" style='font-family:arial; font-weight:bold; '>Upload a new song (mp3 or wav)</span>
    <form method='POST'    enctype='multipart/form-data' id='audioform'><br />
    	<label style='margin-bottom:5px; font-family:arial; font-weight:bold;'>Song Title</label><br />
		<textarea id='audio_content' name='description' style='resize:none; box-sizing:border-box; width:100%;  margin-top:5px; height:40px;' placeholder='Example:Love in the moon'>
		</textarea><br /><br />
		<label style='margin-bottom:5px; font-family:arial; font-weight:bold;'>Song(mp3 or wav)</label><br />
		<input type='hidden' id='username_audio' name='username' value='<?php echo $_COOKIE['user']; ?>'>
		<input type='file' id='audio_song' style='margin-top:5px;' name='audio'><br /><br />
		<label style='margin-bottom:5px; font-family:arial; font-weight:bold;'>Song Image(Cover)</label><br />
		<input type='file' id='audio_image' style='margin-top:5px;' name='image'><br /><br />
		<button type='submit' name='upload_audio' style='background:white; border:none; border:1px solid black; padding:5px 5px; cursor:pointer; border-radius:10px;'>Upload</button>
	</form>
	<?php
if(isset($_POST['upload_audio'])){
if(empty($_POST['description'])){
	echo "<script>alert('Please Include Song description In form');</script>";
}else{
$username=$_COOKIE['user'];
$getgenre="SELECT genre FROM artiste_info WHERE username='$username'";
$queryreq=mysqli_query($conn,$getgenre);
if($getreq=mysqli_fetch_assoc($queryreq)){
$GLOBALS['usergenre'] = $getreq['genre'];
}
$genre=$GLOBALS['usergenre'];
$day=date('Y-m-d H:i:s');
$caption=htmlspecialchars($_POST['description']);
$imagename=$_FILES['image']['name'];
$imagesize=$_FILES['image']['size'];
$imagetype=$_FILES['image']['type'];
$imageerror=$_FILES['image']['error'];
$imagetmp=$_FILES['image']['tmp_name'];
$imageext=explode(".", $imagename);
$imagerealname=strtolower(end($imageext));
$audioname=$_FILES['audio']['name'];
$audiosize=$_FILES['audio']['size'];
$audiotype=$_FILES['audio']['type'];
$audioerror=$_FILES['audio']['error'];
$audiotmp=$_FILES['audio']['tmp_name'];
$audioext=explode(".", $audioname);
$audiorealname=strtolower(end($audioext));
$allowed=array('jpg','png','PNG','JPG', 'mp3','wav');
$songarray=array('mp3','wav');
if(in_array($imagerealname,$allowed) && in_array($audiorealname,$songarray)){
if($imagesize < 1000000){
if($imageerror===0 && $audioerror===0){
$audionamenew=uniqid('',true).".".$audiorealname;
$imagenamenew=uniqid('',true).".".$imagerealname;
$audiodir='audio/'.$audionamenew;
$imagedir='image/'.$imagenamenew;
$sql="INSERT INTO user_post(username,caption,image,post_day,audio,genre) VALUES(?,?,?,?,?,?)";
 $stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){
	echo "Sorry Something Went Wrong";
}else{
	mysqli_stmt_bind_param($stmt,"ssssss",$username,$caption,$imagenamenew,$day,$audionamenew,$genre);
	mysqli_stmt_execute($stmt);
	move_uploaded_file($audiotmp, $audiodir);
move_uploaded_file($imagetmp, $imagedir);

}
$sql1="SELECT follower FROM followership WHERE following='$username'";
$result1=mysqli_query($conn,$sql1);
while($row1=mysqli_fetch_assoc($result1)){
	$owner=$row1['follower'];
	$sql2="INSERT INTO notifications(sender,details,owner,status,day,location,unique_id)VALUES('$username','$username uploaded a new song','$owner',0,'$day','audio','$imagenamenew');";
	$result2=mysqli_query($conn,$sql2);
}
echo "<script>alert('Song Uploaded Sucessfuly');</script>";
	echo "<script>
	window.location.href='profile.php';
	</script>";
}else{
	echo "<script>alert('We can't Upload the image and song on our site wrong format, or production');</script>";
	echo "<script>
	window.location.href='profile.php';
	</script>";
	
}
}else{
		echo"<script>alert('Please Resize the image or reduce the size of song in studio');</script>";
		echo "<script>
	window.location.href='profile.php';
	</script>";
}
}else{
	echo "<script>alert('Image and audio can only be png,jpg,mp3 and wav format');</script>";
		echo "<script>
	window.location.href='profile.php';
	</script>";
	
}
}

}

?>
	<p class='response' style='color:black;'></p>
	
</div>
<div class='upload-photo-div' style=' display:none; background:black;   padding:5px 5px;'>
	<span style='color:red; font-size:20px; float:right; cursor:pointer;' onclick='hideimagediv()'>&times;</span>
	<span class="upload-tile" style="font-family:arial; font-weight:bold; color:white;">Upload a new photo (jpg or png)</span>
	<form method='POST' action='upload_photo.php' enctype='multipart/form-data'>
		<br />
		<label style="margin-bottom:5px; font-family:arial; font-weight:bold; color:white; ">Photo Caption</label>
		<br />
		<textarea name='text' class="pic-text" placeholder='Write a caption....' style='resize:none; box-sizing:border-box; width:100%;'></textarea><br /><br />
		<label style="margin-bottom:5px; font-family:arial; font-weight:bold; color:white;">Image 1</label>
		<br />
		<input type='file' name='image1' style='margin-top:5px; color:white; margin-bottom:5px;'><br /><br />
		<label style="margin-bottom:5px; font-family:arial; font-weight:bold; color:white;">Image 2</label>
		<br />
		<input type='file' name='image2' style='color:white;'><br /><br />
		<button type='submit' name='uploadpic' style='margin-top:5px; margin-bottom:5px; padding:5px 5px; border:none; border:1px solid white; border-radius:10px; cursor:pointer; margin-left:5px;'>Post</button>
	</form>
</div>
</div>

	<script type="text/javascript">
function popup(){
	$(".pop-div").css("display","block");
	$(".black-div").css("display","block");
}

function hideimagediv(){
	$(".upload-photo-div").css('display','none');
}
function hidesongform(){
$("#song-up-div").css("display","none");
}
function showaudio(){
	$(".song-up-div").css('display','block');
}
function showphoto(){
$(".upload-photo-div").css('display','block');
}

</script>
</div>
<?php
     mysqli_close($conn);
?>
<?php
}
?>