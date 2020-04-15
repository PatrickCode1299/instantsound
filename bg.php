<?php
		if(isset($_POST['coverbg'])){
	$owner=htmlspecialchars($_POST['username']);
	$file = $_FILES['file'];
	$fileName = $_FILES['file']['name'];
	$flieType = $_FILES['file']['type'];
	$fileTmp = $_FILES['file']['tmp_name'];
	$fileError = $_FILES['file']['error'];
	$fileSize = $_FILES['file']['size'];
	$fileExt = explode('.', $fileName);
$fileActualExt = strtolower(end($fileExt));

$allowed = array('jpg', 'jpeg', 'JPG', 'png', 'gif' ,'PNG',);
if(in_array($fileActualExt, $allowed)){
if ($fileError ===0 ) {

if($fileSize < 1000000000){
$fileNameNew = uniqid('',true).".".$fileActualExt;
$fileDir = 'bg/'.$fileNameNew;
require 'db.php';
$sql = "SELECT * FROM artiste_info WHERE username='$owner'";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
	$sqlImg = "UPDATE artiste_info SET coverbg='$fileNameNew' WHERE username='$owner'";
	$result=mysqli_query($conn,$sqlImg);
	
	

}
	mysqli_close($conn);
move_uploaded_file($fileTmp, $fileDir);
echo "file upload sucess";
}else{

	echo "Your file is too big";
}
}else{
	echo"There was an error uploading your file";
}
}
header('Location:profile.php');
}
?>