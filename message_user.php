<?php
if(isset($_POST['submit'])){
	require 'db.php';
    $username=$_POST['username'];
    $message=$_POST['message'];
    $reciever=$_POST['reciever'];
    $day=$_POST['day'];
    $unique_id=$day;
    $status=0;
    if(empty($message)){
   echo "<script>alert('Please Write Something In the Box');</script>";
    }else{
$sql="INSERT INTO  chat(username,message,reciever,day,unique_id,status) VALUES(?,?,?,?,?,?);";
	$stmt=mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		echo "Something Went Wrong";
	}else{
		mysqli_stmt_bind_param($stmt,'ssssss',$username,$message,$reciever,$day,$unique_id,$status);
		mysqli_stmt_execute($stmt);
	}
	echo "<script>
	$('#message').html('<img src=loading.gif width=20px height=20px>');
	function hi(){
	alert('Message Sent To   $reciever ');
	}
		setTimeout(hi,4000);
		clearInterval();

	</script>";
    }
	

	

}

?>