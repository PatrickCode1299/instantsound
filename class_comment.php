<?php
date_default_timezone_set('Africa/Lagos');
class user_comment
{
	var $username;
	var $post_comment;
	var $day;
	var $post_id;
	
	function __construct($username,$post_comment,$day,$post_id)
	{
		$this->username=$username;
		$this->post_comment=$post_comment;
		$this->day=$day;
		$this->post_id=$post_id;
	}
	function getComments(){
		require 'db.php';
		$post_comment=trim(htmlspecialchars($this->post_comment));
		$username=trim(htmlspecialchars($this->username));
		$day=$this->day;
		$post_id=$this->post_id;
	    $sql="INSERT INTO comments(username,post_comment,day,post_id) VALUES(?,?,?,?);";
	    $stmt=mysqli_stmt_init($conn);
	    if(!mysqli_stmt_prepare($stmt,$sql)){
	    	echo "Somethings Wrong";
	    }else{
        mysqli_stmt_bind_param($stmt,'ssss',$username,$post_comment,$day,$post_id);
        mysqli_stmt_execute($stmt);
	    }
	    mysqli_close($conn);
	}
}


?>