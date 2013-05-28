<?php

	function buildscripttable($limit,$caller)
	{
		$result_scripts = mysql_query("SELECT * FROM Scripts WHERE Closed='0' LIMIT ".$limit);
		while($row = mysql_fetch_array($result_scripts))
		{
			$ScriptID = $row['ScriptID'];
			$OwnerID = $row['OwnerID'];
			$OwnerSteam = json_decode(file_get_contents("cache/ISteamUser/{$row['OwnerID']}.json"));

			$Header = "<th><p>{$row['Title']}</p></th>";
			$Price = "<td><p>$ {$row['Price']}</p></td>";
			$Owner = "<td><a href='profile.php?id=".$OwnerID."'>{$OwnerSteam->response->players[0]->personaname}</a></td>";
			$Script = "<td><a href='view_script.php?id=".$ScriptID."'><img src='Images/FatCow/magnifier.png' alt='Script Info' /></a></td>";
			
			if($row['OwnerID'] == $caller){
				$Status = 'success';
			} else {
				$Status = '';
			}
			
			echo "<tr class=".$Status.">";
			echo "<td>$Header</td><td>$Price</td><td>$Owner</td><td>$Script</td>";
			if($row['OwnerID'] == $caller){
				echo "<td><a href='edit.php?type=script&id=".$ScriptID."'><img src='Images/FatCow/cog.png' alt='Edit Script' /></a></td>";
			}
			echo "</tr>";
		}
	}
	
	function build_script_information()
	{
		if ( isset($_GET['id']) && !empty($_GET['id']) ) {
			if(is_numeric($_GET['id']) == false) { 
				die("Bad");
			}
			
			$result = mysql_query("SELECT * FROM Scripts WHERE ScriptID='{$_GET['id']}'");

			if (mysql_num_rows($result) == 1) {
				while($row = mysql_fetch_array($result))
				{
					$ScriptID = $_GET['id'];
					$ScriptCreator = json_decode(file_get_contents("cache/ISteamUser/{$row['OwnerID']}.json"));
					$Title = $row['Title'];
					$Price = $row['Price'];
					$Desc = nl2br($row["Description"]);
					$Image = $row['Image_1'];
					
					$CoderRep = 0;
					$OwnerInfo = mysql_query("SELECT * FROM Users WHERE SteamID64='{$row['OwnerID']}'");
					if (mysql_num_rows($OwnerInfo) == 1) {
						while($row2 = mysql_fetch_array($OwnerInfo))
						{
							$CoderRep = $row2['CoderRep_UP'] - $row2['CoderRep_DOWN'];
						}
					}
					
					return array('ScriptID' => $ScriptID, 
						'ScriptCreator' => $ScriptCreator,
						'Title' => $Title, 
						'Price' => $Price,
						'NoHTMLDesc' => $row["Description"],
						'Desc' => $Desc, 
						'Image' => $Image,
						'CoderRep' => $CoderRep);
				}
			} else if(mysql_num_rows($result) > 1) {
				exit('Two Scripts With the Same ID in Database: Quiting');
			}
		}
	}
	
	function build_script_details()
	{
		if ( isset($_POST['id']) && !empty($_POST['id']) ) {
			if(is_numeric($_GET['id']) == false) { 
				die("Bad");
			}
			
			$result = mysql_query("SELECT * FROM Scripts WHERE ScriptID='{$_POST['id']}'");

			if (mysql_num_rows($result) == 1) {
				while($row = mysql_fetch_array($result))
				{
					$ScriptCreator = json_decode(file_get_contents("cache/ISteamUser/{$row['OwnerID']}.json"));
					
					return array('ScriptID' => $_POST['id'], 
						'ScriptCreator' => $ScriptCreator);
				}
			} else if(mysql_num_rows($result) > 1) {
				exit('Two Scripts With the Same ID in Database: Quiting');
			}
		}
	}

?>