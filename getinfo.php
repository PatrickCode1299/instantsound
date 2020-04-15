<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
  header('Location:index.php');
}else{
date_default_timezone_set('Africa/Lagos');
include_once 'timeago.php';
include_once 'checkcount.php';
include_once 'commentcount.php';
include_once 'shares.php';
include_once 'streamcount.php';
require 'db.php';
?>
<?php
$username=$_COOKIE['user'];
$sql8="SELECT following FROM followership WHERE follower='$username' ORDER BY id asc";
$result8=mysqli_query($conn,$sql8);
if(mysqli_num_rows($result8) > 0){
while($row8=mysqli_fetch_assoc($result8)){
$following8=$row8['following'];
$sql9="SELECT * FROM user_post INNER JOIN artiste_info ON user_post.username=artiste_info.username WHERE user_post.username='$following8' OR user_post.status='sponsored' AND user_post.status !='shared' ORDER BY RAND();";
$result9=mysqli_query($conn,$sql9);
if(mysqli_num_rows($result9) > 0){

while($row9=mysqli_fetch_assoc($result9)){
if($row9['image']=='' && $row9['profile_pic']=='' && $row9['audio']=='' && $row9['colorbg']=='white'){
 echo "<div style='padding:5px 5px; margin-top:5px; background:grey; border-radius:5px; border:1px solid grey; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'><span style='margin-top:15px; display:block; font-weight:bold;'>".$row9['username']."</span></h3>
    <p style='word-wrap:break-word; color:white;'>".htmlspecialchars($row9['caption'])."</p>
   ";
   $user=$_COOKIE['user']; 
   $postid=$row9['post_day'];
    $sql5="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result5=mysqli_query($conn,$sql5); 
  if(mysqli_num_rows($result5)>0){
    echo " <form method='POST' id='".$row9['id']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
     <input type='hidden' name='changeid' value='".$row9['id']."'>
       <button  class='".$row9['userpostid']."'     type='submit' name='unlike' style='background:none; color:red; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'    style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row9['userpostid']."' action='like.php' class='ajax' id='".$row9['username']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
        <input type='hidden' name='changeid' value='".$row9['userpostid']."'>
     <button class='".$row9['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
    echo "<a href='post_comment.php?mid=".base64_encode($row9['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
     echo checkcount($row9['post_day']);
  echo commentcount($row9['post_day']);
  echo "<p style='font-size:10px; clear:both; color:lightgrey; font-weight:500;'>".time_ago_in_php($row9['post_day'])."</p>";
    echo"
    <form method='POST' style='margin-top:4px; margin-bottom:4px;' action='comment.php' class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row9['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row9['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
   }elseif ($row9['image']=='' && $row9['profile_pic']!='' && $row9['colorbg']=='white') {
       echo "<div style='padding:5px 5px; margin-top:5px; background:grey; border-radius:5px; border:1px solid grey; margin-left:4px; margin-right:4px;' >
    <h3><img src='profilepic/".$row9['profile_pic']."' id='post-profile-pic'><span style='margin-top:15px; display:block; font-weight:bold;'>".$row9['username']."</span></h3>
    <p style='word-wrap:break-word; color:white;'>".htmlspecialchars($row9['caption'])."</p>
    ";$user=$_COOKIE['user']; 
   $postid=$row9['post_day'];
  $sql5="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result5=mysqli_query($conn,$sql5); 
    if(mysqli_num_rows($result5)>0){
    echo " <form method='POST' id='".$row9['id']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
     <input type='hidden' name='changeid' value='".$row9['id']."'>
    <button  class='".$row9['userpostid']."'     type='submit' name='unlike' style='background:none; color:red; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'    style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row9['userpostid']."' action='like.php' class='ajax' id='".$row9['username']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
        <input type='hidden' name='changeid' value='".$row9['userpostid']."'>
     <button class='".$row9['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
   echo "<a href='post_comment.php?mid=".base64_encode($row9['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo checkcount($row9['post_day']);
  echo commentcount($row9['post_day']);
   echo "<p style='font-size:10px; clear:both; color:lightgrey; font-weight:500;'>".time_ago_in_php($row9['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row9['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row9['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
    elseif($row9['image']=='' && $row9['profile_pic']=='' && $row9['colorbg']=='lightblue'){
 echo "<div style='background:;padding:5px 5px; margin-top:5px; background:lightblue; border:1px solid white; margin-left:4px; border-radius:5px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/default.jpg' id='post-profile-pic'><span style='margin-top:15px; display:block; font-weight:bold;'>".$row9['username']."</span></h3>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row9['caption'])."</p>
   ";
   $user=$_COOKIE['user']; 
   $postid=$row9['post_day'];
   $sql5="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result5=mysqli_query($conn,$sql5); 
  if(mysqli_num_rows($result5)>0){
    echo " <form method='POST' id='".$row9['id']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
     <input type='hidden' name='changeid' value='".$row9['id']."'>
<button  class='".$row9['userpostid']."'     type='submit' name='unlike' style='background:none; color:red; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'    style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row9['userpostid']."' action='like.php' class='ajax' id='".$row9['username']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
        <input type='hidden' name='changeid' value='".$row9['userpostid']."'>
     <button class='".$row9['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
    echo "<a href='post_comment.php?mid=".base64_encode($row9['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
     echo checkcount($row9['post_day']);
  echo commentcount($row9['post_day']);
    echo "<p style='font-size:10px; clear:both; color:lightgrey; font-weight:500;'>".time_ago_in_php($row9['post_day'])."</p>";
    echo"
    <form method='POST' style='margin-top:4px; margin-bottom:4px;' action='comment.php' class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row9['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row9['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
   }elseif ($row9['image']=='' && $row9['profile_pic']!='' && $row9['colorbg']=='lightblue') {
       echo "<div style='background:;padding:5px 5px; margin-top:5px; background:lightblue; border:1px solid white; margin-left:4px; border-radius:5px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/".$row9['profile_pic']."' id='post-profile-pic'><span style='margin-top:15px; display:block; font-weight:bold;'>".$row9['username']."</span></h3>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row9['caption'])."</p>
    ";$user=$_COOKIE['user']; 
   $postid=$row9['post_day'];
     $sql5="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result5=mysqli_query($conn,$sql5); 
  if(mysqli_num_rows($result5)>0){
    echo " <form method='POST' id='".$row9['id']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
     <input type='hidden' name='changeid' value='".$row9['id']."'>
<button  class='".$row9['userpostid']."'     type='submit' name='unlike' style='background:none; color:red; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'    style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row9['userpostid']."' action='like.php' class='ajax' id='".$row9['username']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
        <input type='hidden' name='changeid' value='".$row9['userpostid']."'>
     <button class='".$row9['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row9['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo checkcount($row9['post_day']);
  echo commentcount($row9['post_day']);
    echo "<p style='font-size:10px; clear:both; color:lightgrey; font-weight:500;'>".time_ago_in_php($row9['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row9['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row9['username']."'>
    <button type='submit' name='submit' class='submit-comment-button' >Comment</button>
    </form>
    </div>";
    }
     elseif($row9['image']=='' && $row9['profile_pic']=='' && $row9['colorbg']=='gold'){
 echo "<div style='background:;padding:5px 5px; margin-top:5px; background:gold; border-radius:5px; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/default.jpg' id='post-profile-pic'><span style='margin-top:15px; color:white; display:block; font-weight:bold;'>".$row['username']."</span></h3>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row9['caption'])."</p>
   ";
   $user=$_COOKIE['user']; 
   $postid=$row9['post_day'];
    $sql5="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result5=mysqli_query($conn,$sql5); 
  if(mysqli_num_rows($result5)>0){
    echo " <form method='POST' id='".$row9['id']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
     <input type='hidden' name='changeid' value='".$row9['id']."'>
  <button  class='".$row9['userpostid']."'     type='submit' name='unlike' style='background:none; color:red; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'    style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row9['userpostid']."' action='like.php' class='ajax' id='".$row9['username']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
        <input type='hidden' name='changeid' value='".$row9['userpostid']."'>
     <button class='".$row9['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
     echo "<a href='post_comment.php?mid=".base64_encode($row9['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
     echo checkcount($row9['post_day']);
  echo commentcount($row9['post_day']);
  echo "<p style='font-size:10px; clear:both; color:lightgrey; font-weight:500;'>".time_ago_in_php($row9['post_day'])."</p>";
    echo"
    <form method='POST' style='margin-top:4px; margin-bottom:4px;' action='comment.php' class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row9['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row9['username']."'>
    <button type='submit' name='submit' class='submit-comment-button' style='background:white; border:none; color:black;'>Comment</button>
    </form>
    </div>";
   }elseif ($row9['image']=='' && $row9['profile_pic']!='' && $row9['colorbg']=='gold') {
       echo "<div style='background:;padding:5px 5px; margin-top:5px; background:gold; border-radius:5px; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/".$row9['profile_pic']."' id='post-profile-pic'><span style='margin-top:15px; color:white; display:block; font-weight:bold;'>".$row9['username']."</span></h3>
    <p style='word-wrap:break-word; font-family:AlexBrush-Regular; color:white;'>".htmlspecialchars($row9['caption'])."</p>
    ";$user=$_COOKIE['user']; 
   $postid=$row9['post_day'];
    $sql5="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result5=mysqli_query($conn,$sql5); 
  if(mysqli_num_rows($result5)>0){
    echo " <form method='POST' id='".$row9['id']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
     <input type='hidden' name='changeid' value='".$row9['id']."'>
<button  class='".$row9['userpostid']."'     type='submit' name='unlike' style='background:none; color:red; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'    style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row9['userpostid']."' action='like.php' class='ajax' id='".$row9['username']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
        <input type='hidden' name='changeid' value='".$row9['userpostid']."'>
     <button class='".$row9['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
   echo "<a href='post_comment.php?mid=".base64_encode($row9['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo checkcount($row9['post_day']);
  echo commentcount($row9['post_day']);
    echo "<p style='font-size:10px; clear:both; color:lightgrey; font-weight:500;'>".time_ago_in_php($row9['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row9['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button' style='background:white; border:none; color:black;'>Comment</button>
    </form>
    </div>";
    }
    elseif ($row9['image'] !='' && $row9['image1']=='' && $row9['profile_pic']=='' && $row9['audio']=='' && $row9['status'] !='shared') {
       echo "<div class='post-img-con'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'><span style='margin-top:15px; display:block; font-weight:bold;'>".$row9['username']."</span></h3>
    <img src='image/".$row9['image']."' style='width:100%; height:auto;'>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row9['caption'])."</p>
    
   ";
   $user=$_COOKIE['user']; 
   $postid=$row9['post_day'];
     $sql5="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result5=mysqli_query($conn,$sql5); 
  if(mysqli_num_rows($result5)>0){
    echo " <form method='POST' id='".$row9['id']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
     <input type='hidden' name='changeid' value='".$row9['id']."'>
<button  class='".$row9['userpostid']."'     type='submit' name='unlike' style='background:none; color:red; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'    style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row9['userpostid']."' action='like.php' class='ajax' id='".$row9['username']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
        <input type='hidden' name='changeid' value='".$row9['userpostid']."'>
     <button class='".$row9['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row9['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row9['post_day']);
  echo commentcount($row9['post_day']);
   echo "<p style='font-size:10px; margin-left:2px; clear:both; color:lightgrey; font-weight:500;'>".time_ago_in_php($row9['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row9['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row9['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
        elseif ($row9['image'] !='' && $row9['image1']=='' &&  $row9['profile_pic']!='' && $row9['audio']=='' && $row9['status'] !='shared') {
       echo "<div class='post-img-con'>
    <h3><img src='profilepic/".$row9['profile_pic']."' id='post-profile-pic'><span style='margin-top:15px; display:block; font-weight:bold;'>".$row9['username']."</span></h3>
    <img src='image/".$row9['image']."' style='width:100%; height:auto;'>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row9['caption'])."</p>
    
   ";
  $user=$_COOKIE['user']; 
   $postid=$row9['post_day'];
    $sql5="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result5=mysqli_query($conn,$sql5); 
  if(mysqli_num_rows($result5)>0){
    echo " <form method='POST' id='".$row9['id']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
     <input type='hidden' name='changeid' value='".$row9['id']."'>
  <button  class='".$row9['userpostid']."'     type='submit' name='unlike' style='background:none; color:red; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'    style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row9['userpostid']."' action='like.php' class='ajax' id='".$row9['username']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
        <input type='hidden' name='changeid' value='".$row9['userpostid']."'>
     <button class='".$row9['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row9['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row9['post_day']);
  echo commentcount($row9['post_day']);
    echo "<p style='font-size:10px; margin-left:2px; clear:both; color:lightgrey; font-weight:500;'>".time_ago_in_php($row9['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-left:4px; margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row9['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row9['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
    elseif($row9['image'] !='' && $row9['image1']!='' && $row9['profile_pic']=='' && $row9['audio']==''){
       echo "<div style='background:grey; border-radius:5px; border:1px solid grey; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'><span style='margin-top:15px; display:block; font-weight:bold;'>".$row9['username']."</span></h3>
    <div style='display:flex; flex-direction:row; flex-wrap:nowrap; flex-column-gap:20px;'><img src='image/".$row9['image']."' style='width:50%; height:10%;'>
    <img src='image/".$row9['image1']."' style='width:50%; height:10%;'></div>
    <p style='word-wrap:break-word; color:white;'>".htmlspecialchars($row9['caption'])."</p>

   ";
     $user=$_COOKIE['user']; 
   $postid=$row9['post_day'];
    $sql5="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result5=mysqli_query($conn,$sql5); 
  if(mysqli_num_rows($result5)>0){
    echo " <form method='POST' id='".$row9['id']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
     <input type='hidden' name='changeid' value='".$row9['id']."'>
<button  class='".$row9['userpostid']."'     type='submit' name='unlike' style='background:none; color:red; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'    style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row9['userpostid']."' action='like.php' class='ajax' id='".$row9['username']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
        <input type='hidden' name='changeid' value='".$row9['userpostid']."'>
     <button class='".$row9['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row9['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row9['post_day']);
  echo commentcount($row9['post_day']);
    echo "<p style='font-size:10px; clear:both; color:lightgrey; font-weight:500;'>".time_ago_in_php($row9['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row9['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
      elseif($row9['image'] !='' && $row9['image1']!='' && $row9['profile_pic']!='' && $row9['audio']==''){
       echo "<div style='background:grey; border-radius:5px; border:1px solid grey; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/".$row9['profile_pic']."' id='post-profile-pic'><span style='margin-top:15px; display:block; font-weight:bold;'>".$row9['username']."</span></h3>
     <div style='display:flex; flex-direction:row; flex-wrap:nowrap; flex-column-gap:20px;'><img src='image/".$row9['image']."' style='width:50%; height:10%;'>
    <img src='image/".$row9['image1']."' style='width:50%; height:10%'></div>
    <p style='word-wrap:break-word; color:white;'>".htmlspecialchars($row9['caption'])."</p>
    
   ";
     $user=$_COOKIE['user']; 
   $postid=$row9['post_day'];
   $sql5="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result5=mysqli_query($conn,$sql5); 
    if(mysqli_num_rows($result5)>0){
    echo " <form method='POST' id='".$row9['id']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
     <input type='hidden' name='changeid' value='".$row9['id']."'>
<button  class='".$row9['userpostid']."'     type='submit' name='unlike' style='background:none; color:red; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'    style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row9['userpostid']."' action='like.php' class='ajax' id='".$row9['username']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
        <input type='hidden' name='changeid' value='".$row9['userpostid']."'>
     <button class='".$row9['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row9['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row9['post_day']);
  echo commentcount($row9['post_day']);
  echo "<p style='font-size:10px; clear:both; color:lightgrey; font-weight:500;'>".time_ago_in_php($row9['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row9['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row9['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
    elseif ($row9['image'] !='' && $row9['audio']!='' && $row9['profile_pic']=='') {
       echo "<div style='padding:5px 5px; margin-top:5px; position:relative; background:grey; border-radius:5px; border:1px solid grey; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'><span style='margin-top:15px; display:block; font-weight:bold;'>".$row9['username']."</span></h3>
     <div style=' box-sizing:border-box;  opacity:0.8; width:100%;  background:black; height:auto;'>
<p id='songname' style='text-align:center;  word-wrap:break-word;    color:white; '>".htmlspecialchars($row9['caption'])."</p>
<center><img src='image/".$row9['image']."'  style='width:100px; margin:0px auto; border:2px solid white; border-radius:50%;  height:100px; '></center><br />
 <audio id='songelement' value=".$row9['id']." onmouseover='streamcount()' style='width:100%;' controls>
    <source src='audio/".$row9['audio']."' type='audio/mpeg'>
    <source src='audio/".$row9['audio']."' type='audio/ogg'>
    </audio>
   </div>
    <br />
    <br />
   
    ";
   $user=$_COOKIE['user']; 
   $postid=$row9['post_day'];
   $sql5="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result5=mysqli_query($conn,$sql5); 
  if(mysqli_num_rows($result5)>0){
    echo " <form method='POST' id='".$row9['id']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
     <input type='hidden' name='changeid' value='".$row9['id']."'>
    <button  class='".$row9['userpostid']."'     type='submit' name='unlike' style='background:none; color:red; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'    style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row9['userpostid']."' action='like.php' class='ajax' id='".$row9['username']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
        <input type='hidden' name='changeid' value='".$row9['userpostid']."'>
     <button class='".$row9['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
    echo "<a href='post_comment.php?mid=".base64_encode($row9['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo "<form method='POST' action='repost.php' class='ajax'>
    <input type='hidden' name='realowner' value='".$row9['username']."'>
    <input type='hidden' name='reposter' value='".$_COOKIE['user']."'>
    <input type='hidden' name='content' value='".$row9['caption']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='image' value='".$row9['image']."'>
  <button type='submit' id='retweet-button' name='repost'><i class='fa fa-paper-plane' style='font-size:18px; color:black;'></i></button>
    </form>";
     echo checkcount($row9['post_day']);
  echo commentcount($row9['post_day']);
  echo shares($row9['post_day']);
  echo streamcount($row9['audio']);
     echo "<p style='font-size:10px; clear:both; color:lightgrey; font-weight:500;'>".time_ago_in_php($row9['post_day'])."</p>";
    echo"
    <form method='POST' style='margin-top:4px; margin-bottom:4px;' action='comment.php' class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row9['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row9['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
     elseif ($row9['image'] !='' && $row9['audio']!='' && $row9['profile_pic']!='') {
       echo "<div style='padding:5px 5px; margin-top:5px;  position:relative;  background:grey; border-radius:5px; border:1px solid grey; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/".$row9['profile_pic']."' id='post-profile-pic'><span style='margin-top:15px; display:block; font-weight:bold;'>".$row9['username']." (Audio)</span></h3>
         <div style=' box-sizing:border-box;  opacity:0.8; width:100%;  background:black; height:auto;'>
<p id='songname' style='text-align:center;  word-wrap:break-word;    color:white; '>".htmlspecialchars($row9['caption'])."</p>
<center><img src='image/".$row9['image']."'  style='width:100px; margin:0px auto; border:2px solid white; border-radius:50%;  height:100px; '></center><br />
 <audio id='songelement' value=".$row9['id']." onmouseover='streamcount()' style='width:100%;' controls>
    <source src='audio/".$row9['audio']."' type='audio/mpeg'>
    <source src='audio/".$row9['audio']."' type='audio/ogg'>
    </audio>
   </div>
    <br />
    <br />
   
    ";
   $user=$_COOKIE['user']; 
   $postid=$row9['post_day'];
   $sql5="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result5=mysqli_query($conn,$sql5); 
  if(mysqli_num_rows($result5)>0){
    echo " <form method='POST' id='".$row9['id']."' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
     <input type='hidden' name='changeid' value='".$row9['id']."'>
    <button  class='".$row9['userpostid']."'     type='submit' name='unlike' style='background:none; color:red; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'    style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row9['userpostid']."' action='like.php' class='ajax' id='".$row9['username']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row9['post_day']."'>
        <input type='hidden' name='changeid' value='".$row9['userpostid']."'>
     <button class='".$row9['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
    echo "<a href='post_comment.php?mid=".base64_encode($row9['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo "<form method='POST' action='repost.php' class='ajax'>
    <input type='hidden' name='realowner' value='".$row9['username']."'>
    <input type='hidden' name='reposter' value='".$_COOKIE['user']."'>
    <input type='hidden' name='content' value='".$row9['caption']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='image' value='".$row9['image']."'>
  <button type='submit' id='retweet-button' name='repost'><i class='fa fa-paper-plane' style='font-size:18px; color:black;'></i></button>
    </form>";
     echo checkcount($row9['post_day']);
  echo commentcount($row9['post_day']);
  echo shares($row9['post_day']);
  echo streamcount($row9['audio']);
       echo "<p style='font-size:10px; clear:both; color:lightgrey; font-weight:500;'>".time_ago_in_php($row9['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row9['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d h:i:s')."'>
    <input type='hidden' name='post_owner' value='".$row9['username']."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
  
    }
    elseif ($row9['profile_pic']=='' && $row9['image'] !='' && $row9['audio']=='' && $row9['status']=='sponsored') {
echo "<div style='background:white; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><span class='name-font' style='margin-top:15px; color:black; display:block; font-weight:bold;'>".$row['username']."</span></h3>
    <span style='display:block; font-size:13px; color:lightgrey; margin-top:0px;'>sponsored</span>
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
        <button  class='".$row['userpostid']."'     type='submit' name='unlike' style='background:none; color:red; border:none; float:left; cursor:pointer; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'    style='font-size:18px;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row['userpostid']."' action='like.php' class='ajax' >
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo checkcount($row['post_day']);
    echo"
    </div>";
}

}
}
}
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