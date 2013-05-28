<?php 
	include 'PHP_Includes/home_system.php';
	
	$Stats = build_home_stats();
	$UserStats = build_user_stats();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Coder4Hire - Home</title>
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
							<li class="active"><a href="#">Home</a></li>
							<li><a href="jobs.php">Jobs</a></li>
							<li><a href="scripts.php">Scripts</a></li>
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
		
			<h1>Welcome, <?php echo $Steam->response->players[0]->personaname ?></h1>
			
			<h3>Your Jobs</h3>
			<?php if($UserStats['UJ'] >= 1 ) { echo "
			<table id='scripts' summary='GMod Scripts' class='table table-striped'>
				<thead>
					<tr>
						<th scope='col'></th>
						<th scope='col'>Job Name</th>
						<th scope='col'></th>
						<th scope='col'>Job Price</th>
						<th scope='col'></th>
						<th scope='col'>Coder Name</th>
						<th scope='col'>Due Date</th>
						<th scope='col'></th>
						<th scope='col'>Info</th>
						<th scope='col'>Edit</th>
					</tr>
				</thead>
				<tbody>
					"; 
				build_home_jobs(); 
				echo "
				</tbody>
			</table>"; } else {
				echo '<p id="job_new_ban" class="alert alert-info">You have no jobs.</p>';
			} ?>
			</br>
			
			<h3>Your Scripts</h3>
			<?php if($UserStats['US'] >= 1 ) { echo "
			<table id='scripts' summary='GMod Scripts' class='table table-striped'>
				<thead>
					<tr>
						<th scope='col'></th>
						<th scope='col'>Script Name</th>
						<th scope='col'></th>
						<th scope='col'>Script Price</th>
						<th scope='col'></th>
						<th scope='col'>Info</th>
						<th scope='col'></th>
						<th scope='col'></th>
						<th scope='col'>Edit</th>
					</tr>
				</thead>
				<tbody>
					";
				build_home_scripts();
				echo "
				</tbody>
			</table>
			";} else {
				echo '<p id="job_new_ban" class="alert alert-info">You have no scripts.</p>';
			}
			?>
			</br>
			
			<h3>Your Coding Jobs</h3>
			<?php if($UserStats['UCJ'] >= 1 ) { echo "
			<table id='scripts' summary='GMod Scripts' class='table table-striped'>
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
					</tr>
				</thead>
				<tbody>
					";
				build_home_coding_jobs();
				echo "
				</tbody>
			</table>
			";} else {
				echo '<p id="job_new_ban" class="alert alert-info">You have no coding jobs.</p>';
			}
			?>
			<hr class="soften_v2 border" />
			<div class="row-fluid">
				<div class="span12" id="center_text">
					</br>
					<p>
						<button class="btn btn-info disabled" type="button" title="Your Jobs"><?php echo "Your Jobs: ".$UserStats['UJ'] ?></button>
						<button class="btn btn-info disabled" type="button" title="Your Completed Jobs"><?php echo "Your Completed Jobs: ".$UserStats['UJC'] ?></button>
						<button class="btn btn-info disabled" type="button" title="Your Completed Jobs"><?php echo "Your Coding Jobs: ".$UserStats['UCJ'] ?></button>
						<button class="btn btn-info disabled" type="button" title="Your Expenses"><?php echo "Your Expenses: $".$UserStats['USPT'] ?></button>
						<button class="btn btn-info disabled" type="button" title="Your Profit"><?php echo "Your Profit: $".$UserStats['UP'] ?></button>
						<button class="btn btn-info disabled" type="button" title="Your Scripts"><?php echo "Your Scripts: ".$UserStats['US'] ?></button>
						<button class="btn btn-info disabled" type="button" title="Your CoderRep"><?php echo "Your CoderRep: ".$UserStats['UCR'] ?></button>
						<button class="btn btn-info disabled" type="button" title="Your HireRep"><?php echo "Your HireRep: ".$UserStats['UHR']; ?></button>
					</p>
				</div>
				<hr class="soften_v2 border" />
				<div class="span12" id="center_text">
					</br>
					<p>
						<button class="btn btn-primary disabled" type="button" title="Total Jobs"><?php echo "Total Jobs: ".$Stats['TJS'] ?></button>
						<button class="btn btn-primary disabled" type="button" title="Total Finished Jobs"><?php echo "Total Finished Jobs: ".$Stats['TCJS'] ?></button>
						<button class="btn btn-primary disabled" type="button" title="Total Payout"><?php echo "Total Payout: $".$Stats['TJP'] ?></button>
						<button class="btn btn-primary disabled" type="button" title="Total Scripts"><?php echo "Total Scripts: ".$Stats['TS'] ?></button>
					</p>
				</div>
			</div>
			
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
		<script src="js/bootstrap-scrollspy.js"></script>
		<script src="js/bootstrap-tab.js"></script>
		<script src="js/bootstrap-tooltip.js"></script>
		<script src="js/bootstrap-popover.js"></script>
		<script src="js/bootstrap-button.js"></script>
		<script src="js/bootstrap-collapse.js"></script>
		<script src="js/bootstrap-carousel.js"></script>
		<script src="js/bootstrap-typeahead.js"></script>

	</body>
</html>
