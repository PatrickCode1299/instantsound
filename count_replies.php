<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
?>
<?php
function count_replies($commentid){
	   require 'db.php';
      $sql="SELECT count(username) AS total FROM comment_replies WHERE unique_id='$commentid'";
      $result=mysqli_query($conn,$sql);
      while($row=mysqli_fetch_assoc($result)){
        if($row['total']< 2 && $row['total'] > 0){
          return "<span style='clear:both; font-weight:bold; font-family:sans-serif; font-size:14px; margin-top:8px; margin-bottom:8px;'> ".$row['total']."reply</span>";

        }
        elseif ($row['total'] < 1) {
          return "";
        }
        else{
          return "<span style='clear:both; font-weight:bold; font-family:sans-serif; font-size:14px; margin-top:8px; margin-bottom:8px;'> ".$row['total']."replies</span>";
        }
      }
      mysqli_close($conn);
}
?>
<?php
}
?>