<?php

//Google Client Library

	require_once 'Google/autoload.php';
	require_once 'routines.php';
	
	//session_start();
	

// $service implements the client interface, has to be set before auth call
$client = createAuth();

if($client == null ){
echo "<button onclick=\"window.location.href='login.php'\" class=\"btn btn-default\" type=\"button\">Please Log in</button>";
	die;
}

$service = new Google_Service_Calendar($client);

$date = dateformatConvert($_GET['date']);
$timeMin=$date['min'];
$timeMax=$date['max'];

//echo "Events from Google Calendar:<br>";
echo "<head> Events for ".$_GET['date']."</head>";

$optParams = array('timeMin' => $timeMin,'timeMax' => $timeMax);

$events = $service->events->listEvents('primary',$optParams);

$index = 1;

//Parsing each event record of the day

  foreach ($events->getItems() as $event) {
	$title = $event -> getSummary();
	$event_id = $event -> getId();
	$description = $event -> getDescription();
	$location = $event -> getLocation();
	
	//Parsing start date with default time 00:00:00
	if($event->getStart()->getDate() !== null) {
		$start_date = $event->getStart()->getDate();
		$start_date = date_create_from_format('Y-m-d',$start_date);
		$start_time = date_create_from_format('H:i:s', "00:00:00");
	} else {
		$start_date = substr($event->getStart()->getDateTime(), 0, 10);
		$start_date = date_create_from_format('Y-m-d',$start_date);
		$start_time = substr($event->getStart()->getDateTime(), -14, 8);
		$start_time = date_create_from_format('H:i:s', $start_time);
	}
	
	//All day event end date will be the same day as the start date, default time 23:59:59
	if($event->getEnd()->getDate() !== null) {
		$end_date = date_create_from_format('Y-m-d',$event->getStart()->getDate());
		$end_time = date_create_from_format('H:i:s', "23:59:59");
	} else {
		$end_date = substr($event->getStart()->getDateTime(), 0, 10);
		$end_date = date_create_from_format('Y-m-d', $end_date);
		$end_time = substr($event->getEnd()->getDateTime(), -14, 8);
		$end_time = date_create_from_format('H:i:s', $end_time);
	}
	
	echo "<ul class=\"listview image\">";
	echo "<p>Event: <a href=\"".$event -> getHtmlLink()."\" target=\"_blank\" >".$title."</a></p>";
	echo "<p>Description: ".$description."</p>";
	echo "<p><small>Start Date: ".$start_date->format('Y-m-d')."</small></p>"; 
	echo "<p><small>Start Time: ".$start_time->format('H:i:s')."</small></p>";
	echo "<p><small>End Date: ".$end_date->format('Y-m-d')."</small></p>"; 
	echo "<p><small>End Time: ".$end_time->format('H:i:s')."</small></p>";
	echo "</ul>";
	echo "<br>";

	$index = $index + 1;

}
echo "<button onclick=\"window.location.href='mainpage.html'\" class=\"btn btn-default\" type=\"button\">Back to Homepage</button>";

?>