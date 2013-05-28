<?php
	include('PHP_Includes/header_check.php');
	include 'PHP_Includes/job_system.php';
	
	
	$Error = 0;
	
	if(isset($_POST['id']) && isset($_POST['id'])) {
		if(is_numeric($_POST['id']) == false) { 
			die("Bad");
		}
		$ID = $_POST['id'];
		
		
		$Job = build_job_information($Steam->response->players[0]->steamid);
			
		$JobID = $Job['JobID'];
		$Title = $Job['Title'];
		$Owner = $Job['Owner'];
		$JobCreator = $Job['JobCreator'];
		$JobDesc = $Job['NoHTMLDesc'];
		$JobTime = $Job['JobTime'];
		$JobFinished = $Job['JobFinished'];
		$JobProgress = $Job['JobProgress'];
			
		if ($JobFinished == 1) {
			$Error = 13;
		}
			
			
		if($Steam->response->players[0]->steamid != $JobCreator->response->players[0]->steamid) {
			die('Bad!');
		} else if($Error == 0) {
			mysql_query("UPDATE Jobs SET Finished='1' WHERE JobID='{$JobID}'");
			
			$Query2 = "INSERT INTO Job_Feedback (JobID) VALUES ('".$JobID."') ";
			mysql_query($Query2) or die(mysql_error());
			
			echo '<div class="alert alert-success"><img src="Images/FatCow/tick.png" /> <p>You have closed the job.</p></div>';
			echo "<meta HTTP-EQUIV='REFRESH' content='0; url=view_job.php?id=".$JobID."'>";
		}
		
	} else {
		$Error = 1;
	}
	
	if ($Error > 0) {
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=error.php?eid=".$Error."'>";
	}
?>