<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
?>
<?php
include_once 'loginheader.php';
?><br /><br /><br /><br />
<h1 style="text-align:center; font-weight:400; font-size:20px; font-family:arial; background:black; border-radius:5px; padding:4px 4px; color:white;">TOP ARTISTS</h1>
<div class="top-artist-container">
<h1 style='text-align:center;'>COMING SOON</h1>
</div>
<?php
mysqli_close($conn);
}
?>
</body>
</html>