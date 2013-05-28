<?php
	include 'PHP_Includes/header_check.php';
	include 'PHP_Includes/job_system.php';
	
	$_SESSION['PreviousURL'] = $_SERVER['REQUEST_URI'];
	
	$Job = build_job_information($Steam->response->players[0]->steamid);
	
	$JobID = $Job['JobID'];
	$Title = $Job['Title'];
	$JobCreator = $Job['JobCreator'];
	$Owner = $Job['Owner'];
	$HireRep = $Job['HireRep'];
	$JobFinished = $Job['JobFinished'];
	$JobProgress = $Job['JobProgress'];
	$JobDesc = $Job['Desc'];
	$Revoked = $Job['Revoked'];
	$Price = $Job['Price'];
	$Applied = $Job['Applied'];
	$Days = $Job['Days'];
	$Hours = $Job['Hours'];
	$Minutes = $Job['Minutes'];
	
	$Closed = $Job['Closed'];
	$Closed_Reason = $Job['Closed_Reason'];
	
	if ($JobProgress != '') {
		$CoderSteam = json_decode(file_get_contents("cache/ISteamUser/{$JobProgress}.json"));
	}
?>

<!DOCTYPE html>
<html lang="en" class="fuelux">
	<head>
		<meta charset="utf-8">
		<title>Coder4Hire - Job</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/bootstrap-responsive.css" rel="stylesheet">

		<link href="dist/css/fuelux.min.css" rel="stylesheet">
		<link href="dist/radio.js" rel="stylesheet">
		
		<script src="lib/require.js"></script>
		<script type="text/javascript" src="js/gradualfader.js">
			/***********************************************
			* Gradual Element Fader- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
			* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
			* This notice must stay intact for legal use
			***********************************************/
		</script>
		<script type="text/javascript">// <![CDATA[
        function preloader(){
            document.getElementById("loading").style.display = "none";
        }//preloader
        window.onload = preloader;// ]]>
		</script>
		<script type="text/javascript">
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
		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
		<![endif]-->

		<!-- Fav and touch icons -->
		<link rel="shortcut icon" href="ico/favicon.png">
		<link href="css/c4h_login.css" rel="stylesheet">
	</head>
	
	<div id="loading" class="progress progress-striped active">
		<div class="bar" style="width: 40%;"></div>
    </div>
	</br>
	
	<div id="myModal" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Report Job</h3>
		</div>
		<div id="JobReport" class="modal-body">
			<div id="job_new_report" class="alert alert-error">Abuse of this system will result in a ban.</div></br>
			<label for="ReportText">Comment: </label><textarea id="ReportText" class="field span6" maxlength="120" name="report_txt" rows="3" cols="100" placeholder="Enter Comment" required></textarea></br>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			<button id="SubmitReport" class="btn btn-primary">Submit Report</button>
		</div>
	</div>
	
	<div id="myModal_2" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Apply For Job</h3>
		</div>
		<div id="JobApply" class="modal-body">
			<div id="job_new_app" class="alert alert-error">If you do not complete the job by the required time, you'll receive negative rep.</div></br>
			<label class="formlabel" for="price">Your Price: </label><input id="apply_price" type="number" onkeypress="return numbersonly(this, event)" name="apply_price" min="1" max="999" placeholder="<?php echo $Price ?>" required/></br>
			<label for="AppText">Comment: </label><textarea id="AppText" class="field span6" maxlength="70" name="app_txt" rows="3" cols="100" placeholder="Enter Comment" required></textarea></br>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			<button id="SubmitApplication" class="btn btn-primary">Submit Application</button>
		</div>
	</div>
	
	<div id="RevokeApp" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Revoke Application</h3>
		</div>
		<div id="JobRevoke" class="modal-body">
			<div id="job_revoke" class="alert alert-error">You can not re-apply once you've revoked your application.</div></br>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			<button id="RevokeApplication" class="btn btn-primary">Revoke Application</button>
		</div>
	</div>
	
	<div id="JobClose" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Finish Job</h3>
		</div>
		<div id="JobFinish" class="modal-body">
			<div id="job_finish" class="alert alert-error">Are you sure you want to finish this job?</div></br>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			<button id="FinishJob" class="btn btn-primary">Finish Job</button>
		</div>
	</div>
	
	<div id="ViewApplicants" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Job Applicants</h3>
		</div>
		<div id="JobApplicants" class="modal-body">
			<div id="job_applicants" class="alert alert-info">Here are the people who've applied to complete your job.</div></br>
			<table id='scripts' summary='GMod Scripts' class="table table-striped">
				<thead>
					<tr>
						<th scope='col'>Name</th>
						<th scope='col'>Price</th>
						<th scope='col'>Coder Rep</th>
						<th scope='col'>Comment</th>
						<th scope='col'>Accept</th>
					</tr>
				</thead>
				<tbody>
				<?php
					build_job_applicants();
				?>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		</div>
	</div>

	<body id="content">
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
							<li><a href="jobs.php"><img src="Images/FatCow_16x16/button_navigation_back.png" alt="Back Button" /> Back</a></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>
		
		<div id='container' class="container" style="background-color: #FFFFFF;border-radius:5px;">
			</br>
			<div id="myWizard" class="wizard">
				<ul class="steps">
					<li class="active"><span class="badge badge-info">1</span>Accepting Applications<span class="chevron"></span></li>
					<?php 
						if(isset($CoderSteam)){
							echo '<li class="active"><span class="badge badge-info">2</span>In Progress by <a href="profile.php?id='.$CoderSteam->response->players[0]->steamid.'" >'.$CoderSteam->response->players[0]->personaname.' <img class="img-rounded" src="'.$CoderSteam->response->players[0]->avatar.'" /></a><span class="chevron"></span></li>';
						} else {
							echo '<li><span class="badge">2</span>In Progress<span class="chevron"></span></li>';
						}
						if($JobFinished == 1 && $Closed == 0){
							echo '<li class="active"><span class="badge badge-info">3</span>Finished<span class="chevron"></span></li>';
						} else if($JobFinished == 0 & $Closed == 0) {
							echo '<li><span class="badge">3</span>Finished<span class="chevron"></span></li>';
						} else if($Closed == 1) {
							echo '<li><span class="badge">3</span>Job Closed by Moderation Team<span class="chevron"></span></li>';
						}
					?>
				</ul>
			</div><!-- /Wizard -->
			
			<h2 id='title'><?php
					echo "{$JobCreator->response->players[0]->personaname}'s Job: {$Title}</br>";
				?>
			</h1></br>
			
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span2">
					<!--Sidebar content-->
						<img id="job_image" src="<?php echo $JobCreator->response->players[0]->avatarfull ?>" /></br></br>
						<?php
							echo "<p id='Cost'><img id='price' src='Images/FatCow/money_dollar.png' alt='Job Price Image' />{$Price}</p>";
							echo "<img data-toggle='modal' data-target='#myModal' class='gradualfader' id='job_report' src='Images/FatCow/prohibition_button.png' alt='report' />";
							if ($Owner != $_SESSION['T2SteamID64'] && $Closed == 0) {
								if (($Applied == false && $Revoked == 0) && ($JobProgress == '' && $JobFinished == 0)) {
									echo "<button data-toggle='modal' data-target='#myModal_2' class='btn btn-primary' type='button'>Apply for this Job</button>";
								} else if(($Applied == true && $Revoked) == 0 && ($JobProgress == '' && $JobFinished == 0)) {
									echo "<button data-toggle='modal' data-target='#RevokeApp' class='btn btn-primary' type='button'>Revoke your Application</button>";
								} else {
									echo '<button class="btn btn-primary disabled" type="button">No Longer Accepting Applications</button>';
								}
							} else if(($JobProgress == '' && $JobFinished == 0) && $Closed == 0) {
								echo "<button data-toggle='modal' data-target='#ViewApplicants' class='btn btn-primary' class='btn btn-primary' type='button'>View Applicants</button>";
							} else if($JobFinished == 0 && $Closed == 0) {
								echo "<button data-toggle='modal' data-target='#JobClose' class='btn btn-primary' class='btn btn-primary' type='button'>Finish Job</button>";
							} else {
								echo '<button class="btn btn-primary disabled" type="button">No Longer Accepting Applications</button>';
							}
						?>
					</div>
						<p id='job_timeleft'>Time Left: <?php echo "{$Days} Days, {$Hours} Hours, {$Minutes} Minutes" ?> </p>
					<div class="span10" id="job_desc">
						</br>
						<p><?php echo $JobDesc ?></p>
					<!--Body content-->
					</div>
				</div>
			</div>
			
			<div class="row-fluid">
				<div class="span12" id="center_text">
					</br>
					<p>
						<button class="btn btn-primary disabled" type="button" title="<?php echo $JobCreator->response->players[0]->loccountrycode ?>"><img  src="Images/flags/<?php echo strtolower($JobCreator->response->players[0]->loccountrycode) ?>.png" alt="Back Button" /></button>
						<button class="btn btn-primary disabled" type="button" title="HireRep"><?php if ($HireRep >= 0){
							echo "+{$HireRep} <img id='script_price' src='Images/FatCow_16x16/thumb_up.png' alt='HireRep+' />";
						} else { 
							echo "-{$HireRep} <img id='script_price' src='Images/FatCow_16x16/thumb_down.png' alt='HireRep-' />"; 
						} ?></button>
						<?php echo '<a title="Steam Profile" href="http://www.steamcommunity.com/profiles/'.$JobCreator->response->players[0]->steamid.'/" target="_blank">'; ?><button class="btn btn-primary" type="button">STEAM&trade;</button></a>
						<?php echo '<a title="Steam Profile" href="profile.php?id='.$JobCreator->response->players[0]->steamid.'" >'; ?><button class="btn btn-primary" type="button">Profile</button></a>
					</p>
					<hr class="soften" />
					<div id="comments">
						</br>
						<?php build_job_comments($JobCreator,$Steam) ?>
					</div>
					<div id="comment_system">
						<?php build_job_comments_system($JobCreator,$Steam) ?>
					</div>
				</div>
			</div>
			
		</div> <!-- /container -->
		</br>
		
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
		<script src="js/bootstrap-popover.js"></script>
		<script src="js/bootstrap-button.js"></script>
		<script src="js/bootstrap-collapse.js"></script>
		
		<script type="text/javascript">
			gradualFader.init() //activate gradual fader
		</script type="text/javascript">
		<script type="text/javascript">
			var textarea = document.getElementById("ContentText");
			textarea.onkeyup = function() {
				var lines = textarea.value.split("\n");
				for (var i = 0; i < lines.length; i++) {
					if (lines[i].length <= 100) continue;
					var j = 0; space = 100;
					while (j++ <= 100) {
						if (lines[i].charAt(j) === " ") space = j;
					}
					lines[i + 1] = lines[i].substring(space + 1) + (lines[i + 1] || "");
					lines[i] = lines[i].substring(0, space);
				}
				textarea.value = lines.slice(0, 3).join("\n");
			};
			
			var textarea2 = document.getElementById("ReportText");
			textarea2.onkeyup = function() {
				var lines = textarea2.value.split("\n");
				for (var i = 0; i < lines.length; i++) {
					if (lines[i].length <= 100) continue;
					var j = 0; space = 100;
					while (j++ <= 100) {
						if (lines[i].charAt(j) === " ") space = j;
					}
					lines[i + 1] = lines[i].substring(space + 1) + (lines[i + 1] || "");
					lines[i] = lines[i].substring(0, space);
				}
				textarea2.value = lines.slice(0, 3).join("\n");
			};
			
			var textarea3 = document.getElementById("AppText");
			textarea3.onkeyup = function() {
				var lines = textarea3.value.split("\n");
				for (var i = 0; i < lines.length; i++) {
					if (lines[i].length <= 100) continue;
					var j = 0; space = 100;
					while (j++ <= 100) {
						if (lines[i].charAt(j) === " ") space = j;
					}
					lines[i + 1] = lines[i].substring(space + 1) + (lines[i + 1] || "");
					lines[i] = lines[i].substring(0, space);
				}
				textarea3.value = lines.slice(0, 3).join("\n");
			};
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
				//##### Add record when Add Record Button is clicked #########
				$("#FormSubmit").click(function (e) {
				   
					e.preventDefault();
				   
					if($("#ContentText").val() === "") //simple validation
					{
						alert("Please enter some text!");
						return false;
					}
				   
					var myData = "content_txt="+$("#ContentText").val()+"&JobID="+$("#JobID").val(); //post variables
				   
					jQuery.ajax({
						type: "POST", // HTTP method POST or GET
						url: "new_comment_submit.php", //Where to make Ajax calls
						dataType:"text", // Data type, HTML, json etc.
						data:myData, //post variables
						success:function(response){
							$("#comments").append(response);
							$("#ContentText").val(''); //empty text field after successful submission
						},
						error:function (xhr, ajaxOptions, thrownError){
							alert(thrownError); //throw any errors
						}
					});
				});
				$("#SubmitReport").click(function (e) {
				   
					e.preventDefault();
				   
					if($("#ReportText").val() === "") //simple validation
					{
						alert("Please enter some text!");
						return false;
					}
				   
					var myData = "report_txt="+$("#ReportText").val()+"&ID="+$("#JobID").val()+"&type=job"; //post variables
				   
					jQuery.ajax({
						type: "POST", // HTTP method POST or GET
						url: "new_report_submit.php", //Where to make Ajax calls
						dataType:"text", // Data type, HTML, json etc.
						data:myData, //post variables
						success:function(response){
							$("#job_new_report").remove()
							$("#JobReport").prepend(response);
							$("#ReportText").val(''); //empty text field after successful submission
						},
						error:function (xhr, ajaxOptions, thrownError){
							alert(thrownError); //throw any errors
						}
					});
				});
				$("#SubmitApplication").click(function (e) {
				   
					e.preventDefault();
				
					var myData = "app_txt="+$("#AppText").val()+"&ID="+$("#JobID").val()+"&price="+$("#apply_price").val(); //post variables
				   
					jQuery.ajax({
						type: "POST", // HTTP method POST or GET
						url: "new_app_submit.php", //Where to make Ajax calls
						dataType:"text", // Data type, HTML, json etc.
						data:myData, //post variables
						success:function(response){
							$("#SubmitApplication").remove()
							$("#job_new_app").remove()
							$("#JobApply").prepend(response);
							$("#AppText").val(''); //empty text field after successful submission
						},
						error:function (xhr, ajaxOptions, thrownError){
							alert(thrownError); //throw any errors
						}
					});
				});
				$("#RevokeApplication").click(function (e) {
				   
					e.preventDefault();

					var myData = "ID=<?php echo $JobID ?>"; //post variables
				   
					jQuery.ajax({
						type: "POST", // HTTP method POST or GET
						url: "app_revoke.php", //Where to make Ajax calls
						dataType:"text", // Data type, HTML, json etc.
						data:myData, //post variables
						success:function(response){
							$("#RevokeApplication").remove()
							$("#job_revoke").remove()
							$("#JobRevoke").prepend(response);
						},
						error:function (xhr, ajaxOptions, thrownError){
							alert(thrownError); //throw any errors
						}
					});
				});
				$(".AcceptApp").click(function (e) {
				   
					e.preventDefault();
					
					var myData = "ID=<?php echo $JobID ?>"+"&AppID="+$(e.target).val(); //post variables
					jQuery.ajax({
						type: "POST", // HTTP method POST or GET
						url: "accept_application.php", //Where to make Ajax calls
						dataType:"text", // Data type, HTML, json etc.
						data:myData, //post variables
						success:function(response){
							$(".AcceptApp").remove()
							$("#JobApplicants").prepend(response);
						},
						error:function (xhr, ajaxOptions, thrownError){
							alert(thrownError); //throw any errors
						}
					});
				});
				$("#FeedbackSubmit_Hire").click(function (e) {
				   
					e.preventDefault();
					
					var rep = 0;
					if ($('input[id=optionsRadios1]:checked', '#comment').val() === 'repup' ) {
						rep = 1;
					} else if ($('input[id=optionsRadios2]:checked', '#comment').val() === 'repnone' ) {
						rep = 2;
					} else if ($('input[id=optionsRadios3]:checked', '#comment').val() === 'repdown' ) {
						rep = 3;
					}
					
					var myData = "ID=<?php echo $JobID ?>"+"&who=hire&rep="+rep+"&feed_txt="+$("#ContentText").val(); //post variables
					jQuery.ajax({
						type: "POST", // HTTP method POST or GET
						url: "new_feedback.php", //Where to make Ajax calls
						dataType:"text", // Data type, HTML, json etc.
						data:myData, //post variables
						success:function(response){
							$("#FeedbackSubmit_Hire").remove();
							$("#ContentText").remove();
							$("#optionsRadios1").remove();
							$("#optionsRadios2").remove();
							$("#optionsRadios3").remove();
							$("#job_new_ban").remove();
							$("#comment").prepend(response);
						},
						error:function (xhr, ajaxOptions, thrownError){
							alert(thrownError); //throw any errors
						}
					});
				});
				
				$("#FinishJob").click(function (e) {
				   
					e.preventDefault();
					
					var myData = "id=<?php echo $JobID ?>"; //post variables
					jQuery.ajax({
						type: "POST", // HTTP method POST or GET
						url: "job_close.php", //Where to make Ajax calls
						dataType:"text", // Data type, HTML, json etc.
						data:myData, //post variables
						success:function(response){
							$("#FinishJob").remove()
							$("#job_finish").remove()
							$("#JobFinish").prepend(response);
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