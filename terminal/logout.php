<?php
require_once 'session.php';

$logout_time = date("Y-m-d H:i:s");
$login_end = 2;

  $sql_edit = "UPDATE INSPECTORS SET INSP_LOGOUTTIME = '$logout_time', INSP_LOGSTATE = '0' WHERE INSP_EMPID='$glob_inspid'";
mysqli_query($fit, $sql_edit); 

$_SESSION['insp_id'] = '';
 
header('location:index.php?mc_id=' . $glob_mcid);
