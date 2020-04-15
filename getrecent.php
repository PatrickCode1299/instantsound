<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
require 'db.php';
include_once 'timeago.php';
?>
<?php
$unique_id=$_POST['unique_id'];
$sql="SELECT * FROM chat INNER JOIN artiste_info ON chat.username=artiste_info.username WHERE chat.unique_id='$unique_id' AND status=0 ORDER BY chat.id desc LIMIT 1";
$result=mysqli_query($conn,$sql);
if($row=mysqli_fetch_assoc($result)){
	$person=$_COOKIE['user'];
	if($row['username']!=$person && $row['profile_pic']=='' && $row['image']=='' && $row['audio']=='' && $row['emoji']==''){
		echo "<div class='sender'><img src='profilepic/default.jpg' id='inbox-pic'><p id='inbox-message'>".$row['message']."</p><p style='text-align:right; clear:both; font-size:11px; font-weight:400; color:white;'>".time_ago_in_php($row['day'])."</p></div><br />";
	}elseif($row['username']!=$person && $row['profile_pic'] !='' && $row['image']=='' && $row['image1']=='' && $row['audio']=='' && $row['emoji']==''  ) {
	echo "<div class='sender'><img src='profilepic/".$row['profile_pic']."'  id='inbox-pic'><p id='inbox-message'>".$row['message']."</p><p style='text-align:right; clear:both; font-size:11px; font-weight:400; color:white;'>".time_ago_in_php($row['day'])."</p></div><br />";
	}elseif($row['username']!=$person && $row['profile_pic']=='' && $row['image'] !='' && $row['image1']=='' && $row['audio']=='' && $row['emoji']==''){
		echo "<div class='sender-img'><img src='chat/".$row['image']."' id='inbox-sent-image' style='display:block; width:100%; height:auto;'><p id='inbox-message'>".$row['message']."</p><p style='text-align:right; clear:both; font-size:11px; font-weight:400; color:white;'>".time_ago_in_php($row['day'])."</p></div><br />";
	}elseif($row['username']!=$person && $row['profile_pic'] !='' && $row['image'] !='' && $row['image1']=='' && $row['audio']=='' && $row['emoji']==''){
		echo "<div class='sender-img'><img src='chat/".$row['image']."' id='inbox-sent-image' style='display:block; width:100%; height:auto;'><p id='inbox-message'>".$row['message']."</p><p style='text-align:right; clear:both; font-size:11px; font-weight:400; color:white;'>".time_ago_in_php($row['day'])."</p></div><br />";
	}
	elseif($row['username']!=$person && $row['profile_pic']=='' && $row['image'] !='' && $row['image1']!='' && $row['audio']=='' && $row['emoji']==''){
		echo "<div style='float:right; background:yellow; width:300px; height:auto; margin-top:10px; padding:4px 4px; clear:both;'><div style='display:flex; flex-direction:row; flex-wrap:nowrap;'><img src='chat/".$row['image']."'  style='width:50%; height:10%;'><img src='chat/".$row['image1']."'  style='width:50%; height:10%;'></div><p id='inbox-message'>".$row['message']."</p><p style='text-align:right; clear:both; font-size:11px; font-weight:400; color:white;'>".time_ago_in_php($row['day'])."</p></div><br />";
	}elseif($row['username']!=$person && $row['profile_pic'] !='' && $row['image'] !='' && $row['image1']!='' && $row['audio']=='' && $row['emoji']==''){
		echo "<div style='float:right; background:yellow; width:300px; height:auto; margin-top:10px; padding:4px 4px; clear:both;'><div style='display:flex; flex-direction:row; flex-wrap:nowrap;'><img src='chat/".$row['image']."'  style='width:50%; height:10%;'><img src='chat/".$row['image1']."'  style='width:50%; height:10%;'></div><p id='inbox-message'>".$row['message']."</p><p style='text-align:right; clear:both; font-size:11px; font-weight:400; color:white;'>".time_ago_in_php($row['day'])."</p></div><br />";
	}
	elseif ($row['username'] !=$person && $row['profile_pic']=='' && $row['image']=='' && $row['audio'] !='' && $row['emoji']=='') {
				echo "";
	}elseif ($row['username'] !=$person && $row['profile_pic']!='' && $row['image']=='' && $row['audio'] !='' && $row['emoji']=='') {
		echo "";
	}elseif ($row['username'] !=$person && $row['profile_pic']=='' && $row['image']=='' && $row['audio'] =='' && $row['emoji']!='') {
		echo "<div class='sender'><img src='profilepic/default.jpg' id='inbox-pic'><img src='emoji/".$row['emoji']."' id='inbox-sent-image' style='display:block;'><p id='inbox-message'>".$row['message']."</p><p style='text-align:right; clear:both; font-size:11px; font-weight:400; color:white;'>".time_ago_in_php($row['day'])."</p></div><br />";
	}elseif ($row['username'] !=$person && $row['profile_pic']!='' && $row['image']=='' && $row['audio'] =='' && $row['emoji']!='') {
		echo "<div class='sender'><img src='profilepic/".$row['profile_pic']."'  id='inbox-pic'><img src='emoji/".$row['emoji']."' id='inbox-sent-image' style='display:block;'><p id='inbox-message'>".$row['message']."</p><p style='text-align:right; clear:both; font-size:11px; font-weight:400; color:white;'>".time_ago_in_php($row['day'])."</p></div><br />";
	}
}
?>
<?php
$username=$_COOKIE['user'];
$unique_id=$_POST['unique_id'];
$sql="UPDATE chat SET status=1 WHERE  unique_id='$unique_id' AND reciever='$username'";
$result=mysqli_query($conn,$sql);
?>
<?php
mysqli_close($conn);
}
?>