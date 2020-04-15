<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
    header('Location:index.php');
}elseif (!isset($_GET['id'])) {
   header('Location:home.php');
}elseif (is_numeric($_GET['id'])) {
    header('Location:home.php');
}
else{
require 'db.php';
?>
<?php
include_once 'loginheader.php';
include_once 'checkcount.php';
include_once 'commentcount.php';
include_once 'checkgenre.php';
include_once  'numberreducer.php';
include_once 'streamcount.php';
include_once 'shares.php';
?>
<script type="text/javascript" src='info.js'></script>
<?php
$id=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
?>
<div class='main-profile' style='background:grey; position:relative;'>
    <?php
$id=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
  $sql="SELECT coverbg FROM artiste_info WHERE username='$id'";
  $result=mysqli_query($conn,$sql);
  if($row=mysqli_fetch_assoc($result)){
   if($row['coverbg']==''){
    echo "<script>
        $('.main-profile').css('background-image','url(bg/default.jpg)');
        $('.main-profile').css({'background-repeat':'no-repeat', 'background-position':'center','background-attachment':'fixed', 'background-size':'cover'});
    </script>";
   }else{
   
echo "<script>
        $('.main-profile').css('background-image','url(bg/".$row['coverbg'].")');
        $('.main-profile').css({'background-repeat':'no-repeat', 'background-position':'center','background-attachment':'fixed', 'background-size':'cover'});
    </script>";
    
   }
  }
    ?>
    <div>
    <button style='background:none; border:none; cursor:pointer; margin-top:20px; float:left;' onclick='sidebar()'>
        <span id='nav'></span>
        <span id='nav'></span>
        <span id='nav'></span>
    </button>
    <?php
    $username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
    $sql="SELECT profile_pic FROM artiste_info WHERE username='$username'";
    $result=mysqli_query($conn,$sql);
     if($row=mysqli_fetch_assoc($result)){
        if($row['profile_pic']==''){
        echo "<center><div style='  border-radius:10px; margin-top:80px; width:100px; height:auto; box-sizing:border-box; '><img src='profilepic/default.jpg' class='main-pic'></div></center>";
        }else{
            echo "<center><div style='  border-radius:10px; margin-top:80px; width:100px; height:auto; box-sizing:border-box; '><img src='profilepic/".$row['profile_pic']."' class='main-pic'></div></center>";
        }
     }

      ?>
     </div>
      <div class='main-details-container'>
    <figure><?php
        $username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
    $sql="SELECT count(caption) AS total FROM user_post WHERE username='$username' AND status !='shared'";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
        if($row['total'] > 1){
            echo $row['total']."<figcaption>Posts</figcaption>";
        }else{
            echo number_format_short($row['total'])."<figcaption>Post</figcaption>";
        }
    }
    ?></figure>
    <figure class='user_click' onclick='showfollower()'><?php 
        $username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
    $sql="SELECT count(follower) AS total FROM followership WHERE following='$username'";
    $result=mysqli_query($conn,$sql);
  while($row=mysqli_fetch_assoc($result)){
        if($row['total'] > 1){
            echo $row['total']."<figcaption>Fans</figcaption>";
        }else{
            echo number_format_short($row['total'])."<figcaption>Fan</figcaption>";
        }
    }
    ?></figure>
    <figure class='user_clicks' onclick='showfollowing()'><?php 
        $username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
    $sql="SELECT count(following) AS total FROM followership WHERE follower='$username'";
    $result=mysqli_query($conn,$sql);
  while($row=mysqli_fetch_assoc($result)){
        if($row['total'] > 1){
            echo $row['total']."<figcaption>Following</figcaption>";
        }else{
            echo number_format_short($row['total'])."<figcaption>Following</figcaption>";
        }
    }
    ?></figure>
     <?php
       $username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
   $current=$_COOKIE['user'];
   if($username=='Superuser'){
    echo "";
   }else{
    $sql6="SELECT * FROM followership WHERE follower='$current' AND following='$username'";
$result6=mysqli_query($conn,$sql6);
if(mysqli_num_rows($result6) > 0){

echo "<form method='POST' style='float:right; margin-top:2px;' id='unfollow-form' action='unfollow.php' class='ajax'  value='".mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])))."'>
    <input type='hidden' name='following' value='".base64_decode($_GET['id'])."'>
    <input type='hidden' name='follower' value='".$_COOKIE['user']."'>
    <button type='submit' name='unfollow' onclick='callaction()' class='".mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])))."'  id='unfollow-button' style='margin-top:0px;'>unfollow</button>
    </form>";
}else{
echo"<form method='POST' class='ajax'  style='float:right; margin-top:2px; margin-bottom:0px;' action='follow.php'>
    <input type='hidden'   name='following' value='".base64_decode($_GET['id'])."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <button type='submit'  name='follow' class='".base64_decode($_GET['id'])."' id='unfollow-button' style='margin-top:0px;'>follow</button>
    </form>";
}
   }
 
