<?php 
	include 'PHP_Includes/profile_system.php';
	
	if (isset($_GET['id']) && !empty($_GET['id'])) {
		if(strlen($_GET['id']) == 17) {
			$ProfileSteam = json_decode(file_get_contents("cache/ISteamUser/{$_GET['id']}.json"));
			$UserStats = build_user_stats($ProfileSteam->response->players[0]->steamid);
			$ProfileSteamID = $ProfileSteam->response->players[0]->steamid;
			$HireRep = $UserStats['UHR'];
			$CoderRep = $UserStats['UCR'];
		} else {
			header("Location: error.php?eid=1");
		}
	} else {
		header("Location: error.php?eid=1");
	}

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
							<li><a href="home.php"><img src="Images/FatCow_16x16/button_navigation_back.png" alt="Back Button" /> Back</a></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>

		<div id='container' class="container" style="background-color: #FFFFFF;border-radius:5px;">
		
			<h1><?php echo $ProfileSteam->response->players[0]->personaname ?>'s Profile</h1></br>
			
			<div id="Profile_Fluid" class="container-fluid">
				<div id="Profile_Fluid_Row" class="row-fluid">
					<img id="profile_image" src="<?php echo $ProfileSteam->response->players[0]->avatarfull ?>" /></br></br>
				</div>
			</div>
			
			<h3 id="Profile_Job_H3">Their Jobs</h3>
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
					</tr>
				</thead>
				<tbody>
					<?php echo build_home_jobs($ProfileSteamID); ?>
				</tbody>
			</table>
			</br>
			
			<h3>Their Scripts</h3>
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
					</tr>
				</thead>
				<tbody>
				 <?php echo build_home_scripts($ProfileSteamID); ?>
				</tbody>
			</table>
			</br>
			
			<h3>Their Coding Jobs</h3>
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
				<?php echo build_home_coding_jobs($ProfileSteamID); ?>
				</tbody>
			</table>
			<hr class="soften_v2 border" />
			<div class="row-fluid">
				<div class="span12" id="center_text">
					</br>
					<p>
						<button class="btn btn-primary disabled" type="button" title="<?php echo $ProfileSteam->response->players[0]->loccountrycode ?>"><img  src="Images/flags/<?php echo strtolower($ProfileSteam->response->players[0]->loccountrycode) ?>.png" alt="Back Button" /></button>
						<button class="btn btn-primary disabled" type="button" title="HireRep"><?php if ($HireRep >= 0){
							echo "+{$HireRep} <img id='script_price' src='Images/FatCow_16x16/thumb_up.png' alt='HireRep+' />";
						} else { 
							echo "-{$HireRep} <img id='script_price' src='Images/FatCow_16x16/thumb_down.png' alt='HireRep-' />"; 
						} ?></button>
						<button class="btn btn-primary disabled" type="button" title="CoderRep"><?php if ($CoderRep >= 0){
							echo "+{$CoderRep} <img id='script_price' src='Images/FatCow_16x16/script.png' alt='CoderRep+' />";
						} else { 
							echo "-{$CoderRep} <img id='script_price' src='Images/FatCow_16x16/script.png' alt='CoderRep-' />"; 
						} ?></button>
						<?php echo '<a title="Steam Profile" href="http://www.steamcommunity.com/profiles/'.$ProfileSteam->response->players[0]->steamid.'/" target="_blank">'; ?><button class="btn btn-primary" type="button">STEAM&trade;</button></a>
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
