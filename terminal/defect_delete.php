<?php
require_once 'session.php';
extract($_REQUEST);
	$sql_update = "delete from CURDEFECTS where CD_ID='$defect_id' ";
		mysqli_query($fit, $sql_update);
	header('location: home.php');

