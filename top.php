<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
?>
<?php
$sql="SELECT DISTINCT  username FROM user_post;";
$result=mysqli_query($conn,$sql);
while ($row=mysqli_fetch_assoc($result)) {
echo $row['username']."<br />";
}
?>

<?php
mysqli_close($conn);
}
?>