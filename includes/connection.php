<?php

date_default_timezone_set('Asia/Kolkata');

session_start();
ob_start();

/**Error Reporting*/
//error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);


/* Connection Details of FIT */
$hostname = "localhost";
$username = "sa";
$password = "d";
$fit_db = "fit";
// Create connection to FIT
$fit = mysqli_connect($hostname, $username, $password, $fit_db);
// Check connection FIT
if (!$fit) {
	die("Connection to FIT is failed: " . mysqli_connect_error());
}

// To Use Other Language Fonts
$tamil_font = 'SET CHARACTER SET utf8';
mysqli_query($fit, $tamil_font) or die('Can\'t charset in DataBase');


// Connection Details of FIT_MONTH
$hostname = "localhost";
$username = "sa";
$password = "d";
$mth_db = "fitmonth";
// Create connection FIT_MONTH
$mth = mysqli_connect($hostname, $username, $password, $mth_db);
// Check connection FIT_MONTH
if (!$mth) {
	die("Connection to FIT MONTH is failed: " . mysqli_connect_error());
}

$hostname = "localhost";
$username = "sa";
$password = "d";
$loom_db = "loom";
$loom = mysqli_connect($hostname, $username, $password, $loom_db);
$mdate = date("Y-m-d");
$mshift = 1;
