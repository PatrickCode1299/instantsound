<?php
if(isset($_POST['uploadpic'])){
require 'db.php';
$username=$_COOKIE['user'];
$image1=$_FILES['image1'];
$image2=$_FILES['image2'];
if($_FILES['image1']['size']==0 && $_FILES['image2']['size']==0){
echo "<script>window.location.href='profile.php';</script>";
}elseif ($_FILES['image1']['size']!=0 && $_FILES['image2']['size']!=0) {
  
$image1name=$_FILES['image1']['name'];
   $image1size=$_FILES['image1']['size'];
   $image1type=$_FILES['image1']['type'];
   $image1error=$_FILES['image1']['error'];
   $image1tmp=$_FILES['image1']['tmp_name'];
   $image1ext=explode(".", $image1name);
   $image1realext=strtolower(end($image1ext));

   $image2name=$_FILES['image2']['name'];
   $image2size=$_FILES['image2']['size'];
   $image2type=$_FILES['image2']['type'];
   $image2error=$_FILES['image2']['error'];
   $image2tmp=$_FILES['image2']['tmp_name'];
   $image2ext=explode(".", $image2name);
   $image2realext=strtolower(end($image2ext));
   $allowed=array('jpg','png','jpeg','JPG','JPEG','PNG');
   if(in_array($image2realext,$allowed) && in_array($image1realext,$allowed)){
    if($image2size < 1000000 && $image1size < 1000000){
if($image2error===0 && $image1error===0){
  $image2namenew=uniqid('',true).".".$image2realext;
  $image1namenew=uniqid('',true).".".$image1realext;
  $filedirimage1='image/'.$image1namenew;
  $filedirimage2='image/'.$image2namenew;
  $day=date('Y-m-d H:i:s');
  $username=$_COOKIE['user'];
  $caption=$_POST['text'];
   move_uploaded_file($image2tmp, $filedirimage2);
  move_uploaded_file($image1tmp, $filedirimage1);
  $sql="INSERT INTO user_post(username,caption,image,image1,post_day) VALUES(?,?,?,?,?)";
  $stmt=mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){
    echo "Something went wrong";
  }else{
    mysqli_stmt_bind_param($stmt,'sssss',$username,$caption,$image2namenew,$image1namenew,$day);
    mysqli_stmt_execute($stmt);
    echo "<script>window.location.href='profile.php';</script>";


  }
}else{
       echo "<script>window.location.href='profile.php';</script>";
}
    }else{
          echo "<script>window.location.href='profile.php';</script>";
    }
   }else{
          echo "<script>window.location.href='profile.php';</script>";
   }
}elseif ($_FILES['image1']['size']!=0 && $_FILES['image2']['size']==0) {
  $image1name=$_FILES['image1']['name'];
   $image1size=$_FILES['image1']['size'];
   $image1type=$_FILES['image1']['type'];
   $image1error=$_FILES['image1']['error'];
   $image1tmp=$_FILES['image1']['tmp_name'];
   $image1ext=explode(".", $image1name);
   $image1realext=strtolower(end($image1ext));
    $allowed=array('jpg','png','jpeg','JPG','JPEG','PNG');
    if(in_array($image1realext,$allowed)){
     if($image1size < 1000000){
    if($image1error===0){
     $image1namenew=uniqid('',true).".".$image1realext;
     $filedirimage1='image/'.$image1namenew;
     $day=date('Y-m-d H:i:s');
  $username=$_COOKIE['user'];
  $caption=$_POST['text'];
  move_uploaded_file($image1tmp, $filedirimage1);
    $sql="INSERT INTO user_post(username,caption,image,post_day) VALUES(?,?,?,?)";
  $stmt=mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){
    echo "Something went wrong";
  }else{
    mysqli_stmt_bind_param($stmt,'ssss',$username,$caption,$image1namenew,$day);
    mysqli_stmt_execute($stmt);
      echo "<script>window.location.href='profile.php';</script>";
  }
    }else{
      echo "<script>window.location.href='profile.php';</script>";
    }
     }
     else{
          echo "<script>window.location.href='profile.php';</script>";
     }
    }else{
      echo "<script>window.location.href='profile.php';</script>";
    }
  
}elseif ($_FILES['image1']['size']==0 && $_FILES['image2']['size']!=0 ) {
$image1name=$_FILES['image2']['name'];
   $image1size=$_FILES['image2']['size'];
   $image1type=$_FILES['image2']['type'];
   $image1error=$_FILES['image2']['error'];
   $image1tmp=$_FILES['image2']['tmp_name'];
   $image1ext=explode(".", $image1name);
   $image1realext=strtolower(end($image1ext));
    $allowed=array('jpg','png','jpeg','JPG','JPEG','PNG');
    if(in_array($image1realext,$allowed)){
     if($image1size < 1000000){
    if($image1error===0){
     $image1namenew=uniqid('',true).".".$image1realext;
     $filedirimage1='image/'.$image1namenew;
     $day=date('Y-m-d H:i:s');
  $username=$_COOKIE['user'];
  $caption=$_POST['text'];
  move_uploaded_file($image1tmp, $filedirimage1);
    $sql="INSERT INTO user_post(username,caption,image,post_day) VALUES(?,?,?,?)";
  $stmt=mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){
    echo "Something went wrong";
  }else{
    mysqli_stmt_bind_param($stmt,'ssss',$username,$caption,$image1namenew,$day);
    mysqli_stmt_execute($stmt);
      echo "<script>window.location.href='profile.php';</script>";
  }
    }else{
      echo "<script>window.location.href='profile.php';</script>";
    }
     }
     else{
           echo "<script>window.location.href='profile.php';</script>";
     }
    }else{
            echo "<script>window.location.href='profile.php';</script>";
    }
}
}

?>