echo"<form style='display:none;'>
<input type='hidden' id='infodata' name='nothing' value='".base64_decode($_GET['id'])."'>
</form>";

      ?>
        
    <script type="text/javascript">
    function showfollowing(){
        $(".following-box").css('display','block');
    }
    function showfollower(){
        $(".follower-box").css('display','block');
    }

    </script>
</div>

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


    

</div>
<div class='bio-info-container'>
    <?php
      $username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
   $sql="SELECT user_bio FROM artiste_info WHERE username='$username'";
   $result=mysqli_query($conn,$sql);
   if($row=mysqli_fetch_assoc($result)){
    if($row['user_bio']==''){

echo "";

    }else{
        echo "<p class='bio-holder' style=' margin-top:4px; font-size:14px; text-align:left; font-family:sans-serif;
        '>Bio:  ".$row['user_bio']."</p>";
        
    }
   }
    ?>

</div>
<div class="follower-box" id="follower-box">
        <span style='color:black; margin-left:10px;  cursor:pointer; ' onclick='hidebox()'><i class='fa fa-arrow-left' style='font-size:20px;'></i></span><span style='margin-left:5px;'>Followers</span>
    <?php echo"<form method='POST' style='margin-top:5px;'>
    <input type='hidden' id='main' name='username' value='".mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])))."'>
    <textarea name='search' onclick='showfollowerRes()' id='tofind' value='' onkeydown='checkfollowers()' style='resize:none; width:100%; border:none; height:30px;border:1px solid lightgrey; padding:4px 4px;' placeholder='Search ".mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])))." followers'></textarea>
    </form>"; 

    ?>
<div id='followers-response' onclick='hidefollowresponsebox()' class='following-res' style='position:fixed; display:none; height:100%;  padding:4px 4px; width:100%; opacity:0.8;   color:white; z-index:1; background:black;'>
</div>
    <script>
    function checkfollowers(){
 $.ajax({
    url:'findfollowers.php',
    type:'POST',
    data:{user:$("#tofind").val(),
    current:$("#main").val()
},
    success:function(response){
  $("#followers-response").html(response)
    }
});
    }
    function showfollowerRes(){
        $("#followers-response").css('display','block');
    }
    function hidebox(){
        $("#follower-box").css('display','none');
        $("#following-box").css('display','none');
    }
    function hidefollowresponsebox(){
            $(".following-res").css('display','none');
    }
    </script>
    <?php
