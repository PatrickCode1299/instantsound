<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
?>
<?php
include_once 'loginheader.php';
?><br /><br /><br /><br />
<div class="find-search">
<i class='fa fa-search' style='position:absolute; font-size:18px; margin-top:3px; margin-left:4px; '></i><textarea placeholder='Search' onclick='show()' style='resize:none; box-sizing:border-box; padding-left:25px; padding-top:4px;  width:100%;  height:30px;'>
</textarea>
</div>
<div class="button-group">
	<h2>Trending</h2>
	<button type="button" class="rapmusic">Rap</button><button class="soulmusic" type="button">Soul Music</button><button type="button" class="afropop">Afropop</button><button type="button" class="instrumental">Beats</button>
</div>
<div class="show-data-box" id="show-data-box">
	
</div>
<script type="text/javascript">
	$(".rapmusic").on("click", function(){
    $.ajax({
  url:'findrapsongs.php',
  type:'POST',
  async:false,
  data:{id:$("#infodata").val()},
  success:function(response){
 $("#show-data-box").html(response);
  }
});
	});
	$(".soulmusic").on("click", function(){
    $.ajax({
  url:'findsoul.php',
  type:'POST',
  async:false,
  data:{id:$("#infodata").val()},
  success:function(response){
 $("#show-data-box").html(response);
  }
});
	});
	$(".afropop").on("click", function(){
    $.ajax({
  url:'findafropop.php',
  type:'POST',
  async:false,
  data:{id:$("#infodata").val()},
  success:function(response){
 $("#show-data-box").html(response);
  }
});
	});
	$(".instrumental").on("click", function(){
    $.ajax({
  url:'findinstrumental.php',
  type:'POST',
  async:false,
  data:{id:$("#infodata").val()},
  success:function(response){
 $("#show-data-box").html(response);
  }
});
	});
</script>
<?php
mysqli_close($conn);
}
?>
</body>
</html>