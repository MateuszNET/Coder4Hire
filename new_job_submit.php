<?php
	include 'PHP_Includes/header_check.php';
	
	$Error = false;
	
	function html2txt($document){
		$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
				   '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
				   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
				   '@<![\s\S]*?--[ \t]*>@'         // Strip multi-line comments including CDATA
		);
		$text = preg_replace($search, '', $document);
		return $text;
	} 
	
	if(isset($_POST['title']) && !empty($_POST['desc'])) {
		$Title = mysql_escape_string($_POST['title']);
		$Desc = mysql_escape_string($_POST['desc']);
		
		if(is_numeric($_POST['price']) == false) { 
				die("Bad");
			}
		
		if ($Error == false)
		{
			$Date = date("Y-m-d H:i:s", strtotime($_POST['date']));
			$Query = "INSERT INTO Jobs (OwnerID, Title, Price, Description, JobTime, JobCreated) VALUES ('".$_SESSION['T2SteamID64']."', '".html2txt($Title)."', '".$_POST['price']."', '".html2txt($Desc)."', '".$Date."', '".date("Y-m-d H:i:s")."') ";
			mysql_query($Query) or die(mysql_error());
		}
	}

?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Coder4Hire - New Job Submission</title>
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
							<li><a href="jobs.php"><img src="Images/FatCow_16x16/button_navigation_back.png" alt="Back Button" /> Back</a></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>

		<div id='container' class="container" style="background-color: #FFFFFF;border-radius:5px;">
			<h1>Welcome, <?php echo $Steam->response->players[0]->personaname ?></h1></br>
			<?php
				if ($Error == false)
				{
					echo "<p id='job_new_ban' class='alert alert-success'><img src='Images/FatCow/tick.png' alt='Success' /> You've added the job to the list!</p></br>";
				} else {
					echo '<p id="job_new_warn" class="alert alert-error"><img src="Images/FatCow/error.png" alt="Failure" /> There was an error processing your submission, please try again later</p>';
				}
				?>
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