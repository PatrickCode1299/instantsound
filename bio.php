<?php
if(isset($_POST['bio-update'])){
require 'db.php';
$username=$_POST['username'];
$bio=$_POST['bio'];
if(strlen($bio) > 140){
	echo "<script>alert('Please type a short description of your self');</script>";
}else{
$sql="UPDATE artiste_info SET user_bio='$bio' WHERE username='$username'";
$result=mysqli_query($conn,$sql);
	$sql="SELECT user_bio FROM artiste_info WHERE username='$username'";
   $result=mysqli_query($conn,$sql);
   if($row=mysqli_fetch_assoc($result)){
   		echo "<script>
	$('#update-bio-button').html('<img src=loading.gif width=20px height=20px>');
	function loaderr(){
$('#update-bio-button').html('Update');
alert('Your bio has been updated');
		$('.bioarea').val('".$row['user_bio']."');
	
	}
		setTimeout(loaderr,4000);
		clearInterval();

	</script>";	

}
}

}
?>