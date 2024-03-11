
<?php

	require_once '../user/session.php';
	// Get Batch
	if(isset($_POST["get_batch"])){
		$period = $_POST['period'];
		$where = 1;
		if($_POST['date1']!='' && $_POST['date2'] ==''){
			$date1 = date("Y-m-d", strtotime($_POST['date1']));
			$where .= " AND BATCH_START_DATE='$date1'";
		}
		else if($_POST['date1']!='' && $_POST['date2'] !=''){
			$date1 = date("Y-m-d", strtotime($_POST['date1']));
			$date2 = date("Y-m-d", strtotime($_POST['date2']));
			$where .= " AND BATCH_START_DATE BETWEEN '$date1' AND '$date2'";
		}

		if($period=='current'){
			$where .= " AND ROLL_BATCHROLL > '1'";
			$sql1 = "SELECT distinct ROLL_BATCHID,BATCH_NUMBER FROM ROLL INNER JOIN STD_BATCH ON ROLL_BATCHID=BATCH_ID WHERE $where";
		}
		else if($period=='date'){
			$roll_table = 'Roll_'.date("mY", strtotime($_POST['date1']));
			//$sql1 = "SELECT distinct ROLL_BATCHID,BATCH_NUMBER FROM $mth_db.$roll_table INNER JOIN STD_BATCH ON ROLL_BATCHID=BATCH_ID WHERE $where";
			$sql1 = "SELECT distinct ROLL_BATCHID,BATCH_NUMBER FROM roll INNER JOIN STD_BATCH ON ROLL_BATCHID=BATCH_ID WHERE $where";
		}
		if($period=='any_time'){
			$query    = "SELECT TABLE_NAME AS tablex FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$mth_db'";
			$res      = mysqli_query($mth, $query);
			$bigquery = '';
			if (mysqli_num_rows($res) > 0) {
				while ($row = mysqli_fetch_assoc($res)) {
					if ((substr($row['tablex'], 0, 5) == 'roll_') || (substr($row['tablex'], 0, 5) == 'ROLL_')) {
						//$bigquery .= "SELECT distinct ROLL_BATCHID,BATCH_NUMBER FROM $mth_db." . $row['tablex'] . " INNER JOIN STD_BATCH ON ROLL_BATCHID=BATCH_ID WHERE $where UNION ";
						$bigquery .= "SELECT distinct ROLL_BATCHID,BATCH_NUMBER FROM roll INNER JOIN STD_BATCH ON ROLL_BATCHID=BATCH_ID WHERE $where UNION ";
					}
				}
				$sql1 =  rtrim($bigquery, "UNION ");
			}
		}
		else if($period=='from_to'){

			$startmonth = date('Y-m-01', strtotime($date1));
			$endmonth = date('Y-m-01', strtotime($date2));
			$mtharray = array();
			$bigquery = '';
			while (strtotime($startmonth) <= strtotime($endmonth)) {
				array_push($mtharray, "ROLL_" . date('mY', strtotime($startmonth)));
				$startmonth = date("Y-m-01", strtotime("+1 month", strtotime($startmonth)));
			}
			for ($a = 0; $a < sizeof($mtharray); $a++) {
				$rolltbl = $mtharray[$a];
				$query2    = "SELECT TABLE_NAME AS tablex FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$mth_db' AND TABLE_NAME='$rolltbl'";
				$res2      = mysqli_query($mth, $query2);
				if (mysqli_num_rows($res2) > 0) {
					//$bigquery .= "SELECT distinct ROLL_BATCHID,BATCH_NUMBER FROM $mth_db." .$rolltbl. " INNER JOIN STD_BATCH ON ROLL_BATCHID=BATCH_ID WHERE $where UNION ";
					$bigquery .= "SELECT distinct ROLL_BATCHID,BATCH_NUMBER FROM roll INNER JOIN STD_BATCH ON ROLL_BATCHID=BATCH_ID WHERE $where UNION ";
				}
			}
			$sql1 =  rtrim($bigquery, "UNION ");
		}
echo $sql1;
		$res1 = mysqli_query($fit, $sql1);
		if ($res1 && mysqli_num_rows($res1) > 0) {
			echo '<option value="all">ALL</option>';
			while ($row1 = mysqli_fetch_assoc($res1)) {
				echo '<option value="'.$row1['ROLL_BATCHID'].'">'.$row1['BATCH_NUMBER'].'</option>';
			}
		}
		else{
			echo '<option value="">Batch not available</option>';
		}
	}


	// Get Inspection Table
	if(isset($_POST["get_machine"])){
		$period = $_POST['period'];
		$where = 1;
		if($_POST['date1']!='' && $_POST['date2'] ==''){
			$date1 = date("Y-m-d", strtotime($_POST['date1']));
			$where .= " AND BATCH_START_DATE='$date1'";
		}
		else if($_POST['date1']!='' && $_POST['date2'] !=''){
			$date1 = date("Y-m-d", strtotime($_POST['date1']));
			$date2 = date("Y-m-d", strtotime($_POST['date2']));
			$where .= " AND BATCH_START_DATE BETWEEN '$date1' AND '$date2'";
		}

		if($period=='current'){
			$where .= " AND ROLL_BATCHROLL > '1'";
			$sql1 = "SELECT distinct(ROLL_MCID)FROM ROLL INNER JOIN STD_BATCH ON ROLL_BATCHNUM=BATCH_NUMBER WHERE $where";
		}
		else if($period=='date'){
			$roll_table = 'Roll_'.date("mY", strtotime($_POST['date1']));
			$sql1 = "SELECT distinct(ROLL_MCID) FROM $mth_db.$roll_table INNER JOIN STD_BATCH ON ROLL_BATCHNUM=BATCH_NUMBER WHERE $where";
		}
		if($period=='any_time'){
			$query    = "SELECT TABLE_NAME AS tablex FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$mth_db'";
			$res      = mysqli_query($mth, $query);
			$bigquery = '';
			if (mysqli_num_rows($res) > 0) {
				while ($row = mysqli_fetch_assoc($res)) {
					if ((substr($row['tablex'], 0, 5) == 'roll_') || (substr($row['tablex'], 0, 5) == 'ROLL_')) {
						$bigquery .= "SELECT distinct(ROLL_MCID) FROM $mth_db." . $row['tablex'] . " INNER JOIN STD_BATCH ON ROLL_BATCHNUM=BATCH_NUMBER WHERE $where UNION ";
					}
				}
				$sql1 =  rtrim($bigquery, "UNION ");
			}
		}
		else if($period=='from_to'){

			$startmonth = date('Y-m-01', strtotime($date1));
			$endmonth = date('Y-m-01', strtotime($date2));
			$mtharray = array();
			$bigquery = '';
			while (strtotime($startmonth) <= strtotime($endmonth)) {
				array_push($mtharray, "ROLL_" . date('mY', strtotime($startmonth)));
				$startmonth = date("Y-m-01", strtotime("+1 month", strtotime($startmonth)));
			}
			for ($a = 0; $a < sizeof($mtharray); $a++) {
				$rolltbl = $mtharray[$a];
				$query2    = "SELECT TABLE_NAME AS tablex FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$mth_db' AND TABLE_NAME='$rolltbl'";
				$res2      = mysqli_query($mth, $query2);
				if (mysqli_num_rows($res2) > 0) {
					$bigquery .= "SELECT distinct(ROLL_MCID) FROM $mth_db." .$rolltbl. " INNER JOIN STD_BATCH ON ROLL_BATCHNUM=BATCH_NUMBER WHERE $where UNION ";
				}
			}
			$sql1 =  rtrim($bigquery, "UNION ");
		}

		$res1 = mysqli_query($fit, $sql1);
		if ($res1 && mysqli_num_rows($res1) > 0) {
			echo '<option value="all">ALL</option>';
			while ($row1 = mysqli_fetch_assoc($res1)) {
				$mcid = $row1['ROLL_MCID'];
				$mc_name = GFV("STD_MACHINES", "MC_NAME", "MC_ID='$mcid'");
				echo '<option value="'.$mcid.'">'.$mc_name.'</option>';
			}
		}
		else{
			echo '<option value="">Inspection Table not available</option>';
		}
	}


	if(isset($_POST["get_inspector"])){
		$period = $_POST['period'];
		$where = 1;
		if($_POST['date1']!='' && $_POST['date2'] ==''){
			$date1 = date("Y-m-d", strtotime($_POST['date1']));
			$where .= " AND BATCH_START_DATE='$date1'";
		}
		else if($_POST['date1']!='' && $_POST['date2'] !=''){
			$date1 = date("Y-m-d", strtotime($_POST['date1']));
			$date2 = date("Y-m-d", strtotime($_POST['date2']));
			$where .= " AND BATCH_START_DATE BETWEEN '$date1' AND '$date2'";
		}

		if($period=='current'){
			$where .= " AND ROLL_BATCHROLL > '1'";
			$sql1 = "SELECT distinct(ROLL_INSID)FROM ROLL INNER JOIN STD_BATCH ON ROLL_BATCHNUM=BATCH_NUMBER WHERE $where";
		}
		else if($period=='date'){
			$roll_table = 'Roll_'.date("mY", strtotime($_POST['date1']));
			$sql1 = "SELECT distinct(ROLL_INSID) FROM $mth_db.$roll_table INNER JOIN STD_BATCH ON ROLL_BATCHNUM=BATCH_NUMBER WHERE $where";
		}
		if($period=='any_time'){
			$query    = "SELECT TABLE_NAME AS tablex FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$mth_db'";
			$res      = mysqli_query($mth, $query);
			$bigquery = '';
			if (mysqli_num_rows($res) > 0) {
				while ($row = mysqli_fetch_assoc($res)) {
					if ((substr($row['tablex'], 0, 5) == 'roll_') || (substr($row['tablex'], 0, 5) == 'ROLL_')) {
					$bigquery .= "SELECT distinct(ROLL_INSID) FROM $mth_db." . $row['tablex'] . " INNER JOIN STD_BATCH ON ROLL_BATCHNUM=BATCH_NUMBER WHERE $where UNION ";
					}
					}
					$sql1 =  rtrim($bigquery, "UNION ");
					}
					}
					else if($period=='from_to'){

					$startmonth = date('Y-m-01', strtotime($date1));
					$endmonth = date('Y-m-01', strtotime($date2));
					$mtharray = array();
					$bigquery = '';
					while (strtotime($startmonth) <= strtotime($endmonth)) {
					array_push($mtharray, "ROLL_" . date('mY', strtotime($startmonth)));
					$startmonth = date("Y-m-01", strtotime("+1 month", strtotime($startmonth)));
					}
					for ($a = 0; $a < sizeof($mtharray); $a++) {
					$rolltbl = $mtharray[$a];
					$query2    = "SELECT TABLE_NAME AS tablex FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$mth_db' AND TABLE_NAME='$rolltbl'";
					$res2      = mysqli_query($mth, $query2);
					if (mysqli_num_rows($res2) > 0) {
					$bigquery .= "SELECT distinct(ROLL_INSID) FROM $mth_db." .$rolltbl. " INNER JOIN STD_BATCH ON ROLL_BATCHNUM=BATCH_NUMBER WHERE $where UNION ";
					}
					}
					$sql1 =  rtrim($bigquery, "UNION ");
					}

					$res1 = mysqli_query($fit, $sql1);
					if ($res1 && mysqli_num_rows($res1) > 0) {
					echo '<option value="all">ALL</option>';
					while ($row1 = mysqli_fetch_assoc($res1)) {
					$insid = $row1['ROLL_INSID'];
					$ins_name = GFV("INSPECTORS", "INSPECTOR_FIRSTNAME", "INSPECTOR_ID='$insid'");
					echo '<option value="'.$insid.'">'.$ins_name.'</option>';
					}
					}
					else{
					echo '<option value="">Inspection Table not available</option>';
					}
					}
