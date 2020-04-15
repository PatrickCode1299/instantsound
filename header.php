<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="description" content="An online music community  for upcoming artistes  in Africa and Nigeria to share their songs to listeners">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no"/>  
<link rel="icon" type="img/png" href="css/instar.png">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="fontawesome-free/css/all.css">
<script type="text/javascript" src='script/jquery-3.3.1.min.js'></script>
<script type="text/javascript" src="script/smallscreen.js"></script>
<title>Online Music Community For || Nigerian Musicians</title>
</head>
<body>
<header style="box-sizing:border-box;">
<a href='index.php'><span class='site-name'>Instantsound</span></a>
<button id='toggle-btn' class='toggle-btn' onclick='showsmallform()' ondblclick='sayhey()'><span style='background:black; width:20px;  height:5px; margin-top:2px; display:block;'>
</span>
<span style='background:black; width:20px; height:5px; margin-top:2px; display:block;'>
</span>
<span style='background:black; width:20px; height:5px; margin-top:2px; display:block;'>
</span>
</button>
<div  class='smallform' >
	<form method='POST' id='small-screen-form'   style=' margin-top:0px; box-sizing:border-box;' action='<?php echo htmlspecialchars('checklogin.php'); ?>'  class='ajax'>
	<input type='text' name='username' class='small-screen-bar' placeholder='username' required><br />
	<input type='password' name='password' class='small-screen-bar' placeholder='password' required><br />
	<button type='submit' name='submit' class='sign-in' style='width:100px; float:right; margin-left:0px; margin-top:3px; padding:2px 2px;'>Login</button>
	</form>
</div>
	<form method='POST' action='<?php echo htmlspecialchars('login.php'); ?>' id='login-form' class='ajax'>
	<input type='text' name='username' class='user-name-bar' placeholder='username' required>
	<input type='password' name='password' class='password-bar' placeholder='password' required>
	<button type='submit' name='submit' id='sign-in'>Login</button>
	</form>
</header>