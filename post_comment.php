<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}
elseif (!isset($_GET['mid'])) {
header('Location:home.php');
}elseif (is_numeric($_GET['mid'])) {
	header('Location:home.php');
}
else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
?>
<?php
include_once 'loginheader.php';
include_once 'count_replies.php';
?>
<style type="text/css">
	body{
		background-color:whitesmoke;
	}
</style>
<?php
$id=base64_decode($_GET['mid']);
$sql="SELECT * FROM user_post INNER JOIN artiste_info ON user_post.username=artiste_info.username WHERE user_post.post_day='$id' ";
$result=mysqli_query($conn,$sql);
while ($row=mysqli_fetch_assoc($result)) {
	$GLOBALS['postowner'] = $row['username'];
	if($row['profile_pic']==''){
      echo "<div style='margin-top:100px;'><img src='profilepic/default.jpg' id='comment_profile_pic'><span style='font-weight:bold; font-family:helvetica;'>".$row['username']."</span><p style='word-wrap:break-word; font-size:13px; margin-top:8px; font-family:helvetica; font-weight:400;'>".htmlspecialchars($row['caption'])."</p></div><hr style='clear:both;' />";
	}else{
   echo "<div style='margin-top:100px;'><img src='profilepic/".$row['profile_pic']."' id='comment_profile_pic'><span style='font-weight:bold; font-family:helvetica;'>".$row['username']."</span><p style='word-wrap:break-word; font-size:13px; margin-top:8px; font-family:helvetica; font-weight:400;'>".htmlspecialchars($row['caption'])."</p></div><hr style='clear:both;' />";
	}
}
?>
<div class='all' style='padding:4px 4px;'>
<?php
$id=base64_decode($_GET['mid']);
$sql2="SELECT * FROM comments INNER JOIN artiste_info ON comments.username=artiste_info.username WHERE comments.post_id='$id' ORDER BY comments.postid asc";
$result2=mysqli_query($conn,$sql2);
if(mysqli_num_rows($result2) > 0){
	while ($row=mysqli_fetch_assoc($result2)) {
		if($row['profile_pic']=='' && $row['username']==$_COOKIE['user']){
echo "<div id='".$row['postid']."' style='margin-top:10px; padding:4px 4px; '><img src='profilepic/default.jpg' id='comment_profile_pic_users'><a href='profile.php'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row['username']."</span></a><p style='word-wrap:break-word; clear:both; font-size:13px; margin-top:8px; font-family:helvetica; font-weight:400;'>".htmlspecialchars($row['post_comment'])."</p><form method='POST' class='ajax' action='deletecomment.php'>
<input type='hidden' name='getid' value='".base64_decode($_GET['mid'])."'>
<input type='hidden' name='comid' value='".$row['postid']."'><button type='submit' name='delete' style='background:none; cursor:pointer; border:none; float:right;'><i class='fa fa-trash' style='font-size:18px; color:red;'></i></button></form><span style='font-size:13px; margin-left:5px; color:lightgrey;'>".time_ago_in_php($row['day'])."</span>
<a style='color:black;'>".count_replies($row['postid'])."</a>
<form method='POST' action='reply.php' class='ajax'>
<input type='hidden' name='username'   value='".$_COOKIE['user']."'>
<input type='hidden' name='replied'   value='".$row['username']."'>
<input type='hidden' name='unique_id' value='".$row['postid']."'>
<input type='hidden' name='notid'    value='".$row['post_id']."'>
<textarea name='text' id='replyarea' placeholder='reply to ".$row['username']."\ncomment' style='resize:none; margin-top:5px;'></textarea>
<button type='submit' name='reply' style='padding:4px 4px; vertical-align:top; background:forestgreen; color:white; border:none; cursor:pointer; border:1px solid white; color:white; border-radius:5px;'>reply</button>
</form>";
$comid=$row['postid'];
echo "<div class='".$row['postid']."' style='margin-top:5px; margin-left:5px; padding:4px 4px;'>
";
$sql4="SELECT * FROM comment_replies INNER JOIN artiste_info ON comment_replies.username=artiste_info.username WHERE comment_replies.unique_id='$comid' ORDER BY comment_replies.replyid asc LIMIT 5;";
$result4=mysqli_query($conn,$sql4);
while($row4=mysqli_fetch_assoc($result4)){
if($row4['profile_pic']=='' && $row4['username']==$_COOKIE['user']){
echo "<img src='profilepic/default.jpg' id='comment_profile_pic_users'><a href='profile.php'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row4['username']."</span></a><p style='word-wrap:break-word; font-size:12px; margin-top:8px; font-family:helvetica; font-weight:400;'>".htmlspecialchars($row4['reply'])."</p>";
}elseif ($row4['profile_pic']!='' && $row4['username']==$_COOKIE['user']) {
	echo "<img src='profilepic/".$row4['profile_pic']."' id='comment_profile_pic_users'><a href='profile.php'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row4['username']."</span></a><p style='word-wrap:break-word; font-size:12px; margin-top:8px; font-family:helvetica; font-weight:400;'>".htmlspecialchars($row4['reply'])."</p>";
}elseif ($row4['profile_pic']=='' && $row4['username']!=$_COOKIE['user']) {
echo "<img src='profilepic/default.jpg' id='comment_profile_pic_users'><a href='info.php?id=".base64_encode($row4['username'])."'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row4['username']."</span></a><p style='word-wrap:break-word; font-size:12px; margin-top:8px; font-family:helvetica; font-weight:400;'>".htmlspecialchars($row4['reply'])."</p>";
}
elseif ($row4['profile_pic']!='' && $row4['username']!=$_COOKIE['user']) {
echo "<img src='profilepic/".$row4['profile_pic']."' id='comment_profile_pic_users'><a href='info.php?id=".base64_encode($row4['username'])."'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row4['username']."</span></a><p style='word-wrap:break-word; font-size:12px; margin-top:8px; font-family:helvetica; font-weight:400;'>".htmlspecialchars($row4['reply'])."</p>";
}
}"
</div>";
echo"</div><hr style='clear:both;' />";		
}elseif ($row['profile_pic']!='' && $row['username']==$_COOKIE['user']) {
		 echo "<div id='".$row['postid']."' style='margin-top:10px; padding:4px 4px; '><img src='profilepic/".$row['profile_pic']."' id='comment_profile_pic_users'><a href='profile.php'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row['username']."</span></a><p style='word-wrap:break-word; font-size:13px; margin-top:8px; font-family:helvetica; font-weight:400;'>".htmlspecialchars($row['post_comment'])."</p><form method='POST' class='ajax' action='deletecomment.php'>
		 <input type='hidden' name='getid' value='".base64_decode($_GET['mid'])."'>
		 <input type='hidden' name='comid' value='".$row['postid']."'><button type='submit' name='delete' style='background:none; cursor:pointer; border:none; float:right;'><i class='fa fa-trash' style='font-size:18px; color:red;'></i></button></form><span style='font-size:13px; margin-left:5px; color:lightgrey;'>".time_ago_in_php($row['day'])."</span>
		<a  style='color:black;'>".count_replies($row['postid'])."</a>
        <form method='POST' action='reply.php' class='ajax'>
<input type='hidden' name='username' value='".$_COOKIE['user']."'>
<input type='hidden' name='replied' value='".$row['username']."'>
<input type='hidden' name='unique_id' value='".$row['postid']."'>
<input type='hidden' name='notid'    value='".$row['post_id']."'>
<textarea name='text' id='replyarea' placeholder='reply to ".$row['username']."\ncomment' style='resize:none; margin-top:5px;'></textarea>
<button type='submit' name='reply' style='padding:4px 4px; vertical-align:top; background:forestgreen; color:white; border:none; border:1px solid white; cursor:pointer; color:white; border-radius:5px;'>reply</button>
</form>";
$comid=$row['postid'];
echo "<div class='".$row['postid']."' style='margin-top:5px; margin-left:5px; padding:4px 4px;'>
";
$sql4="SELECT * FROM comment_replies INNER JOIN artiste_info ON comment_replies.username=artiste_info.username WHERE comment_replies.unique_id='$comid'ORDER BY comment_replies.replyid asc LIMIT 5;";
$result4=mysqli_query($conn,$sql4);
while($row4=mysqli_fetch_assoc($result4)){
if($row4['profile_pic']=='' && $row4['username']==$_COOKIE['user']){
echo "<img src='profilepic/default.jpg' id='comment_profile_pic_users'><a href='profile.php'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row4['username']."</span></a><p style='word-wrap:break-word; font-size:12px; margin-top:8px; font-family:helvetica; font-weight:400;'>".$row4['reply']."</p>";
}elseif ($row4['profile_pic']!='' && $row4['username']==$_COOKIE['user']) {
	echo "<img src='profilepic/".$row4['profile_pic']."' id='comment_profile_pic_users'><a href='profile.php'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row4['username']."</span></a><p style='word-wrap:break-word; font-size:12px; margin-top:8px; font-family:helvetica; font-weight:400;'>".$row4['reply']."</p>";
}elseif ($row4['profile_pic']=='' && $row4['username']!=$_COOKIE['user']) {
echo "<img src='profilepic/default.jpg' id='comment_profile_pic_users'><a href='info.php?id=".base64_encode($row4['username'])."'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row4['username']."</span></a><p style='word-wrap:break-word; font-size:12px; margin-top:8px; font-family:helvetica; font-weight:400;'>".$row4['reply']."</p>";
}
elseif ($row4['profile_pic']!='' && $row4['username']!=$_COOKIE['user']) {
echo "<img src='profilepic/".$row4['profile_pic']."' id='comment_profile_pic_users'><a href='info.php?id=".base64_encode($row4['username'])."'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row4['username']."</span></a><p style='word-wrap:break-word; font-size:12px; margin-top:8px; font-family:helvetica; font-weight:400;'>".$row4['reply']."</p>";
}
}"
</div>";
echo"</div><hr style='clear:both;' />";		
}elseif ($row['profile_pic']=='' && $row['username']!=$_COOKIE['user']) {
			echo "<div  style='margin-top:10px; padding:4px 4px; '><img src='profilepic/default.jpg' id='comment_profile_pic_users'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row['username']."</span><p style='word-wrap:break-word; font-size:13px; margin-top:8px; font-family:helvetica; font-weight:400;'>".htmlspecialchars($row['post_comment'])."</p><span style='font-size:13px; margin-left:5px; color:lightgrey;'>".time_ago_in_php($row['day'])."</span>
			<a  style='color:black;'>".count_replies($row['postid'])."</a>
<form method='POST' action='reply.php' class='ajax'>
<input type='hidden' name='username' value='".$_COOKIE['user']."'>
<input type='hidden' name='replied' value='".$row['username']."'>
<input type='hidden' name='unique_id' value='".$row['postid']."'>
<input type='hidden' name='notid'    value='".$row['post_id']."'>
<textarea name='text' id='replyarea' placeholder='reply to ".$row['username']."\ncomment' style='resize:none; margin-top:5px;'></textarea>
<button type='submit' name='reply' style='padding:4px 4px; background:forestgreen; vertical-align:top; color:white; border:none; border:1px solid white; color:white; cursor:pointer; border-radius:5px;'>reply</button>
</form>";
$comid=$row['postid'];
echo "<div class='".$row['postid']."' style='margin-top:5px; margin-left:5px; padding:4px 4px;'>
";
$sql4="SELECT * FROM comment_replies INNER JOIN artiste_info ON comment_replies.username=artiste_info.username WHERE comment_replies.unique_id='$comid' ORDER BY comment_replies.replyid asc LIMIT 5;";
$result4=mysqli_query($conn,$sql4);
while($row4=mysqli_fetch_assoc($result4)){
if($row4['profile_pic']=='' && $row4['username']==$_COOKIE['user']){
echo "<img src='profilepic/default.jpg' id='comment_profile_pic_users'><a href='profile.php'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row4['username']."</span></a><p style='word-wrap:break-word; font-size:12px; margin-top:8px; font-family:helvetica; font-weight:400;'>".$row4['reply']."</p>";
}elseif ($row4['profile_pic']!='' && $row4['username']==$_COOKIE['user']) {
	echo "<img src='profilepic/".$row4['profile_pic']."' id='comment_profile_pic_users'><a href='profile.php'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row4['username']."</span></a><p style='word-wrap:break-word; font-size:12px; margin-top:8px; font-family:helvetica; font-weight:400;'>".$row4['reply']."</p>";
}elseif ($row4['profile_pic']=='' && $row4['username']!=$_COOKIE['user']) {
echo "<img src='profilepic/default.jpg' id='comment_profile_pic_users'><a href='info.php?id=".base64_encode($row4['username'])."'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row4['username']."</span></a><p style='word-wrap:break-word; font-size:12px; margin-top:8px; font-family:helvetica; font-weight:400;'>".$row4['reply']."</p>";
}
elseif ($row4['profile_pic']!='' && $row4['username']!=$_COOKIE['user']) {
echo "<img src='profilepic/".$row4['profile_pic']."' id='comment_profile_pic_users'><a href='info.php?id=".base64_encode($row4['username'])."'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row4['username']."</span></a><p style='word-wrap:break-word; font-size:12px; margin-top:8px; font-family:helvetica; font-weight:400;'>".$row4['reply']."</p>";
}
}"
</div>";
echo"</div><hr style='clear:both;' />";		
}else{
  echo "<div  style='margin-top:10px; padding:4px 4px; '><img src='profilepic/".$row['profile_pic']."' id='comment_profile_pic_users'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row['username']."</span><p style='word-wrap:break-word; font-size:13px; margin-top:8px; font-family:helvetica; font-weight:400;'>".htmlspecialchars($row['post_comment'])."</p><span style='font-size:13px; margin-left:5px; color:lightgrey;'>".time_ago_in_php($row['day'])."</span>
<a  style='color:black;'>".count_replies($row['postid'])."</a>
<form method='POST' action='reply.php' class='ajax'>
<input type='hidden' name='username' value='".$_COOKIE['user']."'>
<input type='hidden' name='replied' value='".$row['username']."'>
<input type='hidden' name='unique_id' value='".$row['postid']."'>
<input type='hidden' name='notid'    value='".$row['post_id']."'>
<textarea name='text' id='replyarea' placeholder='reply to ".$row['username']."\ncomment' style='resize:none; margin-top:5px;'></textarea>
<button type='submit' name='reply' style='padding:4px 4px; background:forestgreen; vertical-align:top; color:white; border:none; border:1px solid white; color:white; cursor:pointer; border-radius:5px;'>reply</button>
</form>";
$comid=$row['postid'];
echo "<div class='".$row['postid']."' style='margin-top:5px; margin-left:5px; padding:4px 4px;'>
";
$sql4="SELECT * FROM comment_replies INNER JOIN artiste_info ON comment_replies.username=artiste_info.username WHERE comment_replies.unique_id='$comid' ORDER BY comment_replies.replyid asc LIMIT 5;";
$result4=mysqli_query($conn,$sql4);
while($row4=mysqli_fetch_assoc($result4)){
if($row4['profile_pic']=='' && $row4['username']==$_COOKIE['user']){
echo "<img src='profilepic/default.jpg' id='comment_profile_pic_users'><a href='profile.php'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row4['username']."</span></a><p style='word-wrap:break-word; font-size:12px; margin-top:8px; font-family:helvetica; font-weight:400;'>".$row4['reply']."</p>";
}elseif ($row4['profile_pic']!='' && $row4['username']==$_COOKIE['user']) {
	echo "<img src='profilepic/".$row4['profile_pic']."' id='comment_profile_pic_users'><a href='profile.php'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row4['username']."</span></a><p style='word-wrap:break-word; font-size:12px; margin-top:8px; font-family:helvetica; font-weight:400;'>".$row4['reply']."</p>";
}elseif ($row4['profile_pic']=='' && $row4['username']!=$_COOKIE['user']) {
echo "<img src='profilepic/default.jpg' id='comment_profile_pic_users'><a href='info.php?id=".base64_encode($row4['username'])."'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row4['username']."</span></a><p style='word-wrap:break-word; font-size:12px; margin-top:8px; font-family:helvetica; font-weight:400;'>".$row4['reply']."</p>";
}
elseif ($row4['profile_pic']!='' && $row4['username']!=$_COOKIE['user']) {
echo "<img src='profilepic/".$row4['profile_pic']."' id='comment_profile_pic_users'><a href='info.php?id=".base64_encode($row4['username'])."'><span style='font-weight:bold; color:black; font-family:helvetica;'>".$row4['username']."</span></a><p style='word-wrap:break-word; font-size:12px; margin-top:8px; font-family:helvetica; font-weight:400;'>".$row4['reply']."</p>";
}
}"
</div>";
echo"</div><hr style='clear:both;' />";			
		}
	
	}
}else{
	echo "";
}
?>
</div>
<footer style=' width:100%;'>
<form method="POST" style='position:relative; margin-bottom:0px;' action='comment_post.php' class='ajax'>
	<textarea name='comment' id="replyarea" value='' style='resize:none; width:85%;  margin-bottom:0px;' placeholder='Comment as <?php echo $_COOKIE['user'];  ?>'></textarea>
	<input type='hidden' name='username' value='<?php echo $_COOKIE['user']; ?>'>
    <input type='hidden' name='post_id' value='<?php echo $id; ?>'>
    <input type='hidden' name='replied' id='replyinput' value=''>
    <input type='hidden' name='unique_id' id='unique_id' value=''>
    <input type='hidden' name='post_owner' value='<?php echo $GLOBALS['postowner'];  ?>'>
    <input type='hidden' name='day' value='<?php echo date('Y-m-d H:i:s');?>'>
	<button style='background:forestgreen; padding:2px 2px; vertical-align:top;' class='submit-comment-button' name='submit'>post</button>
</form>
<script type="text/javascript">
function reply(){
	alert("hey");

	
}
	$('form.ajax').on('submit' ,function(){
var that= $(this),
url= that.attr('action'),
type=that.attr('method'),
data={};
that.find('[name]').each(function(index, value){
	var that = $(this),
	  name=that.attr('name'),
	  value=that.val();
	  data[name]=value;

});
$.ajax({
	url:url,
	type:type,
	data:data,
	success:function(response){
    $(".all").prepend(response);
	}
});

return false;
});
	</script>
</footer>
<?php
mysqli_close($conn);
}
?>