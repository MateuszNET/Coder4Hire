<?php
	include 'header_check.php';
	include 'Mysql.inc.php';
	
	function build_home_jobs($user)
	{
		$result_Jobs = mysql_query("SELECT * FROM Jobs WHERE OwnerID='".$user."' ");
		while($row = mysql_fetch_array($result_Jobs))
		{
			$ScriptID = $row['JobID'];
			$DueDate = $row['JobTime'];
			$Finished = $row['Finished'];
			$Closed = $row['Closed'];
			$Accepted = $row['Accepted_ID'];
			
			if($Accepted != ''){
				$CoderSteam = json_decode(file_get_contents("cache/ISteamUser/{$Accepted}.json"));
				$CoderSteamID = $CoderSteam->response->players[0]->steamid;
				$CoderName = $CoderSteam->response->players[0]->personaname;
			} else {
				$CoderSteamID = null;
				$CoderName = 'N/A';
			}
			
			$Header = "<th>{$row['Title']}</th>";
			$Price = "<td>$ {$row['Price']}</td>";
			$Owner = "<td><a href='profile.php?id=".$CoderSteamID."'>{$CoderName}</a></td>";
			$Script = "<td><a href='view_job.php?id=".$ScriptID."'><img src='Images/FatCow/magnifier.png' alt='Job Info' /></a></td>";
			
			if($Closed == 1){
				$Status = 'error';
			} else if($Finished == 1){
				$Status = 'success';
			} else if($Accepted != ''){
				$Status = 'warning';
			} else {
				$Status = 'info';
			}

			echo "<tr class=".$Status.">";
			echo "<td>$Header</td><td>$Price</td><td>$Owner</td><td>$DueDate</td><td>$Script</td>";
			echo "</tr>";
		}
	}
	
	function build_home_scripts($user)
	{
		$result_scripts = mysql_query("SELECT * FROM Scripts WHERE OwnerID='".$_SESSION['T2SteamID64']."' ");
		while($row = mysql_fetch_array($result_scripts))
		{
			$ScriptID = $row['ScriptID'];

			$Header = "<th><p>{$row['Title']}</p></th>";
			$Price = "<td><p>$ {$row['Price']}</p></td>";
			$Script = "<td><a href='view_script.php?id=".$ScriptID."'><img src='Images/FatCow/magnifier.png' alt='Script Info' /></a></td>";
			
			echo "<tr class='success'>";
			echo "<td>$Header</td><td>$Price</td><td>$Script</td>";
			echo "<td></td>";
			echo "</tr>";
		}
	}
	
	function build_home_coding_jobs($user)
	{
		$result_Jobs = mysql_query("SELECT * FROM Jobs WHERE Accepted_ID='".$user."' ");
		while($row = mysql_fetch_array($result_Jobs))
		{
			$JobID = $row['JobID'];
			$DueDate = $row['JobTime'];
			$Finished = $row['Finished'];
			$Closed = $row['Closed'];
			$Accepted = $row['OwnerID'];
			
			if($Accepted != ''){
				$OwnerSteam = json_decode(file_get_contents("cache/ISteamUser/{$Accepted}.json"));
				$OwnerSteamID = $OwnerSteam->response->players[0]->steamid;
				$OwnerName = $OwnerSteam->response->players[0]->personaname;
			} else {
				$OwnerSteamID = null;
				$OwnerName = 'N/A';
			}
			
			$Header = "<th>{$row['Title']}</th>";
			$Price = "<td>$ {$row['Price']}</td>";
			$Owner = "<td><a href='profile.php?id=".$OwnerSteamID."'>{$OwnerName}</a></td>";
			$Script = "<td><a href='view_job.php?id=".$JobID."'><img src='Images/FatCow/magnifier.png' alt='Job Info' /></a></td>";
			
			if($Closed == 1){
				$Status = 'error';
			} else if($Finished == 1){
				$Status = 'success';
			} else if($Accepted != ''){
				$Status = 'warning';
			} else {
				$Status = 'info';
			}

			echo "<tr class=".$Status.">";
			echo "<td>$Header</td><td>$Price</td><td>$Owner</td><td>$DueDate</td><td>$Script</td>";
			echo "</tr>";
		}
	}
	
	function build_user_stats($user)
	{
		$User_CoderRep = 0;
		$User_HireRep = 0;
		
		$user_stats = mysql_query("SELECT * FROM Users WHERE SteamID64='".$user."' ");
		while($row = mysql_fetch_array($user_stats))
		{
			$User_CoderRep = $row['CoderRep_UP'] - $row['CoderRep_DOWN'];
			$User_HireRep = $row['HireRep_UP'] - $row['HireRep_DOWN'];
		}
		
		return array('UCR' => $User_CoderRep,
		'UHR' => $User_HireRep);
	}
?>