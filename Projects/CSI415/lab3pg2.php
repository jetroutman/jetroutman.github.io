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
		.inv {
			display: none;
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
	<h1>The Train Database</h1>
	<div class="navigation row" style="margin-left: 0px;">
		<a href="lab3.php">Train Current Location</a>
		<a class="current" href="lab3pg2.php">Train History</a>
		<a href="lab3pg3.php">Add Route</a>
	</div>
	<?php include 'LAB3/selecttrain.php';?>
    <script>
        document
            .getElementById('target')
            .addEventListener('change', function () {
                'use strict';
                var vis = document.querySelector('.vis'),
                    target = document.getElementById(this.value);
                if (vis !== null) {
                    vis.className = 'inv';
                }
                if (target !== null ) {
                    target.className = 'vis';
                }
        });
    </script>
</body>
</html>