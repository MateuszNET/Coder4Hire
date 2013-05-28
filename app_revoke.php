<?php
	include 'PHP_Includes/header_check.php';
	
	if(isset($_POST['ID']) && !empty($_POST['ID'])) {
		if(is_numeric($_POST['ID']) == false) { 
			die("Bad");
		}

		$Query = "UPDATE Job_Applications SET Revoked='1' WHERE OwnerID='".$_SESSION['T2SteamID64']."' AND JobID='".$_POST['ID']."' ";
		mysql_query($Query) or die(mysql_error());

		echo '<div class="alert alert-success"><img src="Images/FatCow/tick.png" /> <p>Your application has been revoked!</p></div>';
		echo "<meta HTTP-EQUIV='REFRESH' content='2; url=view_job.php?id=".$_POST['ID']."'>";
	} else {
		echo "No ID";
	}

?>