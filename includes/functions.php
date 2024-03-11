<?php
//include "connection.php";\
function dbDate($date)
{
	return date("Y-m-d", strtotime($date));
}
function showdbDate($date)
{
	return date("d-m-Y", strtotime($date));
}
function showNDate($date)
{
	return date("d.m.y", strtotime($date));
}
function showDateTime($date)
{
	return date("d/m/Y H:i:s", strtotime($date));
}

function roundOne($val)
{
	return number_format(round($val, 1), 1, '.', '');
}

function roundTwo($val)
{
	return number_format(round($val, 2), 2, '.', '');
}
function roundThree($val)
{
	return number_format(round($val, 3), 3, '.', '');
}

function icons($defect)
{
}
function getUpperPostKey()
{
	foreach ($_POST as $postKey => $postVar) {
		unset($_POST[$postKey]);
		$_POST[strtoupper($postKey)] = $postVar;
	}
	return $_POST;
}
function currentDatewithTime()
{
	return date("d-m-Y H:i:s");
}
function logfile($content)
{
	/// $log_con = "\r\n" . currentDatewithTime()  . "\t" . $content. "\n";
	//$fname = "FIT_" . date('Y_m_d') . ".txt";
	// $fp = fopen ( "log/$fname", "a" );
	//fwrite ( $fp, $log_con );
	//fclose ( $fp );
}

function GFV($tabel, $getfiled, $criteria)
{
	$returnresult = '';
	global $fit;
	if (strlen($criteria) == 0) {
		$query_function = "SELECT $getfiled FROM " . $tabel . " LIMIT 1";
	} else {
		$query_function = "SELECT $getfiled FROM " . $tabel . " WHERE " . $criteria . " LIMIT 1";
	}
	$fun = mysqli_query($fit, $query_function);
	if ($fun && mysqli_num_rows($fun) > 0) {
		$row_fun      = mysqli_fetch_assoc($fun);
		$returnresult = $row_fun[$getfiled];
		return $returnresult;
	} else {
		return null;
	}
}

function GFV_MONTH($tabel, $getfiled, $criteria)
{
	$returnresult = '';
	global $mth;
	if (strlen($criteria) == 0) {
		$query_function = "SELECT $getfiled FROM " . $tabel . " LIMIT 1";
	} else {
		$query_function = "SELECT $getfiled FROM " . $tabel . " WHERE " . $criteria . " LIMIT 1";
	}
	$fun = mysqli_query($mth, $query_function);
	if ($fun && mysqli_num_rows($fun) > 0) {
		$row_fun      = mysqli_fetch_assoc($fun);
		$returnresult = $row_fun[$getfiled];
		return $returnresult;
	} else {
		return null;
	}
}

function gp_calc($roll_id, $length, $width)
{
	$gp_result = '';
	global $fit;

	if ($length > 0 && $width > 0) {
		$sql2 = "SELECT SUM(CD_POINT) as defect FROM CURDEFECTS WHERE CD_ROLL_ID='$roll_id'";
		$res2 = mysqli_query($fit, $sql2);
		if ($res2 && mysqli_num_rows($res2) > 0) {
			$row2 = mysqli_fetch_assoc($res2);
			$defect = $row2['defect'];
			$gp_result = round((($defect / $length) * 100), 2);
			return $gp_result;
		} else {
			$gp_result = 0;
			return $gp_result;
		}
	} else {
		$gp_result = 0;
		return $gp_result;
	}
}

function grade_calc($roll_id, $length, $width)
{
	$grade_result = '';
	global $fit;

	if ($length > 0 && $width > 0) {
		$sql2 = "SELECT SUM(CD_POINT) as defect FROM CURDEFECTS WHERE CD_ROLL_ID='$roll_id'";
		$res2 = mysqli_query($fit, $sql2);
		if ($res2 && mysqli_num_rows($res2) > 0) {
			$row2 = mysqli_fetch_assoc($res2);
			$defect = $row2['defect'];
			//$grade1 = round((($defect / $length) * (100 / $width) * 100), 2);
			$grade1 = round((($defect / $length)  * 100), 2);
			if ($grade1 <= 20) {
				$grade_result = 'A';
			} else if ($grade1 <= 30) {
				$grade_result = 'B';
			} else if ($grade1 <= 40) {
				$grade_result = 'C';
			} else {
				$grade_result = 'D';
			}
			return $grade_result;
		} else {
			$grade_result = 'A';
			return $grade_result;
		}
	} else {

		return NULL;
	}
}


function empty_datetime($dt)
{
	if ($dt == '' || $dt == NULL || $dt == '0000-00-00' || $dt == '0000-00-00 00:00:00') {
		return true;
	} else {
		return false;
	}
}
