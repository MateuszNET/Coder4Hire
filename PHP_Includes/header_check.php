<?php
	session_start();
	
	include 'Mysql.inc.php';
	
	if(!isset($_SESSION['T2SteamAuth'])){
		header("Location: index.php");
	} else {
		$Steam = json_decode(file_get_contents("cache/ISteamUser/{$_SESSION['T2SteamID64']}.json"));
		
		$result = mysql_query("SELECT * FROM Users WHERE SteamID64='{$_SESSION['T2SteamID64']}'");
	
		if (mysql_num_rows($result) == 1) {
			while($row = mysql_fetch_array($result))
			{
				if ($row['Activated'] == '0') {
					header("Location: register.php");
				}
				
				$_SESSION['IsBanned'] = $row['Banned'];
				$_SESSION['IsMod'] = $row['Moderator'];
				$_SESSION['PreviousURL'] = $_SERVER['REQUEST_URI'];
			}
		} else if(mysql_num_rows($result) > 1) {
			exit('Two Users in Database: Quiting');
		} else {
			header("Location: register.php");
		}
		
		if ($_SESSION['IsBanned'] == 1) {
			header("Location: banned.php");
		}
	}
?>