<?php 
	session_start();
	
	include 'PHP_Includes/Mysql.inc.php';
	
	if(!isset($_SESSION['T2SteamAuth'])){
		header("Location: index.php");
	} else {
		$Steam = json_decode(file_get_contents("cache/ISteamUser/{$_SESSION['T2SteamID64']}.json"));
		
		$result = mysql_query("SELECT * FROM Users WHERE SteamID64='{$_SESSION['T2SteamID64']}'");
	
		if (mysql_num_rows($result) == 1) {
			while($row = mysql_fetch_array($result))
			{
				$_SESSION['IsBanned'] = $row['Banned'];
				$_SESSION['IsMod'] = $row['Moderator'];
				$_SESSION['PreviousURL'] = $_SERVER['REQUEST_URI'];
				
				$EMail = $row['EMail'];
			}
		} else if(mysql_num_rows($result) > 1) {
			exit('Two Users in Database: Quiting');
		}
		
		if ($_SESSION['IsBanned'] == 1) {
			header("Location: banned.php");
		}
	}
	
	$result1 = mysql_query("SELECT * FROM Users WHERE SteamID64='{$_SESSION['T2SteamID64']}'");

	$Registered = '';
	
	if(mysql_num_rows($result1) == 1){
		while($row = mysql_fetch_array($result1))
		{
			if ($row['Activation_Key'] == '' && $row['Activated'] == '1') {
				$Registered = "<p class='alert alert-error'>You've already registered and are activated, stop being an idiot!</p>";
			} else {
				$Registered = "<p class='alert alert-info'>You've already registered, please wait. An email has been sent to your email for verification.</p>
				<p class='alert alert-warning'>Please check your spam box aswell!</p>
				<label class='control-label' for='inputIcon'>Email address</label>
					<div class='controls'>
						<div class='input-prepend'>
							<span class='add-on'><i class='icon-envelope'></i></span>
							<input class='span2' id='inputIcon' type='email' name='email' value=".$EMail." required>
						</div>
					<button id='resubmit' class='btn' type='button'>RE-Submit</button>
 				</div>";
			}
		}
	} else {
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Coder4Hire - Registration</title>
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
							<li class="active"><a href="#">Home</a></li>
							<li><a href="index.php?logout">Logout</a></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>
		
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Coder4Hire</h3>
		</div>
		<div class="modal-body">
			<p>*We Take no responsibility for any loss in profit(s).</br>
			*The Rep here is only a guide.</br>
			*Spamming and ill-treatment of the system will result in a ban.</br>
			*Still use common sense!</br>
			</br>
			*Your personal information (E-Mail) will be used for verification purposes, and stored for future reference. Your email will not be given out!</br>
			*If you find an exploit, please report it, do not abuse it..</br>
			</p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		</div>
	</div>

		<div id="container" class="container" style="background-color: #FFFFFF;border-radius:5px;">
			<h1>Welcome, <?php echo $Steam->response->players[0]->personaname ?></h1>
			<?php 
				if($Registered == ''){
					echo '<form id="register" action="new_user.php" method="post">
					<div class="control-group" id="email">
						<label class="control-label" for="inputIcon">Email address</label>
						<div class="controls">
							<div class="input-prepend">
								<span class="add-on"><i class="icon-envelope"></i></span>
								<input class="span2" id="inputIcon" type="email" name="email" required>
							</div>
						</div>
						<label><input type="checkbox" class="checkbox" value="1" name="tos" required> Agree to the <a data-toggle="modal" data-target="#myModal" href="#">TOS</a></label>
						<input type="submit" value="Submit" />
					</div></form>
					';
				} else {
					echo $Registered;
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
		
		<script type="text/javascript">
		$(document).ready(function() {
			$("#resubmit").click(function (e) {
				   
				e.preventDefault();

				var myData = "email="+$("#inputIcon").val(); //post variables
				jQuery.ajax({
					type: "POST", // HTTP method POST or GET
					url: "resubmit_user.php", //Where to make Ajax calls
					dataType:"text", // Data type, HTML, json etc.
					data:myData, //post variables
					success:function(response){
						$(".control-label").remove()
						$("#container").append(response);
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
