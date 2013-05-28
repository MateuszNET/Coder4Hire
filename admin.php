<?php
	include 'PHP_Includes/admin_system.php';
	include 'PHP_Includes/header_check.php';
	
	if ($_SESSION['IsMod'] != 1) {
		header("Location: error.php?eid=13");
	}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Coder4Hire - Admin</title>
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
							<li><a href="jobs.php">Jobs</a></li>
							<li><a href="scripts.php">Scripts</a></li>
							<li class="active"><a href="admin.php">Admin</a></li>
							<li><a href="index.php?logout">Logout</a></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>

		<div id='container' class="container" style="background-color: #FFFFFF;border-radius:5px;">
			<h1>Welcome Moderator, <?php echo $Steam->response->players[0]->personaname ?></h1>
			<div class="alert alert-error">At the moment banning is permanent, be carefull!</div>
			<div class="alert alert-warning">Jobs wanting illegal gamemodes should be closed.</div>
			<div id="Response" ></div>
			<table id='reports' summary='GMod Scripts' class='table table-striped'>
				<thead>
					<tr>
						<th scope='col'>Reporter Name</th>
						<th scope='col'>Report Type</th>
						<th scope='col'>Report Comment</th>
						<th scope='col'>View</th>
						<th scope='col'>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php build_reports() ?> 
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
		<script src="js/bootstrap-dropdown.js"></script>
		<script src="js/bootstrap-tooltip.js"></script>
		<script src="js/bootstrap-button.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function() {
				//##### Add record when Add Record Button is clicked #########
				$(".BanReporter").click(function (e) {
				   
					var myData = "command=banreporter&"+"id="+$(e.target).val(); //post variables
				   
					jQuery.ajax({
						type: "POST", // HTTP method POST or GET
						url: "admin_commands.php", //Where to make Ajax calls
						dataType:"text", // Data type, HTML, json etc.
						data:myData, //post variables
						success:function(response){
							$("#Response").prepend(response);
						},
						error:function (xhr, ajaxOptions, thrownError){
							alert(thrownError); //throw any errors
						}
					});
				});
				
				$(".RemoveReport").click(function (e) {
				   
					var myData = "command=removereport&"+"id="+$(e.target).val(); //post variables
				   
					jQuery.ajax({
						type: "POST", // HTTP method POST or GET
						url: "admin_commands.php", //Where to make Ajax calls
						dataType:"text", // Data type, HTML, json etc.
						data:myData, //post variables
						success:function(response){
							$("#Response").prepend(response);
						},
						error:function (xhr, ajaxOptions, thrownError){
							alert(thrownError); //throw any errors
						}
					});
				});
				
				$(".BanOwner").click(function (e) {
				   
					var myData = "command=banowner&"+"id="+$(e.target).val(); //post variables
				   
					jQuery.ajax({
						type: "POST", // HTTP method POST or GET
						url: "admin_commands.php", //Where to make Ajax calls
						dataType:"text", // Data type, HTML, json etc.
						data:myData, //post variables
						success:function(response){
							$("#Response").prepend(response);
						},
						error:function (xhr, ajaxOptions, thrownError){
							alert(thrownError); //throw any errors
						}
					});
				});
				
				$(".Close").click(function (e) {
				   
					var myData = "command=closejob/script&"+"id="+$(e.target).val(); //post variables
				   
					jQuery.ajax({
						type: "POST", // HTTP method POST or GET
						url: "admin_commands.php", //Where to make Ajax calls
						dataType:"text", // Data type, HTML, json etc.
						data:myData, //post variables
						success:function(response){
							$("#Response").prepend(response);
						},
						error:function (xhr, ajaxOptions, thrownError){
							alert(thrownError); //throw any errors
						}
					});
				});
				
				$(".CloseJob").click(function (e) {
				   
					var myData = "command=closejobscript&"+"type=job&"+"id="+$(e.target).val(); //post variables
				   
					jQuery.ajax({
						type: "POST", // HTTP method POST or GET
						url: "admin_commands.php", //Where to make Ajax calls
						dataType:"text", // Data type, HTML, json etc.
						data:myData, //post variables
						success:function(response){
							$("#Response").prepend(response);
						},
						error:function (xhr, ajaxOptions, thrownError){
							alert(thrownError); //throw any errors
						}
					});
				});
				$(".CloseScript").click(function (e) {
				   
					var myData = "command=closejobscript&"+"type=script&"+"id="+$(e.target).val(); //post variables
				   
					jQuery.ajax({
						type: "POST", // HTTP method POST or GET
						url: "admin_commands.php", //Where to make Ajax calls
						dataType:"text", // Data type, HTML, json etc.
						data:myData, //post variables
						success:function(response){
							$("#Response").prepend(response);
						},
						error:function (xhr, ajaxOptions, thrownError){
							alert(thrownError); //throw any errors
						}
					});
				});
			});
		</script>

	</body>
</html>