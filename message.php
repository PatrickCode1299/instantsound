<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
require 'db.php';
?>
<?php
include_once 'loginheader.php';
?><br /><br /><br /><br /><br />
<?php
$username=$_COOKIE['user'];
$mid=htmlspecialchars(base64_decode($_GET['mid']));
$sql="SELECT * FROM chat WHERE username='$mid' AND reciever='$username'";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
	while ($row=mysqli_fetch_assoc($result)) {
		echo "<script>window.location.href='inbox.php?mid=".base64_encode($row['username'])."&unique_id=".base64_encode($row['unique_id'])."';</script>";
	}
}else{
?>
<?php
$username=$_COOKIE['user'];
$mid=htmlspecialchars(base64_decode($_GET['mid']));
$sql="SELECT * FROM chat WHERE reciever='$mid' AND username='$username'";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)> 0){
	echo "<script>window.location.href='info.php?id=".base64_encode($mid)."'</script>";
}else{
	$mid=htmlspecialchars(base64_decode($_GET['mid']));
	$sql="SELECT profile_pic FROM artiste_info WHERE username='$mid'";
	$result=mysqli_query($conn,$sql);
	if($row=mysqli_fetch_assoc($result)){
		if(empty($row['profile_pic'])){
 	echo "<div class='message-user-container'>
	<h5><center><img src='profilepic/default.jpg' id='message-profile-pic'></center><br />".$mid."</h5><br /><br /><br />
	<form method='POST' class='ajax' id='msg-form' action='message_user.php'>
	<textarea name='message' class='message-area'></textarea>
	<input type='hidden' name='username' value='".$username."'>
	<input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
	<input type='hidden' name='reciever' value='".$mid."'>
	<button type='submit' name='submit' id='message'>Send</button>
	</form>
	</div>";
		}else{
 	echo "<div class='message-user-container'>
	<h5><center><img src='profilepic/".$row['profile_pic']."' id='message-profile-pic'></center><br />".$mid."</h5><br /><br /><br />
	<form method='POST' class='ajax' id='msg-form' action='message_user.php'>
	<textarea name='message' class='message-area'></textarea>
	<input type='hidden' name='username' value='".$username."'>
	<input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
	<input type='hidden' name='reciever' value='".$mid."'>
	<button type='submit' name='submit' id='message'>Send</button>
	</form>
	</div>";
		}
     
	}

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
</body>
</html>
<?php
}
mysqli_close($conn);
?>