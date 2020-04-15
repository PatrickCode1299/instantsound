<?php
if(isset($_COOKIE['user'])&&isset($_COOKIE['email']) && isset($_COOKIE['phone'])){
	header('Location:home.php');
}else{
if(isset($_SESSION['u_email'])){
	header('Location:home.php');
}else{
?>
<?php
include_once 'header.php';
?>
<section>
<div class="contenido">
<ul class="backgroundslider">
<li></li>
<li></li>
<li></li>
<li></li>	
</ul>
<div class='space-form-class'>
		<h4 style='text-align:center; color:white;'>Instantsound Sign Up</h4>
	<form method='POST' class='ajax' style=' width:300px; padding:5px 5px; margin:0 auto;  margin-bottom:5px;' action='<?php echo htmlspecialchars("signup.php"); ?>' align='center'>
		<span><i class='fa fa-user' style='color:white; font-size:15px; margin-right:5px;'></i></span><input type='text' name='username' placeholder='username' id='join-username' align='center' onkeydown='checkusername()' onmouseout='hide()' required><br />
		<p id='result' style='color:red;'></p>
		<span><i class='fa fa-phone' style='color:white; font-size:15px; margin-right:5px;'></i></span><input type='text' name='phone' placeholder='phone' id='join-username' align='center' onkeydown='checkphone()' onmouseout='hidephone()' required><br />
		<p id='resultphone' style='color:red;'></p>
		<span><i class='fa fa-envelope' style='color:white; font-size:15px; margin-right:5px;'></i></span><input type='email' name='email' id='join-username' placeholder='john@example.com' required><br />
		<p id='resultemail'></p>
	    <span><i class='fa fa-key' style='color:white; font-size:15px; margin-right:5px;'></i></span><input type='password' name='password' placeholder='password' id='join-username' align='center' onkeydown='checkpass()' onmouseout='hidepass()' required><br />
	    <p id='resultpass' style='color:red;'></p>
		<span style='color:white;'><i class='fa fa-birthday-cake' style='color:white; font-size:15px; margin-right:5px;'></i></span><input type='date' name='birthday' id="join-username" style='margin-top:8px;' align='center'><br />
		<p style='color:red;'>By signing up Read Our <a href='terms.htm'>Terms thoroughly</a></p>
		<button type='submit' name='join' id='join-button'>Join</button>
		<p id='error' style='background:pink; padding-left:5px; padding-top:3px; padding-bottom:3px; padding-right:5px; position:fixed; margin:0 auto; left:10%; right:10%; height:40px; top:20%; bottom:auto; margin-top:30px; z-index:1; border-radius:5px; color:red; display:none;'></p>
	</form>
</div>
</div>
<script type="text/javascript">
$('form.ajax').on('submit' ,function(){
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
function checkusername(){
	$("#result").html("Cannot be less than 3 characters");
}
function checkphone(){
	$("#resultphone").html("Cannot be less than 11 characters and must be a valid digit");
}
function hide(){
	$("#result").html("");
}
function checkpass(){
	$("#resultpass").html("Cannot be less than six characters and must contain alphanumeric chars");
}
function hidepass(){
	$("#resultpass").html("");
}
function hidephone(){
	$("#resultphone").html("");
}
function hideresponse(){
	$("#error").css('display','none');
}
</script>
</section>
<footer style=' width:100%; box-sizing:border-box;'>
	<br />
	<ul style='list-style:none; padding-top:2px; margin-bottom:0px; color:white; padding-bottom:2px; text-align:center;'>
		<a href='ad.php'><li style='display:inline; padding-left:5px; font-size:18px; color:red; cursor:pointer;'>Advertise</li></a>
		<a href='terms.htm'><li style='display:inline; padding-left:5px; font-size:18px; color:red; cursor:pointer;'>Terms</li></a>
		<a href='contact.htm'><li style='display:inline; padding-left:5px; font-size:18px; color:red; cursor:pointer;'>Contact</li></a>
	</ul>
	<p style='text-align:center; margin-top:0px;' id='copyright'>Copyright Instantsound Community &copy; 2019</p>
</footer>
<noscript>Oh no you can't disable javascript on this browser am not gonna work.</noscript>
</body>
</html>
<?php
  }
}
?>