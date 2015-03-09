<?php

session_start();
unset($_SESSION['token']);
unset($_SESSION['client_id']);
unset($_SESSION['client_secret']);
unset($_SESSION['client_key']);
unset($_SESSION['scriptUri']);
unset($_SESSION['scope']);

header("Location:http://localhost:8888/index.html"); 

?>