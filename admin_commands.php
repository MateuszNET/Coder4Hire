<?php
	include 'PHP_Includes/header_check.php';
	
	if ($_SESSION['IsMod'] != 1) {
		header("Location: error.php?eid=13");
	}
	
	if(isset($_POST['command']) && !empty($_POST['id'])) {
		$ID = $_POST['id'];
		$Command = $_POST['command'];
		
		if(is_numeric($_POST['id']) == false) { 
			die("Bad");
		}
		
		if(isset($_POST['type'])){
			$Type = $_POST['type'];
		}
		
		if ($Command == 'banreporter') {
			$Query = "UPDATE Users SET Banned='1' WHERE SteamID64='".$ID."' ";
		} else if ($Command == 'banowner') {
			$result_Jobs = mysql_query("SELECT OwnerID FROM Jobs WHERE JobID='".$ID."' ");
			while($row = mysql_fetch_array($result_Jobs))
			{
				$Query = "UPDATE Users SET Banned='1' WHERE SteamID64='".$row['OwnerID']."' ";
			}
		} else if ($Command == 'removereport') {
			$Query = "DELETE FROM Reports WHERE ReportID='".$ID."' ";
		} else if ($Command == 'closejobscript') {
			if($Type == 'job'){
				$Query = "UPDATE Jobs SET Closed='1', Close_Reason='Closed by moderator.' WHERE JobID='".$ID."' ";
			} else if($Type == 'script'){
				$Query = "UPDATE Scripts SET Closed='1', Close_Reason='Closed by moderator.' WHERE ScriptID='".$ID."' ";
			}
		}
		
		mysql_query($Query) or die(mysql_error());
		echo '<div class="alert alert-success"><img src="Images/FatCow/tick.png" /> <p>Your command has been executed!</p></div>';
		echo "<meta HTTP-EQUIV='REFRESH' content='2; url=admin.php'>";
	} else {
		echo "No command / ID";
	}

?>