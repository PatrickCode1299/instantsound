    <?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
    header('Location:index.php');
}else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
?>
    <?php
$username=$_POST['username'];
$sql="SELECT * FROM followership INNER JOIN artiste_info ON followership.following=artiste_info.username WHERE followership.follower='$username'";
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