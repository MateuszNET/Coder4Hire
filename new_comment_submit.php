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
	
	if(isset($_POST['content_txt']) && !empty($_POST['content_txt'])) {
		if(isset($_POST['JobID']) && !empty($_POST['JobID'])) {
			if(is_numeric($_POST['JobID']) == false) { 
				die("Bad");
			}
			$Comment = mysql_escape_string($_POST['content_txt']);
			
			$Query = "INSERT INTO Job_Comments (OwnerID, JobID, Comment) VALUES ('".$_SESSION['T2SteamID64']."', '".$_POST['JobID']."', '".html2txt($Comment)."') ";
			mysql_query($Query) or die(mysql_error());
			
			$Commenter = json_decode(file_get_contents("cache/ISteamUser/{$_SESSION['T2SteamID64']}.json"));
			$Comment_Format = nl2br(html2txt($Comment));

			echo "<p class='commenter_name'>{$Commenter->response->players[0]->personaname}</p>";
			echo "<a class='commenter_a' href='profile.php?id={$Commenter->response->players[0]->steamid}' ><img class='commenter_image' src='{$Commenter->response->players[0]->avatarmedium}' alt='avatarmedium+' /></a>";
			echo "<p class='commenter_comment'>{$Comment_Format}</p>";
			echo "<hr class='soften'/></br>";
		} else {
			echo "No ID";
		}
	} else {
		echo "No Comment";
	}

?>