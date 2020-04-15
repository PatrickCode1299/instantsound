<?php
   function shares($param){
      require 'db.php';
      $sql="SELECT count(sharer) AS total FROM user_post WHERE unique_id='$param' AND sharer !=''";
      $result=mysqli_query($conn,$sql);
      while($row=mysqli_fetch_assoc($result)){
        if($row['total']< 2 && $row['total'] > 0){
          return "<p style='clear:both; font-weight:bold; font-family:sans-serif; font-size:14px; margin-top:8px; margin-bottom:8px;'> ".$row['total']." share</p>";

        }
        elseif ($row['total'] < 1) {
          return "";
        }
        else{
          return "<p style='clear:both; font-weight:bold; font-family:sans-serif; font-size:14px; margin-top:8px; margin-bottom:8px;'> ".$row['total']." shares</p>";
        }
      }
       }
       ?>