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
include_once 'streamcount.php';
?><br /><br /><br />
<?php
$username=$_COOKIE['user'];
$sql1="SELECT following FROM followership WHERE follower='$username' AND following !='Superuser' ORDER BY  RAND();";
$result1=mysqli_query($conn,$sql1);
if(mysqli_num_rows($result1) > 0){
while($row=mysqli_fetch_assoc($result1)){
$following=$row['following'];
$sql3="SELECT * FROM user_post INNER JOIN artiste_info ON user_post.username=artiste_info.username WHERE user_post.username='$following' OR user_post.sharer='$following' OR user_post.status='sponsored' ORDER BY  user_post.userpostid desc LIMIT 1 ";
$result3=mysqli_query($conn,$sql3);
if(mysqli_num_rows($result3) > 0){

while($row=mysqli_fetch_assoc($result3)){
  echo "<div class='post-area' id='postarea'>";
if($row['image']=='' && $row['profile_pic']=='' && $row['audio']=='' && $row['colorbg']=='white'){
 echo "<div style='padding:5px 5px; margin-top:5px; background:grey; border-radius:5px; border:1px solid grey; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span></h3>
    <p style='word-wrap:break-word; color:white;'>".htmlspecialchars($row['caption'])."</p>
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
    echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
     echo checkcount($row['post_day']);
  echo commentcount($row['post_day'])."<br />";
  echo "<p style='font-size:10px; clear:both; display:block; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
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
       echo "<div style='background:;padding:5px 5px; margin-top:5px; background:grey; border-radius:5px; border:1px solid grey;  margin-left:4px; margin-right:4px;' >
    <h3><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span></h3>
    <p style='word-wrap:break-word; color:white;'>".htmlspecialchars($row['caption'])."</p>
  
    ";$user=$_COOKIE['user']; 
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
   echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo checkcount($row['post_day']);
  echo commentcount($row['post_day'])."<br />";
   echo "<p style='font-size:10px; clear:both; display:block; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
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
 echo "<div style='background:;padding:5px 5px; margin-top:5px; background:lightblue; border-radius:5px; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span></h3>
    <p style='word-wrap:break-word; '>".htmlspecialchars($row['caption'])."</p>

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
    echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
     echo checkcount($row['post_day']);
  echo commentcount($row['post_day'])."<br />";
  echo "<p style='font-size:10px; clear:both; display:block; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
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
       echo "<div style='background:;padding:5px 5px; margin-top:5px; background:lightblue; border-radius:5px; border:1px solid white; margin-left:4px; margin-right:4px;'>
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
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo checkcount($row['post_day']);
    echo commentcount($row['post_day'])."<br />";
  echo "<p style='font-size:10px; clear:both; display:block; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
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
 echo "<div style='background:;padding:5px 5px; margin-top:5px; background:gold; border-radius:5px; border:1px solid white; margin-left:4px; margin-right:4px;'>
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
     echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
     echo checkcount($row['post_day']);
  echo commentcount($row['post_day'])."<br />";
  echo "<p style='font-size:10px; clear:both; display:block; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
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
       echo "<div style='background:;padding:5px 5px; margin-top:5px; background:gold; border-radius:5px; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; color:black; display:block; font-weight:bold;'>".$row['username']."</span></h3>
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
   echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo checkcount($row['post_day']);
    echo commentcount($row['post_day'])."<br />";
  echo "<p style='font-size:10px; clear:both; display:block; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
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
     elseif ($row['image'] !='' && $row['image1']=='' && $row['status'] !='shared' && $row['profile_pic']=='' && $row['audio']=='') {
       echo "<div style='background:grey; border:1px solid grey; border-radius:5px; padding:5px 5px;  margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; color:black; display:block; font-weight:bold;'>".$row['username']."</span></h3>
    <img src='image/".$row['image']."' style='width:100%; height:auto;'>
    <p style='word-wrap:break-word; color:white;'>".htmlspecialchars($row['caption'])."</p>

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
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
    echo "<p style='font-size:10px; clear:both; display:block; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
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
        elseif ($row['image'] !='' && $row['image1']=='' && $row['status'] !='shared' && $row['profile_pic']!='' && $row['audio']=='') {
       echo "<div style='background:grey; border:1px solid grey; border-radius:5px; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; color:black; display:block; font-weight:bold;'>".$row['username']."</span></h3>
    <img src='image/".$row['image']."' style='width:100%; height:auto; '>
    <p style='word-wrap:break-word; color:white;'>".htmlspecialchars($row['caption'])."</p>
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
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
    echo "<p style='font-size:10px; clear:both; display:block; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
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
       echo "<div style='background:grey; border:1px solid grey; border-radius:5px; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; color:black; display:block; font-weight:bold;'>".$row['username']."</span></h3>
    <div style='display:flex; flex-direction:row; flex-wrap:nowrap; flex-column-gap:20px;'><img src='image/".$row['image']."' style='width:50%; height:50%;'>
    <img src='image/".$row['image1']."' style='width:50%; height:50%;'></div>
    <p style='word-wrap:break-word; color:white;'>".htmlspecialchars($row['caption'])."</p>
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
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
    echo "<p style='font-size:10px; clear:both; display:block; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
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
       echo "<div style='background:grey; border:1px solid grey; border-radius:5px; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; color:black; display:block; font-weight:bold;'>".$row['username']."</span></h3>
     <div style='display:flex; flex-direction:row; flex-wrap:nowrap; flex-column-gap:20px;'><img src='image/".$row['image']."' style='width:50%; height:50%;'>
    <img src='image/".$row['image1']."' style='width:50%; height:50%;'></div>
    <p style='word-wrap:break-word; color:white;'>".htmlspecialchars($row['caption'])."</p>
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
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
    echo "<p style='font-size:10px; clear:both; display:block; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
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
    elseif ($row['image'] !='' && $row['audio']!='' && $row['status']!='shared' && $row['profile_pic']=='') {
       echo "<div style='padding:5px 5px; margin-top:5px; background:grey; border:1px solid grey; border-radius:5px; position:relative;  border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'><span style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span></h3>
     <div style=' box-sizing:border-box;  opacity:0.8; width:100%;  background:black; height:auto;'>
<p id='songname' style='text-align:center;  word-wrap:break-word;    color:white; '>".htmlspecialchars($row['caption'])."</p>
<center><img src='image/".$row['image']."'  style='width:100px; margin:0px auto; border:2px solid white; border-radius:50%;  height:100px; '></center><br />
   <audio id='songelement' value=".$row['id']." onmouseover='streamcount()' style='width:100%;' controls>
    <source src='audio/".$row['audio']."' type='audio/mpeg'>
    <source src='audio/".$row['audio']."' type='audio/ogg'>
    </audio>
   </div>
    <br />
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
    echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo "<form method='POST' action='repost.php' class='ajax'>
    <input type='hidden' name='realowner' value='".$row['username']."'>
    <input type='hidden' name='reposter' value='".$_COOKIE['user']."'>
    <input type='hidden' name='content' value='".$row['caption']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='image' value='".$row['image']."'>
  <button type='submit' id='retweet-button' name='repost'><i class='fa fa-paper-plane style='font-size:18px; color:black;'></i></button>
    </form>";
    echo streamcount($row['audio']);
     echo checkcount($row['post_day']);
  echo commentcount($row['post_day'])."<br />";
  echo shares($row['post_day']);
    echo "<p style='font-size:10px; clear:both; display:block; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";

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
       echo "<div style='padding:5px 5px; margin-top:5px; background:grey; border:1px solid grey; border-radius:5px; position:relative;  border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']." (Audio)</span></h3>
      <div style=' box-sizing:border-box;  opacity:0.8; width:100%;  background:black; height:auto;'>
<p id='songname' style='text-align:center;  word-wrap:break-word;    color:white; '>".htmlspecialchars($row['caption'])."</p>
<center><img src='image/".$row['image']."'  style='width:100px; margin:0px auto; border:2px solid white; border-radius:50%;  height:100px; '></center><br />
   <audio id='songelement' value=".$row['id']." onmouseover='streamcount()' style='width:100%;' controls>
    <source src='audio/".$row['audio']."' type='audio/mpeg'>
    <source src='audio/".$row['audio']."' type='audio/ogg'>
    </audio>
   </div>
    <br />
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
    echo streamcount($row['audio']);
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day'])."<br />";
  echo shares($row['post_day']);
    echo "<p style='font-size:10px; clear:both; display:block; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
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
    elseif ($row['image'] !='' && $row['audio']!='' && $row['status']=='shared' && $row['profile_pic']==''){
       echo "<div style='background:;padding:5px 5px; margin-top:5px; background:grey; border:1px solid grey; border-radius:5px; border:1px solid white; margin-left:4px; margin-right:4px;'>
     <h3 style='background:none;'><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['sharer']." (Shared Audio)</span></h3>
    <h3>".$row['username']."</h3>
    <div style=' box-sizing:border-box;  opacity:0.8; width:100%;  background:black; height:auto;'>
<p id='songname' style='text-align:center;  word-wrap:break-word;    color:white; '>".htmlspecialchars($row['caption'])."</p>
<center><img src='image/".$row['image']."'  style='width:100px; margin:0px auto; border:2px solid white; border-radius:50%;  height:auto; '></center><br />
   <audio id='songelement' value=".$row['id']." onmouseover='streamcount()' style='width:100%;' controls>
    <source src='audio/".$row['audio']."' type='audio/mpeg'>
    <source src='audio/".$row['audio']."' type='audio/ogg'>
    </audio>
   </div>
    <br />
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
    echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo "<form method='POST' action='repost.php' class='ajax'>
    <input type='hidden' name='realowner' value='".$row['username']."'>
    <input type='hidden' name='reposter' value='".$_COOKIE['user']."'>
    <input type='hidden' name='content' value='".$row['caption']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <input type='hidden' name='image' value='".$row['image']."'>
  <button type='submit' id='retweet-button' name='repost'><i class='fa fa-retweet' style='font-size:18px; color:black;'></i></button>
    </form>";
    echo streamcount($row9['audio']);
     echo checkcount($row['post_day']);
  echo commentcount($row['post_day'])."<br />";
  echo shares($row['post_day']);
    echo "<p style='font-size:10px; clear:both; display:block; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";

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
       echo "<div style='padding:5px 5px; margin-top:5px; background:grey; border:1px solid grey; border-radius:5px; margin-left:4px; margin-right:4px;'>
     <h3 style='background:none;'><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['sharer']." (Shared Audio)</span></h3>
    <h3>".$row['username']."</h3>
       <div style=' box-sizing:border-box;  opacity:0.8; width:100%;  background:black; height:auto;'>
<p id='songname' style='text-align:center;  word-wrap:break-word;    color:white; '>".htmlspecialchars($row['caption'])."</p>
<center><img src='image/".$row['image']."'  style='width:100px; margin:0px auto; border:2px solid white; border-radius:50%;  height:auto; '></center><br />
   <audio id='songelement' value=".$row['id']." onmouseover='streamcount()' style='width:100%;' controls>
    <source src='audio/".$row['audio']."' type='audio/mpeg'>
    <source src='audio/".$row['audio']."' type='audio/ogg'>
    </audio>
   </div>
    <br />
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
    echo streamcount($row['audio']);
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day'])."<br />";
  echo shares($row['post_day']);
    echo "<p style='font-size:10px; clear:both; display:block; color:lightgrey; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
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
    elseif ($row['status']=='sponsored') {
echo "<div style='background:grey; border:1px solid black; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
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
  echo "</div>";
}
}else{
  
}
}
}else{
echo "<div class='to-follow-box'>";
$sql="SELECT * FROM artiste_info WHERE username !='$username' AND username !='Superuser'  ORDER BY RAND() LIMIT 10; ";
$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
if($row['profile_pic']==''){
echo "<div class='follow-box'>
          <center><img src='profilepic/default.jpg' id='following-image'></center>
          <a href='info.php?id=".base64_encode($row['username'])."'><p style='font-size:15px; text-align:center; color:white; font-family:arial; font-weight:bold; '>".$row['username']."</p></a>
          <form action='follow.php' method='POST' class='ajax'>
          <input type='hidden' name='username' value='".$_COOKIE['user']."'>
          <input type='hidden' name='following' value='".$row['username']."'>
          <center><button type='submit' value='".$row['username']."' class='".$row['username']."' name='follow'  id='follow-button'>Follow</button></center>
          </form>
  </div>";
}else{
echo "<div class='follow-box'>
          <center><img src='profilepic/".$row['profile_pic']."' id='following-image'></center>
          <a href='info.php?id=".base64_encode($row['username'])."'><p style='font-size:15px; text-align:center; color:white; font-family:arial; font-weight:bold; '>".$row['username']."</p></a>
          <form action='follow.php' method='POST' class='ajax'>
          <input type='hidden' name='username' value='".$_COOKIE['user']."'>
          <input type='hidden' name='following' value='".$row['username']."'>
          <center><button type='submit' value='".$row['username']."' class='".$row['username']."' name='follow'  id='follow-button'>Follow</button></center>
          </form>
  </div>";
}
  
}
echo"</div>";
}
?>
<script type="text/javascript" src='findstories.js'></script>
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
</body>
</html>
<?php
mysqli_close($conn);
}
?>