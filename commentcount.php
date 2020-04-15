<?php
  function commentcount($time){
        require 'db.php';
         $sqlComments = "SELECT count(post_comment) AS total FROM  comments WHERE post_id='$time'";
   $cresult = mysqli_query($conn,$sqlComments);
   while($rowCresult = mysqli_fetch_assoc($cresult)){
    if($rowCresult['total']<2 && $rowCresult['total'] > 0){
      return "<a href='post_comment.php?mid=".base64_encode($time)."'><p style='color:lightgrey; font-size:13px; clear:both;'>".$rowCresult['total']."comment</p></a>";

    }elseif ($rowCresult['total'] < 1) {
      return "";
    }else{
      return "<a href='post_comment.php?mid=".base64_encode($time)."'><p style='color:lightgrey; font-size:13px; clear:both;'>View all ".$rowCresult['total']." comments</p></a>";
    }
   }
      }
?>