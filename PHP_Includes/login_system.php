<?php
	include 'Config.php';
	$API_Key = 'YourSteamAPIKey';
   	include "OpenID.php";
	
    $OpenID = new LightOpenID("coder4hire.net");
    session_start();
 
    if(!$OpenID->mode){
 
        if(isset($_GET['login'])){
            $OpenID->identity = "http://steamcommunity.com/openid";
            header("Location: {$OpenID->authUrl()}");
        }
 
        if(!isset($_SESSION['T2SteamAuth'])){
            $login = "<a href=\"?login\"><img src=\"http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_large_border.png\" alt=\"Steam Login\" /></a>";
        }
 
    } elseif($OpenID->mode == "cancel"){
 
        echo "User has canceled Authenticiation.";
 
    } else {
 
        if(!isset($_SESSION['T2SteamAuth'])){
            $_SESSION['T2SteamAuth'] = $OpenID->validate() ? $OpenID->identity : null;
            $_SESSION['T2SteamID64'] = str_replace("http://steamcommunity.com/openid/id/", "", $_SESSION['T2SteamAuth']);
			
            if($_SESSION['T2SteamAuth'] !== null){
                $Profile = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$API_Key."&steamids=".$_SESSION['T2SteamID64']."&format=json");
                $Buffer = fopen("cache/ISteamUser/{$_SESSION['T2SteamID64']}.json", "w+");
                fwrite($Buffer, $Profile);
                fclose($Buffer);
				
				$Profile = file_get_contents("http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=".$API_Key."&steamid=".$_SESSION['T2SteamID64']."&format=json");
                $Buffer = fopen("cache/IPlayerService/{$_SESSION['T2SteamID64']}.json", "w+");
                fwrite($Buffer, $Profile);
                fclose($Buffer);
            }
        }
		
		$_SESSION['IsBanned'] = 0;
 
    }
 
    if(isset($_SESSION['T2SteamAuth'])){
        	$Steam = json_decode(file_get_contents("cache/ISteamUser/{$_SESSION['T2SteamID64']}.json"));
		$login = "<meta HTTP-EQUIV='REFRESH' content='0; url=home.php'>";
    }
 
    if(isset($_GET['logout'])){
    	unset($_SESSION['T2SteamAuth']);
       unset($_SESSION['T2SteamID64']);
	session_destroy();
    	header("Location: index.php");
    }
 
?>