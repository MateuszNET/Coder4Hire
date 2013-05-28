<?php
	include 'PHP_Includes/header_check.php';
	include 'PHP_Includes/job_system.php';
	include 'PHP_Includes/script_system.php';
	
	function html2txt($document){
		$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
				   '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
				   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
				   '@<![\s\S]*?--[ \t]*>@'         // Strip multi-line comments including CDATA
		);
		$text = preg_replace($search, '', $document);
		return $text;
	}
	
	$Error = 0;
	
	if(isset($_POST['type']) && !empty($_POST['id'])) {
		$ID = $_POST['id'];
		$Type = $_POST['type'];
		$Title = mysql_escape_string(html2txt($_POST['title']));
		$Desc = mysql_escape_string(html2txt($_POST['desc']));
		
		if(is_numeric($_POST['id']) == false) { 
			die("Bad");
		}
		
		$Delete = 0;
		if(isset($_POST['delete']) && !empty($_POST['delete'])) {
			$Delete = $_POST['delete'];
		}
		
		if ($Type == 'script') {
			$Script = build_script_details();
			if($Steam->response->players[0]->steamid != $Script['ScriptCreator']->response->players[0]->steamid) {
				die('Bad!');
			}
		} else {
			$Job = build_job_details();
			if($Steam->response->players[0]->steamid != $Job['JobCreator']->response->players[0]->steamid) {
				die('Bad!');
			}
			if ($Job['JobProgress'] != '') {
				$Error = 12;
			} else if ($Job['JobFinished'] == 1) {
				$Error = 13;
			}
		}
		
		if ($Error > 0) {
			echo "<meta HTTP-EQUIV='REFRESH' content='0; url=error.php?eid=".$Error."'>";
		}
		
		if ($Delete == 1 && $Type == 'script') {
			$Query = "DELETE FROM Scripts WHERE ScriptID='".$ID."' ";
		} else if ($Delete == 1 && $Type == 'job') {
			$Query = "DELETE FROM Jobs WHERE JobID='".$ID."' ";
		} else if ($Type == 'script') {
			$Query = "UPDATE Scripts SET Title='".$Title."', Description='".$Desc."', Price='".$_POST['price']."' WHERE ScriptID='".$ID."'";
		} else if ($Type == 'job') {
			$Query = "UPDATE `Jobs` SET `Title`='".$Title."', `Description`='".$Desc."', `JobTime`='".$_POST['date']."' WHERE `JobID`='".$ID."'";
		}
		
		mysql_query($Query) or die(mysql_error());
	}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Coder4Hire - Edit</title>
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
					<a class="brand" href="#">Coder4Hire</a>
					<div class="nav-collapse collapse">
						<ul class="nav">
							<li><a href="home.php"><img src="Images/FatCow_16x16/button_navigation_back.png" alt="Back Button" /> Back</a></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>

		<div id="container" class="container" style="background-color: #FFFFFF;border-radius:5px;">
			<h1>Edit Submission</h1>
			<?php
				echo '<p class="alert alert-success"><img src="Images/FatCow/tick.png" alt="Success" /> Edit made successfully!</p>';
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