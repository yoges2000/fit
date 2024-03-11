<?php
require_once 'session.php';

if (isset($_POST['widthentry_act'])) {
	$length = $_POST['length'];
	$cw_type = $_POST['cw_type'];
	if (isset($_POST['cw_width1']) && !empty($_POST['cw_width1'])) {
		$cw_width1 = $_POST['cw_width1'];
	} else {
		$cw_width1 = 0;
	}
	if (isset($_POST['cw_width2']) && !empty($_POST['cw_width2'])) {
		$cw_width2 = $_POST['cw_width2'];
	} else {
		$cw_width2 = 0;
	}
	$roll_id = GFV("STD_MACHINES", "MC_ROLL_ID", "MC_ID='$glob_mcid' AND MC_ROLLACTIVE='1'");
	$parentid = GFV("STD_MACHINES", "MC_PARENTID", "MC_ID='$glob_mcid' AND MC_ROLLACTIVE='1'");

	$parentroll = GFV("ROLL", "ROLL_NUMBER", "ROLL_ID='$parentid'");
	$batchid = GFV("ROLL", "ROLL_BATCHID", "ROLL_ID='$parentid'");
	$cw_length = round($length, 2);
	$cw_date = date("Y-m-d");
	$ins_act = $_POST['inspect_entry_act'];
	$sql_add = "INSERT INTO CURWIDTH (CW_PARENTID, CW_ROLLID, CW_MCID, CW_INSID, CW_TYPE, CW_LENGTH, CW_WIDTH1, CW_WIDTH2, CW_DATE, CW_SHIFT, CW_TIME)
			VALUES ('$parentid', '$roll_id', '$glob_mcid', '$glob_insid', '$cw_type', '$cw_length', LPAD('$cw_width1', 3, '0'), LPAD('$cw_width2', 3, '0'), '$glob_mdate', '$glob_mshift', CURTIME())";
	mysqli_query($fit, $sql_add);
}

header('location: home.php');
