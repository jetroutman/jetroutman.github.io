<?php include 'menu.php';?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>CSI 415</title>

	<link type="text/css" rel="stylesheet" href="webcss.css"/>
	<style>
		body{
			background-color: #171717;
			font-size: 24px;
			color: white;
		}
	</style>
  </head>


  <body class="container-fluid">
	<div class="header row">
		<div class="col-xs-12 col-sm-5 col-md-4">
			<h1>Group 1</h1>
		</div>
		<div class="col-xs-12 col-sm-7 col-md-8 text-center">
			<h3>The Collaboration of McKendree Knowledge</h3>
		</div>
	</div>
	<h1>Login to your session of the game</h1>

	<div class="col-xs-12 col-md-6">
		<h2>Login</h2>
		<form action="LAB5/login_action.php" method="GET">
			User Name: <input type="text" id="username" name="username" placeholder="Enter name">
			Password: <input type="password" id="password" name="password" placeholder="Enter Password">
		<input type="submit" value="Submit">
		</form>
	</div>

	<div class="col-xs-12 col-md-6">
		<h2>Create New User</h2>
		<form action="LAB5/create_user_action.php" method="GET">
			User Name: <input type="text" id="username" name="username" placeholder="Enter desired user name">
			Password: <input type="password" id="password" name="password" placeholder="Enter Password">
		<input type="submit" value="Submit">
		</form>
	</div>
	<div><a class="mapbutton" href="LAB5/mapmaker.php">Map Maker</a></div>
</body>
</html>