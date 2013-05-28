<?php
	include('PHP_Includes/header_check.php');
	include 'PHP_Includes/job_system.php';
	include 'PHP_Includes/script_system.php';
	
	$Error = 0;
	
	if(isset($_GET['type']) && isset($_GET['id'])) {
		$Type = $_GET['type'];
		$ID = $_GET['id'];
		
		if ($Type == 'script') {
			
	
			$Script = build_script_information();
			
			$ScriptID 		= 	$Script['ScriptID'];
			$ScriptCreator	=	$Script['ScriptCreator'];
			$Title 			= 	$Script['Title'];
			$Price 			= 	$Script['Price'];
			$ScriptDesc 	= 	$Script['NoHTMLDesc'];
			
			if($Steam->response->players[0]->steamid != $ScriptCreator->response->players[0]->steamid) {
				die('Bad!');
			}
			
		} else if ($Type == 'job') {
		
			$Job = build_job_information($Steam->response->players[0]->steamid);
			
			$JobID = $Job['JobID'];
			$Title = $Job['Title'];
			$Owner = $Job['Owner'];
			$JobCreator = $Job['JobCreator'];
			$JobDesc = $Job['NoHTMLDesc'];
			$JobTime = $Job['JobTime'];
			$JobFinished = $Job['JobFinished'];
			$JobProgress = $Job['JobProgress'];
			$Closed = $Job['Closed'];
			
			if ($JobProgress != '') {
				$Error = 12;
			} else if ($JobFinished == 1 or $Closed == 1) {
				$Error = 13;
			}
			
			if($Steam->response->players[0]->steamid != $JobCreator->response->players[0]->steamid) {
				die('Bad!');
			}
		
		} else {
			$Error = 2;
		}
	} else {
		$Error = 1;
	}
	
	if ($Error > 0) {
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=error.php?eid=".$Error."'>";
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
		<script language="javascript" type="text/javascript" src="js/datetimepicker.js"></script>
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

		<div id='container'  class="container" style="background-color: #FFFFFF;border-radius:5px;">
			<h1>Editing <?php echo $Type ?>, <?php echo $Title ?></h1></br>
			<?php 
				if ($Type == 'job') {
				echo '<form action="edit_submit.php" method="post" >
					<input type="hidden" value="'.$Type.'" name="type">
					<input type="hidden" value="'.$ID.'" name="id">
					<label class="checkbox"><input type="checkbox" value="1" name="delete">Delete?</label>
					<label class="formlabel" for="title">Job Title: </label><input value="'.$Title.'" type="text" name="title" required/></br>
					<label class="formlabel" for="date">Job Completion Date: </label><input id="date" value="'.$JobTime.'" type="text" name="date" onkeypress="return disable_input(this, event)" required/> <a id="calendar" href="javascript:NewCal("date","ddmmmyyyy",true,24)"><img src="Images/FatCow/calendar.png" alt="Pick a date" ></a></br>
					<label class="formlabel" for="desc">Job Description: </label><textarea class="field span6" maxlength="255" name="desc" rows=3 cols=60 >'.$JobDesc.'</textarea></br>
					<input class="forminput" type="submit" value="Submit" /><br></br>
				</form>';
				} else if($Type == 'script'){
				echo '<form action="edit_submit.php" method="post" enctype="post" >
						<input type="hidden" value="'.$Type.'" name="type">
						<input type="hidden" value="'.$ID.'" name="id">
						<label class="checkbox"><input type="checkbox" value="1" name="delete">Delete?</label>
						<label class="formlabel" for="title">Script Title: </label><input class="forminput" value="'.$Title.'" placeholder="Script Title or Name" type="text" name="title" required/></br>
						<label class="formlabel" for="price">Script Price: </label><input class="forminput" value="'.$Price.'" type="number" onkeypress="return numbersonly(this, event)" name="price" min="1" max="999" required/></br></br></br>
						<label class="formlabel" for="desc">Script Description: </label><textarea class="field span6" maxlength="255" name="desc" rows="6" cols="60" placeholder="Script Description here...">'.$ScriptDesc.'</textarea></br></br></br>
						<input class="forminput" type="submit" value="Submit" /><br></br></br>
					</form>';
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