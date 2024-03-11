<?php
require_once '../includes/connection.php';
require_once '../includes/functions.php';

logfile('Page: ' . strtoupper(basename(__FILE__, '.php')));
$error =false;
if (isset($_POST)) {
    getUpperPostKey();
    $idname = 'STYLE_ID';
    $idvalue = $_POST[$idname];
    $checkfld= 'ROLL_STYLE_ID';
	$new_style_id = $_POST[$checkfld];
    $fields = array();
    $values = array();
	$weight = 'WEIGHT';
    $weight = $_POST[$weight];
	if ($weight > 1){
		$qry = "update roll set ROLL_WEIGHT='$weight' where roll_id=$idvalue";
	} elseif ($new_style_id > 0){
        $qry = "update roll set ROLL_BATCHID=$new_style_id where roll_id=$idvalue";
	}
		mysqli_query($fit,$qry);
		//exit;
}
    if ($weight > 1){
		header('location: ../user/weight.php');
	}  elseif ($new_style_id > 0){
		header('location: ../user/approval.php');
	}
?>