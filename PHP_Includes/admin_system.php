<?php
	include 'Mysql.inc.php';
	
	function build_reports()
	{
		$result_Jobs = mysql_query("SELECT * FROM Reports");
		while($row = mysql_fetch_array($result_Jobs))
		{
			$ReportID = $row['ReportID'];
			$ReporterID = $row['ReporterID'];
			$WarningID = $row['WarningID'];
			$Type = $row['Type'];
			$Message = nl2br($row['Message']);
			
			$ReporterSteam = json_decode(file_get_contents("cache/ISteamUser/{$ReporterID}.json"));
			$ReporterSteamID = $ReporterSteam->response->players[0]->steamid;
			$ReporterName = $ReporterSteam->response->players[0]->personaname;
			
			$Header = "<a href='profile.php?id=".$ReporterSteamID."'>{$ReporterName}</a>";
			$Type = "{$Type}";
			$Comment = "{$Message}";
			
			if($Type == 'job'){
				$Action = '<td><div class="btn-group">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Actions<span class="caret"></span></a>
					<ul class="dropdown-menu">
					<!-- dropdown menu links -->
						<li><button type="button" style="margin:0 auto;" class="btn btn-link AdminButton BanReporter" value='.$ReporterID.' >Ban Reporter</button></li>
						<li><button type="button" style="margin:0 auto;" class="btn btn-link AdminButton BanOwner" value='.$WarningID.' >Ban Job/Script Owner</button></li>
						 <li class="divider"></li>
						<li><button type="button" style="margin:0 auto;" class="btn btn-link AdminButton RemoveReport" value='.$ReportID.' >Remove Report</button></li>
						 <li class="divider"></li>
						<li><button type="button" style="margin:0 auto;" class="btn btn-link AdminButton CloseJob" value='.$WarningID.' >Close Job/Script</button></li>
					</ul>
				</div></td>';
				$Script = "<a href='view_job.php?id=".$WarningID."'><img src='Images/FatCow/magnifier.png' alt='Job Info' /></a>";
				echo "<tr class='info'>";
				echo "<td>$Header</td><td>$Type</td><td>$Comment</td><td>$Script</td>";
				echo $Action;
				echo "</tr>";
			} else if ($Type == 'script'){
				$Action = '<td><div class="btn-group">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Actions<span class="caret"></span></a>
					<ul class="dropdown-menu">
					<!-- dropdown menu links -->
						<li><button type="button" style="margin:0 auto;" class="btn btn-link AdminButton BanReporter" value='.$ReporterID.' >Ban Reporter</button></li>
						<li><button type="button" style="margin:0 auto;" class="btn btn-link AdminButton BanOwner" value='.$WarningID.' >Ban Job/Script Owner</button></li>
						 <li class="divider"></li>
						<li><button type="button" style="margin:0 auto;" class="btn btn-link AdminButton RemoveReport" value='.$ReportID.' >Remove Report</button></li>
						 <li class="divider"></li>
						<li><button type="button" style="margin:0 auto;" class="btn btn-link AdminButton CloseScript" value='.$WarningID.' >Close Job/Script</button></li>
					</ul>
				</div></td>';
				$Script = "<a href='view_script.php?id=".$WarningID."'><img src='Images/FatCow/magnifier.png' alt='Script Info' /></a>";
				echo "<tr class='info'>";
				echo "<td>$Header</td><td>$Type</td><td>$Comment</td><td>$Script</td>";
				echo $Action;
				echo "</tr>";
			} else if ($Type == 'user'){
			} else if ($Type == 'comment'){
			}
		}
	}

?>