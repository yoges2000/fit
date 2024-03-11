<?php
require_once '../includes/connection.php';

$login_time = date("Y-m-d H:i:s");
$login_end = 2;
$mc_id = '';
if (isset($_POST['insp_empid']) && isset($_POST['insp_password']) && isset($_POST['mc_id']) && !empty($_POST['mc_id'])) {
	$insp_empid = $_POST['insp_empid'];
	$password = md5($_POST['insp_password']);
	$mc_id = $_POST['mc_id'];
	 $qry 		= "SELECT * FROM INSPECTORS WHERE INSP_EMPID='$insp_empid'";
	$res = mysqli_query($fit, $qry);
	if (mysqli_num_rows($res) > 0) {
		$row = mysqli_fetch_assoc($res);
		$insp_id = $row['INSP_ID'];
		if ($row['INSP_VALID'] == '1') {
			if ($row['INSP_PASSWORD'] == $password) {
				 $_SESSION['insp_id'] = $insp_id;
				  $sql_edit = "UPDATE INSPECTORS SET INSP_LOGINTIME = '$login_time', INSP_LOGSTATE = '1', INSP_LOGMCID='$mc_id' WHERE INSP_ID='$insp_id'";
				mysqli_query($fit, $sql_edit);
			} else {
				$_SESSION['error'] = 'Invalid Password';
			}
		} else {
			$_SESSION['error'] = 'Your Account is Deactivated';
		}
	} else {
		$_SESSION['error'] = 'The EMPLOYEE ID is not Registered';
	}
} else {
	$_SESSION['error'] = 'Please check Login Name, password, Machine ID.';
}

if (!empty($mc_id)) {
	header('location: index.php?mc_id=' . $mc_id);
} else {
	header('location: index.php');
}
