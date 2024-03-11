<?php
require_once 'session.php';

error_reporting(E_ALL);
if (isset($_POST['rollend_act'])) {
	$length = $_POST['length'];
	$remark = $_POST['remark'];
	
	$note = $_POST['note'];

	$roll_id = GFV("STD_MACHINES", "MC_ROLL_ID", "MC_ID='$glob_mcid' AND MC_ROLLACTIVE='1'");
	$parentid = GFV("STD_MACHINES", "MC_PARENTID", "MC_ID='$glob_mcid' AND MC_ROLLACTIVE='1'");
	

	$roll_date =  GFV("ROLL", "ROLL_INSP_DATE", "ROLL_ID='$parentid'");
	$roll_style_id =  GFV("ROLL", "ROLL_STYLE_ID", "ROLL_ID='$parentid'");
	
	$defect_count= GFV("CURDEFECTS", "COUNT(CD_DEFECT)", "CD_ROLL_ID='$roll_id'");
	
	$defect_points = GFV("CURDEFECTS", "SUM(CD_POINT)", "CD_ROLL_ID='$roll_id'");
	
	$width =  GFV("ROLL", "ROLL_WIDTH", "ROLL_ID='$parentid'");
	if (empty($width) || intval($width) <= 0) {
		$width = round(GFV("STD_STYLES", "WIDTH", "STYLE_ID='$roll_style_id'"), 2);
	}
	$gp = gp_calc($roll_id, $length, $width);
	$grade = grade_calc($roll_id, $length, $width);
	$cd_point = $gp;
	$batchroll = $grade;
	$cd_type = 4;
	$defect_id = 1000;
	$cd_shiftchange = 0;
	$cd_shiftdate = '0000-00-00';
	$cd_endlength = 0;
	$cd_date = date("Y-m-d");
	$cd_time = date("H:i:s");

	$roll_startlen = GFV("ROLL", "ROLL_STARTLENGTH", "ROLL_ID='$roll_id'");
	
	$cd_length = round($length, 2);
	$roll_length =  GFV("ROLL", "SUM(ROLL_LENGTH)", "ROLL_ID='$parentid' or ROLL_PARENTID='$parentid'");
	$roll_endlen =  round($length+$roll_length, 2);
	
		$sql_reset = "UPDATE STD_MACHINES SET MC_LENGTH='0', MC_ROLL_ID='0', MC_PARENTID='0', MC_ROLLACTIVE='0' WHERE MC_ID='$glob_mcid'";
		if (mysqli_query($fit, $sql_reset)) {
			if ($length > 0) {
				$sql_update = "UPDATE ROLL SET ROLL_LENGTH='$length', ROLL_WIDTH='$width', ROLL_ENDLENGTH='$roll_endlen', ROLL_REMARK='$remark', ROLL_NOTE='$note',ROLL_TOTAL_DEFECTS='$defect_count',ROLL_TOTAL_POINTS='$defect_points', ROLL_ENDTIME=CURTIME(), ROLL_CURRENT='0', ROLL_END='1', ROLL_GP='$gp', ROLL_GRADE='$grade' WHERE ROLL_ID='$roll_id' ";
				mysqli_query($fit, $sql_update);

				//Moving Defect Data to Month DB
				$defectable = "DEFECT_" . date('mY', strtotime($roll_date));
				$query0 = "CREATE TABLE IF NOT EXISTS $mth_db.$defectable LIKE $fit_db.CURDEFECTS";
				mysqli_query($mth, $query0);
				$query0 = "ALTER TABLE $mth_db.$defectable  MODIFY CD_ID INT NOT NULL";
				mysqli_query($mth, $query0);
				$query0 = "ALTER TABLE $mth_db.$defectable DROP PRIMARY KEY";
				mysqli_query($mth, $query0);
				$query1 = "INSERT INTO $mth_db.$defectable SELECT * FROM $fit_db.CURDEFECTS WHERE CURDEFECTS.CD_PARENTID='$parentid'";
				if (mysqli_query($mth, $query1)) {
					$query2 = "DELETE FROM $fit_db.CURDEFECTS WHERE CURDEFECTS.CD_PARENTID='$parentid'";
					mysqli_query($fit, $query2);
				}


				//Moving Roll Data to Month DB
				$rolltable = "ROLL_" . date('mY', strtotime($roll_date));
				$query0 = "CREATE TABLE IF NOT EXISTS $mth_db.$rolltable LIKE $fit_db.ROLL";
				mysqli_query($mth, $query0);
				$query0 = "ALTER TABLE $mth_db.$rolltable  MODIFY ROLL_ID INT NOT NULL";
				mysqli_query($mth, $query0);
				$query0 = "ALTER TABLE $mth_db.$rolltable DROP PRIMARY KEY";
				mysqli_query($mth, $query0);
				$query1 = "INSERT INTO $mth_db.$rolltable SELECT * FROM $fit_db.ROLL WHERE ROLL.ROLL_PARENTID='$parentid'";
				mysqli_query($mth, $query1);
				//$query1 = "DELETE FROM $fit_db.ROLL WHERE ROLL.ROLL_ID='$roll_id'";
				//mysqli_query($fit, $query1);

			
			}
		} else {
			$_SESSION['error'] = 'Error Occurred while Processing Piece/Roll End';
		}
	
	// UPDATE LOGOUT TIME
	//$sql_edit = "UPDATE INSPECTORS SET INSP_LOGOUTTIME = NOW(), INSP_LOGSTATE = '0' WHERE INSP_ID='$glob_insid'";
	//mysqli_query($fit, $sql_edit);


}
header("Location: home.php");
