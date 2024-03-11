<?php

require_once '../user/session.php';

error_reporting(E_ALL);
$period = $_POST['period'];
$date1 = date('Y-m-d', strtotime($_POST['date1']));
$date2 = date('Y-m-d', strtotime($_POST['date2']));
$sortby = $_POST['sortby'];

$wqry = "1";
$sort = '';
$mdata = array();

if (isset($_POST['selectdata']) && (!empty($_POST['selectdata']))) {
    $selectdata = $_POST['selectdata'];
    $mdata = implode(',', $selectdata);
}
switch ($sortby) {
    case "Machine":
        $wqry .= (!empty($mdata)) ? " and ROLL_MC_ID IN ($mdata)" : "";
        $sort = "MC_ID,";
        $sortname = "MC_NAME";
        break;
    case "Style":
        $wqry .= (!empty($mdata)) ? " and ROLL_STYLE_ID IN ($mdata)" : "";
        $sort = "STYLE,";
        $sortname = "STYLE";
        break;
    case "Inspector":
        $wqry .= (!empty($mdata)) ? " and ROLL_INSP_ID IN ($mdata)" : "";
        $sort = "INSP_NAME,";
        $sortname = "INSP_NAME";
        break;
    case "Roll":
        $wqry .= (!empty($mdata)) ? " and ROLL_ID IN ($mdata)" : "";
        $sort = "ROLL_ID,";
        $sortname = "ROLL_NUMBER";
        break;
}

$orderby = " order by $sort ROLL_INSP_DATE,ROLL_STARTTIME";
$sortid = rtrim($sort, ',');

$beg = true;
$prev = "";

$selqry = "SELECT DISTINCT ROLL_NUMBER,ROLL_SUBNUMBER,ROLL_ID,MC_ID,MC_NAME,INSP_ID,INSP_NAME,ROLL_DOFF_LOOM,STYLE,PPCM,ROLL_INSP_DATE,ROLL_DOFF_LENGTH,ROLL_LENGTH,ROLL_STARTTIME,ROLL_ENDTIME,ROLL_GP,ROLL_GRADE,ROLL_TOTAL_DEFECTS,ROLL_TOTAL_POINTS,ROLL_REMARK FROM ROLL INNER JOIN STD_STYLES ON(STYLE_ID=ROLL_STYLE_ID) INNER JOIN INSPECTORS ON(ROLL_INSP_ID=INSP_ID) INNER JOIN STD_MACHINES ON(ROLL_MC_ID=MC_ID) WHERE ";

if ($period == "date") {
    $wqry .= " and ROLL_INSP_DATE='$date1'";
} else {
    $wqry .= " and ROLL_INSP_DATE BETWEEN '$date1' AND '$date2'";
}

