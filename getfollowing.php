<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
?>
<?php
$username=$_COOKIE['user'];
$sql="SELECT * FROM followership INNER JOIN artiste_info ON followership.following=artiste_info.username WHERE followership.follower='$username'";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
while($row=mysqli_fetch_assoc($result)){
	if($row['profile_pic']==''){
echo "<ul class='following-list'>
	<li id='".$row['following']."'><img src='profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['following']."</span></a><form method='POST' value='".$row['following']."' id='unfollow-form' class='ajax' action='unfollow.php'   style='float:right; margin-top:10px;'>
	<input type='hidden' id='unfollow-details' name='following' value='".$row['following']."'>
	<input type='hidden' name='follower' value='".$_COOKIE['user']."'>
	<button type='submit' name='unfollow' onclick='callaction()' class='".$row['following']."' id='unfollow-button'>unfollow</button>
	</form></li><br />
	</ul>";
	}else{
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
echo "";
}

	?>
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
	</script>
<?php
mysqli_close($conn);
}
?>