<?php
	include 'PHP_Includes/header_check.php';
	
	if(isset($_POST['email']) && !empty($_POST['email'])) {
		$email = mysql_escape_string($_POST['email']);
		if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) {  
			$msg = 'The email you have entered is invalid, please try again.'; 
		} else {  
			$msg = 'Your account has been made, <br /> please verify it by clicking the activation link that has been send to your email.'; 
			$hash = hash('md5', $email);
			$Query =  (string)"UPDATE Users SET EMail='".$email."',Activation_Key='".$hash."' WHERE SteamID64='".$_SESSION['T2SteamID64']."' ";
			
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
			
			echo '<p class="alert alert-success"><img src="Images/FatCow/tick.png" alt="Success" /> You have resubmited your email, and another verification email has been sent!</p>';
		} 
		
	}
	
?>