$query = "$selqry $wqry $orderby";
$res = mysqli_query($fit, $query);
if (mysqli_num_rows($res) > 0) {
?>
    <div class="serDiv">
        <?php echo "Inspection Report " . $period . " / " . date('d-m-Y', strtotime($date1)) . " / " . date('d-m-Y', strtotime($date2)) . " / " . $sortby . " @ " . date('h:m:s'); ?>
    </div>

    <table id="example" class="responsiveTbl" style="width:100%">

        <thead>
            <tr>
                <th>Roll Number</th>
                <th>Machine</th>
                <th>Inspector Name</th>
                <th>Sort Name</th>
                <th>Doffed Length</th>
                <th>Total Defects</th>
                <th>Total Points</th>
                <th>Inspected Length</th>
                <th>Inspected Date</th>
                <th>Start time</th>
                <th>End time</th>
                <th>Grade Point</th>
                <th>Grade</th>
                <th>Roll Remark</th>

            </tr>
        </thead>
        <tbody>

            <?php
            $gcnt = 0;
            $tcnt = 0;
            $grlength = 0;
            $trlength = 0;
            $gdlength = 0;
            $tdlength = 0;
            $gpoints = 0;
            $tpoints = 0;
            $gdefects = 0;
            $tdefects = 0;
            while ($row = mysqli_fetch_assoc($res)) {

                if ($prev != $row[$sortid] && $beg != true) {
            ?>
                    <!-- Sub total -->
                    <tr style="background-color:#ebf4e5;">
                        <td><?php echo $gcnt; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo $gdlength; ?></td>
                        <td><?php echo $gdefects; ?></td>
                        <td><?php echo $gpoints; ?></td>
                        <td><?php echo $grlength; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                <?php
                    $grlength = 0;
                    $gdlength = 0;
                    $gpoints = 0;
                    $gdefects = 0;
                    $gcnt = 0;
                }

                if ($prev != $row[$sortid]) {

                ?>
                    <!-- Sub head -->
                    <tr>
                        <td style="font-weight:bold"><?php echo $sortby . ':' . $row[$sortname]; ?></td>
                    </tr>
                <?php
                }
                if ($row['ROLL_SUBNUMBER'] > 0) {
                    $rollnumber = $row['ROLL_NUMBER'] . "-" . $row['ROLL_SUBNUMBER'];
                } else {
                    $rollnumber = $row['ROLL_NUMBER'];
                }


                ?>


                <tr id="<?php echo $row['ROLL_ID']; ?>" class="show1" onclick="open_defects(this,'<?php echo $row['ROLL_ID']; ?>')">
                    <td><?php echo $rollnumber; ?></td>
                    <td><?php echo $row['MC_NAME']; ?></td>
                    <td><?php echo $row['INSP_NAME']; ?></td>
                    <td><?php echo $row['STYLE']; ?></td>
                    <td><?php echo round($row['ROLL_DOFF_LENGTH']); ?></td>
                    <td><?php echo $row['ROLL_TOTAL_DEFECTS']; ?></td>
                    <td><?php echo $row['ROLL_TOTAL_POINTS']; ?></td>
                    <td><?php echo round($row['ROLL_LENGTH']); ?></td>
                    <td><?php echo date('d-m-Y', strtotime($row['ROLL_INSP_DATE'])); ?></td>
                    <td><?php echo $row['ROLL_STARTTIME']; ?></td>
                    <td><?php echo $row['ROLL_ENDTIME']; ?></td>
                    <td><?php echo $row['ROLL_GP']; ?></td>
                    <td><?php echo $row['ROLL_GRADE']; ?></td>
                    <td><?php echo $row['ROLL_REMARK']; ?></td>
                </tr>
                <?php


                $dt = $row['ROLL_INSP_DATE'];
                $defectable = $mth_db . ".DEFECT_" . date('mY', strtotime($dt));

                $defqry = "SELECT CD_DEFECT,DEFECT_NAME,DEFECT_SHORTNAME,CD_STARTLENGTH,CD_POINT,CD_TIME FROM $defectable INNER JOIN STD_DEFECTS ON(CD_DEFECT=DEFECT_ID) where 1 and CD_ROLL_ID='" . $row['ROLL_ID'] . "'";
                $defres = mysqli_query($fit, $defqry);
                if (mysqli_num_rows($defres) > 0) {
                    while ($defrow = mysqli_fetch_assoc($defres)) {
                ?>
                        <!-- inner table data -->
                        <tr class="defects_<?php echo $row['ROLL_ID']; ?>" style="display:none;background-color:gainsboro;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo $defrow['DEFECT_NAME']; ?></td>
                            <td><?php echo $defrow['DEFECT_SHORTNAME']; ?></td>
                            <td></td>
                            <td><?php echo $defrow['CD_POINT']; ?></td>
                            <td><?php echo round($defrow['CD_STARTLENGTH']); ?></td>
                            <td></td>
                            <td><?php echo $defrow['CD_TIME']; ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

            <?php
                    }
                }

                $gcnt++;
                $tcnt++;
                $gdlength += round($row['ROLL_DOFF_LENGTH']);
                $tdlength += round($row['ROLL_DOFF_LENGTH']);
                $grlength += round($row['ROLL_LENGTH']);
                $trlength += round($row['ROLL_LENGTH']);
                $gpoints += $row['ROLL_TOTAL_POINTS'];
                $tpoints += $row['ROLL_TOTAL_POINTS'];
                $gdefects += $row['ROLL_TOTAL_DEFECTS'];
                $tdefects += $row['ROLL_TOTAL_DEFECTS'];

                $beg = false;
                $prev = $row[$sortid];
            }

            ?>
            <!-- Sub total -->
            <tr style="background-color:#ebf4e5;">
                <td><?php echo $gcnt; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php echo $gdlength; ?></td>
                <td><?php echo $gdefects; ?></td>
                <td><?php echo $gpoints; ?></td>
                <td><?php echo $grlength; ?></td>
                <td></td>
                <td></td>
                              <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <!-- summary -->
            <tr style="background-color:#ffdada;font-weight:bold">
                <td><?php echo $tcnt; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php echo $tdlength; ?></td>
                <td><?php echo $tdefects; ?></td>
                <td><?php echo $tpoints; ?></td>
                <td><?php echo $trlength; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>



<?php
}
?>