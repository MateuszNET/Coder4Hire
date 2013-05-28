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
	
	if(isset($_POST['who']) && !empty($_POST['who'])) {
		if(isset($_POST['ID']) && !empty($_POST['ID'])) {
			if(isset($_POST['rep']) && !empty($_POST['rep'])) {
			
				$Comment = '';
				if(isset($_POST['feed_txt']) && !empty($_POST['feed_txt'])) {
					$Comment = mysql_escape_string($_POST['feed_txt']);
				}
				
				if($_POST['who'] == 'hire') {
					$Query = "UPDATE Job_Feedback SET HirerFeedback='".$_POST['rep']."', HirerComment='".html2txt($Comment)."' WHERE JobID='".$_POST['ID']."' ";
					mysql_query($Query) or die(mysql_error());
					
					$result_job = mysql_query("SELECT * FROM Jobs WHERE JobID='{$_POST['ID']}'");
					if (mysql_num_rows($result_job) == 1) {
						while($row = mysql_fetch_array($result_job))
						{
							$Coder = $row['Accepted_ID'];
						}
					}
					
					if ($_POST['rep'] == 1) {
						$Query = "UPDATE `Users` SET `CoderRep_UP`=`CoderRep_UP` + 1 WHERE `SteamID64`='{$Coder}'";
					} else if ($_POST['rep'] == 3) {
						$Query = "UPDATE `Users` SET `CoderRep_DOWN`=`CoderRep_DOWN` + 1 WHERE `SteamID64`='{$Coder}'";
					}
					mysql_query($Query) or die(mysql_error());
					
					echo '<div class="alert alert-success"><img src="Images/FatCow/tick.png" /> <p>Your feedback has been submited!</p></div>';
				} else if ($_POST['who'] == 'coder') {
					$Query = "UPDATE Job_Feedback SET CoderFeedback='".$_POST['rep']."', CoderComment='".html2txt($Comment)."' WHERE JobID='".$_POST['ID']."' ";
					mysql_query($Query) or die(mysql_error());
					echo '<div class="alert alert-success"><img src="Images/FatCow/tick.png" /> <p>Your feedback has been submited!</p></div>';
				} else {
					echo '<div class="alert alert-error"><img src="Images/FatCow/warning.png" /> <p>No Proper WHO Specified!</p></div>';
				}
				
				//echo "<meta HTTP-EQUIV='REFRESH' content='3; url=view_job.php?id=".$_POST['ID']."'>";

			} else {
				echo "No REP";
			}
		} else {
			echo "No ID";
		}
	} else {
		echo "No WHO";
	}

?>