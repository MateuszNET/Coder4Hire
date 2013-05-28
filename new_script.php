<?php
	include('PHP_Includes/header_check.php');
	
	$result = mysql_query("SELECT * FROM Users WHERE SteamID64='{$_SESSION['T2SteamID64']}'");

	if (mysql_num_rows($result) == 1) {
		while($row = mysql_fetch_array($result))
		{
			if ($row['Activated'] == '0') {
				echo "<meta HTTP-EQUIV='REFRESH' content='0; url=register.php'>";
			}
			
			$CoderRep = $row['CoderRep_UP'] - $row['CoderRep_DOWN'];
		}
	} else if(mysql_num_rows($result) > 1) {
		exit('Two Users in Database: Quiting');
	} else {
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=register.php'>";
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Coder4Hire - New Script</title>
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
			function numbersonly(myfield, e, dec)
			{
				var key;
				var keychar;

				if (window.event)
					key = window.event.keyCode;
				else if (e)
					key = e.which;
				else
				   return true;
				keychar = String.fromCharCode(key);

				if ((key==null) || (key==0) || (key==8) || 
					(key==9) || (key==13) || (key==27) )
				   return true;
				else if ((("0123456789").indexOf(keychar) > -1))
				   return true;
				else if (dec && (keychar == "."))
				{
				   myfield.form.elements[dec].focus();
				   return false;
				}
				else
				   return false;
			}
			function disable_input(myfield, e, dec)
			{
				return false;
			}
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
						<ul class="nav">
							<li><a href="home.php">Home</a></li>
							<li><a href="scripts.php"><img src="Images/FatCow_16x16/button_navigation_back.png" alt="Back Button" /> Back</a></li>
						</ul>
				</div>
			</div>
		</div>

		<div id='container' class="container" style="background-color: #FFFFFF;border-radius:5px;">
			<h1>Welcome, <?php echo $Steam->response->players[0]->personaname ?></h1></br>
			<?php if($CoderRep < 3) {
					echo '<p id="job_new_warn" class="alert"><img src="Images/FatCow/error.png" alt="Failure" /> You are required to have a CoderRep of +3 before you can submit a script for public view! You currently have '.$CoderRep.'</p></br>';
				} else {
					echo '<p id="job_new_ban" class="alert alert-error"><img src="Images/FatCow/exclamation.png" alt="Warning" /> Misleading, derogatory and NSFW images will be removed and your account banned.</p></br>
					<p id="job_new_warn" class="alert alert-info">Best image size is 184x184 (They will be scaled). Accepted Extensions: PNG, JPEG, JPG and must be under 64Kb.</p></br>
					<form action="new_script_submit.php" method="post" enctype="multipart/form-data" >
						<label class="formlabel" for="file">Image: </label><input type="file" name="file" id="file" /></br></br>
						<label class="formlabel" for="title">Script Title: </label><input placeholder="Script Title or Name" type="text" name="title" required/></br>
						<label class="formlabel" for="price">Script Price: </label><input type="number" onkeypress="return numbersonly(this, event)" name="price" min="1" max="999" required/></br>
						<label class="formlabel" for="desc">Script Description: </label><textarea class="span4" maxlength="255" name="desc" rows=3 cols=60 placeholder="Script Description here..."></textarea></br></br></br>
						<input class="forminput" type="submit" value="Submit" /><br></br></br>
					</form>';
				} ?>
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