$username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
$currentname=$_COOKIE['user'];
$sql="SELECT * FROM followership INNER JOIN artiste_info ON followership.follower=artiste_info.username WHERE followership.following='$username' ORDER BY followership.follower desc LIMIT 30";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
while($row=mysqli_fetch_assoc($result)){
$tounfollow=$row['follower'];
$sql3="SELECT follower FROM followership WHERE follower='$currentname' AND following='$tounfollow'";
$result3=mysqli_query($conn,$sql3);
if(mysqli_num_rows($result3) > 0){
$clearusername=$_COOKIE['user'];
if($row['profile_pic']=='' && $row['username']!=$clearusername){
echo "<ul class='following-list'>
    <li><img src='profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a><form method='POST' style='float:right; margin-top:10px;' id='unfollow-form' action='unfollow.php' class='ajax'  value='".$row['follower']."'>
    <input type='hidden' name='following' value='".$row['follower']."'>
    <input type='hidden' name='follower' value='".$_COOKIE['user']."'>
    <button type='submit' name='unfollow' onclick='callaction()' class='".$row['follower']."'  id='unfollow-button'>unfollow</button>
    </form></li><br />
    </ul>";
}
elseif ($row['profile_pic']!='' && $row['username']!=$clearusername) {
    echo "<ul class='following-list'>
    <li><img src='profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a><form method='POST' style='float:right; margin-top:10px;' id='unfollow-form'  action='unfollow.php' class='ajax' value='".$row['follower']."'>
    <input type='hidden' name='following' value='".$row['follower']."'>
    <input type='hidden' name='follower' value='".$_COOKIE['user']."'>
    <button type='submit' name='unfollow' onclick='callaction()' class='".$row['follower']."'  name='unfollow' id='unfollow-button'>unfollow</button>
    </form></li><br />
    </ul>";
}
elseif ($row['profile_pic']!='' && $row['username']==$clearusername) {
    echo "<ul class='following-list'>
    <li><img src='profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='profile.php'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a></li><br />
    </ul>";
}
else{
    echo "<ul class='following-list'>
    <li><img src='profilepic/default.jpg' id='following-profile-pic'><a href='profile.php'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a></li><br />
    </ul>";
}
}else{
    $clearusername=$_COOKIE['user'];
    if($row['profile_pic']==''&& $row['username']!=$clearusername){
echo "<ul class='following-list'>
    <li><img src='profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a><form method='POST' style='float:right; margin-top:10px;' class='ajax' action='follow.php'>
    <input type='hidden' name='following' value='".$row['follower']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <button type='submit' name='follow' class='".$row['follower']."' id='unfollow-button'>follow</button>
    </form></li><br />
    </ul>";
    }elseif($row['profile_pic']!='' && $row['username']!=$clearusername){
        echo "<ul class='following-list'>
    <li><img src='profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a><form method='POST' style='float:right; margin-top:10px;' class='ajax' action='follow.php'>
    <input type='hidden' name='following' value='".$row['follower']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <button type='submit' name='follow' class='".$row['follower']."' id='unfollow-button'>follow</button>
    </form></li><br />
    </ul>";
    }
    elseif ($row['profile_pic']!='' && $row['username']==$clearusername) {
    echo "<ul class='following-list'>
    <li><img src='profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='profile.php'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a></li><br />
    </ul>";
}
else{
    echo "<ul class='following-list'>
    <li><img src='profilepic/default.jpg' id='following-profile-pic'><a href='profile.php'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a></li><br />
    </ul>";
}
}
}
}else{
    echo "<p style='text-align:center;'><b>No Ones Feeling this user yet</b></p>";
}

    ?>

</div>
<div class="following-box" id="following-box">
          <span style='color:black; margin-left:10px;  cursor:pointer; ' onclick='hidebox()'><i class='fa fa-arrow-left' style='font-size:20px;'></i></span><span style='margin-left:5px;'>Following</span>
    <?php echo"<form method='POST' style='margin-top:5px;'>
    <input type='hidden' id='maintwo' name='username' value='".base64_decode($_GET['id'])."'>
    <textarea name='search' onclick='showfollowerResponse()' id='tofindtwo' value='' onkeydown='checkfollowing()' style='resize:none; width:100%; border:none; height:30px;border:1px solid lightgrey; padding:4px 4px;' placeholder='Search following'></textarea>
    </form>"; 

    ?>
<div id='following-response' class='follower-res' onclick='hideresponsebox()' style='position:fixed; display:none; height:100%;  padding:4px 4px; width:100%; opacity:0.8;   color:white; z-index:1; background:black;'>
</div>
    <script>
    function checkfollowing(){
 $.ajax({
    url:'findfollowing.php',
    type:'POST',
    data:{followinguser:$("#tofindtwo").val(),
    mainuser:$("#maintwo").val()
},
    success:function(response){
  $("#following-response").html(response)
    }
});
    }
    function showfollowerResponse(){
        $("#following-response").css('display','block');
    }
    function hidebox(){
        $("#follower-box").css('display','none');
        $("#following-box").css('display','none');
    }
    function hideresponsebox(){
        $(".follower-res").css('display','none');
    }
    </script>
    <?php
