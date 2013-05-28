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
	
	if(isset($_POST['app_txt']) && !empty($_POST['app_txt'])) {
		if(isset($_POST['ID']) && !empty($_POST['ID'])) {
			if(isset($_POST['price']) && !empty($_POST['price'])) {
				if(is_numeric($_POST['ID']) == false) { 
					die("Bad");
				}
				if(is_numeric($_POST['price'])) {
					if($_POST['price'] <= 0) {
						die("Price needs to be greater than 0");
					}
				} else {
					die("Price is not number");
				}
				$Comment = mysql_escape_string($_POST['app_txt']);
				
				$Query = "INSERT INTO Job_Applications (JobID, OwnerID, Comment, Cost) VALUES ('".$_POST['ID']."', '".$_SESSION['T2SteamID64']."', '".html2txt($Comment)."', '".$_POST['price']."' ) ";
				mysql_query($Query) or die(mysql_error());
				

				echo '<div class="alert alert-success"><img src="Images/FatCow/tick.png" /> <p>Your application has been submitted!</p></div>';
				echo "<meta HTTP-EQUIV='REFRESH' content='3; url=view_job.php?id=".$_POST['ID']."'>";
			} else {
				echo "No Price";
			}
		} else {
			echo "No ID";
		}
	} else {
		echo "No Comment";
	}

?>