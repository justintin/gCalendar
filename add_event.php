<?php

require_once 'Google/autoload.php';
require_once 'routines.php';

session_start();

$startdatetime = datetimeformatConvert($_POST['startdatetime']);
$enddatetime = datetimeformatConvert($_POST['enddatetime']);

$client = createAuth();

$service = new Google_Service_Calendar($client);
$post = array(
	'Summary' => $_POST['Summary'],
	'Description' => $_POST['Description'],
	'startdatetime' => $startdatetime,
	'enddatetime' => $enddatetime,
	'Location' => $_POST['Location'],
	'Email' => $_POST['Email'],
	'Attendees'=> explode(",",$_POST['Attendees'])
	);

$event_res=add_event($service,$post);
 if($event_res!=-1){
 header("Location:http://localhost:8888/mainpage.html");}
else{
	echo "Can not insert event.";
	echo "<button onclick=\"window.location.href='add_event.html'\" class=\"btn btn-default\" type=\"button\">Back</button>";
}
?>