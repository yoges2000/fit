<?php

require_once '../includes/connection.php';
require_once '../includes/functions.php';

logfile('Page: ' . strtoupper(basename(__FILE__, '.php')));
$error =false;
if (isset($_POST)) {
    getUpperPostKey();
    $tablename = 'STD_MACHINES';
    $idname = 'MC_ID';
    $idvalue = $_POST[$idname];
    
    $checkfld= 'MC_NAME';
    $fields = array();
    $values = array();
    foreach ($_POST as $key => $val) {
        $col_sel = "SHOW Fields FROM " . $tablename . " WHERE UPPER(Field)=UPPER('$key')";
        $col_res = mysqli_query($fit, $col_sel);
        if (mysqli_num_rows($col_res) > 0) {
            $col_row = mysqli_fetch_assoc($col_res);
            if (strtoupper($col_row['Field']) != $idname ) {
                array_push($fields, $col_row['Field']);
                array_push($values, $val);
            }
        } else {
            // If the field is not in the database we can process it here or show the errors
            $_SESSION['ERROR'] = $key . ' not found in table';
        }
    }
    $set = '';
    for ($a = 0; $a < sizeof($fields); $a++) {
        $set .= $fields[$a] . "='" . $values[$a] . "',";
    }
    
    $set = rtrim($set, ",");
    if (!empty($idvalue)) {
          $qry = "UPDATE " . $tablename . " SET " . $set . " WHERE " . $idname . "='" . $idvalue . "'";
    } else {
        if(isset($checkfld) && !empty($checkfld)){
            $check_qry="SELECT * FROM $tablename WHERE $checkfld='$_POST[$checkfld]'";
            $res = mysqli_query($fit, $check_qry);
            if (mysqli_num_rows($res) == 0) {
                $qry = "INSERT INTO " . $tablename . " SET " . $set;
            }else{
                logfile('Error: '.$checkfld.' Already available');
                $_SESSION['ERROR'] = 'Error: '.$checkfld.' Already available';
                $error = true;
            }
        }
        
    }
    if( $error !=true){
        if (mysqli_query($fit, $qry)) {
            logfile('Success: ' . $qry);
             $_SESSION['SUCCESS'] = 'Data Saved Successfully';
        } else {
            logfile('Error: ' . mysqli_error($fit) . ' - ' . $qry);
             $_SESSION['ERROR'] = $fit->error;
        }
    }
}

	header('location: ../user/std_machines.php');
?>
