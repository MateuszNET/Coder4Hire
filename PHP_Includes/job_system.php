<?php
	include 'Mysql.inc.php';
	function buildjobtable($limit,$caller)
	{
		$result_Jobs = mysql_query("SELECT * FROM Jobs WHERE Finished='0' AND Closed='0' ORDER BY JobID DESC LIMIT ".$limit);
		while($row = mysql_fetch_array($result_Jobs))
		{
			$ScriptID = $row['JobID'];
			$OwnerID = $row['OwnerID'];
			$DueDate = $row['JobTime'];
			$OwnerSteam = json_decode(file_get_contents("cache/ISteamUser/{$row['OwnerID']}.json"));
			
			$Header = "<th>{$row['Title']}</p></th>";
			$Price = "<td>$ {$row['Price']}</td>";
			$Owner = "<td><a href='profile.php?id=".$OwnerID."'>{$OwnerSteam->response->players[0]->personaname}</a></td>";
			$Script = "<td><a href='view_job.php?id=".$ScriptID."'><img src='Images/FatCow/magnifier.png' alt='Job Info' /></a></td>";
			
			if($row['OwnerID'] == $caller){
				$Status = 'success';
			} else if($row['Accepted_ID'] != ''){
				$Status = 'warning';
			} else {
				$Status = 'info';
			}
			
			echo "<tr class=".$Status.">";
			echo "<td>$Header</td><td>$Price</td><td>$Owner</td><td>$DueDate</td><td>$Script</td>";
			if($row['OwnerID'] == $caller){
				echo "<td><a href='edit.php?type=job&id=".$ScriptID."'><img src='Images/FatCow/cog.png' alt='Edit Job' /></a></td>";
			} else {
				echo "<td></td>";
			}
			echo "</tr>";
		}
	}
	
	function build_job_information($caller)
	{
		$Applied = false;
	
		if ( isset($_GET['id']) && !empty($_GET['id']) ) {
			if(is_numeric($_GET['id']) == false) { 
				die("Bad");
			}
			$result = mysql_query("SELECT * FROM Jobs WHERE JobID='{$_GET['id']}'");

			if (mysql_num_rows($result) == 1) {
				while($row = mysql_fetch_array($result))
				{
					$JobID = $_GET['id'];
					$JobCreator = json_decode(file_get_contents("cache/ISteamUser/{$row['OwnerID']}.json"));
					$Title = $row['Title'];
					$Price = $row['Price'];
					$Owner = $row['OwnerID'];
					$NoHTMLDesc = $row["Description"];
					$Desc = nl2br($row["Description"]);
					$JobFinished = $row['Finished'];
					$JobProgress = $row['Accepted_ID'];
					
					$Closed = $row['Closed'];
					$Closed_Reason = $row['Close_Reason'];
					
					if ($JobFinished == 0) {
						$Date = strtotime($row['JobTime']);
						$seconds=$Date-time();
						$Days = floor($seconds / 86400);
						$seconds %= 86400;
						$Hours = floor($seconds / 3600);
						$seconds %= 3600;
						$Minutes = floor($seconds / 60);
						$seconds %= 60;
					} else {
						$Days = 0;
						$Hours = 0;
						$Minutes = 0;
					}
					
					$_SESSION['PreviousURL'] = $_SERVER['REQUEST_URI'];
					
					$HireRep = 0;
					$OwnerInfo = mysql_query("SELECT * FROM Users WHERE SteamID64='{$row['OwnerID']}'");
					if (mysql_num_rows($OwnerInfo) == 1) {
						while($row2 = mysql_fetch_array($OwnerInfo))
						{
							$HireRep = $row2['HireRep_UP'] - $row2['HireRep_DOWN'];
						}
					}
					
					$Revoked = 0;
					if($row['OwnerID'] != $_SESSION['T2SteamID64'])
					{
						$JobApplication = mysql_query("SELECT * FROM Job_Applications WHERE OwnerID='{$caller}' AND JobID='{$JobID}'");
						if (mysql_num_rows($JobApplication) == 1) {
							$Applied = true;
							
							$row2 = mysql_fetch_array($JobApplication);
							$Revoked = $row2['Revoked'];
						}
					}
					return array('JobID' => $JobID, 
					'JobCreator' => $JobCreator,
					'Title' => $Title, 
					'Price' => $Price, 
					'Owner' => $Owner,
					'Closed' => $Closed,
					'Closed_Reason' => $Closed_Reason,
					'NoHTMLDesc' => $NoHTMLDesc,
					'Desc' => $Desc, 
					'JobTime' => $row['JobTime'],
					'JobFinished' => $JobFinished,
					'JobProgress' => $JobProgress,
					'Days' => $Days,
					'Hours' => $Hours,
					'Minutes' => $Minutes,
					'HireRep' => $HireRep,
					'Applied' => $Applied,
					'Revoked' => $Revoked);
				}
			} else if(mysql_num_rows($result) > 1) {
				exit('Two Jobs With the Same ID in Database: Quiting');
			} else if(mysql_num_rows($result) == 0){
				echo "<meta HTTP-EQUIV='REFRESH' content='0; url=error.php?eid=1'>";
			}
		}
	}
	
	function build_job_details()
	{
	
		if ( isset($_POST['id']) && !empty($_POST['id']) ) {
			if(is_numeric($_POST['id']) == false) { 
				die("Bad");
			}
			$result = mysql_query("SELECT * FROM Jobs WHERE JobID='{$_POST['id']}'");

			if (mysql_num_rows($result) == 1) {
				while($row = mysql_fetch_array($result))
				{
					$JobID = $_POST['id'];
					$JobCreator = json_decode(file_get_contents("cache/ISteamUser/{$row['OwnerID']}.json"));
					$JobFinished = $row['Finished'];
					$JobProgress = $row['Accepted_ID'];
					
					return array('JobID' => $JobID, 
					'JobCreator' => $JobCreator,
					'JobFinished' => $JobFinished,
					'JobProgress' => $JobProgress);
				}
			} else if(mysql_num_rows($result) > 1) {
				exit('Two Jobs With the Same ID in Database: Quiting');
			} else if(mysql_num_rows($result) == 0){
				echo "<meta HTTP-EQUIV='REFRESH' content='0; url=error.php?eid=1'>";
			}
		}
	}
	
	function build_job_comments($JobCreator,$caller)
	{
		if(is_numeric($_GET['id']) == false) { 
			die("Bad");
		}
		$Job_Comments = mysql_query("SELECT * FROM Job_Comments WHERE JobID={$_GET['id']}");
		if (mysql_num_rows($Job_Comments) > 0) {
			while($row = mysql_fetch_array($Job_Comments))
			{
				$CID = $row['CommentID'];
				$Commenter = json_decode(file_get_contents("cache/ISteamUser/{$row['OwnerID']}.json"));
				$Comment = nl2br($row['Comment']);
				
				echo "<p class='commenter_name'>{$Commenter->response->players[0]->personaname}</p>";
				echo "<a class='commenter_a' href='profile.php?id={$Commenter->response->players[0]->steamid}' ><img class='commenter_image' src='{$Commenter->response->players[0]->avatarmedium}' alt='avatarmedium+' /></a>";
				echo "<p class='commenter_comment'>{$Comment}</p>";
				echo "<hr class='soften'/></br>";
			}
		} else {
			echo '<p>No Comments Yet<p>';
		}
	}
	
	function build_job_comments_system($JobCreator,$caller)
	{
		if(is_numeric($_GET['id']) == false) { 
			die("Bad");
		}
		$result = mysql_query("SELECT * FROM Jobs WHERE JobID='{$_GET['id']}'");
		if (mysql_num_rows($result) == 1) {
			while($row = mysql_fetch_array($result))
			{
				$Finished = $row['Finished'];
				$CoderID = $row['Accepted_ID'];
				$OwnerID = $row['OwnerID'];
				$Closed = $row['Closed'];
			}
		}
		
		$result_feedback = mysql_query("SELECT * FROM Job_Feedback WHERE JobID='{$_GET['id']}'");
		if (mysql_num_rows($result_feedback) == 1) {
			while($row = mysql_fetch_array($result_feedback))
			{
				$HirerFeedback = $row['HirerFeedback'];
				$CoderFeedback = $row['CoderFeedback'];
			}
		} else {
			$HirerFeedback = 0;
			$CoderFeedback = 0;
		}
		
		if(($JobCreator->response->players[0]->steamid != $caller->response->players[0]->steamid && $Finished == 0) && $Closed == 0){
			echo '<div id="job_new_ban" class="alert alert-info">Please be polite and respectful.</div></br>
					<input type="hidden" value="'.$_GET['id'].'" name="JobID" id="JobID" />
					<label for="ContentText">Comment: </label><textarea id="ContentText" onkeydown="return limitTextareaLine(this, event)" class="field span6" maxlength="120" name="content_txt" rows="3" cols="100" placeholder="Enter Comment" required></textarea></br>
					<button id="FormSubmit" class="btn btn-primary" type="button">Add Comment</button></br></br>';
		} else if(($CoderID == $caller->response->players[0]->steamid && $Finished == 1) && ($CoderFeedback == 0 && $Closed == 0)){
			echo '<div id="comment"><p id="job_new_ban" class="alert alert-info">Please Leave Job Feedback.</p></br>
					<label class="radio inline"><input type="radio" name="optionsRadios" id="optionsRadios1" value="repup" >+1 Rep</label>
					<label class="radio inline"><input type="radio" name="optionsRadios" id="optionsRadios2" value="repnone" checked>No Rep</label>
					<label class="radio inline"><input type="radio" name="optionsRadios" id="optionsRadios3" value="repdown" >- 1Rep</label>
					<label for="comment">Comment: </label><textarea id="ContentText" class="field span6" maxlength="120" name="comment" rows="3" cols="100" placeholder="Enter Comment" ></textarea></br>
					<button id="FeedbackSubmit_Coder" class="btn btn-primary" type="button">Leave Feedback</button></br></br><br></div>';
		} else if(($OwnerID == $caller->response->players[0]->steamid && $Finished == 1 && $HirerFeedback == 0) && ($CoderID != '' && $Closed == 0)){
			echo '<div id="comment"><p id="job_new_ban" class="alert alert-info">Please Leave Job Feedback.</p></br>
					<label class="radio inline"><input type="radio" name="optionsRadios" id="optionsRadios1" value="repup" >+1 Rep</label>
					<label class="radio inline"><input type="radio" name="optionsRadios" id="optionsRadios2" value="repnone" checked>No Rep</label>
					<label class="radio inline"><input type="radio" name="optionsRadios" id="optionsRadios3" value="repdown" >-1 Rep</label>
					<label for="comment">Comment: </label><textarea id="ContentText" class="field span6" maxlength="120" name="comment" rows="3" cols="100" placeholder="Enter Comment" ></textarea></br>
					<button id="FeedbackSubmit_Hire" class="btn btn-primary" type="button">Leave Feedback</button></br></br><br></div>';
		}
	}
	
	function build_job_applicants()
	{	
		if(is_numeric($_GET['id']) == false) { 
			die("Bad");
		}
		$result = mysql_query("SELECT OwnerID,Cost,Comment,Revoked FROM Job_Applications WHERE JobID='{$_GET['id']}'");
		if (mysql_num_rows($result) >= 1) {
			while($row = mysql_fetch_array($result))
			{
				$ApplicantID = $row['OwnerID'];
				$OwnerSteam = json_decode(file_get_contents("cache/ISteamUser/{$ApplicantID}.json"));
				$Revoked = $row['Revoked'];
				$Comment = nl2br($row['Comment']);
				
				
				$Name = "<img src='{$OwnerSteam->response->players[0]->avatar}'/> <a href='profile.php?id=".$ApplicantID."'>{$OwnerSteam->response->players[0]->personaname}</a>";
				$Price = "$".$row['Cost'];
				
				$user_stats = mysql_query("SELECT CoderRep_DOWN,CoderRep_UP FROM Users WHERE SteamID64='".$ApplicantID."' ");
				while($row = mysql_fetch_array($user_stats))
				{
					$CoderRep = $row['CoderRep_UP'] - $row['CoderRep_DOWN'];
				}
				
				if($Revoked == 1){
					$Status = 'error';
					$Accept = '<button type="button" class="btn btn-primary" value='.$ApplicantID.'>Revoked</button>';
				} else {
					$Status = 'success';
					$Accept = '<button type="button" class="btn btn-primary AcceptApp" value='.$ApplicantID.'>Accept</button>';
				}
				
				if($CoderRep < 0){
					$Status_BDG = 'important';
				} else if($CoderRep > 0) {
					$Status_BDG = 'success';
				} else {
					$Status_BDG = 'warning';
				}
				
				$Rep = '<span class="badge badge-'.$Status_BDG.'">'.$CoderRep.'</span>';
				
				echo "<tr class=".$Status.">";
				echo "<td>$Name</td><td>$Price</td><td>$Rep</td><td>$Comment</td><td>$Accept</td>";
				echo "</tr>";
			}
		} else {
			echo "<tr class='info'>";
			echo "<td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td>";
			echo "</tr>";
		}
	}

?>