<?php
	include '/var/www/html/Coder4Hire/PHP_Includes/Mysql.inc.php';
	
	$result = mysql_query("SELECT * FROM Jobs WHERE Finished='0' AND Closed='0' ");

	while($row = mysql_fetch_array($result))
	{
		$JobID = $row['JobID'];
		$Date = strtotime($row['JobTime']);
		$TimeLeft=$Date-time();
				
		if ($TimeLeft <= 0){
			mysql_query("UPDATE Jobs SET Closed='1' WHERE JobID='{$JobID}'");
			if($row['Accepted_ID'] != ''){
				mysql_query("UPDATE Users SET CoderRep_DOWN=CoderRep_DOWN+1 WHERE SteamID64='{$row['Accepted_ID']}'");
			}
			
			$Query2 = "INSERT INTO Job_Feedback (JobID) VALUES ('".$JobID."') ";
			mysql_query($Query2) or die(mysql_error());
		}
		
		
		echo ' Fixed Jobs';
	}
	echo ' Done';
?>