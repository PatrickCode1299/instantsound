<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
?>
<?php
if(isset($_POST['submit'])){
	require 'db.php';
$username=$_POST['username'];
$reciever=$_POST['reciever'];
$unique_id=$_POST['unique_id'];
$day=$_POST['day'];
$message=nl2br(htmlspecialchars($_POST['message']));
$status=0;
if(empty($message) && !isset($_FILES['file'])){
	echo "<script>alert('Seems Like Your Message Is Empty');</script>";
}
elseif(empty($message)&& (isset($_FILES['file']))){
	$filename=$_FILES['file']['name'];
	$fileSize=$_FILES['file']['size'];
	$fileTmpName=$_FILES['file']['tmp_name'];
	$fileError=$_FILES['file']['error'];
	$fileType=$_FILES['file']['type'];
	$fileExt=explode(".", $filename);
	$fileRealExt=strtolower(end($fileExt));
	$allowed = array('jpg', 'jpeg', 'JPG', 'png','PNG',);
	if(in_array($fileRealExt, $allowed)){
   if($fileError===0){
  if($fileSize < 1000000000){
$fileNameNew = uniqid('',true).".".$fileRealExt;
$fileDir = 'chat/'.$fileNameNew;
require 'db.php';
$sql="INSERT INTO chat(username,reciever,day,image,unique_id) VALUES('$username','$reciever','$day','$fileNameNew','$unique_id')";
$result=mysqli_query($conn,$sql);
move_uploaded_file($fileTmpName, $fileDir);
  }else{
echo "<script>alert('Your File Is Too Big');</script>";
  }
   }else{
echo "<script>alert('There Was an Error Uploading Your File');</script>";
   }
	}else{
echo "<script>alert('You can Only Upload PNG and JPG files');</script>";
	}

}
else{
$sql="INSERT INTO chat(username,message,reciever,day,unique_id,status) VALUES(?,?,?,?,?,?) ";

$stmt=mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		echo "Something Went Wrong";
	}else{
		mysqli_stmt_bind_param($stmt,'ssssss',$username,$message,$reciever,$day,$unique_id,$status);
		mysqli_stmt_execute($stmt);
			$sql="SELECT * FROM chat WHERE username='$username' AND unique_id='$unique_id' ORDER BY id desc LIMIT 1";
	$result=mysqli_query($conn,$sql);
	while($row=mysqli_fetch_assoc($result)){
echo "<div class='current'><p id='inbox-message'>".$row['message']."</p></div><br />";
if(!empty($row['image'])){
	echo "<div class='img-current'><img src='chat/".$row['image']."' class='inbox-message'></div>";
}
	}
	}
}
echo"<script>$('textarea').val('');</script>";
}
?>
<?php
}
mysqli_close($conn);
?>