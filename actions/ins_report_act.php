<?php

require_once '../user/session.php';

// Get style
if (isset($_POST["get_ins_report"])) {
	$period = $_POST['period'];
	$where = 1;
	if ($_POST['date1'] != '' && $_POST['date2'] == '') {
		$date1 = date("Y-m-d", strtotime($_POST['date1']));
		$where .= " AND ROLL_INSP_DATE='$date1'";
	} else if ($_POST['date1'] != '' && $_POST['date2'] != '') {
		$date1 = date("Y-m-d", strtotime($_POST['date1']));
		$date2 = date("Y-m-d", strtotime($_POST['date2']));
		$where .= " AND ROLL_INSP_DATE BETWEEN '$date1' AND '$date2'";
	}

	/*if ($_POST['style'] != 'all') {
		$where .= " AND ROLL_STYLE_ID='{$_POST['style']}'";
		$title_style = $_POST['style'];
	}

	if ($_POST['machine'] != '') {
		$where .= " AND ROLL_MC_ID='{$_POST['machine']}'";
		$title_mc = GFV("STD_MACHINES", "MC_NAME", "MC_ID='{$_POST['machine']}'");
	}

	if ($_POST['inspector'] != '') {
		$where .= " AND ROLL_INSP_ID='{$_POST['inspector']}'";
		$title_ins = GFV("INSPECTORS", "INSP_NAME", "INSP_ID='{$_POST['inspector']}'");
	}*/

	// Detailed Report
	if ($_POST["rep_type"] == 'detailed') {
	    
	    
	    echo "test";
	    if ($period == 'date') {
	        $roll_tbl = 'ROLL_' . date("mY", strtotime($_POST['date1']));
	        $dfct_tbl = 'DEFECT_' . date("mY", strtotime($_POST['date1']));
	        $sql1 = "SELECT * FROM $mth_db.$roll_tbl INNER JOIN $fit_db.STD_STYLES ON ROLL_STYLE_ID=STYLE_ID INNER JOIN $mth_db.$dfct_tbl ON ROLL_ID=CD_ROLL_ID WHERE $where";
	    }
	    if ($period == 'any_time') {
	        $query    = "SELECT TABLE_NAME AS tablex FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$mth_db'";
	        $res      = mysqli_query($mth, $query);
	        $bigquery = '';
	        if (mysqli_num_rows($res) > 0) {
	            while ($row = mysqli_fetch_assoc($res)) {
	                
	                if ((substr($row['tablex'], 0, 5) == 'roll_') || (substr($row['tablex'], 0, 5) == 'ROLL_')) {
	                    $roll_tbl = $row['tablex'];
	                    $dfct_tbl = "defect_" . substr($row['tablex'], 5, 8);
	                    $bigquery .= "SELECT * FROM $mth_db.$roll_tbl INNER JOIN $fit_db.STD_STYLES ON ROLL_STYLE_ID=STYLE_ID INNER JOIN $mth_db.$dfct_tbl ON ROLL_ID=CD_ROLL_ID WHERE $where UNION ";
	                }
	            }
	            $sql1 =  rtrim($bigquery, "UNION ");
	        }
	    } else if ($period == 'from_to') {
	        
	        $startmonth = date('Y-m-01', strtotime($date1));
	        $endmonth = date('Y-m-01', strtotime($date2));
	        $mtharray = array();
	        $mtharray1 = array();
	        $bigquery = '';
	        while (strtotime($startmonth) <= strtotime($endmonth)) {
	            array_push($mtharray, "ROLL_" . date('mY', strtotime($startmonth)));
	            array_push($mtharray1, "DEFECT_" . date('mY', strtotime($startmonth)));
	            $startmonth = date("Y-m-01", strtotime("+1 month", strtotime($startmonth)));
	        }
	        for ($a = 0; $a < sizeof($mtharray); $a++) {
	            $roll_tbl = $mtharray[$a];
	            $dfct_tbl = $mtharray1[$a];
	            $query2    = "SELECT TABLE_NAME AS tablex FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$mth_db' AND TABLE_NAME='$roll_tbl'";
	            $res2      = mysqli_query($mth, $query2);
	            if (mysqli_num_rows($res2) > 0) {
	                $bigquery .= "SELECT * FROM $mth_db.$roll_tbl INNER JOIN $fit_db.STD_STYLES ON ROLL_STYLE_ID=STYLE_ID INNER JOIN $mth_db.$dfct_tbl ON ROLL_ID=CD_ROLL_ID  WHERE $where UNION ";
	            }
	        }
	        $sql1 =  rtrim($bigquery, "UNION ");
	    }
	    
	    $sql1 .= " ORDER BY ROLL_STYLE_ID,CD_STARTLENGTH";
	   // echo $sql1;
	    $res1 = mysqli_query($fit, $sql1);
	    if ($res1 && mysqli_num_rows($res1) > 0) {
	        
	        echo '<div><h4>Inspection Report: Detailed | ';
	        if ($period == 'any_time') {
	            echo 'Period: All Time | ';
	        }
	        if ($period == 'date') {
	            echo 'Period: ' . date('d-m-Y', strtotime($date1)) . ' | ';
	        }
	        if ($period == 'from_to') {
	            echo 'Period: ' . date('d-m-Y', strtotime($date1)) . ' to ' . date('d-m-Y', strtotime($date2)) . ' | ';
	        }
	        if ($_POST['style'] != 'all' && $_POST['style'] != '') {
	            echo 'style: ' . $title_style . ' | ';
	        } else {
	            echo 'style: All | ';
	        }
	        if ($_POST['machine'] != 'all' && $_POST['machine'] != '') {
	            echo 'Inspection Table: ' . $title_mc . ' | ';
	        } else {
	            echo 'Inspection Table: All | ';
	        }
	        if ($_POST['inspector'] != 'all' && $_POST['inspector'] != '') {
	            echo 'Inspector: ' . $title_ins;
	        } else {
	            echo 'Inspector: All';
	        }
	        echo '</h4></div>';
	        
	        $i = 0;
	        $j = 0;
	        $sno = 1;
	        $k = 0;
	        $beg = true;
	        $roll_check = '';
	        $style_ckeck = '';
	        $blength_tot = 0;
	        echo '<table class="table table-bordered">';
	        echo '<thead>
				<tr style="background-color:#efefef;">
				<th style="color:#000000;">S.No.</th>
				<th style="color:#000000;">Defect</th>
				<th style="color:#000000;">Length</th>
				<th style="color:#000000;">Points</th>
				</tr>
				</thead>';
	        echo '<tbody>';
	        while ($row1 = mysqli_fetch_assoc($res1)) {
	            
	           
	            
	            $roll_id = $row1['ROLL_ID'];
	            $roll_number = $row1['ROLL_NUMBER'];
	            $insid = $row1['ROLL_INSP_ID'];
	            $style_id = $row1['ROLL_STYLE_ID'];
	            
	            $ROLL_INSP_DATE = $row1['ROLL_INSP_DATE'];
	            $roll_starttime = $row1['ROLL_STARTTIME'];
	            $mcid = $row1['ROLL_MC_ID'];
	            
	            $roll_length = $row1['ROLL_LENGTH'];
	            $roll_width = $row1['ROLL_WIDTH'];
	            $roll_weight = $row1['ROLL_WEIGHT'];
	            $roll_gp = $row1['ROLL_GP'];
	            $roll_grade = $row1['ROLL_GRADE'];
	            
	            
	            
	            $cd_type = $row1['CD_TYPE'];
	            
	            $startlength = round($row1['CD_STARTLENGTH']);
	            $endlength = round($row1['CD_ENDLENGTH']);
	            $width = round($row1['CD_WIDTH']);
	            $defectid = $row1['CD_DEFECT'];
	            $point = $row1['CD_POINT'];
	            $mc_name = GFV("STD_MACHINES", "MC_NAME", "MC_ID='$mcid'");
	            $ins_name = GFV("INSPECTORS", "INSP_NAME", "INSP_ID='$insid'");
	            $defectname = GFV("std_defects", "DEFECT_NAME", "DEFECT_ID='$defectid'");
	            $defect_shortname = GFV("std_defects", "DEFECT_SHORTNAME", "DEFECT_ID='$defectid'");
	            $style_name = GFV("STD_STYLES", "STYLE", "STYLE_ID='$style_id'");
	           
	            
	            
	            if ($roll_check != $roll_id && $beg != true) {
	                
	                
	                
	                echo '<tr>';
	                echo '<td style="color:#000000;background-color:#add8e6; font-weight:bold;">Piece/Roll Total:</td>';
	                echo '<td style="color:#000000;background-color:#add8e6; font-weight:bold;">Defects: ' . $i . '</td>';
	                echo '<td style="color:#000000;background-color:#add8e6; font-weight:bold;">Length: ' . round($roll_length) . '</td>';
	                
	                echo '<td style="color:#000000;background-color:#add8e6; font-weight:bold;">GP: ' . round($roll_gp, 0) . ', Grade: ' . $roll_grade . '</td>';
	                echo '</tr>';
	                
	                $i = 0;
	                
	                echo '<tr><td colspan="20"></td></tr>';
	                
	                
	            }
	            
	            if ($style_check != $stylenum && $beg != true) {}
	            
	            
	            if ($roll_check != $roll_id) {
	                
	            }
	            
	                echo '<tr>';
	                echo '<td style="color:#000000;">' . $sno . '</td>';
	                echo '<td style="color:#000000;">' . $roll_number . '-'. $style_name . '-'. $ins_name . '-'. $mcid .'</td>';
	                echo '<td style="color:#000000;">' . $defect_shortname . ' - ' . $defectname . ' </td>';
	                echo '<td style="color:#000000;">' . $startlength . '</td>';
	               
	                echo '<td style="color:#000000;">' . $point . '</td>';
	                echo '</tr>';
	                $sno++;
	                $i++;
	                $j++;
	            
	            $beg = false;
	            $roll_check = $roll_id;
	            $style_check = $stylenum;
	        }
	        
	        
	        
	        echo '</tbody>';
	        echo '</table>';
	    } else {
	        echo '<div>Data not available</div>';
	    }
	    
	    
	}

	// Summary Report
	else {
	    
	    
	    
	    
	}
}
