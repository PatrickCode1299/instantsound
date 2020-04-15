	<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
  header('Location:index.php');
}else{
require 'db.php';
include_once 'timeago.php';
include_once 'checkcount.php'; 
include_once 'commentcount.php';
include_once 'shares.php';
include_once 'streamcount.php';
?>
  <?php
	$username=$_COOKIE['user'];
  $sql1="SELECT count(caption) AS total FROM user_post WHERE username='$username';";
  $result1=mysqli_query($conn,$sql1);
  while ($row1=mysqli_fetch_assoc($result1)) {
if($row1['total'] > 10){
$sql="SELECT * FROM user_post INNER JOIN artiste_info ON user_post.username=artiste_info.username WHERE user_post.username='$username' AND user_post.status !='shared' OR user_post.sharer='$username' ORDER BY user_post.userpostid asc";
     $result=mysqli_query($conn,$sql);
     if(mysqli_num_rows($result) > 0){
    while($row=mysqli_fetch_assoc($result)){
    if($row['image']=='' && $row['profile_pic']=='' && $row['audio']=='' && $row['colorbg']=='white'){
 echo "<div style='padding:5px 5px; margin-top:5px; background:grey; border-radius:5px; border:1px solid grey; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span><form method='POST' action='deletepost.php'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='username' value='".$row['username']."'>
   <button type='submit' name='delete' style='border:none; background:none; cursor:pointer; float:right;'><i class='fa fa-trash' style='font-size:15px; color:red;'></i></button>
   </form></h3>
    <p style='word-wrap:break-word; color:white;'>".htmlspecialchars($row['caption'])."</p>
    ";$user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }elseif ($row['image']=='' && $row['profile_pic']!='' && $row['colorbg']=='white') {
       echo "<div style='padding:5px 5px; margin-top:5px;background:grey; border-radius:5px; border:1px solid grey;  margin-left:4px; margin-right:4px;' >
    <h3><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span><form method='POST' action='deletepost.php'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='username' value='".$row['username']."'>
   <button type='submit' name='delete' style='border:none; background:none; cursor:pointer; float:right;'><i class='fa fa-trash' style='font-size:15px; color:red;'></i></button>
   </form></h3>
    <p style='word-wrap:break-word; color:white;'>".htmlspecialchars($row['caption'])."</p>
    ";$user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
    elseif($row['image']=='' && $row['profile_pic']=='' && $row['colorbg']=='lightblue'){
 echo "<div style='background:;padding:5px 5px; margin-top:5px; background:lightblue; border-radius:5px; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span><form method='POST' action='deletepost.php'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='username' value='".$row['username']."'>
   <button type='submit' name='delete' style='border:none; background:none; cursor:pointer; float:right;'><i class='fa fa-trash' style='font-size:15px; color:red;'></i></button>
   </form></h3>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
   ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
    echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
     echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
    echo"
    <form method='POST' style='margin-top:4px; margin-bottom:4px;' action='comment.php' class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
   }elseif ($row['image']=='' && $row['profile_pic']!='' && $row['colorbg']=='lightblue') {
       echo "<div style='background:;padding:5px 5px; margin-top:5px; background:lightblue; border-radius:5px; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span><form method='POST' action='deletepost.php'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='username' value='".$row['username']."'>
   <button type='submit' name='delete' style='border:none; background:none; cursor:pointer; float:right;'><i class='fa fa-trash' style='font-size:15px; color:black;'></i></button>
   </form></h3>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
    ";$user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button' >Comment</button>
    </form>
    </div>";
    }
     elseif($row['image']=='' && $row['profile_pic']=='' && $row['colorbg']=='gold'){
 echo "<div style='background:;padding:5px 5px; margin-top:5px; background:gold; border-radius:5px; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; color:white; display:block; font-weight:bold;'>".$row['username']."</span><form method='POST' action='deletepost.php'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='username' value='".$row['username']."'>
   <button type='submit' name='delete' style='border:none; background:none; cursor:pointer; float:right;'><i class='fa fa-trash' style='font-size:15px; color:red;'></i></button>
   </form></h3>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
   ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
   echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
     echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:black; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
    echo"
    <form method='POST' style='margin-top:4px; margin-bottom:4px;' action='comment.php' class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button' style='background:white; border:none; color:black;'>Comment</button>
    </form>
    </div>";
   }elseif ($row['image']=='' && $row['profile_pic']!='' && $row['colorbg']=='gold') {
       echo "<div style='background:;padding:5px 5px; margin-top:5px; background:gold; border-radius:5px; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span style='margin-top:15px; color:white; display:block; font-weight:bold;'>".$row['username']."</span><form method='POST' action='deletepost.php'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='username' value='".$row['username']."'>
   <button type='submit' name='delete' style='border:none; background:none; cursor:pointer; float:right;'><i class='fa fa-trash' style='font-size:15px; color:black;'></i></button>
   </form></h3>
    <p style='word-wrap:break-word; font-family:AlexBrush-Regular; color:white;'>".htmlspecialchars($row['caption'])."</p>
    ";$user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
  if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
   echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:black; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button' style='background:white; border:none; color:black;'>Comment</button>
    </form>
    </div>";
    }
    elseif ($row['image'] !='' && $row['image1']=='' && $row['profile_pic']=='' && $row['audio']=='') {
       echo "<div style='background:grey; border-radius:5px; border:1px solid grey; ; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'>".$row['username']."</h3>
    <img src='image/".$row['image']."' style='width:100%; height:auto;'>
    <p style='word-wrap:break-word; color:white;'>".htmlspecialchars($row['caption'])."</p>
   ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
 if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
        elseif ($row['image'] !='' && $row['image1']=='' && $row['profile_pic']!='' && $row['audio']=='') {
       echo "<div style='background:grey; border-radius:5px; border:1px solid grey;  padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'>".$row['username']."</h3>
    <img src='image/".$row['image']."' style='width:100%; height:auto;'>
    <p style='word-wrap:break-word; color:white;'>".htmlspecialchars($row['caption'])."</p>
   ";
  $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
    elseif($row['image'] !='' && $row['image1']!='' && $row['profile_pic']=='' && $row['audio']==''){
       echo "<div style='background:grey; border-radius:5px; border:1px solid grey;  padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'>".$row['username']."</h3>
    <div style='display:flex; flex-direction:row; flex-wrap:nowrap; flex-column-gap:20px;'><img src='image/".$row['image']."' style='width:50%; height:10%;'>
    <img src='image/".$row['image1']."' style='width:50%; height:10%;'></div>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
   ";
     $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
      elseif($row['image'] !='' && $row['image1']!='' && $row['profile_pic']!='' && $row['audio']==''){
       echo "<div style='background:grey; border-radius:5px; border:1px solid grey;  padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'>".$row['username']."</h3>
     <div style='display:flex; flex-direction:row; flex-wrap:nowrap; flex-column-gap:20px;'><img src='image/".$row['image']."' style='width:50%; height:10%;'>
    <img src='image/".$row['image1']."' style='width:50%; height:10%;'></div>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
   ";
     $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
 if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
    elseif ($row['image'] !='' && $row['audio']!='' && $row['profile_pic']=='' && $row['username']==$_COOKIE['user']) {
       echo "<div style='padding:5px 5px; position:relative; margin-top:5px; background:grey; border-radius:5px; border:1px solid grey;  border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'><span style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span><a href='linkholder.php?linkid=".base64_encode($row['image'])."' style='color:red;'><span style='float:right;'><i style='color:red;' class='fa fa-headphones'></i></span></a></h3>
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
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
    echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
     echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
   echo shares($row['post_day']);
   echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
    echo"
    <form method='POST' style='margin-top:4px; margin-bottom:4px;' action='comment.php' class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
     elseif ($row['image'] !='' && $row['audio']!='' && $row['profile_pic']!='' && $row['username']==$_COOKIE['user']) {
       echo "<div style='padding:5px 5px; margin-top:5px; position:relative; background:grey; border-radius:5px; border:1px solid grey;  margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']." (Audio)</span><a href='linkholder.php?linkid=".base64_encode($row['image'])."' style='color:red;'><span style='float:right;'><i style='color:red;' class='fa fa-headphones'></i></span></a></h3>
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
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
  echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo streamcount($row['audio']);
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
   echo shares($row['post_day']);
   echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
  
    }elseif ($row['sharer']==$_COOKIE['user'] && $row['profile_pic'] !='') {
      echo "<div style='padding:5px 5px; margin-top:5px; background:grey; border-radius:5px; border:1px solid grey;  margin-left:4px; margin-right:4px;'>
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
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
 echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
 echo streamcount($row['audio']);
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo shares($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
  
    }
    elseif ($row['sharer']==$_COOKIE['user'] && $row['profile_pic'] =='') {
      echo "<div style='padding:5px 5px; margin-top:5px; background:grey; border-radius:5px; border:1px solid grey;  margin-left:4px; margin-right:4px;'>
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
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' action='like.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
     <button class='".$row['userpostid']."'  type='submit' name='like' style='background:none; cursor:pointer; float:left;  border:none; margin-top:5px; display:inline; margin-bottom:5px;'><i class='fa fa-heart'   id='likebutton'   style='font-size:18px; '></i></button>
    </form>";
   }
 echo "<a href='post_comment.php?mid=".base64_encode($row['post_day'])."' style='color:black;'><span><i class='fa fa-comment' style='font-size:18px; cursor:pointer; display:inline; float:left;  margin-right:5px; margin-top:5px;'></i></span></a>";
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
  echo shares($row['post_day']);
  echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
    echo"

    <form method='POST' style='margin-top:4px; clear:both; margin-bottom:4px;' action='comment.php'  class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
     <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
    }
     }
}else{
  echo "";
}
  }
     
	?>
  <script type="text/javascript">
  $('form.ajax').on('submit' ,function(e){
    e.stopImmediatePropagation();
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