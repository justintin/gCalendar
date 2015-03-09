<?php
require_once 'Google/autoload.php';

$MONTHS = array(
		'January'=> '01',
		'February'=>'02',
		'March'=>'03',
		'April'=>'04',
		'May'=>'05',
		'June'=>'06',
		'July'=>'07',
		'August'=>'08',
		'September'=>'09',
		'October'=>'10',
		'November'=>'11',
		'December'=>'12'
		);

function dateformatConvert($date){
	global $MONTHS;

	$dmy = explode(" ", $date);

	date_default_timezone_set('America/New_York');
	$timerange=array();
	$timerange['min']=date("Y-m-d\TH:i:sP", mktime(0, 0, 0, $MONTHS[$dmy[1]], $dmy[0], $dmy[2]));
	$timerange['max']=date("Y-m-d\TH:i:sP", mktime(0, 0, 0, $MONTHS[$dmy[1]], $dmy[0]+1, $dmy[2]));
	return $timerange;
}

function datetimeformatConvert($datetime){
	global $MONTHS;
	try{
	$timeTuple=preg_split("/[\s:-]+/", $datetime);
	if($timeTuple[5] == 'pm'){$timeTuple[3]=intval($timeTuple[3])+12;}
	date_default_timezone_set('America/New_York');
	$timeformat=date("Y-m-d\TH:i:sP", mktime($timeTuple[3], (int)$timeTuple[4], 0, $MONTHS[$timeTuple[1]], (int)$timeTuple[0], $timeTuple[2]));
	return $timeformat;}
	catch(Exception $e)
 {
 	return $e->getMessage();
 }
}

function createAuth(){

session_start();
//Google API configuration
$client_id=$_SESSION['client_id'];
$client_secret = $_SESSION['client_secret'];
$client_key = $_SESSION['client_key'];
$scriptUri = $_SESSION['scriptUri'];
$scope = $_SESSION['scope'];
$client = new Google_Client();
$client ->setApplicationName("My Calendar");

$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setDeveloperKey($client_key); 
$client->setRedirectUri($scriptUri);
$client->setScopes($scope);



if (isset($_SESSION['token'])) { 
	$token = $_SESSION['token'];
    $client->setAccessToken($token);
}

if (!$client->getAccessToken()) { 
	$client=null;
}

return $client;

}

function add_event($service, $post){
try{
$event = new Google_Service_Calendar_Event();
$event->setSummary($post['Summary']);
$event->setDescription($post['Description']);
$event->setLocation($post['Location']);
$start = new Google_Service_Calendar_EventDateTime();
$start->setDateTime($post['startdatetime']);
$event->setStart($start);
$end = new Google_Service_Calendar_EventDateTime();
$end->setDateTime($post['enddatetime']);
$event->setEnd($end);
$attendee1 = new Google_Service_Calendar_EventAttendee();
$attendee1->setEmail($post['Email']);
$attendees = $post['Attendees'];
$event->attendees = $attendees;
$createdEvent = $service->events->insert('primary', $event);
return $createdEvent->getId();
}
catch(Exception $e){
 return -1;
 }
}



?>