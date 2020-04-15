<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
require 'db.php';
?>
<?php
if(isset($_POST['reply'])){
	$username=$_POST['username'];
	$replied=$_POST['replied'];
	$unique_id=$_POST['unique_id'];
	$notid=$_POST['notid'];
	$reply=(htmlspecialchars($_POST['text']));
	$duedate=date('Y-m-d');
	if(empty($reply)){
echo "<script>alert('Oops your reply is empty');</script>";
	}else{
$day=date('Y-m-d H:i:s');
if($replied==$_COOKIE['user']){
echo "";
}else{
$sql2="INSERT INTO notifications(sender,details,owner,status,day,location,unique_id,duedate) VALUES('$username','$username replied to your comment','$replied',0,'$day','reply','$notid','$duedate');";
$result2=mysqli_query($conn,$sql2);
}
$sql="INSERT INTO comment_replies(username,replied,reply,unique_id) VALUES(?,?,?,?)";
	$stmt=mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		echo "Sorry Something Went Wrong";
	}else{
		mysqli_stmt_bind_param($stmt,'ssss',$username,$replied,$reply,$unique_id);
		mysqli_stmt_execute($stmt);
	    
        echo "<script>
        window.location.href='post_comment.php?mid=".base64_encode($notid)."';
        </script>";
       
		
	}
}
	
}

?>

<?php
mysqli_close($conn);
}
?>