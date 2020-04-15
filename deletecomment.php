<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
?>
<?php
$comid=$_POST['comid'];
$unid=$_POST['getid'];
$loginuser=$_COOKIE['user'];
$sql="DELETE FROM comments WHERE postid='$comid'";
$result=mysqli_query($conn,$sql);
$sql2="DELETE FROM notifications WHERE sender='$loginuser' AND unique_id='$unid' AND location='comments';";
$result2=mysqli_query($conn,$sql2);

echo "<script>
$('#$comid').css('display','none');
</script>";
?>
<?php
mysqli_close($conn);
}
?>