<?php
$mysqli = new mysqli("localhost", "root", "vertrigo", "home");

if ($mysqli->connect_errno) {
    printf("No connection: %s\n", $mysqli->connect_error);
    exit();
}

$userid = $mysqli->real_escape_string($_COOKIE['userid']);
$area = $mysqli->real_escape_string($_POST['area']);

$result = $mysqli->query("INSERT INTO actions SET userid = $userid, area = '$area'");

if (!$result) {
	echo $mysqli->error;
}

$mysqli->close();