$username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
$sql="SELECT * FROM followership INNER JOIN artiste_info ON followership.following=artiste_info.username WHERE followership.follower='$username' ORDER BY followership.following desc LIMIT 30";
$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
    $tounfollow=$row['following'];
    $current=$_COOKIE['user'];
    $sql2="SELECT following FROM followership WHERE follower='$current' AND following='$tounfollow'";
    $result2=mysqli_query($conn,$sql2);
    if(mysqli_num_rows($result2) > 0){
 if($row['username']==$_COOKIE['user'] && $row['profile_pic']==''){
 echo "<ul class='following-list'>
    <li><img src='profilepic/default.jpg' id='following-profile-pic'><a href='profile.php'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['following']."</span></a></li><br />
    </ul>";
    }elseif($row['username']==$_COOKIE['user'] && $row['profile_pic'] !='') {
         echo "<ul class='following-list'>
    <li><img src='profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='profile.php'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['following']."</span></a></li><br />
    </ul>";
    }elseif($row['username']!=$_COOKIE['user'] && $row['profile_pic'] ==''){
    echo "<ul class='following-list'>
    <li><img src='profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['following']."</span></a><form method='POST' value='".$row['following']."' id='unfollow-form' class='ajax' action='unfollow.php'   style='float:right; margin-top:10px;'>
    <input type='hidden' id='unfollow-details' name='following' value='".$row['following']."'>
    <input type='hidden' name='follower' value='".$_COOKIE['user']."'>
    <button type='submit' name='unfollow' onclick='callaction()' class='".$row['following']."' id='unfollow-button'>unfollow</button>
    </form></li><br />
    </ul>";
    }else{
  echo "<ul class='following-list'>
    <li><img src='profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['following']."</span></a><form method='POST' value='".$row['following']."' id='unfollow-form' class='ajax' action='unfollow.php'   style='float:right; margin-top:10px;'>
    <input type='hidden' id='unfollow-details' name='following' value='".$row['following']."'>
    <input type='hidden' name='follower' value='".$_COOKIE['user']."'>
    <button type='submit' name='unfollow' onclick='callaction()' class='".$row['following']."' id='unfollow-button'>unfollow</button>
    </form></li><br />
    </ul>";
    }
    }else{
 if($row['username']==$_COOKIE['user'] && $row['profile_pic']==''){
 echo "<ul class='following-list'>
    <li><img src='profilepic/default.jpg' id='following-profile-pic'><a href='profile.php'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['following']."</span></a></li><br />
    </ul>";
    }elseif($row['username']==$_COOKIE['user'] && $row['profile_pic'] !='') {
         echo "<ul class='following-list'>
    <li><img src='profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='profile.php'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['following']."</span></a></li><br />
    </ul>";
    }elseif($row['username']!=$_COOKIE['user'] && $row['profile_pic'] ==''){
    echo "<ul class='following-list'>
    <li><img src='profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['following']."</span></a><form method='POST' style='float:right; margin-top:10px;' class='ajax' action='follow.php'>
    <input type='hidden' name='following' value='".$row['following']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <button type='submit' name='follow' class='".$row['following']."' id='unfollow-button'>follow</button>
    </form></li><br />
    </ul>";
    }else{
  echo "<ul class='following-list'>
    <li><img src='profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['following']."</span></a><form method='POST' style='float:right; margin-top:10px;' class='ajax' action='follow.php'>
    <input type='hidden' name='following' value='".$row['following']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <button type='submit' name='follow' class='".$row['following']."' id='unfollow-button'>follow</button>
    </form></li><br />
    </ul>";
    }
    }
   
  
}
    ?>
</div>
<div class='side-bar'>
    <span class='close-bar' style='float:right; cursor:pointer; font-size:30px; color:red;'>&times;</span>
    <?php
$username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
$sql="SELECT * FROM artiste_info WHERE username='$username'";
$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
    echo "<ul id='details-list'>
    <li><i class='fa fa-user' style='margin-right:5px;'></i>".$row['username']."</li><br />
    <li><i class='fa fa-envelope' style='margin-right:5px;'></i>".$row['email']."</li><br />
    <li><i class='fa fa-phone' style='margin-right:5px;'></i>".$row['phone']."</li><br />
    <li><i class='fa fa-microphone' style='margin-right:5px;'></i>".checkgenre($row['genre'])."</li><br />
    </ul>";
}

    ?>
 
    <?php 
    echo "<a href='message.php?mid=".base64_encode(base64_decode($_GET['id']))."'><button style='border:none; padding:5px 5px; border-radius:5px;  border:1px solid black; cursor:pointer; width:100%; margin-top:5px;'>Message</button></a>"; ?>
     <?php 
    echo "<a href='allmp3.php?uid=".base64_encode(base64_decode($_GET['id']))."'><button style='border:none; padding:5px 5px; border-radius:5px;  border:1px solid black; cursor:pointer; width:100%; margin-top:5px;'>Songs</button></a>"; ?>
   
