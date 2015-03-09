<?php
//Google Client Library
	require_once 'Google/autoload.php';
	
	session_start();
	
//Google API configuration
	$client_id="your client id";
	$client_secret = "your client secret";
	$client_key = "your client key";
	$scriptUri = "your script Uir";
	$scope = "https://www.googleapis.com/auth/calendar";

	$client = new Google_Client();
	$client ->setApplicationName("My Calendar");
	
	$client->setClientId($client_id);
	$client->setClientSecret($client_secret);
	$client->setDeveloperKey($client_key); 
	$client->setRedirectUri($scriptUri);
	$client -> setScopes($scope);
	

//Receive positive auth callback, get the token, and store it in the token
if (isset($_GET['code'])) { 
	$client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
	}

// extract token from session and configure client
if (isset($_SESSION['token'])) { 
	$token = $_SESSION['token'];
    $client -> setAccessToken($token);
}

// Auth call to google
if (!$client->getAccessToken()) { 
    $authUrl = $client->createAuthUrl();
    header("Location: ".$authUrl);
    die;
}

if(!isset($_SESSION['client_id'])){
	$_SESSION['client_id']=$client_id;
}
if(!isset($_SESSION['client_secret'])){
	$_SESSION['client_secret']=$client_secret;
}
if(!isset($_SESSION['client_key'])){
	$_SESSION['client_key']=$client_key;
}
if(!isset($_SESSION['scriptUri'])){
	$_SESSION['scriptUri']=$scriptUri;
}
if(!isset($_SESSION['scope'])){
	$_SESSION['scope']=$scope;
}


header("Location:http://localhost:8888/mainpage.html"); 
?>