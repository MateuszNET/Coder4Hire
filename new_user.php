<?php
	include 'PHP_Includes/header_check.php';
	
	if(isset($_POST['email']) && !empty($_POST['email'])) {
		$email = mysql_escape_string($_POST['email']);
		if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) {  
			$msg = 'The email you have entered is invalid, please try again.'; 
		} else {  
			$msg = 'Your account has been made, <br /> please verify it by clicking the activation link that has been send to your email.'; 
			$hash = hash('md5', $email);
			$Query =  (string)"INSERT INTO Users (SteamID64, EMail, Activation_Key) VALUES ('".$_SESSION['T2SteamID64']."', '".mysql_escape_string($email)."', '".$hash."') ";
			
			mysql_query($Query) or die(mysql_error());

			$to      = $email; // Send email to our user  
			$subject = 'Coder4Hire | Verification'; // Give the email a subject   
			$message = ' 

			Thanks for signing up! 
			Your account has been created, you can login after you have activated your account by pressing the url below. 

			Please click this link to activate your account: 

			http://coder4hire.net/verify_user.php?email='.$email.'&hash='.$hash.' 

			';

			$headers = 'From:noreply@coder4hire.net' . "\r\n"; // Set from headers  
			mail($to, $subject, $message, $headers); // Send our email  
		} 
		
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

		<div id="container" class="container" style="background-color: #FFFFFF;border-radius:5px;">
			<h1>Welcome, <?php echo $Steam->response->players[0]->personaname ?></h1>
			<p><?php echo $msg ?></p>
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
