<?php
	include 'PHP_Includes/header_check.php';
	
	function html2txt($document){
		$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
				   '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
				   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
				   '@<![\s\S]*?--[ \t]*>@'         // Strip multi-line comments including CDATA
		);
		$text = preg_replace($search, '', $document);
		return $text;
	} 
	
	if(isset($_POST['report_txt']) && !empty($_POST['report_txt'])) {
		if(isset($_POST['ID']) && !empty($_POST['ID'])) {
			if(isset($_POST['type']) && !empty($_POST['type'])) {
				if(is_numeric($_POST['ID']) == false) { 
					die("Bad");
				}
				$Comment = mysql_escape_string($_POST['report_txt']);
				$Type = mysql_escape_string($_POST['type']);
				
				$Query = "INSERT INTO Reports (ReporterID, WarningID, Type, Message) VALUES ('".$_SESSION['T2SteamID64']."', '".$_POST['ID']."', '".$Type."', '".html2txt($Comment)."') ";
				mysql_query($Query) or die(mysql_error());

				echo '<div class="alert alert-success"><img src="Images/FatCow/tick.png" /> <p>Your report has been submited!</p></div>';
			} else {
				echo "No Type";
			}
		} else {
			echo "No ID";
		}
	} else {
		echo "No Comment";
	}

?>