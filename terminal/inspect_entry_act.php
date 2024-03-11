<?php
require_once 'session.php';

if (isset($_POST['inspect_entry_act'])) {
	$length = $_POST['length'];
	if (isset($_POST['cd_id']) && !empty($_POST['cd_id'])) {
		$cd_id = $_POST['cd_id'];
	}
	//print_r( $_POST);
	
	if (isset($_POST['width']) && !empty($_POST['width'])) {
		$width = $_POST['width'];
	} else {
		$width = 0;
	}
	$roll_id = GFV("STD_MACHINES", "MC_ROLL_ID", "MC_ID='$glob_mcid' AND MC_ROLLACTIVE='1'");
	$parentid = GFV("STD_MACHINES", "MC_PARENTID", "MC_ID='$glob_mcid' AND MC_ROLLACTIVE='1'");
	

	$rollcount = GFV("ROLL", "COUNT(ROLL_ID)", "ROLL_PARENTID='$parentid' OR ROLL_ID='$parentid'");
	//$alphabet = range('A', 'Z');
	$mqry="select * from ROLL WHERE ROLL_ID='$parentid'";
	$res=mysqli_query($fit, $mqry);
	if ($res && mysqli_num_rows($res) > 0) {
	    $row = mysqli_fetch_assoc($res);
	    $rollppcm=$row['ROLL_PPCM'];
	    $rollepi=$row['ROLL_EPI'];
	    $rollwidth=$row['ROLL_WIDTH'];
	    $rolldofflength=$row['ROLL_DOFF_LENGTH'];
	    
	    $parentroll =$row['ROLL_NUMBER']; 
	    $doffloomno =$row['ROLL_DOFF_LOOM'];
	    $styleid =$row['ROLL_STYLE_ID'];
	    $warplot = $row['ROLL_WARPLOT'];
	    $weftlot = $row['ROLL_WEFTLOT'];
	    $rollinspdate =$row['ROLL_INSP_DATE']; 	    
	}
	
	$batchroll = '';
	$remark = '';
	$reason =  '';
	$subreason =  '';
	$note =  '';
	$cd_shiftchange = 0;
	$cd_shiftdate = '0000-00-00';
	$cd_endlength = 0;
	$defect_id = 0;
	$cd_point = 0;
	$cd_date = date("Y-m-d");
	$cd_time = date("H:i:s");
	$cd_datetime = date("Y-m-d H:i:s");
	$ins_act = $_POST['inspect_entry_act'];
	if ($ins_act == 'defect') {
		$cd_type = 1;
		$defect_id = $_POST['defect_id'];
		$cd_point = $_POST['point'];
		$cd_length = round($length, 2);
	} else if ($ins_act == 'continuous_start') {
		$cd_type = 2;
		$defect_id = $_POST['defect_id'];
		$cd_length = round($length, 2);
	} else if ($ins_act == 'continuous_end') {
		$cd_type = 2;
		$defect_id = $_POST['defect_id'];
		$cd_length = GFV("CURDEFECTS", "CD_STARTLENGTH", "CD_ID='$cd_id'");
		$cd_endlength = round($length, 2);
		$cd_point = (round($cd_endlength)  - round($cd_length) + 1) * 4;
	
	} else if ($ins_act == 'rollcut') {
		$cd_type = 4;
		$remark = $_POST['remark'];
		$reason = $_POST['reason'];
		$subreason = $_POST['subreason'];
		$note = $_POST['note'];

		$roll_startlen = GFV("ROLL", "ROLL_STARTLENGTH", "ROLL_ID='$roll_id'");
		//$roll_endlen =  round($length, 2);
		
		$roll_length =  GFV("ROLL", "SUM(ROLL_LENGTH)", "ROLL_ID='$parentid' or ROLL_PARENTID='$parentid'");
		$roll_endlen =  round($length+$roll_length, 2);
		
		$nextroll_startlen = $roll_endlen;

		$cd_length = round($length, 2);
		$defect_id = 1000;

		$width =  GFV("ROLL", "ROLL_WIDTH", "ROLL_ID='$parentid'");
		if (empty($width) || intval($width) <= 0) {
			$width = round(GFV("STD_STYLES", "WIDTH", "STYLE_ID='$styleid'"), 2);
		}
		$gp = gp_calc($roll_id, $length, $width);
		$grade = grade_calc($roll_id, $length, $width);
		$cd_point = $gp;
		$batchroll = $grade;

		if($rollcount==1){
		$extra_qry = "ROLL_SUBNUMBER='$rollcount',";
		}
		
		$defect_count= GFV("CURDEFECTS", "COUNT(CD_DEFECT)", "CD_ROLL_ID='$roll_id'");
		
		$defect_points = GFV("CURDEFECTS", "SUM(CD_POINT)", "CD_ROLL_ID='$roll_id'");
		
		
		$sql_update = "UPDATE ROLL SET $extra_qry ROLL_LENGTH='$length', ROLL_WIDTH='$width', ROLL_ENDLENGTH='$roll_endlen', ROLL_REMARK='$remark', ROLL_NOTE='$note',ROLL_TOTAL_DEFECTS='$defect_count',ROLL_TOTAL_POINTS='$defect_points', ROLL_ENDTIME=CURTIME(), ROLL_CURRENT='0', ROLL_END='1', ROLL_GP='$gp', ROLL_GRADE='$grade' WHERE ROLL_ID='$roll_id' ";
		mysqli_query($fit, $sql_update);
		
		$next_subroll=$rollcount+1;
		$sql_add = "INSERT INTO ROLL (ROLL_NUMBER,ROLL_SUBNUMBER, ROLL_MC_ID,ROLL_DOFF_LOOM,ROLL_WARPLOT,ROLL_WEFTLOT,ROLL_PPCM,ROLL_EPI,ROLL_WIDTH,ROLL_DOFF_LENGTH, ROLL_INSP_ID, ROLL_STYLE_ID, ROLL_DOFF_DATE, ROLL_DOFF_SHIFT, ROLL_CURRENT,ROLL_INSP_DATE, ROLL_STARTTIME, ROLL_STARTLENGTH, ROLL_PARENTID)
		VALUES ('$parentroll','$next_subroll', '$glob_mcid','$doffloomno','$warplot','$weftlot','$rollppcm','$rollepi','$rollwidth','$rolldofflength', '$glob_inspid', '$styleid', '$cd_date', '$glob_mshift', '1','$rollinspdate',  CURTIME(), '$nextroll_startlen', '$parentid')";
		if (mysqli_query($fit, $sql_add)) {
			$last_id = mysqli_insert_id($fit);
			$sql_reset = "UPDATE STD_MACHINES SET MC_LENGTH=0,MC_ROLL_ID='$last_id' WHERE MC_ID='$glob_mcid'";
			$ress = mysqli_query($fit, $sql_reset);
		}
	}
	if($ins_act == 'continuous_end'){
	    $sql_edit = "UPDATE CURDEFECTS SET   CD_POINT='$cd_point', CD_ENDLENGTH='$cd_endlength' WHERE CD_ID='$cd_id'";
	    mysqli_query($fit, $sql_edit);
	    
	}else{
        
		 $sql_add = "INSERT INTO CURDEFECTS (CD_PARENTID, CD_ROLL_ID, CD_MC_ID, CD_INSP_ID, CD_STYLE_ID, CD_TYPE, CD_STARTLENGTH, CD_WIDTH, CD_POINT, CD_DEFECT, CD_DATE, CD_SHIFT, CD_TIME, CD_ENDLENGTH)
			VALUES ('$parentid', '$roll_id', '$glob_mcid', '$glob_inspid', '$styleid','$cd_type', '$cd_length', LPAD('$width', 3, '0'), '$cd_point', '$defect_id', '$cd_date', '$glob_mshift', CURTIME(), '$cd_endlength')";
		mysqli_query($fit, $sql_add);
	}
 header('location: home.php');
}
