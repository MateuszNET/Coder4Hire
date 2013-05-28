<?php
	include 'PHP_Includes/header_check.php';
	include 'PHP_Includes/job_system.php';
	
	$_SESSION['PreviousURL'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Coder4Hire - Jobs</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<link href="css/c4h_login.css" rel="stylesheet">
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/bootstrap-responsive.css" rel="stylesheet">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
		<![endif]-->

		<!-- Fav and touch icons -->
		<link rel="shortcut icon" href="ico/favicon.png">
		<script>
			(function(document) {
				'use strict';

				var LightTableFilter = (function(Arr) {

					var _input;

					function _onInputEvent(e) {
						_input = e.target;
						var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
						Arr.forEach.call(tables, function(table) {
							Arr.forEach.call(table.tBodies, function(tbody) {
								Arr.forEach.call(tbody.rows, _filter);
							});
						});
					}

					function _filter(row) {
						var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
						row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
					}

					return {
						init: function() {
							var inputs = document.getElementsByClassName('table-filter');
							Arr.forEach.call(inputs, function(input) {
								input.oninput = _onInputEvent;
							});
						}
					};
				})(Array.prototype);

				document.addEventListener('readystatechange', function() {
					if (document.readyState === 'complete') {
						LightTableFilter.init();
					}
				});

			})(document);
		</script>
	</head>

	<body>

		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="brand" href="#">Coder4Hire</a>
					<div class="nav-collapse collapse">
						<ul class="nav">
							<li><a href="home.php">Home</a></li>
							<li class="active"><a href="#">Jobs</a></li>
							<li ><a href="scripts.php">Scripts</a></li>
							<?php if($_SESSION['IsMod'] == 1) { 
								echo '<li><a href="admin.php">Admin</a></li>';
								} ?>
							<li><a href="index.php?logout">Logout</a></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>

		<div id='container' class="container" style="background-color: #FFFFFF;border-radius:5px;">
			<h1>Welcome, <?php echo $Steam->response->players[0]->personaname ?></h1></br>
			<div class="input-append search">
				<input type="search" class="table-filter" data-table="table table-striped" placeholder="Filter" /></br>
			</div>
			<div class='span2'>
					<a href='new_job.php'> <button class="btn btn-primary" type="button">Submit A Job</button></a>
			</div>
			<table id='scripts' summary='GMod Scripts' class="table table-striped">
				<thead>
					<tr>
						<th scope='col'></th>
						<th scope='col'>Job Name</th>
						<th scope='col'></th>
						<th scope='col'>Job Price</th>
						<th scope='col'></th>
						<th scope='col'>Hirer Name</th>
						<th scope='col'>Due Date</th>
						<th scope='col'></th>
						<th scope='col'>Info</th>
						<th scope='col'></th>
					</tr>
				</thead>
				<tbody>
				<?php
					buildjobtable(200,$Steam->response->players[0]->steamid);
				?>
				</tbody>
			</table>
		</div> <!-- /container -->
		
		<div class="navbar navbar-fixed-bottom">
			<div class="navbar-inner">
				<div id='footer' class="container">
					<p>Powered by <a  href="http://steampowered.com/" alt="Powered by Steam">Steam</a></p>
				</div>
			</div>
		</div>

		<!-- Le javascript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script src="js/bootstrap-transition.js"></script>
		<script src="js/bootstrap-alert.js"></script>
		<script src="js/bootstrap-modal.js"></script>
		<script src="js/bootstrap-tab.js"></script>
		<script src="js/bootstrap-button.js"></script>

	</body>
</html>
