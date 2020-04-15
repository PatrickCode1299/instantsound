<?php
class checkoldnots{
var $owner;
function __construct($owner){
$owner=$this->owner;
}
function getoldnot(){
require 'db.php';
$owner=$this->owner;
$day=date('Y-m-d');
$getoldnot="SELECT * FROM notifications WHERE username='$owner'";
$findoldnot=mysqli_query($conn,$getoldnot);
while ($getallnot=mysqli_fetch_assoc($findoldnot)) {
	$clearoldnots="DELETE FROM notifications WHERE username='$owner' AND day !='$day'";
	$execute=$conn->query($clearoldnots);
}
}
}
?>