</div>
<script type="text/javascript">

$('.close-bar').click(function(){
$(".side-bar").css('display','none');
});
function showbox(){
    $("#edit-bio-button").css('display','none');
    $("#user-bio-form").css('display','block');
}
function sidebar(){
    $(".side-bar").css('display','inline-block');
    $(".side-bar").css('width','250px');
}
function raisebutton(){
    $("#update-bio-button").css('display','block');
}
function handle(){
    var result=confirm("Hey <?php echo $_COOKIE['user']; ?> Are You Leaving Now");
    if(result==true){
        window.location.href='logout.php';
    }else{
        $(".side-bar").css('display','none');
    }
}
</script>
<div class='profile-post-area'  id='postarea'>
<?php
    $username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
    $id=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
     $sql="SELECT * FROM user_post INNER JOIN artiste_info ON user_post.username=artiste_info.username WHERE user_post.username='$username'  OR user_post.sharer='$username' ORDER BY user_post.userpostid DESC LIMIT 5";
     $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0){
    while($row=mysqli_fetch_assoc($result)){
    if($row['image']=='' && $row['profile_pic']=='' && $row['audio']=='' && $row['colorbg']=='white'){
 echo "<div style='padding:5px 5px; margin-top:5px; background:grey; border:1px solid grey; border-radius:5px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span><form method='POST' action='deletepost.php'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='username' value='".$row['username']."'>
   <button type='submit' name='delete' style='border:none; background:none; cursor:pointer; float:right;'><i class='fa fa-trash' style='font-size:15px; color:red;'></i></button>
   </form></h3>
    <p style='word-wrap:break-word; font-family:arial; color:white;'>".htmlspecialchars($row['caption'])."</p>
    ";$user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
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
 echo "<div style='padding:5px 5px; margin-top:5px; background:lightblue; border:1px solid white; margin-left:4px; margin-right:4px;'>
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
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
        echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
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
   }elseif ($row['image']=='' && $row['profile_pic']!='' && $row['colorbg']=='white') {
         echo "<div style='padding:5px 5px; margin-top:5px; background:grey; border:1px solid grey; border-radius:5px; margin-left:4px; margin-right:4px;' >
    <h3><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span><form method='POST' action='deletepost.php'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='username' value='".$row['username']."'>
   <button type='submit' name='delete' style='border:none; background:none; cursor:pointer; float:right;'><i class='fa fa-trash' style='font-size:15px; color:red;'></i></button>
   </form></h3>
    <p style='word-wrap:break-word; font-family:arial; color:white;'>".htmlspecialchars($row['caption'])."</p>
    ";$user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
        echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
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
 echo "<div style='background:;padding:5px 5px; margin-top:5px; border-radius:5px; background:lightblue; border:1px solid white; margin-left:4px; margin-right:4px;'>
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
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
        echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
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
         echo "<div style='background:;padding:5px 5px; margin-top:5px; border-radius:5px; background:lightblue; border:1px solid white; margin-left:4px; margin-right:4px;'>
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
        echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
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
    <p style='word-wrap:break-word; color:black;'>".htmlspecialchars($row['caption'])."</p>
   ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
    echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
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
         echo "<div style='background:;padding:5px 5px; margin-top:5px; border-radius:5px; background:gold; border:1px solid white; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span style='margin-top:15px; color:white; display:block; font-weight:bold;'>".$row['username']."</span><form method='POST' action='deletepost.php'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
    <input type='hidden' name='username' value='".$row['username']."'>
   <button type='submit' name='delete' style='border:none; background:none; cursor:pointer; float:right;'><i class='fa fa-trash' style='font-size:15px; color:black;'></i></button>
   </form></h3>
    <p style='word-wrap:break-word; font-family:AlexBrush-Regular; color:black; font-size:20px; '>".$row['caption']."</p>
    ";$user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
        echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
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
    elseif ($row['image'] !='' && $row['image1']=='' && $row['profile_pic']=='' && $row['audio']=='' && $row['status'] !='shared') {
         echo "<div style='background:grey; border:1px solid grey; border-radius:5px; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
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
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
        echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
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
        elseif ($row['image'] !='' && $row['image1']=='' && $row['profile_pic']!='' && $row['audio']==''&& $row['status'] !='shared') {
         echo "<div style='background:grey; border:1px solid grey; border-radius:5px; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
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
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
        echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
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
         echo "<div style='background:grey; border:1px solid grey; border-radius:5px; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
    <h3><img src='profilepic/default.jpg' id='post-profile-pic'>".$row['username']."</h3>
    <div style='display:flex; flex-direction:row; flex-wrap:nowrap; flex-column-gap:20px;'><img src='image/".$row['image']."' style='width:50%; height:10%;'>
    <img src='image/".$row['image1']."' style='width:50%; height:10%;'></div>
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
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
        echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
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
         echo "<div style='background:grey; padding:5px 5px; margin-top:4px; margin-left:4px; margin-right:4px;'>
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
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
        echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
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
    elseif ($row['image'] !='' && $row['audio']!='' && $row['profile_pic']=='') {
         echo "<div style='position:relative; padding:5px 5px; margin-top:5px; background:grey; border:1px solid grey; border-radius:5px; margin-left:4px; margin-right:4px;'>

    <h3>
    <a href='linkholder.php?linkid=".base64_encode($row['image'])."' style='color:red;'><span style='float:right;'><i style='color:red;' class='fa fa-headphones'></i></span></a>
    <img src='profilepic/default.jpg' id='post-profile-pic'><span style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']."</span></h3>
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
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
        echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
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
    <form method='POST' style='margin-top:4px; margin-bottom:4px; clear:both;' action='comment.php' class='ajax'>
    <textarea name='comment' placeholder='Write a comment....' style='resize:none; height:25px; padding-top:4px; '></textarea>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='post_id' value='".$row['post_day']."'>
    <input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
    <button type='submit' name='submit' class='submit-comment-button'>Comment</button>
    </form>
    </div>";
    }
     elseif ($row['image'] !=''  && $row['audio']!='' && $row['status'] !='shared' && $row['profile_pic']!='') {
         echo "<div style='padding:5px 5px; margin-top:5px; position:relative;background:grey; border:1px solid grey; border-radius:5px; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'>
    <a href='linkholder.php?linkid=".base64_encode($row['image'])."' style='color:red;'><span style='float:right;'><i style='color:red;' class='fa fa-headphones'></i></span></a>
    <img src='profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['username']." (Audio)</span></h3>
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
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
        echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
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
  
    }elseif ($row['sharer']==$row['username'] && $row['profile_pic'] !='') {
        echo "<div style='padding:5px 5px; margin-top:5px; background:grey; border:1px solid grey; border-radius:5px;margin-left:4px; margin-right:4px;'>
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
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
        echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
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
    elseif ($row['sharer']==$row['username'] && $row['profile_pic'] =='') {
        echo "<div style='padding:5px 5px; margin-top:5px; background:grey; border:1px solid grey; border-radius:5px;margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;'><img src='profilepic/default.jpg' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:block; font-weight:bold;'>".$row['sharer']." (Shared Audio)</span></h3>
    <h3>".$row['username']."</h3>
    <p style='word-wrap:break-word;'>".htmlspecialchars($row['caption'])."</p>
     <img src='image/".$row['image']."'style='width:100%; height:auto; '><br />
    <audio id='songelement' value=".$row['id']." onmouseover='streamcount()' style='width:100%;' controls  loop>
    <source src='audio/".$row['audio']."' type='audio/mpeg'>
    <source src='audio/".$row['audio']."' type='audio/ogg'>
    </audio><br />
    ";
   $user=$_COOKIE['user']; 
   $postid=$row['post_day'];
   $sql2="SELECT username FROM post_likes WHERE username='$user' AND postid='$postid';";
   $result2=mysqli_query($conn,$sql2); 
 if(mysqli_num_rows($result2)>0){
    echo " <form method='POST' action='unlike.php' class='ajax'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <input type='hidden' name='postid' value='".$row['post_day']."'>
     <input type='hidden' name='changeid' value='".$row['userpostid']."'>
    <button type='submit' name='unlike' style='background:none; border:none; margin-top:5px; margin-bottom:5px; float:left;'><i class='fa fa-heart' style='font-size:18px; color:red;'></i></button>
    </form>";
   }else{
        echo " <form method='POST' id='".$row['userpostid']."'  action='like.php' class='ajax'>
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
     }else{
        echo "<h5 style='font-weight:bold; text-transform:uppercase; text-align:center; font-family:arial;'>$id has no post yet</h5>";
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
</div>
<?php
     mysqli_close($conn);
?>
<?php
}
?>