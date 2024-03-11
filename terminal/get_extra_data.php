<?php
require_once 'session.php';

if (isset($_POST['get_defect_keys'])) {
    //input_text
    if (isset($_POST['defect_type']) && $_POST['defect_type'] == 2) {
        $pagelink = 'continuous_start.php';
    } else {
        $pagelink = 'defect_point.php';
    }
    $where = "1";
    $length = $_POST['length'];
    if (isset($_POST['input_text']) && !empty($_POST['input_text'])) {
        $txt = $_POST['input_text'];
        $where = "(DEFECT_NAME LIKE '%$txt%' OR DEFECT_NAME LIKE '%$txt%' OR DEFECT_SHORTNAME LIKE '%$txt%')";
    }

    echo '	<div class="row">';
    $query = "SELECT *, STD_DEFECTS.DEFECT_ID FROM KEYMAP INNER JOIN STD_DEFECTS ON KEYMAP.DEFECT_ID=STD_DEFECTS.DEFECT_ID WHERE DEFECT_VALID=1 AND $where ORDER BY KEY_NUMBER ASC limit 36";
    $res = mysqli_query($fit, $query);
    while ($row = mysqli_fetch_assoc($res)) {
        $defect_id1 = $row['DEFECT_ID'];
        echo '<div class="col-2 text-center">';
        echo '<a href="' . $pagelink . '?defect_id=' . $row['DEFECT_ID'] . '&length=' . $length . '">';
        echo '<button class="defect_key" style="background-color: ' . $row["DEFECT_COLOR"] . ';border-color: ' . $row["DEFECT_COLOR"] . ';" data-id="' . $row['DEFECT_ID'] . '">';
        echo '<div class="defect_abbrv">' . $row["DEFECT_SHORTNAME"] . '</div>';
        echo '<span  class="defect_name">' . $row["DEFECT_NAME"] . '</span>';
        echo '</button>';
        echo '</a>';
        echo '</div>';
    }
    echo '</div>';
}



if (isset($_POST['get_rolldetails'])) {
    $rollno =  $_POST['rollno'];

    $query = "SELECT style,descr,roll_loom_no FROM STDSTYLE INNER JOIN ROLL ON STYLE_ID = ROLL_BATCHID WHERE ROLL_NUMBER='$rollno' and roll_approve=1";
    $res = mysqli_query($fit, $query);
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $out['style'] = $row['style'];
        $out['descr'] = $row['descr'];
        $out['roll_loom_no'] = $row['roll_loom_no'];
        echo json_encode($out);
    }else{
		$out['style'] = '';
        $out['descr'] = '';
        $out['roll_loom_no'] = '';
        echo json_encode($out);
	}
}


if (isset($_POST['get_rolls_for_start'])) {
    //$style =  $_POST['style_name'];
    //$style_id = GFV("STDSTYLE", "STYLE_ID", "STYLE='$style'");
    $query = "SELECT ROLL_NUMBER FROM ROLL WHERE 1 AND ROLL_CURRENT=0 AND ROLL_END=0  ORDER BY ROLL_NUMBER";
    $res = mysqli_query($fit, $query);
    if ($res && mysqli_num_rows($res) > 0) {
        echo '<option value="" >SELECT ROLL</option>';
        while ($row = mysqli_fetch_assoc($res)) {
            $roll_number = $row['ROLL_NUMBER'];
            echo '<option value="' . $roll_number . '" >' . $roll_number . '</option>';
        }
    } else {
        echo '<option value="" >ROLLS NOT FOUND</option>';
    }
}


if (isset($_POST['get_style_for_start'])) {
    $rolls = '';
    $query = "SELECT ROLL_ID FROM ROLL WHERE ROLL_CURRENT=0 AND ROLL_END=0 ";
    $res = mysqli_query($fit, $query);
    if ($res && mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $rolls .= $row['ROLL_ID'] . ', ';
        }
    }
    $rolls = rtrim($rolls, ', ');

    echo $query = "SELECT DISTINCT(STYLE) FROM STDSTYLE INNER JOIN ROLL ON STYLE_ID = ROLL_BATCHID WHERE ROLL_ID IN ($rolls) ORDER BY STYLE";
    $res = mysqli_query($fit, $query);
    $style_arr = array();
    if ($res && mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $style_arr[] = $row['STYLE'];
        }
    }
    echo json_encode($style_arr);
}
