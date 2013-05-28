<?php
	include 'PHP_Includes/header_check.php';
	include 'PHP_Includes/script_system.php';
	
	$Script = build_script_information();
	
	$ScriptID 		= 	$Script['ScriptID'];
	$Title 			= 	$Script['Title'];
	$Price 			= 	$Script['Price'];
	$ScriptCreator 	= 	$Script['ScriptCreator'];
	$Image 			= 	$Script['Image'];
	$CoderRep 		= 	$Script['CoderRep'];
	$ScriptDesc 	= 	$Script['Desc'];
	
?>


<!DOCTYPE html>
<html lang="en" class="fuelux">
	<head>
		<meta charset="utf-8">
		<title>Coder4Hire - Script</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<link href="css/c4h_login.css" rel="stylesheet">
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/bootstrap-responsive.css" rel="stylesheet">

		<link href="dist/css/fuelux.css" rel="stylesheet">

		<script src="lib/require.js"></script>
		<script type="text/javascript" src="js/gradualfader.js">
			/***********************************************
			* Gradual Element Fader- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
			* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
			* This notice must stay intact for legal use
			***********************************************/
		</script>
		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
		<![endif]-->

		<!-- Fav and touch icons -->
		<link rel="shortcut icon" href="ico/favicon.png">
	</head>
	
	<div id="myModal" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Report Job</h3>
		</div>
		<div class="modal-body">
			<div id="job_new_report" class="alert alert-error">Abuse of this system will result in a ban.</div></br>
			<label for="ReportText">Comment: </label><textarea id="ReportText" class="field span6" maxlength="70" name="report_txt" rows="3" cols="100" placeholder="Enter Comment" required></textarea></br>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			<button id="SubmitReport" class="btn btn-primary">Submit Report</button>
		</div>
	</div>

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
							<li><a href="scripts.php"><img src="Images/FatCow_16x16/button_navigation_back.png" alt="Back Button" /> Back</a></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>
		<div id='container' class="container" style="background-color: #FFFFFF;border-radius:5px;">
			
			<h1><?php
					echo "{$ScriptCreator->response->players[0]->personaname}'s Script: {$Title}</br>";
				?>
			</h1></br>
			
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span2">
					<!--Sidebar content-->
						<img id="job_image" width="184" height="184" src="<?php echo $Image ?>" /></br></br>
						<p><?php  echo "<p id='Cost'><img id='script_price' src='Images/FatCow/money_dollar.png' alt='Script Price Image' />{$Price}</p></br></br>"; 
						echo "<img data-toggle='modal' data-target='#myModal' class='gradualfader' id='script_report' src='Images/FatCow/prohibition_button.png' alt='report' />";
						?></p>
					</div>
					<div class="span10">
						</br>
						<p><?php echo $ScriptDesc ?></p>
					<!--Body content-->
					</div>
				</div>
			</div>
			
			<div class="row-fluid">
				<div class="span12" id="center_text">
					</br>
					<p>
						<button class="btn btn-primary disabled" type="button" title="<?php echo $ScriptCreator->response->players[0]->loccountrycode ?>"><img  src="Images/flags/<?php echo strtolower($ScriptCreator->response->players[0]->loccountrycode) ?>.png" alt="Back Button" /></button>
						<button class="btn btn-primary disabled" type="button" title="CoderRep"><?php if ($CoderRep >= 0){
							echo "+{$CoderRep}<img id='script_price' src='Images/FatCow_16x16/thumb_up.png' alt='CoderRep+' />";
						} else { 
							echo "-{$CoderRep}<img id='script_price' src='Images/FatCow_16x16/thumb_down.png' alt='CoderRep-' />"; 
						} ?></button>
						<?php echo '<a title="Steam Profile" href="http://www.steamcommunity.com/profiles/'.$ScriptCreator->response->players[0]->steamid.'/" target="_blank">'; ?><button class="btn btn-primary" type="button">STEAM&trade;</button></a>
						<?php echo '<a title="Steam Profile" href="profile.php?id='.$ScriptCreator->response->players[0]->steamid.'/" >'; ?><button class="btn btn-primary" type="button">Profile</button></a>
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
		
		<script type="text/javascript">
			gradualFader.init() //activate gradual fader
		</script>
		<script>
			$(document).ready(function() {
				//##### Add record when Add Record Button is clicked #########
				$("#SubmitReport").click(function (e) {
				   
					e.preventDefault();
				   
					if($("#ReportText").val() === "") //simple validation
					{
						alert("Please enter some text!");
						return false;
					}
				   
					var myData = "report_txt="+$("#ReportText").val()+"&ID="+<?php echo $ScriptID ?>+"&type=script"; //post variables
				   
					jQuery.ajax({
						type: "POST", // HTTP method POST or GET
						url: "new_report_submit.php", //Where to make Ajax calls
						dataType:"text", // Data type, HTML, json etc.
						data:myData, //post variables
						success:function(response){
							$("#job_new_report").remove()
							$(".modal-body").prepend(response);
							$("#ContentText").val(''); //empty text field after successful submission
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