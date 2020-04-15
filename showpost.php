<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
?>
<?php
include_once 'loginheader.php';
include_once 'checkcount.php';
include_once 'commentcount.php';
include_once 'shares.php';
?><br /><br /><br /><br /><br />
<?php
$sid=base64_decode($_GET['sid']);
$sql="SELECT * FROM user_post INNER JOIN artiste_info ON user_post.username=artiste_info.username WHERE user_post.username='$sid' AND artiste_info.username='$sid' ORDER BY user_post.userpostid desc LIMIT 5";
$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
	  echo "<div class='post-area' id='postarea'>";
	if($row['image']=='' && $row['profile_pic']=='' && $row['audio']=='' && $row['colorbg']=='white'){
 echo "<div style='background:;padding:5px 5px; margin-top:5px; background:white; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span></h3>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
   ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
     if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' id='".$row['userpostid']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'  class='".$row['userpostid']."' id='unlikebutton' style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row['userpostid']."' action='like.php' class='ajax' >
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
    echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
     echo checkcount($row['post_day']);
  echo commentcount($row['post_day'])."<br />";
  echo "<span style='font-size:10px; display:block; clear:both; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</span>";
    echo"
    <form method='POST' style='margin-top:4px; margin-bottom:4px;' action='comment.php' class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
   }elseif ($row['image']=='' && $row['profile_pic']!='' && $row['colorbg']=='white') {
       echo "<div style='background:;padding:5px 5px; margin-top:5px; background:white; border:1px solid white; margin-left:4px; margin-right:4px;' >
    <h3><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span></h3>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
  
    ";$user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
  if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' id='".$row['userpostid']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'  class='".$row['userpostid']."' id='unlikebutton' style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row['userpostid']."' action='like.php' class='ajax' >
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
   echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo checkcount($row['post_day']);
  echo commentcount($row['post_day'])."<br />";
  echo "<span style='font-size:10px; display:block; clear:both; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</span>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
    elseif($row['image']=='' && $row['profile_pic']=='' && $row['colorbg']=='lightblue'){
 echo "<div style='background:;padding:5px 5px; margin-top:5px; background:lightblue; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span></h3>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>

   ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
  if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' id='".$row['userpostid']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'  class='".$row['userpostid']."' id='unlikebutton' style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row['userpostid']."' action='like.php' class='ajax' >
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
    echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
     echo checkcount($row['post_day']);
  echo commentcount($row['post_day'])."<br />";
  echo "<span style='font-size:10px; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</span>";
    echo"
    <form method='POST' style='margin-top:4px; margin-bottom:4px;' action='comment.php' class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
   }elseif ($row['image']=='' && $row['profile_pic']!='' && $row['colorbg']=='lightblue') {
       echo "<div style='background:;padding:5px 5px; margin-top:5px; background:lightblue; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span></h3>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
    ";$user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
   if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' id='".$row['userpostid']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'  class='".$row['userpostid']."' id='unlikebutton' style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row['userpostid']."' action='like.php' class='ajax' >
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo checkcount($row['post_day']);
    echo commentcount($row['post_day'])."<br />";
  echo "<span style='font-size:10px; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</span>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
   <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row['username']."'>
    <button type='submit' name='submit' class='submit-comment-button' >Comment</button>
    </form>
    </div>";
    }
     elseif($row['image']=='' && $row['profile_pic']=='' && $row['colorbg']=='gold'){
 echo "<div style='background:;padding:5px 5px; margin-top:5px; background:gold; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; color:white; display:block; font-weight:bold;'>".$row['username']."</span></h3>
    <p style='word-wrap:break-word; color:black;'>".htmlspecialchars($row['caption'])."</p>
   ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
   if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' id='".$row['userpostid']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'  class='".$row['userpostid']."' id='unlikebutton' style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row['userpostid']."' action='like.php' class='ajax' >
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
     echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
     echo checkcount($row['post_day']);
  echo commentcount($row['post_day'])."<br />";
  echo "<span style='font-size:10px; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</span>";
  echo "<span style='font-size:10px; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</span>";
    echo"
    <form method='POST' style='margin-top:4px; margin-bottom:4px;' action='comment.php' class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row['username']."'>
    <button type='submit' name='submit' class='submit-comment-button' style='background:white; border:none; color:black;'>Comment</button>
    </form>
    </div>";
   }elseif ($row['image']=='' && $row['profile_pic']!='' && $row['colorbg']=='gold') {
       echo "<div style='background:;padding:5px 5px; margin-top:5px; background:gold; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; color:white; display:block; font-weight:bold;'>".$row['username']."</span></h3>
    <p style='word-wrap:break-word; font-family:AlexBrush-Regular; color:black; font-size:20px;'>".htmlspecialchars($row['caption'])."</p>
    ";$user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
         if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' id='".$row['userpostid']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'  class='".$row['userpostid']."' id='unlikebutton' style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row['userpostid']."' action='like.php' class='ajax' >
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
   echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo checkcount($row['post_day']);
    echo commentcount($row['post_day'])."<br />";
  echo "<span style='font-size:10px; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</span>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row['username']."'>
    <button type='submit' name='submit' class='submit-comment-button' style='background:white; border:none; color:black;'>Comment</button>
    </form>
    </div>";
    }
     elseif ($row['image'] !='' && $row['image1']=='' && $row['profile_pic']=='' && $row['audio']=='') {
       echo "<div style='background:white; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; color:black; display:block; font-weight:bold;'>".$row['username']."</span></h3>
    <img src='image/".$row['image']."' style='width:100%; height:auto;'>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
    <span style='font-size:10px; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</span>
   ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
       if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' id='".$row['userpostid']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'  class='".$row['userpostid']."' id='unlikebutton' style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row['userpostid']."' action='like.php' class='ajax' >
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
        elseif ($row['image'] !='' && $row['image1']=='' && $row['profile_pic']!='' && $row['audio']=='') {
       echo "<div style='background:white; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; color:black; display:block; font-weight:bold;'>".$row['username']."</span></h3>
    <img src='image/".$row['image']."' style='width:100%; height:auto;'>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
    <span style='font-size:10px; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</span>
   ";
  $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
  if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' id='".$row['userpostid']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'  class='".$row['userpostid']."' id='unlikebutton' style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row['userpostid']."' action='like.php' class='ajax' >
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
   <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
    elseif($row['image'] !='' && $row['image1']!='' && $row['profile_pic']=='' && $row['audio']==''){
       echo "<div style='background:white; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; color:black; display:block; font-weight:bold;'>".$row['username']."</span></h3>
    <div style='display:flex; flex-direction:row; flex-wrap:nowrap; flex-column-gap:20px;'><img src='image/".$row['image']."' style='width:50%; height:50%;'>
    <img src='image/".$row['image1']."' style='width:50%; height:50%;'></div>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
    <span style='font-size:10px; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</span>
   ";
     $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
     if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' id='".$row['userpostid']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'  class='".$row['userpostid']."' id='unlikebutton' style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row['userpostid']."' action='like.php' class='ajax' >
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
      elseif($row['image'] !='' && $row['image1']!='' && $row['profile_pic']!='' && $row['audio']==''){
       echo "<div style='background:white; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; color:black; display:block; font-weight:bold;'>".$row['username']."</span></h3>
     <div style='display:flex; flex-direction:row; flex-wrap:nowrap; flex-column-gap:20px;'><img src='image/".$row['image']."' style='width:50%; height:50%;'>
    <img src='image/".$row['image1']."' style='width:50%; height:50%;'></div>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
    <span style='font-size:10px; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</span>
   ";
     $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
  if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' id='".$row['userpostid']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'  class='".$row['userpostid']."' id='unlikebutton' style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row['userpostid']."' action='like.php' class='ajax' >
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d h:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
    elseif ($row['image'] !='' && $row['audio']!='' && $row['status']!='shared' && $row['profile_pic']=='') {
       echo "<div style='background:;padding:5px 5px; margin-top:5px; background:white; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'><span style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span></h3>
    <p style='word-wrap:break-word;'>".$row['caption']."</p>
       <img src='image/".$row['image']."'style='width:100%; height:auto; '><br />
    <audio id='songelement' value='".$row['id']."'  onmouseover='streamcount()' style='width:100%;' controls  loop>
    <source src='audio/".$row['audio']."' type='audio/mpeg'>
    <source src='audio/".$row['audio']."' type='audio/ogg'>
    </audio><br />
    <span id='streamholder' style='font-size:15px; color:lightgrey; font-weight:500;'>".$row['streams']."streams</span><br />
    ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
  if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' id='".$row['userpostid']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'  class='".$row['userpostid']."' id='unlikebutton' style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row['userpostid']."' action='like.php' class='ajax' >
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
    echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo "<form method='POST' action='repost.php' class='ajax'>
    <input type='hidden' name='realowner' value='".$row['username']."'>
    <input type='hidden' name='reposter' value='".$_COOKIE['user']."'>
    <input type='hidden' name='content' value='".$row['caption']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='image' value='".$row['image']."'>
  <button type='submit' id='retweet-button' name='repost'><i class='fa fa-paper-plane style='font-size:18px; color:black;'></i></button>
    </form>";
     echo checkcount($row['post_day']);
  echo commentcount($row['post_day'])."<br />";
  echo "<span style='font-size:10px; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</span>";
  echo shares($row['post_day']);

    echo"
    <form method='POST' style='margin-top:4px; margin-bottom:4px;' action='comment.php' class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
     elseif ($row['image'] !='' && $row['audio']!='' && $row['status']!='shared' && $row['profile_pic']!='') {
       echo "<div style='padding:5px 5px; margin-top:5px; background:white;  border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']." (Audio)</span></h3>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
    <img src='image/".$row['image']."'style='width:100%; height:auto; '><br />
    <audio id='songelement' value='".$row['id']."' onmouseover='streamcount()' style='width:100%;' controls  loop>
    <source src='audio/".$row['audio']."' type='audio/mpeg'>
    <source src='audio/".$row['audio']."' type='audio/ogg'>
    </audio><br />
    <br />
    ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
    if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' id='".$row['userpostid']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'  class='".$row['userpostid']."' id='unlikebutton' style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row['userpostid']."' action='like.php' class='ajax' >
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
   echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo "<form method='POST' action='repost.php' class='ajax'>
    <input type='hidden' name='realowner' value='".$row['username']."'>
    <input type='hidden' name='reposter' value='".$_COOKIE['user']."'>
    <input type='hidden' name='content' value='".$row['caption']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='image' value='".$row['image']."'>
    <input type='hidden' name='unique_id' value='".$row['post_day']."'>
    <input type='hidden' name='audio' value='".$row['audio']."'>
  <button type='submit' id='retweet-button' name='repost'><i class='fa fa-paper-plane' style='font-size:18px; color:black;'></i></button>
    </form>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day'])."<br />";
  echo "<span style='font-size:10px; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</span>";
  echo shares($row['post_day']);
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
  
    }
    elseif ($row['image'] !='' && $row['audio']!='' && $row['status']=='shared' && $row['profile_pic']=='') {
       echo "<div style='background:;padding:5px 5px; margin-top:5px; background:white; border:1px solid white; margin-left:4px; margin-right:4px;'>
     <h3 style='background:none;'><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['sharer']." (Shared Audio)</span></h3>
    <h3>".$row['username']."</h3>
    <p style='word-wrap:break-word;'>".$row['caption']."</p>
       <img src='image/".$row['image']."'style='width:100%; height:auto; '><br />
    <audio id='songelement' value='".$row['id']."'  onmouseover='streamcount()' style='width:100%;' controls  loop>
    <source src='audio/".$row['audio']."' type='audio/mpeg'>
    <source src='audio/".$row['audio']."' type='audio/ogg'>
    </audio><br />
    <span id='streamholder' style='font-size:15px; color:lightgrey; font-weight:500;'>".$row['streams']."streams</span><br />
    ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
   if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' id='".$row['userpostid']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'  class='".$row['userpostid']."' id='unlikebutton' style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row['userpostid']."' action='like.php' class='ajax' >
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
    echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo "<form method='POST' action='repost.php' class='ajax'>
    <input type='hidden' name='realowner' value='".$row['username']."'>
    <input type='hidden' name='reposter' value='".$_COOKIE['user']."'>
    <input type='hidden' name='content' value='".$row['caption']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='image' value='".$row['image']."'>
  <button type='submit' id='retweet-button' name='repost'><i class='fa fa-retweet' style='font-size:18px; color:black;'></i></button>
    </form>";
     echo checkcount($row['post_day']);
  echo commentcount($row['post_day'])."<br />";
  echo "<span style='font-size:10px; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</span>";
  echo shares($row['post_day']);

    echo"
    <form method='POST' style='margin-top:4px; margin-bottom:4px;' action='comment.php' class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
     elseif ($row['image'] !='' && $row['audio']!='' && $row['status']=='shared' && $row['profile_pic']!='') {
       echo "<div style='padding:5px 5px; margin-top:5px; background:white;  border:1px solid white; margin-left:4px; margin-right:4px;'>
     <h3 style='background:none;'><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['sharer']." (Shared Audio)</span></h3>
    <h3>".$row['username']."</h3>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
    <img src='image/".$row['image']."'style='width:100%; height:auto; '><br />
    <audio id='songelement' value='".$row['userpostid']."' onmouseover='streamcount()' style='width:100%;' controls  loop>
    <source src='audio/".$row['audio']."' type='audio/mpeg'>
    <source src='audio/".$row['audio']."' type='audio/ogg'>
    </audio><br />
   <br />
    ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
   if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' id='".$row['userpostid']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'  class='".$row['userpostid']."' id='unlikebutton' style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row['userpostid']."' action='like.php' class='ajax' >
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
   echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo "<form method='POST' action='repost.php' class='ajax'>
    <input type='hidden' name='realowner' value='".$row['username']."'>
    <input type='hidden' name='reposter' value='".$_COOKIE['user']."'>
    <input type='hidden' name='content' value='".$row['caption']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='image' value='".$row['image']."'>
    <input type='hidden' name='unique_id' value='".$row['post_day']."'>
    <input type='hidden' name='audio' value='".$row['audio']."'>
  <button type='submit' id='retweet-button' name='repost'><i class='fa fa-retweet' style='font-size:18px; color:black;'></i></button>
    </form>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day'])."<br />";
  echo "<span style='font-size:10px; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</span>";
  echo shares($row['post_day']);
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
  
    }
  echo "</div>";
}
?>
<script type="text/javascript">
$('form.ajax').on('submit' ,function(e){
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
e.stopImmediatePropagation();
$.ajax({
  url:url,
  type:type,
  data:data,
  success:function(response){
    $("body").append(response);
  }
});

return false;
});
</script>
<?php
mysqli_close($conn);
}
?>
</body>
</html>