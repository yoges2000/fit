<?php


require_once '../includes/connection.php';
require_once '../includes/functions.php';

//logfile('Page: ' . strtoupper(basename(__FILE__, '.php')));
$error = false;
if (isset($_POST)) {
    $roll_id = $_POST['roll_id'];
    if (!empty($roll_id)) {
        echo $qry = "UPDATE ROLL SET ROLL_END=0 WHERE ROLL_ID ='" . $roll_id . "'";


        if (mysqli_query($fit, $qry)) {
            logfile('Success: ' . $qry);
            $_SESSION['SUCCESS'] = 'Data Saved Successfully';
        } else {
            logfile('Error: ' . mysqli_error($fit) . ' - ' . $qry);
            $_SESSION['ERROR'] = $fit->error;
        }
    }
}
