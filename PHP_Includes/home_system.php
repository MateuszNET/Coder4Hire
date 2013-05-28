<?php
	include 'header_check.php';
	include 'Mysql.inc.php';
	
	function build_home_jobs()
	{
		$result_Jobs = mysql_query("SELECT * FROM Jobs WHERE OwnerID='".$_SESSION['T2SteamID64']."' ");
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
			echo "<td><a href='edit.php?type=job&id=".$ScriptID."'><img src='Images/FatCow/cog.png' alt='Edit Job' /></a></td>";
			echo "</tr>";
		}
	}
	
	function build_home_scripts()
	{
		$result_scripts = mysql_query("SELECT * FROM Scripts WHERE OwnerID='".$_SESSION['T2SteamID64']."' ");
		while($row = mysql_fetch_array($result_scripts))
		{
			$ScriptID = $row['ScriptID'];
			$Closed = $row['Closed'];

			$Header = "<th><p>{$row['Title']}</p></th>";
			$Price = "<td><p>$ {$row['Price']}</p></td>";
			$Script = "<td><a href='view_script.php?id=".$ScriptID."'><img src='Images/FatCow/magnifier.png' alt='Script Info' /></a></td>";
			
			if($Closed == 1){
				$Status = 'error';
			} else {
				$Status = 'success';
			}
			
			echo "<tr class=".$Status.">";
			echo "<td>$Header</td><td>$Price</td><td>$Script</td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td><a href='edit.php?type=script&id=".$ScriptID."'><img src='Images/FatCow/cog.png' alt='Edit Script' /></a></td>";
			echo "</tr>";
		}
	}
	
	function build_home_coding_jobs()
	{
		$result_Jobs = mysql_query("SELECT * FROM Jobs WHERE Accepted_ID='".$_SESSION['T2SteamID64']."' ");
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
	
	function build_home_stats()
	{
		
		$Jobs_Total = 0;
		$Jobs_Profit = 0;
		$Jobs_Finished = 0;
		
		$Scripts_Total = 0;
		
		$job_status = mysql_query("SELECT * FROM Jobs");
		while($row = mysql_fetch_array($job_status))
		{
			$JobID = $row['JobID'];
			$Finished = $row['Finished'];
			$Accepted = $row['Accepted_ID'];
			$Price = $row['Price'];

			$Jobs_Total = $Jobs_Total + 1;
			
			if($Finished == 1){
				$Jobs_Finished = $Jobs_Finished + $Finished;
				
				if($Accepted != '') {
					$Jobs_Profit = $Jobs_Profit + $Price;
				}
			}
			
		}
		$script_status = mysql_query("SELECT * FROM Scripts");
		while($row = mysql_fetch_array($script_status))
		{
			$Scripts_Total = $Scripts_Total + 1;
		}
		
		return array('TJS' => $Jobs_Total,
		'TCJS' => $Jobs_Finished,
		'TJP' => $Jobs_Profit,
		'TS' => $Scripts_Total);
	}
	
	function build_user_stats()
	{
		
		$User_Jobs = 0;
		$User_Spent = 0;
		$User_Profit = 0;
		
		$User_Jobs_Completed = 0;
		$User_Jobs_Coding = 0;
		$User_Scripts = 0;
		
		$User_CoderRep = 0;
		$User_HireRep = 0;
		
		$job_status = mysql_query("SELECT * FROM Jobs WHERE OwnerID='".$_SESSION['T2SteamID64']."' ");
		while($row = mysql_fetch_array($job_status))
		{
			$Finished = $row['Finished'];
			$Accepted = $row['Accepted_ID'];
			$Price = $row['Price'];

			$User_Jobs = $User_Jobs + 1;
			
			if($Finished == 1 && $Accepted != ''){
				$User_Spent = $User_Spent + $Price;
			}
			
		}
		
		$coder_status = mysql_query("SELECT * FROM Jobs WHERE Accepted_ID='".$_SESSION['T2SteamID64']."' ");
		while($row = mysql_fetch_array($coder_status))
		{
			
			if($Finished == 1){
				$User_Profit = $User_Profit + $Price;
				$User_Jobs_Completed = $User_Jobs_Completed + $Price;
			}
			
		}
		
		$user_stats = mysql_query("SELECT * FROM Users WHERE SteamID64='".$_SESSION['T2SteamID64']."' ");
		while($row = mysql_fetch_array($user_stats))
		{
			$User_CoderRep = $row['CoderRep_UP'] - $row['CoderRep_DOWN'];
			$User_HireRep = $row['HireRep_UP'] - $row['HireRep_DOWN'];
		}
		
		$script_status = mysql_query("SELECT * FROM Scripts WHERE OwnerID='".$_SESSION['T2SteamID64']."' ");
		while($row = mysql_fetch_array($script_status))
		{
			$User_Scripts = $User_Scripts + 1;
		}
		
		$result_CJobs = mysql_query("SELECT * FROM Jobs WHERE Accepted_ID='".$_SESSION['T2SteamID64']."' ");
		while($row = mysql_fetch_array($result_CJobs))
		{
			$User_Jobs_Coding = $User_Jobs_Coding + 1;
		}
		
		$TotalMoney = $User_Profit - $User_Spent;
		
		return array('UJ' => $User_Jobs,
		'USPT' => $User_Spent,
		'UP' => $User_Profit,
		'UJC' => $User_Jobs_Completed,
		'UCJ' => $User_Jobs_Coding,
		'US' => $User_Scripts,
		'UCR' => $User_CoderRep,
		'UHR' => $User_HireRep);
	}
?>