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
	
		$('.submit-comment-button').html('Comment');
		$('textarea').val('');
		alert('Comment Posted');
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
	$duedate=date('Y-m-d');
$sql3="INSERT INTO notifications(sender,details,owner,status,day,location,unique_id,duedate) VALUES('$username','$username commented on your post','$owner',0,'$day','comments','$unique_id','$duedate')";
	$result3=mysqli_query($conn,$sql3);

	}

	}
	
}

?>