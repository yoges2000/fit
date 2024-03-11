<?php 

require_once '../user/session.php';
$mcid=$_POST['mcid'];
$mcqry="select MC_ROLL_ID,MC_PARENTID FROM STD_MACHINES WHERE MC_ID=$mcid";
$mcres = mysqli_query($fit, $mcqry);
if(mysqli_num_rows($mcres) > 0){
    $mcrow = mysqli_fetch_assoc($mcres);
    $parentid=$mcrow['MC_PARENTID'];
    $roll_id=$mcrow['MC_ROLL_ID'];
$qry2 = "SELECT * FROM CURDEFECTS INNER JOIN ROLL ON CD_ROLL_ID=ROLL_ID WHERE (CD_PARENTID='$parentid' OR CD_ROLL_ID=$roll_id) ORDER BY CD_ID DESC";
$res2 = mysqli_query($fit, $qry2);
if ($res2 && mysqli_num_rows($res2) > 0) {
    echo '<table class="table borderless_table" style="font-size: 11px;">';
    echo '<thead>';
    echo '<tr>';
    echo '<th style="text-align:center;">Particulars</th>';
    echo '<th style="text-align:center;">Detail</th>';
    echo '<th style="text-align:center;">Roll</th>';
    echo '<th style="text-align:center;">Length</th>';
    echo '<th style="text-align:center;">End</th>';
    echo '<th style="text-align:center;">Points</th>';
    echo '<th style="text-align:center;">Width</th>';
    echo '<th style="text-align:center;">SYMBOL</th>';
    echo '<th style="text-align:center;">Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row2 = mysqli_fetch_assoc($res2)) {
        
        $cd_id = $row2['CD_ID'];
        $cd_type = $row2['CD_TYPE'];
        $cd_startlength = round($row2['CD_STARTLENGTH']);
        $defect_id = $row2['CD_DEFECT'];
        $point = $row2['CD_POINT'];
        $width = $row2['CD_WIDTH'];
        $defect_symbol = GFV("std_defects", "DEFECT_SYMBOL", "DEFECT_ID='$defect_id'");
        $defect_color = GFV("std_defects", "DEFECT_COLOR", "DEFECT_ID='$defect_id'");
        $subroll = !empty($row2['ROLL_SUBNUMBER']) ? $row2['ROLL_SUBNUMBER'] : '-';
        switch ($cd_type) {
            case 1:
                $defect_name = GFV("std_defects", "DEFECT_NAME", "DEFECT_ID='$defect_id'");
                $defect_shortname = GFV("std_defects", "DEFECT_SHORTNAME", "DEFECT_ID='$defect_id'");
                $cd_endlength =  '-';
                break;
            case 2:
                $defect_name = GFV("std_defects", "DEFECT_NAME", "DEFECT_ID='$defect_id'");
                $defect_shortname = GFV("std_defects", "DEFECT_SHORTNAME", "DEFECT_ID='$defect_id'");
                $cd_endlength =  round($row2['CD_ENDLENGTH']);
                if (empty($cd_endlength)) {
                    $cd_endlength = '<span style="color:red; font-weight:bold">ACTIVE</span>';
                }
                break;
                
            case 4:
                $scissors = '<span>--</span><i class="fa fa-scissors" aria-hidden="true"></i><span>--</span>';
                $defect_name = $scissors;
                $defect_shortname = $scissors;
                //$point = $scissors;
                $cd_endlength = '<span class="text-primary">' . $row2['CD_BATCHROLL'] . '</span>';;
                $defect_symbol = 'scissors';
                break;
        }
        
        echo '<tr>';
        echo '<td>' . $defect_name . '</td>';
        echo '<td style="text-align:center;">' . $defect_shortname . '</td>';
        echo '<td style="text-align:center;">' . $subroll . '</td>';
        echo '<td style="text-align:center;">' . $cd_startlength . '</td>';
        echo '<td style="text-align:center;">' . $cd_endlength . '</td>';
        if ($defect_symbol == 'scissors') {
            echo '<td style="text-align:center;">' . $scissors . '</td>';
        } else {
            echo '<td style="text-align:center;">' . $point . '</td>';
        }
        if ($defect_symbol == 'scissors') {
            echo '<td style="text-align:center;">' . $scissors . '</td>';
        } else {
            echo '<td style="text-align:center;">' . $width . '</td>';
        }
        echo '<td style="text-align:center;">';
        if ($defect_symbol == 'scissors') {
            echo $scissors;
        } else {
            echo '<i class="fa ' . $defect_symbol . '" style="color:' . $defect_color . '; font-size:15px;" aria-hidden="true"></i>';
        }
        echo '</td>';
        echo '<td style="text-align:center;">';
        if ($defect_symbol == 'scissors') {
            //echo $scissors;
        } else { ?>
			<a href="defect_delete.php?defect_id=<?php echo $cd_id; ?>" onclick="return confirm('Are you sure you want to delete this Defect?');"><i class='fa fa-trash-o' aria-hidden='true' style='color: red;font-size: 15px;' ></i></a>
		<?php }
		echo '</td>';
		
		echo '</tr>';
	}
	echo '</tbody>';
	echo '</table>';
}else{
    ?>
    <span>No data available</span>
    <?php 
    
}

              
}

?>