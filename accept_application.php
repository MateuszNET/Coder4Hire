<?php
	include 'PHP_Includes/header_check.php';
	
	if(isset($_POST['ID']) && !empty($_POST['ID'])) {
		if(isset($_POST['AppID']) && !empty($_POST['AppID'])) {
			if(is_numeric($_POST['ID']) == false) { 
				die("Bad");
			}
			if(is_numeric($_POST['AppID']) == false) { 
				die("Bad");
			}
			
			$Query = "UPDATE Jobs SET Accepted_ID='".$_POST['AppID']."' WHERE JobID='".$_POST['ID']."' ";
			mysql_query($Query) or die(mysql_error());
		
			echo '<div class="alert alert-success"><img src="Images/FatCow/tick.png" /> <p> Success!</p></div>';
			echo "<meta HTTP-EQUIV='REFRESH' content='0; url=view_job.php?id=".$_POST['ID']."'>";
		} else {
			echo "No ID";
		}
	} else {
		echo "No Comment";
	}

?>