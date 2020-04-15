<?php
if(isset($_POST['submit'])){
	include_once 'class_comment.php';
	if(empty($_POST['comment'])){
		echo "<script>alert('Seems Like The comment Posted is empty');</script>";
	}else{
$comment=new user_comment($_POST['username'],$_POST['comment'],$_POST['day'],$_POST['post_id']);
	$comment->getComments();
	   echo "<script>
  
	$('.submit-comment-button').html('<img src=loading.gif width=20px height=20px>');
	function loaderr(){
	
		$('.submit-comment-button').html('post');
	}
		setTimeout(loaderr,4000);
		clearInterval();

	</script>";
	require 'db.php';
	include_once 'timeago.php';
	$username=$_POST['username'];
	$owner=$_POST['post_owner'];
	$post_id=$_POST['post_id'];
	if($owner==$_COOKIE['user']){
echo "";
	}else{
		$username=$_POST['username'];
	$owner=$_POST['post_owner'];
	$day=$_POST['day'];
	$unique_id=$_POST['post_id'];
$sql3="INSERT INTO notifications(sender,details,owner,status,day,location,unique_id) VALUES('$username','$username commented on your post','$owner',0,'$day','comments','$unique_id')";
	$result3=mysqli_query($conn,$sql3);
	}
   $sql="SELECT * FROM comments INNER JOIN artiste_info ON comments.username=artiste_info.username WHERE comments.username='$username' AND comments.post_id='$post_id' ORDER BY comments.postid desc LIMIT 1";
   $result=mysqli_query($conn,$sql);
   while($row=mysqli_fetch_assoc($result)){
   		if($row['profile_pic']==''){
echo "<div style='margin-top:10px; padding:4px 4px; '><img src='profilepic/default.jpg' id='comment_profile_pic_users'><a href='profile.php'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row['username']."</span></a><p style='word-wrap:break-word; font-size:13px; margin-top:8px; font-family:helvetica; font-weight:400;'>".htmlspecialchars($row['post_comment'])."</p><span style='font-size:13px; margin-left:5px; color:lightgrey;'>".time_ago_in_php($row['day'])."</span>
<form method='POST' action='reply.php' class='ajax'>
<input type='hidden' name='username'   value='".$_COOKIE['user']."'>
<input type='hidden' name='replied'   value='".$row['username']."'>
<input type='hidden' name='unique_id' value='".$row['postid']."'>
<input type='hidden' name='notid'    value='".$row['post_id']."'>
<textarea name='text' id='replyarea' placeholder='reply to ".$row['username']."\ncomment' style='resize:none; margin-top:5px;'></textarea>
<button type='submit' name='reply' style='padding:4px 4px; background:forestgreen; color:white; border:none; cursor:pointer; border:1px solid white; color:white; vertical-align:top;'>reply</button>
</form></div><hr style='clear:both;' />";
 echo "<script>
		 $('#replyarea').val('');
		 </script>";			
		}else{
		 echo "<div style='margin-top:10px; padding:4px 4px; '><img src='profilepic/".$row['profile_pic']."' id='comment_profile_pic_users'><a href='profile.php'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row['username']."</span></a><p style='word-wrap:break-word; font-size:13px; margin-top:8px; font-family:helvetica; font-weight:400;'>".htmlspecialchars($row['post_comment'])."</p><span style='font-size:13px; margin-left:5px; color:lightgrey;'>".time_ago_in_php($row['day'])."</span>
		 <form method='POST' action='reply.php' class='ajax'>
<input type='hidden' name='username'   value='".$_COOKIE['user']."'>
<input type='hidden' name='replied'   value='".$row['username']."'>
<input type='hidden' name='unique_id' value='".$row['postid']."'>
<input type='hidden' name='notid'    value='".$row['post_id']."'>
<textarea name='text' id='replyarea' placeholder='reply to ".$row['username']."\ncomment' style='resize:none; margin-top:5px;'></textarea>
<button type='submit' name='reply' style='padding:4px 4px; background:forestgreen; color:white; border:none; cursor:pointer; border:1px solid white; color:white; vertical-align:top;'>reply</button>
</form></div><hr style='clear:both;' />";
		 echo "<script>
		 $('#replyarea').val('');
		 </script>";		
		}
   }
   mysqli_close($conn);
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
    $(".all").prepend(response);
	}
});

return false;
});
</script>
