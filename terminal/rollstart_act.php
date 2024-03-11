<?php
require_once 'session.php';

if (isset($_POST['style_name']) && isset($_POST['roll_number'])) {
	$style_name = $_POST['style_name'];
	//$epi = $_POST['epi'];
	//$ppcm = $_POST['ppcm'];
	//$width = $_POST['width'];
	$roll_number = $_POST['roll_number'];
	
	//mysqli_query($fit, "UPDATE STD_STYLES SET EPI='$epi',PPCM='$ppcm' WHERE style='$style_name'");

	 $qry = "SELECT * FROM INSPECTORS WHERE INSP_ID='$glob_inspid' AND INSP_VALID='1'";
	$res = mysqli_query($fit, $qry);
	if (mysqli_num_rows($res) == 1) {
	echo	$qry1 = "select * from STDSTYLE where style='$style_name'";
		$res1 = mysqli_query($fit, $qry1);
		if (mysqli_num_rows($res1) > 0) {
			$row_style = mysqli_fetch_assoc($res1);
		
			$qry_roll = "SELECT * FROM ROLL WHERE ROLL_BATCHID='". $row_style['STYLE_ID']. "' AND ROLL_NUMBER='$roll_number'";
			$res_roll = mysqli_query($fit, $qry_roll);
			if (mysqli_num_rows($res_roll) > 0) {
				$row_roll = mysqli_fetch_assoc($res_roll);
				$roll_id = $row_roll['ROLL_ID'];
				$parentid = GFV("ROLL", "ROLL_PARENTID", "ROLL_ID='$roll_id'");
				if (empty($parentid)) {
					$parentid = $roll_id;
				}
				$roll_current = $row_roll['ROLL_CURRENT'];
				$roll_end = $row_roll['ROLL_END'];
				if ($roll_end == 0 && $roll_current == 0) {
					

					//Update Roll
					$sql_update2 = "UPDATE ROLL SET  ROLL_CURRENT='1',ROLL_PARENTID='$parentid', ROLL_MC_ID='$glob_mcid', ROLL_INSP_ID='$glob_inspid', ROLL_INSP_DATE='$glob_mdate', ROLL_INSP_SHIFT='$glob_mshift', ROLL_STARTTIME=CURTIME(), ROLL_STARTLENGTH='0' WHERE ROLL_ID='$roll_id'";
					if (mysqli_query($fit, $sql_update2)) {
						$sql_reset = "UPDATE STD_MACHINES SET MC_LENGTH='0', MC_ROLL_ID='$roll_id', MC_PARENTID='$parentid', MC_ROLLACTIVE='1' WHERE MC_ID='$glob_mcid'";
						$ress = mysqli_query($fit, $sql_reset);
					}
				} else {
					$_SESSION['error'] = 'THIS ROLL MAY BE ALREADY INSPECTED';
				}
			} else {
				$_SESSION['error'] = 'THIS ROLL IS NOT AVAILABLE IN THIS BATCH';
			}
		} else {
			$_SESSION['error'] = 'PLEASE CHECK THE BATCH NUMBER';
		}
	} else {
		$_SESSION['error'] = 'THE INSPECTOR IS NOT REGISTERED/VALID';
	}
} else {
	$_SESSION['error'] = 'PLEASE FILL ALL THE FIELDS.';
}

if (isset($_SESSION['error'])) {
	header('location: rollstart.php');
} else {
	header('location: home.php');
}