// Get Batch
	if(isset($_POST["get_roll"])){
					$period = $_POST['period'];
		$where = 1;
		if($_POST['date1']!='' && $_POST['date2'] ==''){
			$date1 = date("Y-m-d", strtotime($_POST['date1']));
			$where .= " AND ROLL_DATE='$date1'";
		}
		else if($_POST['date1']!='' && $_POST['date2'] !=''){
			$date1 = date("Y-m-d", strtotime($_POST['date1']));
			$date2 = date("Y-m-d", strtotime($_POST['date2']));
			$where .= " AND ROLL_DATE BETWEEN '$date1' AND '$date2'";
		}
		
					$rqry1="select roll_id,PROLL_NUMBER from roll where $where and roll_parentid=0 and PROLL_NUMBER !=''";
					$e_rqry1=mysqli_query($fit,$rqry1);
					while($r_rqry1=mysqli_fetch_array($e_rqry1)){
						extract($r_rqry1);
							echo '<option value="'.$roll_id.'">'.$PROLL_NUMBER.'</option>';
						}
				    $rqry="select ROLL_ID,ROLL_NUMBER from roll where $where ";
					$e_rqry=mysqli_query($fit,$rqry);
					while($r_rqry=mysqli_fetch_array($e_rqry)){
						extract($r_rqry);
							echo '<option value="'.$ROLL_ID.'">'.$ROLL_NUMBER.'</option>';
						}
						
	
	}
					?>
