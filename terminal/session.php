<?Php
require_once '../includes/connection.php';
require_once '../includes/functions.php';

$glob_scanner_running = true;
if (isset($_SESSION['mc_id']) && !empty($_SESSION['mc_id']) && isset($_SESSION['insp_id']) && !empty($_SESSION['insp_id'])) {
	$glob_mcid = $_SESSION['mc_id'];
	$glob_inspid = $_SESSION['insp_id'];
	$glob_userend = 2;
} else {
	header('location:index.php');
	exit();
}


function DATENSHIFT($time)
{
	if (is_numeric($time)) {
		// time in seconds
		$caltime = strtotime(date('H:i:s', $time));
		$caldate = strtotime(date('Y-m-d', $time));
	} else {
		// time in string
		$caltime = strtotime(date('H:i:s', strtotime($time)));
		$caldate = strtotime(date('Y-m-d', strtotime($time)));
	}
	$noofshifts = GFV("STD_MILL", "NOOFS", "1");
	$sf1        = strtotime(GFV("STD_MILL", "SHIFT1", "1"));
	$sf2        = strtotime(GFV("STD_MILL", "SHIFT2", "1"));
	$sf3        = strtotime(GFV("STD_MILL", "SHIFT3", "1"));
	$pd         = false;
	if ($noofshifts == 1) {
		$rsf = 1;
		if ($caltime < $sf1) {
			$pd = true;
		}
	} elseif ($noofshifts == 2) {
		if ($caltime >= $sf1 && $caltime < $sf2) {
			$rsf = 1;
		} else {
			$rsf = 2;
			if ($caltime < $sf1) {
				$pd = true;
			}
		}
	} elseif ($noofshifts = 3) {
		if ($caltime > $sf1 && $caltime < $sf2) {
			$rsf = 1;
		} elseif ($caltime >= $sf2 && $caltime < $sf3) {
			$rsf = 2;
		} else {
			$rsf = 3;
			if ($caltime < $sf1) {
				$pd = true;
			}
		}
	}
	if ($pd == true) {
		$rdt = $caldate - (24 * 60 * 60);
	} else {
		$rdt = $caldate;
	}
	$out['Date']  = date('Y-m-d', $rdt);
	$out['Shift'] = $rsf;
	return $out;
}

function Findshift()
{
	global $fit;
	global $fit_db;
	global $sh_end;
	$dttim     = date("Y-m-d H:i:s");
	$n         = DATENSHIFT($dttim);
	$CUR_SHIFT = $n['Shift'];
	$CUR_DATE  = $n['Date'];

	$Mill_qry = "SELECT MDATE,MSHIFT FROM $fit_db.STD_MILL";
	$Mill_Rs  = mysqli_query($fit, $Mill_qry) or die(mysqli_errno($fit));
	$Mrec_RS  = mysqli_fetch_assoc($Mill_Rs);
	if (($Mrec_RS['MSHIFT'] != $CUR_SHIFT) || ($Mrec_RS['MDATE'] != $CUR_DATE)) {
		$sh_end    = 1;
		$SQL11 = "UPDATE $fit_db.STD_MILL SET MDATE = '$CUR_DATE',MSHIFT = $CUR_SHIFT";
		mysqli_query($fit, $SQL11) or die(mysqli_errno($fit));
	}
}

Findshift();

// Get mdate and mshift
$glob_mdate = GFV("STD_MILL", "MDATE", "1");
$glob_mshift = GFV("STD_MILL", "MSHIFT", "1");
$glob_mtime = date("H:i:s");
$glob_datetime = date("H:i:s");

function curtel()
{
    global $fit,$fit_db,$glob_mdate, $glob_mshift, $glob_mtime, $glob_mcid, $glob_datetime;
    //Select From std Machine
    $qry_mc = "SELECT  MC_LENGTH,MC_SCANTIME, MC_PRELEN, MC_PRETIME FROM STD_MACHINES WHERE MC_ID='$glob_mcid'";
    $res_mc = mysqli_query($fit, $qry_mc);
    $row_mc = mysqli_fetch_assoc($res_mc);
    $length = $row_mc['MC_LENGTH'];
    $scantime = $row_mc['MC_SCANTIME'];
    $prelength = $row_mc['MC_PRELEN'];
    $pretime = $row_mc['MC_PRETIME'];
  
    if ((strtotime($glob_datetime) - strtotime($scantime)) < 15) {
       // if (strtotime($scantime) >= strtotime($pretime)) {
           
            //Update Prescan time as current shift begining time in std_machines
            $update_mc = "UPDATE STD_MACHINES SET MC_PRETIME='$scantime', MC_PRELEN='$length' WHERE MC_ID='$glob_mcid'";
            mysqli_query($fit, $update_mc);
            
            return true;
       /*  } else {
            return false;
        } */
    } else {
        return false;
    }
}

$glob_scanner_running = curtel();

//$glob_scanner_running=true;

$page_title = 'FABRIC INSPECTION';

$dlog_logoblock = '<img src="images/Datalog_Logo.png" style="height:40px; vertical-align:middle; ">';
$mill_logoblock = '<img src="images/pdf_logo.jpg" style="height:40px; vertical-align:middle; ">';
