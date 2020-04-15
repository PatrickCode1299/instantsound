<?php
   function checkcount($param){
      require 'db.php';
      $sql="SELECT count(username) AS total FROM post_likes WHERE postid='$param'";
      $result=mysqli_query($conn,$sql);
      while($row=mysqli_fetch_assoc($result)){
        if($row['total']< 2 && $row['total'] > 0){
          return "<p class='$param' style='clear:both; margin-left:2px; font-weight:bold; font-family:sans-serif; font-size:14px; margin-top:8px; margin-bottom:8px;'> ".$row['total']." like</p>";

        }
        elseif ($row['total'] < 1) {
             return "";
        }
        else{
          return "<p  class='$param' style='clear:both; margin-left:2px; font-weight:bold; font-family:sans-serif; font-size:14px; margin-top:8px; margin-bottom:8px;'> ".$row['total']." likes</p>";
        }
      }
       }
       ?> 